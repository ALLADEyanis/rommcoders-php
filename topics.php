
<?php
include_once 'INCLUDES/head.php';
include_once 'INCLUDES/header.php';

include_once 'CONFIG/db.php';
// Start Generation Here
if (isset($_GET['id'])) {
    $topic_id = intval($_GET['id']);
    
    // Requête pour récupérer les détails du sujet
    $query = "SELECT t.id, t.title, t.content, t.created_at, u.username, c.name AS category_name 
              FROM topics t 
              JOIN users u ON t.user_id = u.id 
              JOIN categories c ON t.category_id = c.id 
              WHERE t.id = :id";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $topic_id, PDO::PARAM_INT);
    $stmt->execute();
    $topic_details = $stmt->fetch(PDO::FETCH_ASSOC);

    //recupere l'id de l'utilisateur qui a posté le sujet
    $query1 = "SELECT user_id FROM topics WHERE id = :id";
    $stmt1 = $pdo->prepare($query1);
    $stmt1->bindParam(':id', $topic_id, PDO::PARAM_INT);
    $stmt1->execute();
    $user_id = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    echo "<p>Aucun sujet spécifié.</p>";
}

?>
<!-- 
Install the "flowbite-typography" NPM package to apply styles and format the article content: 

URL: https://flowbite.com/docs/components/typography/
-->

<main class="pt-8 pb-16 antialiased bg-white lg:pt-16 lg:pb-24">
  <div class="flex justify-between max-w-screen-xl px-4 mx-auto ">
    <article class="w-full max-w-2xl mx-auto format format-sm sm:format-base lg:format-lg format-blue">
          <header class="mb-4 lg:mb-6 not-format">
              <address class="flex items-center mb-6 not-italic">
                  <div class="inline-flex items-center mr-3 text-sm text-gray-900 gap-x-2">
                      <img class="w-16 h-16 mr-4 rounded-full" src="https://ui-avatars.com/api/?name=<?= urlencode($topic_details['username']) ?>&background=random" alt="<?= htmlspecialchars($topic_details['username']) ?>">
                      <div>
                          <a href="#" rel="author" class="text-xl font-bold text-gray-900"><?= htmlspecialchars($topic_details['username']) ?></a>
                          <p class="inline-flex items-center px-3 py-1 text-xs font-medium text-blue-800 bg-blue-100 rounded-full "><?= htmlspecialchars($topic_details['category_name']) ?></p>
                          <p class="text-base text-gray-500"><time pubdate datetime="<?= htmlspecialchars($topic_details['created_at']) ?>" title="<?= htmlspecialchars($topic_details['created_at']) ?>"><?= date('M. j, Y', strtotime($topic_details['created_at'])) ?></time></p>
                      </div>
                  </div>
              </address>
              <h1 class="mb-4 text-xl font-semibold leading-tight text-gray-900 lg:mb-6 lg:text-3xl"><?= htmlspecialchars($topic_details['title']) ?></h1>
          </header>
          <p class="pl-4 font-semibold text-gray-800 border-l-4 border-blue-500 lead"><?= nl2br(htmlspecialchars($topic_details['content'])) ?></p>
      </article>
  </div>
  <?php include_once 'commentary.php'  ?>
</main>

<?php include_once 'INCLUDES/footer.php'; ?>