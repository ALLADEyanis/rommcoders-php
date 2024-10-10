<?php 
include_once "CONFIG/db.php";

// Récupération des sujets avec les informations nécessaires
$query = "
    SELECT 
        t.id, t.title, t.content, t.created_at,
        u.username,
        c.name AS category_name
    FROM 
        topics t
    JOIN 
        users u ON t.user_id = u.id
    JOIN 
        categories c ON t.category_id = c.id
    ORDER BY 
        t.created_at DESC
";

$stmt = $pdo->prepare($query);
$stmt->execute();
$topics = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<section class="bg-white">
  <div class="max-w-screen-xl px-4 py-12 mx-auto lg:py-20 lg:px-6">
      <div class="max-w-screen-sm mx-auto mb-8 text-center lg:mb-16">
          <h2 class="mb-4 text-3xl font-extrabold tracking-tight text-gray-900 lg:text-4xl">Nos sujets</h2>
          <p class="font-light text-gray-600 sm:text-xl">Découvrez les discussions récentes de notre communauté.</p>
      </div> 
      <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
          <?php foreach ($topics as $topic): ?>
          <article class="p-6 transition-all duration-300 bg-white border border-gray-200 shadow-lg rounded-xl hover:shadow-xl hover:transform hover:-translate-y-1">
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
              
              <h2 class="mb-3 text-xl font-bold tracking-tight text-gray-900 transition-colors duration-300 hover:text-blue-600">
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
  </div>
<?php
// Nombre de sujets par page
$sujets_par_page = 8;

// Calcul du nombre total de pages
$total_sujets = count($topics);
$total_pages = ceil($total_sujets / $sujets_par_page);

// Récupération de la page courante
$page_courante = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;

// Calcul de l'index de début pour la page courante
$index_debut = ($page_courante - 1) * $sujets_par_page;

// Sélection des sujets pour la page courante
$sujets_page = array_slice($topics, $index_debut, $sujets_par_page);

// Affichage de la pagination
if ($total_pages > 1):
?>
    <div class="flex justify-center mt-8">
        <nav aria-label="Pagination">
            <ul class="inline-flex items-center -space-x-px">
                <?php if ($page_courante > 1): ?>
                    <li>
                        <a href="?page=<?= $page_courante - 1 ?>" class="block px-3 py-2 ml-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-100 hover:text-gray-700">
                            <span class="sr-only">Précédent</span>
                            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                        </a>
                    </li>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li>
                        <a href="?page=<?= $i ?>" class="px-3 py-2 leading-tight <?= $i === $page_courante ? 'text-blue-600 border bg-blue-50 hover:text-blue-700' : 'text-gray-500 border-gray-300 hover:bg-gray-100 hover:text-gray-700' ?>">
                            <?= $i ?>
                        </a>
                    </li>
                <?php endfor; ?>

                <?php if ($page_courante < $total_pages): ?>
                    <li>
                        <a href="?page=<?= $page_courante + 1 ?>" class="block px-3 py-2 leading-tight text-gray-500 border border-gray-300 rounded-r-lg bg-blue-50 hover:bg-gray-100 hover:text-gray-700">
                            <span class="sr-only">Suivant</span>
                            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
<?php endif; ?>
</section>



