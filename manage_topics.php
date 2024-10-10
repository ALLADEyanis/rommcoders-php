
<?php
//requete pour recuperer tous les sujets
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


$query_topics = "SELECT * FROM topics";
$stmt_topics = $pdo->prepare($query_topics);
$stmt_topics->execute();
$topics = $stmt_topics->fetchAll(PDO::FETCH_ASSOC);

$query_user_topics_count = "SELECT COUNT(*) as total_topics FROM topics WHERE user_id = :user_id";

// Compter le nombre de topics par utilisateur

foreach ($utilisateurs as $utilisateur) {
    $stmt_user_topics_count = $pdo->prepare($query_user_topics_count);
    $stmt_user_topics_count->bindParam(':user_id', $utilisateur['id']);
    $stmt_user_topics_count->execute();
    $utilisateur['total_topics'] = $stmt_user_topics_count->fetch();
}



