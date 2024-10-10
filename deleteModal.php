<?php   
    $topic_id = intval($_GET['id']);
    // Requête pour récupérer les détails du sujet
    $user_replies_query = "SELECT * FROM replies WHERE user_id = :user_id";
            $user_replies_stmt = $pdo->prepare($user_replies_query);
            $user_replies_stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $user_replies_stmt->execute();
            $user_replies = $user_replies_stmt->fetchAll(PDO::FETCH_ASSOC);

            // Récupérer l'ID de la réponse de l'utilisateur
            foreach ($user_replies as $reply) {
                $reply_id = $reply['id']; // Récupération de l'ID de la réponse
                // Utilisez $reply_id selon vos besoins
            }
?>

<!-- Modal toggle -->
<form action="edit_reply.php" method="post">
<button data-modal-target="authentication-modal" data-modal-toggle="authentication-modal" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
  Modifier 
</button>

<!-- Main modal -->
<!-- Start of Selection -->
<div id="authentication-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                <h3 class="text-xl font-semibold text-gray-900">
                    Modifier votre contenu
                </h3>
                <button type="button" class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="authentication-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">fermer</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5">
                <form class="space-y-4" action="#">
                    <div>
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Commentaire</label>
                        <input type="hidden" name="reply_id" value="<?= $reply_id ?>">
                        <textarea id="comment" name="content" rows="6"
                        class="px-2 w-full text-sm text-gray-900 border-0 focus:ring-0 focus:outline-none"
                        placeholder="Écrivez un commentaire..." required></textarea>
                    </div>
                    <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Mettre à jour</button>
                    
                </form>
            </div>
        </div>
    </div>
</div> 
<!-- End of Selection -->
 </form>
