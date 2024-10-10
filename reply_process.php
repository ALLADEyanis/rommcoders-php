
<?php
include_once "CONFIG/db.php";

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    die("Vous devez être connecté pour répondre à un sujet.");
}

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $topic_id = intval($_POST['topic_id']);
    $content = trim($_POST['content']);
    $user_id = $_SESSION['user_id'];

    // Valider les données
    if (empty($content)) {
        die("Le contenu de la réponse ne peut pas être vide.");
    }

    try {
        // Préparer la requête d'insertion
        $query = "INSERT INTO replies (topic_id, user_id, content, created_at) VALUES (?, ?, ?, NOW())";
        $stmt = $pdo->prepare($query);

        // Exécuter la requête
        $stmt->execute([$topic_id, $user_id, $content]);

        // Rediriger vers la page du sujet avec un message de succès
        $_SESSION['message'] = "Votre réponse a été ajoutée avec succès.";
        header("Location: topics.php?id=" . $topic_id);
        exit();
    } catch (PDOException $e) {
        // En cas d'erreur, afficher le message d'erreur
        die("Erreur lors de l'ajout de la réponse : " . $e->getMessage());
    }
} else {
    // Si le formulaire n'a pas été soumis, rediriger vers la page du sujet
    header("Location: topics.php");
    exit();
}
?>

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_reply_id'])) {
    $reply_id = intval($_POST['delete_reply_id']);
    $user_id = $_SESSION['user_id'];

    // Vérifier si l'utilisateur a le droit de supprimer cette réponse
    $check_query = "SELECT user_id FROM replies WHERE id = :reply_id";
    $check_stmt = $pdo->prepare($check_query);
    $check_stmt->bindParam(':reply_id', $reply_id, PDO::PARAM_INT);
    $check_stmt->execute();
    $reply_user_id = $check_stmt->fetchColumn();

    if ($reply_user_id === $user_id) {
        // Préparer la requête de suppression
        $delete_query = "DELETE FROM replies WHERE id = :reply_id";
        $delete_stmt = $pdo->prepare($delete_query);
        $delete_stmt->bindParam(':reply_id', $reply_id, PDO::PARAM_INT);
        $delete_stmt->execute();

        // Rediriger avec un message de succès
        $_SESSION['message'] = "Votre réponse a été supprimée avec succès.";
        header("Location: topics.php?id=" . $topic_id);
        exit();
    } else {
        die("Vous n'avez pas le droit de supprimer cette réponse.");
    }
}
