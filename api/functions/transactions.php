<?php
function getTransactions() {
    $userId = $_GET['user_id'] ?? null;

    if (!$userId) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing user_id']);
        exit;
    }

    $transactions = readData('data/transactions.json');

    $userTransactions = array_filter($transactions, function ($txn) use ($userId) {
        return $txn['user_id'] === $userId;
    });

    echo json_encode(array_values($userTransactions));
}
?>
