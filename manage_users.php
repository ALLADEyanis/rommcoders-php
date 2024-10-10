<?php
// Connexion à la base de données
include_once 'CONFIG/db.php';

// Requête pour récupérer tous les utilisateurs
$query = "SELECT * FROM users";
$stmt_users = $pdo->prepare($query);
$stmt_users->execute();
$utilisateurs = $stmt_users->fetchAll(PDO::FETCH_ASSOC);



// Requête pour récupérer le nom et l'email de l'utilisateur qui a pour role admin
$query_admin = "SELECT username, email FROM users WHERE role = 'admin'";
$stmt_admin = $pdo->prepare($query_admin);
$stmt_admin->execute();
$admin_utilisateur = $stmt_admin->fetch(PDO::FETCH_ASSOC);

//requête pour voir le profile d'un utilisateur
$query_profile = "SELECT * from users";


// Compter le nombre total d'utilisateurs
$nombre_total_utilisateurs = count($utilisateurs);

// Requête pour supprimer un utilisateur ainsi que tous les sujets qu'il a créés et les réponses associées aux sujets et les réponses associées aux réponses

if (isset($_POST['delete_user_id'])) {
    $delete_user_id = $_SESSION["user_id"];
    $pdo->beginTransaction();
    // Supprimer les sujets du user
    $stmt_delete_topics = $pdo->prepare("DELETE FROM topics WHERE user_id =?");
    $stmt_delete_topics->execute([$delete_user_id]);
    // Supprimer les réponses du user
    $stmt_delete_replies = $pdo->prepare("DELETE FROM replies WHERE user_id =?");
    $stmt_delete_replies->execute([$delete_user_id]);
    // Supprimer l'utilisateur
    $stmt_delete_user = $pdo->prepare("DELETE FROM users WHERE id =?");
    $stmt_delete_user->execute([$delete_user_id]);
    $pdo->commit();
}

?>
