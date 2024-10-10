<?php include_once 'CONFIG/db.php'; ?>
<?php

if (isset($_GET['topic_id']) && isset($_GET['parent_id'])) {
  $topic_id = intval($_GET['topic_id']);
  $parent_id = intval($_GET['parent_id']);
} else {
  echo "L'ID du sujet ou de la réponse parente n'est pas défini.";
  exit;
}

if (isset($_POST['submit_reply'])) {

  $topic_id = intval($_GET['topic_id']);
  $parent_id = intval($_GET['parent_id']);


  $user_id = $_SESSION['user_id'];
  $content = $_POST['content'];

  // Vérifier si le contenu de la réponse n'est pas vide
  if (!empty($content)) {
    // Préparation de la requête d'insertion
    $insert_reply_query = "INSERT INTO repliestoreplies (topic_id, user_id, parent_id, content, created_at) VALUES (?, ?, ?, ?, NOW())";
    $insert_reply_stmt = $pdo->prepare($insert_reply_query);
    $insert_reply_stmt_result =
      $insert_reply_stmt->execute([$topic_id, $user_id, $parent_id, $content]);
  } else {
    // Redirection vers la page du sujet avec un message d'erreur
    header('Location: topics.php?id=' . $topic_id . '&error=empty_content');
    exit;
  }
}
?>
<?php include 'INCLUDES/head.php' ?>
<?php include 'INCLUDES/header.php' ?>

<form action="form-reply.php?topic_id=<?= $topic_id ?>&parent_id=<?= $parent_id ?>" method="post" class="max-w-screen-sm mx-auto my-6">
  <div class="px-4 py-2 mb-4 bg-white border border-gray-200 rounded-lg rounded-t-lg">
    <label for="reply_content" class="sr-only">Votre réponse</label>
    <textarea id="reply_content" rows="4" name="content"
      class="w-full px-0 text-sm text-gray-900 border-0 focus:ring-0 focus:outline-none"
      placeholder="Écrivez votre réponse..." required></textarea>
  </div>
  <button type="submit" name="submit_reply"
    class="inline-flex items-center py-2.5 px-4 text-xs font-medium text-center text-white bg-blue-500 bg-primary-700 rounded-lg focus:ring-4 focus:ring-primary-200 hover:bg-primary-800">
    Répondre
  </button>
</form>

<section class="py-8 antialiased bg-white lg:py-16">
  <div class="max-w-2xl px-4 mx-auto">
    <h2 class="mb-4 text-2xl font-bold">Reponses</h2>
    <?php
    // Affichage des réponses de la base de données
    $query_replies = "SELECT r.id , r.content , r.created_at , u.username , t.title  FROM repliestoreplies r JOIN 
  users u ON r.user_id = u.id
  JOIN 
      replies rep ON r.parent_id = rep.id
  JOIN 
      topics t ON rep.topic_id = t.id
  WHERE 
      rep.id = ?; -- Remplacez ? par l'ID du commentaire parent
  ";

    $stmt_replies = $pdo->prepare($query_replies);
    $stmt_replies->execute([$parent_id]);
    $replies = $stmt_replies->fetchAll(PDO::FETCH_ASSOC);
    $stmt_replies->closeCursor();

  //   //requete pour recuperer l'auteur de la réponse 
  //   $parent_id = intval($_GET['parent_id']);


  //   $user_id = $_SESSION['user_id'];
  // $query_author = "SELECT username, id FROM users WHERE id = (SELECT user_id FROM repliestoreplies WHERE id =?)";
  // $stmt_author = $pdo->prepare($query_author);
  // $stmt_author->execute([$user_id]);
  // $author = $stmt_author->fetch(PDO::FETCH_ASSOC);
    ?>
    <?php foreach ($replies as $reply): ?>
      <div class="p-4 mb-4 bg-white border border-gray-200 rounded-lg animate-slide-in-left">
        <div class="flex items-center mb-4">
          <div class="flex-shrink-0 mr-3">
            <img class="w-10 h-10 rounded-full" src="https://ui-avatars.com/api/?name=<?php urlencode($reply["username"]) ?>&background=random" alt="<?php htmlspecialchars($reply["username"]) ?>">
          </div>
          <div class="flex-1 min-w-0">
            <p class="text-sm font-medium text-gray-900 truncate">
              <a href="profile.php?username=<?php echo htmlspecialchars($_SESSION["username"]) ?>" class="hover:underline"><?php echo htmlspecialchars($reply["username"]) ?></a>
            </p>
            <p class="text-sm text-gray-500 truncate">
              Reponse le <?php echo htmlspecialchars($reply["created_at"]) ?>
            </p>
          </div>
        </div>
        <p class="text-gray-700"><?php echo htmlspecialchars($reply["content"]) ?></p>
        <div class="flex items-center mt-4 space-x-4">
          <!-- <a href="form-reply.php?topic_id=<?= $topic_details['id'] ?>&parent_id=<?= $reply['id'] ?>"
            class="flex items-center text-sm font-medium text-gray-500 hover:underline">
            <svg class="mr-1.5 w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 18">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5h5M5 8h2m6-3h2m-5 3h6m2-7H2a1 1 0 0 0-1 1v9a1 1 0 0 0 1 1h3v5l5-5h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1Z" />
            </svg>
            Répondre -->
          </a>
          <!-- <form class="flex" action="" method="post">
            <button type="submit">
              <img src="delete.png" width="16px" height="16px" alt="">
            </button>
          </form> -->
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</section>

<?php require "INCLUDES/footer.php"; ?>