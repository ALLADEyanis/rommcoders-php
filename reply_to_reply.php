
<?php
include_once 'CONFIG/db.php';
// Récupérer l'ID de la réponse à laquelle l'utilisateur répond
if (isset($_POST['reply_id'])) {
    $reply_id = intval($_POST['reply_id']);

    // Récupérer le contenu de la réponse
    $content = trim($_POST['content']);
    $user_id = $_SESSION['user_id'];

    // Valider les données
    if (empty($content)) {
        die("Le contenu de la réponse ne peut pas être vide.");
    }
    
    // Récupérer le nom de l'utilisateur à qui l'on répond
    $user_query = "SELECT username FROM replies r JOIN users u ON r.user_id = u.id WHERE r.id = :reply_id";
    $user_stmt = $pdo->prepare($user_query);
    $user_stmt->bindParam(':reply_id', $reply_id, PDO::PARAM_INT);
    $user_stmt->execute();
    $reply_user = $user_stmt->fetch(PDO::FETCH_ASSOC);

    if ($reply_user) { 
        $reply_username = htmlspecialchars($reply_user['username']);
        // Insérer la nouvelle réponse
        $insert_query = "INSERT INTO replies (content, user_id, topic_id, created_at) VALUES (:content, :user_id, :topic_id, NOW())";
        $insert_stmt = $pdo->prepare($insert_query);
        $insert_stmt->bindParam(':content', $content, PDO::PARAM_STR);
        $insert_stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $insert_stmt->bindParam(':topic_id', $topic_id, PDO::PARAM_INT);
        $insert_stmt->execute();

        // Rediriger avec un message de succès
        $_SESSION['message'] = "Votre réponse à $reply_username a été ajoutée avec succès.";
        header("Location: topics.php?id=" . $topic_id);
        exit();
    } else {
        die("Utilisateur non trouvé.");
    }
}
?>
