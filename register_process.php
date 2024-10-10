<?php
include_once "CONFIG/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["register"])) {
  $username = $_POST["username"];
  $email = $_POST["email"];
  $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
  $role = 'member';

  $sql = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)";

  $stmt = $pdo->prepare($sql);
  if ($stmt->execute([$username, $email, $password, $role])) {
    header('Location: login.php');
    exit;
  } else {
    $errorMsg = "erreur d'inscription";
  }
}
