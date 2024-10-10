
<?php include_once 'INCLUDES/head.php'  ?>


<?php
include_once 'CONFIG/db.php';
if (isset($_GET['reply_id']) && isset($_GET['topic_id'])) {
  $reply_id = $_GET['reply_id'];
  $topic_id = $_GET['topic_id'];
  

} else {
  echo "L'ID du sujet ou de la réponse  n'est pas défini.";
  exit;
}

// Vérifier que les données sont fournies
if (isset($_POST['submit_reply'])) {
  
    $reply_id = intval($_GET['reply_id']);
    $content = $_POST['content'];
    $topic_id = intval($_GET['topic_id']);
    $userID = $_SESSION["user_id"];
    
    // Préparer et exécuter la requête pour mettre à jour la réponse
    $stmt = $pdo->prepare("UPDATE replies SET content = ? WHERE id = ? AND user_id = ?");
    $stmt->execute([$content, $reply_id, $userID]);
    // Rediriger vers le sujet après la mise à jour
    header("Location: topics.php?id=" . $topic_id);
    exit;
}
?>

 <form action="update.php?reply_id=<?= $reply_id ?>&topic_id=<?= $topic_id ?>" method="post" class="max-w-screen-sm mx-auto my-6">
  <div class="px-4 py-2 mb-4 bg-white border border-gray-200 rounded-lg rounded-t-lg">
    <label for="reply_content" class="sr-only">Votre réponse</label>
    <textarea id="reply_content" rows="4" name="content"
      class="w-full px-0 text-sm text-gray-900 border-0 focus:ring-0 focus:outline-none"
      placeholder="Écrivez votre réponse..." required></textarea>
  </div>
  <button type="submit" name="submit_reply"
    class="inline-flex items-center py-2.5 px-4 text-xs font-medium text-center text-white bg-blue-500 bg-primary-700 rounded-lg focus:ring-4 focus:ring-primary-200 hover:bg-primary-800">
    modifier
  </button>
</form>

<!-- <section class="bg-white">
  <div class="max-w-screen-md px-4 py-8 mx-auto lg:py-16">
      <h2 class="mb-4 text-4xl font-extrabold tracking-tight text-center text-gray-900">Modifcation</h2>
      
      <form action="update.php?reply_id=<?= $reply_id ?>&topic_id=<?= $topic_id ?>" method="post" class="space-y-8">
          
          <div class="sm:col-span-2">
              <label for="message" class="block mb-2 text-sm font-medium text-gray-900 ">Votre contenue</label>
              
              <textarea id="message" name="content" rows="6" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg shadow-sm border border-gray-300 focus:ring-primary-500 focus:border-primary-500 " placeholder="Nouvelle réponse..."></textarea>
          </div>
          <button type="submit" name="update" class="px-5 py-3 text-sm font-medium text-center text-white bg-blue-600 rounded-lg bg-primary-700 sm:w-fit hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300">Modifier</button>
      </form>
  </div>
</section> -->

<?php include_once 'INCLUDES/footer.php'  ?>

