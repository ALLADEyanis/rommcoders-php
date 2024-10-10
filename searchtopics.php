<?php include_once 'INCLUDES/head.php'  ?>
<?php include_once 'INCLUDES/header.php'  ?>
<?php include_once 'searchtopic_process.php'  ?>


<!-- Subscribe -->
<div class="max-w-6xl px-4 py-10 mx-auto sm:px-6 lg:px-8 lg:py-16">
  <div class="max-w-xl mx-auto text-center">
    <div class="mb-5">
      <h2 class="text-2xl font-bold md:text-3xl md:leading-tight">Rechercher un sujet</h2>
    </div>

    <form method="get" action="">
      <div class="flex flex-col items-center gap-2 mt-5 lg:mt-8 sm:flex-row sm:gap-3">
        <div class="w-full">
          <label for="hero-input" class="sr-only">Recherche</label>
          <input type="text" name="search" placeholder="Rechercher..."
            value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>" class="block w-full px-4 py-3 text-sm border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" placeholder="Entrez le nom du sujet">
        </div>
        <input type="submit" name="submit" value="Rechercher" class="inline-flex items-center justify-center w-full px-4 py-3 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg sm:w-auto whitespace-nowrap gap-x-2 hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
      </div>
    </form>
  </div>
</div>

  <div class="grid h-full grid-cols-1 gap-4 p-5 mx-5 rounded-lg bg-slate-50 lg:grid-cols-4 lg:gap-8">
      <?php foreach ($topics as $topic): ?>
        <?php if(empty($topic)) :  ?>
          <?php echo $msg ?>
        <?php else : ?>
      <div class="h-32 rounded-lg">
        <article class="p-6 transition-all duration-300 bg-white border border-gray-200 shadow-lg w-72 rounded-xl hover:shadow-xl hover:transform hover:-translate-y-1">
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
          <h2 class="mb-3 text-xl font-bold tracking-tight text-gray-900 transition-colors duration-300 hover:text-blue-600">
            <a href="topics.php?id=<?= $topic['id'] ?>"><?= htmlspecialchars($topic['title']) ?></a>
          </h2>
          <p class="mb-5 text-sm font-light text-gray-600 line-clamp-3">
            <?= htmlspecialchars(strlen($topic['content']) > 30 ? substr($topic['content'], 0, 30) . '...' : $topic['content']) ?>
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
              <svg class="w-4 h-4 ml-2 transition-transform duration-300 group-hover:translate-x-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
              </svg>
            </a>
          </div>
        </article>
      </div>
      
      <?php endif;?>
      <?php endforeach; ?>
    </div>
<!-- End Subscribe -->

<?php include_once 'INCLUDES/footer.php'  ?>