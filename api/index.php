<?php
require '../utils.php'; // Move one directory up

header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];
$path = $_GET['path'] ?? null;

if (!$path) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing path']);
    exit;
}

// Remove extra slashes if needed
$path = trim($path, '/');

switch ($path) {
    case 'create_user':
        if ($method !== 'POST') invalidMethod();
        require 'functions/create_user.php';
        createUser();
        break;

    case 'deposit':
        if ($method !== 'POST') invalidMethod();
        require 'functions/deposit.php';
        deposit();
        break;

    case 'withdraw':
        if ($method !== 'POST') invalidMethod();
        require 'functions/withdraw.php';
        withdraw();
        break;

    case 'balance':
        if ($method !== 'GET') invalidMethod();
        require 'functions/balance.php';
        getBalance();
        break;

    case 'transactions':
        if ($method !== 'GET') invalidMethod();
        require 'functions/transactions.php';
        getTransactions();
        break;

    case 'users':
        if ($method !== 'GET') invalidMethod();
        require 'functions/users.php';
        getUsers();
        break;
        

    default:
        http_response_code(404);
        echo json_encode(['error' => 'Unknown API endpoint']);
}

function invalidMethod() {
    http_response_code(405);
    echo json_encode(['error' => 'Invalid HTTP method']);
    exit;
}

function getRequestData() {
    $data = json_decode(file_get_contents('php://input'), true);
    if (!$data) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid JSON']);
        exit;
    }
    return $data;
}
?>
