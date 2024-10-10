
<?php
include_once 'CONFIG/db.php';
include_once 'INCLUDES/head.php';
include_once 'INCLUDES/header.php';
//recuperer les sujets de l'utilisateur
$user_id = $_POST['id'];
//jointure avec users(username)
$totalReplies = $_POST['replies'];

$user_topics_query = "SELECT topics.*, users.username FROM topics JOIN users ON topics.user_id = users.id WHERE users.id = :user_id";
$user_topics_stmt = $pdo->prepare($user_topics_query);
$user_topics_stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$user_topics_stmt->execute();
$user_topics = $user_topics_stmt->fetchAll(PDO::FETCH_ASSOC);

if(empty($user_topics)) {
    $msg = '<div class="flex flex-col items-center justify-center gap-4 mt-10">
            <p class="text-2xl font-semibold">Aucun sujet</p>
            <a href="dashtopics.php" class="p-2 text-sm font-semibold text-blue-500 rounded-xl bg-slate-100">Gestion sujets</a>
        </div>';
    echo $msg;
}

//supprimer le sujet de l'utilisateur

if (isset($_POST['delete_topic_id'])) { 
    //jointure avec replies(si il y a des réponses au sujet on peut pas supprimer)
    $topic_id = $_POST['delete_topic_id'];
    $replies_count_query = "SELECT COUNT(*) FROM replies WHERE topic_id = :topic_id";
    $replies_count_stmt = $pdo->prepare($replies_count_query);
    $replies_count_stmt->bindParam(':topic_id', $topic_id, PDO::PARAM_INT);
    $replies_count_stmt->execute();
    $replies_count = $replies_count_stmt->fetchColumn();
    
    if ($replies_count == 0) {
      // Préparer la requête de suppression
      $delete_topic_query = "DELETE FROM topics WHERE id = :topic_id";
      $delete_topic_stmt = $pdo->prepare($delete_topic_query);
      $delete_topic_stmt->bindParam(':topic_id', $topic_id, PDO::PARAM_INT);
      $delete_topic_stmt->execute();
    } else {
      echo "Impossible de supprimer ce sujet. Il y a des réponses pour votre sujet.";
    }
    $delete_topic_query = "DELETE FROM topics WHERE id = ?";
    $delete_topic_stmt = $pdo->prepare($delete_topic_query);
    $delete_topic_stmt->execute([$user_id]);

    header('Location: view_topics_user.php?id='. $user_id);
}




?>

<!-- Afficher les sujets -->

<section class="max-w-screen-xl px-4 py-12 mx-auto lg:py-20 lg:px-6">

<div class="grid grid-cols-1 gap-4 lg:grid-cols-4 lg:gap-8">
  <?php foreach ($user_topics as $topic):?>
  <div class="h-32 bg-gray-200 rounded-lg">
  <article class="p-6 transition-all duration-300 bg-white border border-gray-200 shadow-lg rounded-xl hover:shadow-xl hover:transform hover:-translate-y-1">
              <div class="flex items-center justify-between mb-5 text-gray-500">
                  
                  <span class="text-sm"><?php
                      $diff = abs(time() - strtotime($topic['created_at']));
                      $unit = '';
                      if ($diff < 60) {
                          $value = $diff;
                          $unit = 'seconde' . ($value > 1 ? 's' : '');
                      } elseif ($diff < 3600) {
                          $value = floor($diff / 60);
                          $unit = 'minute' . ($value > 1 ? 's' : '');
                      } elseif ($diff < 86400) {
                          $value = floor($diff / 3600);
                          $unit = 'heure' . ($value > 1 ? 's' : '');
                      } elseif ($diff < 2592000) {
                          $value = floor($diff / 86400);
                          $unit = 'jour' . ($value > 1 ? 's' : '');
                      } elseif ($diff < 31536000) {
                          $value = floor($diff / 2592000);
                          $unit = 'mois';
                      } else {
                          $value = floor($diff / 31536000);
                          $unit = 'année' . ($value > 1 ? 's' : '');
                      }
                      if ($value == 0) {
                          echo htmlspecialchars("à l'instant");
                      } else {
                          echo htmlspecialchars(sprintf("il y a %d %s", $value, $unit));
                      }
                  ?></span>
                  
              </div>
              <h2 class="mb-3 text-2xl font-bold tracking-tight text-gray-900 transition-colors duration-300 hover:text-blue-600">
                  <a href="topics.php?id=<?= $topic['id'] ?>"><?= htmlspecialchars($topic['title']) ?></a>
              </h2>
              <p class="mb-5 text-sm font-light text-gray-600 line-clamp-3">
                  <?= htmlspecialchars(strlen($topic['content']) > 150 ? substr($topic['content'], 0, 150) . '...' : $topic['content']) ?>
              </p>
              <div class="flex items-center justify-between">
                  <div class="flex items-center space-x-4">
                      <img class="w-8 h-8 rounded-full" src="https://ui-avatars.com/api/?name=<?= urlencode($topic['username']) ?>&background=random" alt="<?= htmlspecialchars($topic['username']) ?>">
                      <span class="text-sm font-medium text-gray-700">
                          <?= htmlspecialchars($topic['username']) ?>
                      </span>
                  </div>
                  <a href="topics.php?id=<?= $topic['id'] ?>" class="inline-flex items-center text-sm font-medium text-blue-600 hover:underline group">
                      Lire plus
                      <svg class="w-4 h-4 ml-2 transition-transform duration-300 group-hover:translate-x-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                  </a>
                  <form class="flex" action="" method="post">
                    <button type="submit" name="delete_topic_id">
                      <img src="delete.png" width="16px" height="16px" alt="">
                    </button>
                  </form>
              </div>
        </article> 
  </div>
  <?php endforeach; ?>
</div>
</section>

<?php require "INCLUDES/footer.php"; ?>