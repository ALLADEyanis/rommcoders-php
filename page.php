<?php
include_once "INCLUDES/head.php";
//include_once "INCLUDES/header.php";
include_once "INCLUDES/hero.php";
include_once "searchBar.php";
?>
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
  <div class="py-12 px-4 mx-auto max-w-screen-xl lg:py-20 lg:px-6">
      <div class="mx-auto max-w-screen-sm text-center lg:mb-16 mb-8">
          <h2 class="mb-4 text-3xl lg:text-4xl tracking-tight font-extrabold text-gray-900">Nos sujets restants</h2>
          <p class="font-light text-gray-600 sm:text-xl">Découvrez les discussions restantes de notre communauté.</p>
      </div> 
      <div class="grid gap-8 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
<?php
// Récupération des sujets restants qui ont dépassé la limite de sujets par page
$sujets_restants = array_slice($topics, $sujets_par_page);

// Affichage des sujets restants
foreach ($sujets_restants as $sujet): ?>
    <article class="p-6 bg-white rounded-xl border border-gray-200 shadow-lg transition-all duration-300 hover:shadow-xl hover:transform hover:-translate-y-1">
        <h2 class="mb-3 text-2xl font-bold tracking-tight text-gray-900">
            <a href="topic.php?id=<?= $sujet['id'] ?>"><?= htmlspecialchars($sujet['title']) ?></a>
        </h2>
        <p class="mb-5 font-light text-gray-600 text-sm line-clamp-3">
            <?= htmlspecialchars(strlen($sujet['content']) > 30 ? substr($sujet['content'], 0, 30) . '...' : $sujet['content']) ?>
        </p>
        <div class="flex justify-between items-center">
            <span class="font-medium text-sm text-gray-700">
                <?= htmlspecialchars($sujet['username']) ?>
            </span>
            <span class="text-sm"><?= htmlspecialchars($sujet['created_at']) ?></span>
        </div>
    </article>
<?php endforeach; ?> 
</div>
</div>
</section>
