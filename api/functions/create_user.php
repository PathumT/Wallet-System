<?php
function createUser() {
    header('Content-Type: application/json');
    error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING); // Suppress notices/warnings

    $data = getRequestData();
    $name = trim($data['name'] ?? '');
    $email = trim($data['email'] ?? '');
    $password = trim($data['password'] ?? '');
    $dob = trim($data['dob'] ?? '');

    if (!$name || !$email || !$password || !$dob) {
        http_response_code(400);
        echo json_encode(['error' => 'All fields are required.']);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid email format.']);
        exit;
    }

    $dobDate = strtotime($dob);
    $today = strtotime(date('Y-m-d'));
    if ($dobDate === false || $dobDate >= $today) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid date of birth. DOB cannot be today or future.']);
        exit;
    }

    $users = readData('data/users.json');
    foreach ($users as $user) {
        if ($user['email'] === $email) {
            http_response_code(409);
            echo json_encode(['error' => 'Email already registered.']);
            exit;
        }
    }

    $newUser = [
        'user_id' => uniqid('user_'),
        'name' => $name,
        'email' => $email,
        'password' => password_hash($password, PASSWORD_DEFAULT),
        'dob' => $dob,
        'balance' => 0
    ];

    $users[] = $newUser;
    writeData('data/users.json', $users);

    echo json_encode(['message' => 'User created successfully!']);
}

?>
