<?php
require 'vendor/autoload.php';
use Firebase\JWT\JWT;

$jwt_secret = $_ENV['JWT_SECRET'];

function generateJWT($user_id, $role) {
    global $jwt_secret;
    $payload = [
        "user_id" => $user_id,
        "role" => $role,
        "exp" => time() + 3600
    ];
    return JWT::encode($payload, $jwt_secret, 'HS256');
}
?>
