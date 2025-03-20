<?php
require 'jwt_helper.php';

function authenticate() {
    $headers = apache_request_headers();
    if (!isset($headers['Authorization'])) {
        die(json_encode(["error" => "Unauthorized"]));
    }

    $token = str_replace("Bearer ", "", $headers['Authorization']);
    
    try {
        return JWT::decode($token, $_ENV['JWT_SECRET'], ['HS256']);
    } catch (Exception $e) {
        die(json_encode(["error" => "Invalid token"]));
    }
}
?>
