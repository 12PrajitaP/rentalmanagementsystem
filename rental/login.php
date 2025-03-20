<?php
require 'db.php';
require 'jwt_helper.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $token = generateJWT($user['id'], $user['role']);
        echo json_encode(["token" => $token]);
    } else {
        echo json_encode(["error" => "Invalid credentials"]);
    }
}
?>
