<?php
include_once "CONFIG/db.php";
if (!isset($_SESSION['user_id'])) {
    die("Vous devez être connecté pour modifier une réponse.");
}

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $reply_id = intval($_POST['reply_id']);
    $content = isset($_POST['content']) ? trim($_POST['content']) : null;
    $user_id = $_SESSION['user_id'];

    // Valider les données
    if (is_null($content)) {
        die("Le contenu de la réponse ne peut pas être vide.");
    }
    $user_replies_query = "SELECT * FROM replies WHERE user_id = :user_id";
            $user_replies_stmt = $pdo->prepare($user_replies_query);
            $user_replies_stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $user_replies_stmt->execute();
            $user_replies = $user_replies_stmt->fetchAll(PDO::FETCH_ASSOC);

            // Récupérer l'ID de la réponse de l'utilisateur
            foreach ($user_replies as $reply) {
                $reply_id = $reply['id']; // Récupération de l'ID de la réponse
                // Utilisez $reply_id selon vos besoins
            }
    // Vérifier si la réponse appartient à l'utilisateur
    $check_query = "SELECT user_id FROM replies WHERE id = :reply_id";
    $check_stmt = $pdo->prepare($check_query);
    $check_stmt->bindParam(':reply_id', $reply_id, PDO::PARAM_INT);
    $check_stmt->execute();
    $reply_user_id = $check_stmt->fetchColumn();

    if ($reply_user_id === false) {
        die("Réponse non trouvée.");
    }

    if ($reply_user_id != $user_id) {
        die("Vous n'avez pas le droit de modifier cette réponse.");
    }

    try {
        // Préparer la requête de mise à jour
        $update_query = "UPDATE replies SET content = :content WHERE id = :reply_id";
        $update_stmt = $pdo->prepare($update_query);
        $update_stmt->bindParam(':content', $content, PDO::PARAM_STR);
        $update_stmt->bindParam(':reply_id', $reply_id, PDO::PARAM_INT);
        $update_stmt->execute();

        // Rediriger avec un message de succès
        $_SESSION['message'] = "Votre réponse a été mise à jour avec succès.";
        header("Location: topic.php?id=" . $_POST['topic_id']);
        exit();
    } catch (PDOException $e) {
        // En cas d'erreur, afficher le message d'erreur
        die("Erreur lors de la mise à jour de la réponse : " . $e->getMessage());
    }
} else {
    // Si le formulaire n'a pas été soumis, rediriger vers la page du sujet
    header("Location: topics.php");
    exit();
}
?>