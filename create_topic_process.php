<?php
include_once "CONFIG/db.php";

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Récupération des données du formulaire
$user_id = $_SESSION['user_id'];
$title = $_POST['title'];
$category_id = $_POST['category'];
$content = $_POST['content'];

// $file_basename = pathinfo($_FILES["picture"]["name"], PATHINFO_FILENAME);
// $file_extension = pathinfo($_FILES["picture"]["name"], PATHINFO_EXTENSION);
// $image = $file_basename .'.'. $file_extension;

// Check if the title already exists in the database
$stmt_check_title = $pdo->prepare("SELECT COUNT(*) AS count FROM topics WHERE title = ?");
$stmt_check_title->execute([$title]);
$title_exists = $stmt_check_title->fetch(PDO::FETCH_ASSOC)['count'] > 0;




if ($title_exists) {
    header("Location: errorTopic.php?id=".$title_existst['id']);
    exit();
}

// Insertion du nouveau sujet dans la base de données



// Requête pour récupérer les sujets avec les informations demandées
$query_topics = "
    SELECT 
        u.username, 
        t.title, 
        c.name AS category_name,
        t.created_at, 
        t.content
    FROM 
        topics t
    JOIN 
        users u ON t.user_id = u.id
    JOIN 
        categories c ON t.category_id = c.id
    ORDER BY 
        t.created_at DESC
";



// Insertion du nouveau sujet
$stmt_insert = $pdo->prepare("INSERT INTO topics (user_id, category_id, title, content,   created_at, picture ) VALUES (?, ?, ?, ?,  NOW())");
$result_insert = $stmt_insert->execute([$user_id, $category_id, $title, $content]);



$stmt_topics = $pdo->prepare($query_topics);
$stmt_topics->execute();
$topics = $stmt_topics->fetchAll(PDO::FETCH_ASSOC);

if ($result_insert) {
    header("Location: index.php");
} else {
    echo "<p>Une erreur est survenue lors de la création du sujet.</p>";
}
?>