<?php

include_once 'CONFIG/db.php';
include_once 'INCLUDES/head.php';
include_once 'INCLUDES/header.php';
$user_id = $_POST["id"];
// Récupérer les informations de l'utilisateur
$user_query = "SELECT * FROM users WHERE id = :user_id";
$user_stmt = $pdo->prepare($user_query);
$user_stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$user_stmt->execute();
$user_info = $user_stmt->fetch(PDO::FETCH_ASSOC);

// Récupérer tous les sujets postés par l'utilisateur
$topics_query = "SELECT * FROM topics WHERE user_id = :user_id";
$topics_stmt = $pdo->prepare($topics_query);
$topics_stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$topics_stmt->execute();
$topics = $topics_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="bg-gray-100">
    <div class="container py-8 mx-auto">
        <div class="grid grid-cols-4 gap-6 px-4 sm:grid-cols-12">
            <div class="col-span-4 sm:col-span-3">
                <div class="p-6 bg-white rounded-lg shadow">
                    <div class="flex flex-col items-center">
                        <img class="mr-4 rounded-full w-30 h-30" src="https://ui-avatars.com/api/?name=<?= urlencode($user_info['username']) ?>&background=random" alt="<?= htmlspecialchars($user_info['username']) ?>">

                        </img>
                        <h1 class="text-2xl font-bold"><?= htmlspecialchars($user_info['username']) ?></h1>
                        <p class="text-gray-700"><?= htmlspecialchars($user_info['email']) ?></p>
                        <?php if($_SESSION["role"] !== "admin"): ?>
                        <div class="flex flex-wrap justify-center gap-4 mt-6">
                            <a href="#" class="px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-600">Modifier</a>
                        </div>
                        <?php endif;?>
                    </div>
                    <hr class="my-6 border-t border-gray-300">
                    <div class="flex flex-col">
                        <span class="mb-2 font-bold tracking-wider text-gray-700 uppercase">Sujets postés</span>
                        <ul>
                            <?php foreach ($topics as $topic): ?>
                                <li class="mb-2"><a href="topics.php?id=<?= $topic['id'] ?>"><?= htmlspecialchars($topic['title']) ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-span-4 sm:col-span-9">
                <main class="pt-8 pb-16 antialiased bg-white lg:pt-16 lg:pb-24">
                    <div class="flex flex-col px-4 mx-auto ">
                        <div>
                            <h2 class="mb-4 text-sm font-bold text-gray-900">Dernier sujet posté</h2>
                            <?php foreach ($topics as $topic): ?>
                                <div class="w-full max-w-2xl ml-2 card format format-sm sm:format-base lg:format-lg format-blue">
                                    <div class="mb-4 card-header lg:mb-6 not-format">
                                        <div class="flex items-center mb-6 not-italic card-address">
                                            <div class="inline-flex items-center mr-3 text-sm text-gray-900 gap-x-2">
                                                <img class="w-10 h-10 mr-1 rounded-full" src="https://ui-avatars.com/api/?name=<?= urlencode($user_info['username']) ?>&background=random" alt="<?= htmlspecialchars($user_info['username']) ?>">
                                                <div>
                                                    <a href="#" rel="author" class="text-2xl font-bold text-gray-900"><?= htmlspecialchars($user_info['username']) ?></a>
                                                    <p class="text-base text-gray-500"><time pubdate datetime="<?= htmlspecialchars($topic['created_at']) ?>" title="<?= htmlspecialchars($topic['created_at']) ?>"><?= date('M. j, Y', strtotime($topic['created_at'])) ?></time></p>
                                                </div>
                                            </div>
                                        </div>
                                        <h1 class="mb-4 text-sm font-semibold leading-tight text-gray-900 lg:mb-6 lg:text-2xl"><?= htmlspecialchars($topic['title']) ?></h1>
                                    </div>
                                    <div class="flex flex-col card-body">
                                        <p class="pl-2 mb-4 text-sm font-semibold text-gray-800 border-l-4 border-blue-500 lead"><?= nl2br(htmlspecialchars($topic['content'])) ?></p>
                                        <a href="topics.php?id=<?= $topic['id'] ?>" class="mb-1 text-blue-600 hover:text-blue-700">Voir les détails</a>
                                    </div>
                                </div>
                                <hr width="100%" class="border-t-2 border-gray-300">
                                <?php endforeach; ?>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>
</div>
<?php include_once 'INCLUDES/footer.php' ?>