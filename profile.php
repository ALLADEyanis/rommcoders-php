<?php

include_once 'CONFIG/db.php';
include_once 'INCLUDES/head.php';
include_once 'INCLUDES/header.php';
$user_id = $_SESSION["user_id"];
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
<!-- <div class="flex justify-center bg-slate-50 h-22">
<div class="flex-1">
<form  class="max-w-md p-5 mx-auto">   
    <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only">Search</label>
    <div class="relative">
        <div class="absolute inset-y-0 flex items-center pointer-events-none start-0 ps-3">
            <svg class="w-4 h-4 text-gray-500 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
            </svg>
        </div>
        <input type="search" id="default-search" class="block w-full p-4 text-sm text-gray-900 border border-gray-300 rounded-lg ps-10 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 " placeholder="recherher vos sujets..." required />
        <button type="submit" class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 ">Rechercher</button>
    </div>
</form>
</div>

</div> -->

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
                        <div class="flex flex-wrap justify-center gap-4 mt-6">
                            <a href="updateProfile.php?id=<?= $user_info["id"] ?>" class="px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-600">Modifier</a>
                        </div>
                    </div>
                    <hr class="my-6 border-t border-gray-300">
                    <div class="flex flex-col">
                        <span class="mb-2 font-bold tracking-wider text-gray-700 uppercase">Sujets postés</span>
                        <ul>
                            <?php foreach ($topics as $topic): ?>
                                <li class="mb-2 text-sm font-semibold text-neutral-800 hover:text-blue-600"><a href="topics.php?id=<?= $topic['id'] ?>"><?= htmlspecialchars($topic['title']) ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-span-4 sm:col-span-9">
                <main class="pt-4 pb-16 antialiased bg-white lg:pt-16 lg:pb-24">
                    <div class="flex flex-col px-4 mx-auto ">
                        <div id="">
                            <h2 class="mb-4 text-sm font-bold text-gray-900">Dernier sujet posté</h2>
                            <?php foreach ($topics as $topic): ?>
                                <div class="w-full max-w-2xl ml-2 card format format-sm sm:format-base lg:format-lg format-blue">
                                    <div class="mb-4 card-header lg:mb-6 not-format">
                                        
                                        
                                        <h1 class="mb-4 text-sm font-semibold leading-tight text-gray-900 lg:mb-6 lg:text-2xl"><?= htmlspecialchars($topic['title']) ?></h1>
                                    </div>
                                    <div class="flex flex-col card-body">
                                        <p class="pl-2 mb-4 font-semibold text-gray-800 border-l-4 border-blue-500 lead"><?= nl2br(htmlspecialchars($topic['content'])) ?></p>
                                        <div class="inline-flex items-baseline gap-4 mb-2">

                                            <a href="topics.php?id=<?= $topic['id'] ?>" class="p-1.5 text-sm font-semibold leading-tight text-neutral-700 bg-blue-200 rounded-md hover:bg-blue-700 hover:text-white">Voir les détails</a>
                                            <!-- <form action="deleteProfilTopic.php" method="post">
                                                <input type="hidden" name="topic_id" value="<?php echo $topic['id'] ?>">
                                                <button type="submit" name="deleteTopicUser" class="p-1 text-sm font-semibold leading-tight text-white bg-red-500 rounded-md hover:bg-red-700 focus: ring-red-300">supprimer</button>
                                            </form> -->
                                        </div>
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