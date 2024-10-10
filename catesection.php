<?php include_once 'CONFIG/db.php';
$query = "SELECT id, name, description FROM categories ORDER BY name ASC";

              try {
                  $stmt = $pdo->prepare($query);
                  $stmt->execute();
                  $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
              } catch(PDOException $e) {
                  $error = $e->getMessage();
              }


?>
<main class="h-screen py-4 mx-4">
<div class="grid grid-cols-1 h-full gap-4 lg:grid-cols-[180px_1fr] lg:gap-8">
  <div class="w-full h-full border border-gray-200 rounded-lg shadow bg-slate-50">
    <div class="p-4">
      <ul style="list-style-type: none; padding: 0;">
      <?php foreach($categories as $category): ?>
      <li><a href="categories.php?id=<?= $category['id'] ?>" class=" font-semibold leading-5 py-1 px-0.5 hover:text-blue-600"><?= $category['name'] ?></a></li>
      <?php endforeach; ?>
      </ul>
    </div>
    
  </div>

  
  
  <div id="categories.php?id=<?= $category['id'] ?>" class="">
  <div class="p-4">
    <?php if(isset($_GET['id'])): ?>
      <?php
        $category_id = $_GET['id'];
        $topics_query = "SELECT t.id, t.title, t.content, t.created_at, u.username, c.name AS category_name FROM topics t JOIN users u ON t.user_id = u.id JOIN categories c ON t.category_id = c.id WHERE c.id = :category_id ORDER BY t.created_at DESC";
        $topics_stmt = $pdo->prepare($topics_query);
        $topics_stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
        $topics_stmt->execute();
        $topics = $topics_stmt->fetchAll(PDO::FETCH_ASSOC);
      ?>
      <?php if (is_array($topics) && count($topics) > 0): ?>
        <div class="grid grid-cols-4 gap-4 mb-2 lg:grid-cols-4 lg:gap-8">
          <?php foreach($topics as $topic): ?>
          <article class="h-full p-6 transition-all duration-300 bg-white border border-gray-200 shadow-lg rounded-xl hover:shadow-xl hover:transform hover:-translate-y-1">
            <div class="flex items-center justify-between mb-5 text-gray-500">
                <span class="inline-flex items-center px-3 py-1 text-xs font-medium text-blue-800 bg-blue-100 rounded-full">
                <?= htmlspecialchars($topic['category_name']) ?>
                </span>
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
              <h2 class="mb-3 text-sm font-bold tracking-tight text-gray-900 transition-colors duration-300 hover:text-blue-600">
                  <a href="topics.php?id=<?= $topic['id'] ?>"><?= htmlspecialchars($topic['title']) ?></a>
              </h2>
              <p class="mb-5 text-sm font-light text-gray-600 line-clamp-3">
                  <?= htmlspecialchars(strlen($topic['content']) > 40 ? substr($topic['content'], 0, 40) . '...' : $topic['content']) ?>
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
              </div>
          </article> 
          <?php endforeach; ?>
        </div>
    <?php else: ?>
      <div><p class="text-3xl text-gray-400">Aucun sujet.</p></div>
    <?php endif;?> 
    <?php endif; ?>
  </div>
  </div>
</div>
</main>
