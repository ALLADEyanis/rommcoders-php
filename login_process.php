<?php
include_once "./config/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
  $email = $_POST["email"];
  $password = $_POST["password"];

  $sql = "SELECT * FROM users WHERE email = ?";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$email]);
  $user = $stmt->fetch();

  if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['role'] = $user['role'];
    
    if ($user['role'] == 'admin') {
      header('Location: dashboard.php');
    } else {
      header('Location: index.php');
    }
    exit;
  } else {
    $errorMsg = "Email ou mot de passe incorrect";
  }
}
if (isset($errorMsg)) {
  echo "<p class='text-red-600'>$errorMsg</p>";
}
?>
