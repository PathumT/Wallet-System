<?php
function withdraw() {
    $data = getRequestData();

    $userId = $data['user_id'] ?? null;
    $amount = $data['amount'] ?? null;

    if (!$userId || !is_numeric($amount)) {
        http_response_code(400);
        echo json_encode(['error' => 'User ID and Amount are required.']);
        exit;
    }

    if ($amount <= 0) {
        http_response_code(400);
        echo json_encode(['error' => 'Withdrawal amount must be greater than 0.']);
        exit;
    }

    $users = readData('data/users.json');
    $transactions = readData('data/transactions.json');

    foreach ($users as &$user) {
        if ($user['user_id'] == $userId) {
            if ($user['balance'] < $amount) {
                http_response_code(400);
                echo json_encode(['error' => 'Insufficient balance for withdrawal.']);
                exit;
            }
            $user['balance'] -= $amount;

            $transactions[] = [
                'user_id' => $userId,
                'type' => 'withdraw',
                'amount' => $amount,
                'timestamp' => date('Y-m-d H:i:s')
            ];

            writeData('data/users.json', $users);
            writeData('data/transactions.json', $transactions);

            echo json_encode(['message' => 'Withdrawal successful']);
            return;
        }
    }

    http_response_code(404);
    echo json_encode(['error' => 'User not found']);
}
?>
