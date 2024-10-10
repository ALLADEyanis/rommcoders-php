<?php
include_once "INCLUDES/head.php";
include_once "INCLUDES/header.php";
include_once "CONFIG/db.php";
?>

<section  class="flex items-center justify-center max-h-screen my-20 bg-white">
    <div class="w-full max-w-screen-md px-4 py-8 mx-auto lg:py-16">
        <h2 class="mb-4 text-4xl font-extrabold tracking-tight text-center text-gray-900">Créer un sujet</h2>
        <p class="mb-8 font-light text-center text-gray-500 lg:mb-16 sm:text-xl">Vous souhaitez partager une idée ou discuter d'un sujet spécifique ? N'hésitez pas à créer un nouveau sujet pour en parler avec la communauté.</p>
        <form action="create_topic_process.php" method="post" class="space-y-8" enctype="multipart/form-data">
            <div>
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Titre du sujet</label>
                <input type="text" name="title" id="topic-title" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5" placeholder="Entrez le titre de votre sujet" required>
            </div>
            <div>
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Mettre une photo</label>
                <input type="file" name="picture" id="topic-title" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5" placeholder="" required>
            </div>
            <div>
                <label for="category" class="block mb-2 text-sm font-medium text-gray-900">Catégorie</label>
                <?php include "getcategory.php"; ?>
            </div>
            <div class="sm:col-span-2">
                <label for="message" class="block mb-2 text-sm font-medium text-gray-900">Contenu du sujet</label>
                <textarea id="message" name="content" rows="6" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg shadow-sm border border-gray-300 focus:ring-primary-500 focus:border-primary-500" placeholder="Laissez un commentaire..."></textarea>
            </div>
            <div class="text-center">
                <button  type="submit" class="px-5 py-3 text-sm font-medium text-center text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300">Créer le sujet</button>
            </div>
        </form>
    </div>
</section>
<?php
include_once "INCLUDES/footer.php";
?>
