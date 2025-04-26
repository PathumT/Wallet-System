<?php
function getUsers() {
    $users = readData('data/users.json');

    if (!$users) {
        http_response_code(404);
        echo json_encode(['error' => 'No users found.']);
        return;
    }

    echo json_encode($users);
}
?>
