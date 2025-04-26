<?php
function getBalance() {
    $userId = $_GET['user_id'] ?? null;

    if (!$userId) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing user_id']);
        exit;
    }

    $users = readData('data/users.json');

    foreach ($users as $user) {
        if ($user['user_id'] == $userId) {
            echo json_encode(['balance' => $user['balance']]);
            return;
        }
    }

    http_response_code(404);
    echo json_encode(['error' => 'User not found']);
}
?>
