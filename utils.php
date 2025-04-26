<?php
function readData($file) {
    $fullPath = __DIR__ . '/' . $file;
    if (!file_exists($fullPath)) {
        file_put_contents($fullPath, json_encode([]));
    }
    return json_decode(file_get_contents($fullPath), true);
}

function writeData($file, $data) {
    $fullPath = __DIR__ . '/' . $file;
    file_put_contents($fullPath, json_encode($data, JSON_PRETTY_PRINT));
}
?>
