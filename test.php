<?php

$message = sayHello();

function sayHello() {
    return 'hello';
}

echo json_encode([
    'message' => $message
]);