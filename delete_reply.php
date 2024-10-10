<?php
include_once 'CONFIG/db.php';
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_reply_id'])) {
    $reply_id = intval($_POST['delete_reply_id']);
    $user_id = $_SESSION['user_id'];
    $topic_id = $_POST['topic_id'];


    // Vérifier si des réponses existent déjà pour cette réponse
    $has_replies_query = "SELECT COUNT(*) FROM repliestoreplies WHERE parent_id = ?";
    $has_replies_stmt = $pdo->prepare($has_replies_query);
    $has_replies_stmt->execute([$reply_id]);
    $has_replies = $has_replies_stmt->fetch();

    if ($has_replies >= 0) {
        // header("Location: error.php");
        // die("Impossible de supprimer cette reponse. Il y a des autres reponses pour votre réponse.");
        $message = "Impossible de supprimer cette reponse. Il y a des autres reponses pour votre réponse.";
        echo "<script type='text/javascript'>alert('$message');</script>";
        exit();
        
    }
        // Préparer la requête de suppression
        $delete_query = "DELETE FROM replies WHERE id = :reply_id";
        $delete_stmt = $pdo->prepare($delete_query);
        $delete_stmt->bindParam(':reply_id', $reply_id, PDO::PARAM_INT);
        $delete_stmt->execute();

        // Rediriger vers la page du sujet avec un message de succès
        //$_SESSION['message'] = "Votre réponse a été supprimée avec succès.";
        header("Location: topics.php?id=" . $topic_id);
        
        exit();
    
}
