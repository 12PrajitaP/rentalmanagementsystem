<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $token = bin2hex(random_bytes(50));
        $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));

        $pdo->prepare("UPDATE users SET reset_token = ?, token_expiry = ? WHERE email = ?")
            ->execute([$token, $expiry, $email]);

        $reset_link = "http://yourwebsite.com/reset_password.php?token=$token";
        mail($email, "Password Reset", "Click here: $reset_link");

        echo json_encode(["message" => "Check your email for reset link"]);
    } else {
        echo json_encode(["error" => "Email not found"]);
    }
}
?>
