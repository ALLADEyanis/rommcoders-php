<?php include_once 'INCLUDES/head.php' ?>
<?php include_once 'searchtopic_process.php' ?>

<?php
$query = "SELECT id, name, description FROM categories ORDER BY name ASC";

try {
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = $e->getMessage();
}




?>

<script src="ASSETS/search.js"></script>



<form class="max-w-2xl mt-8 mx-auto">
    <div class="flex">
        <label for="search-dropdown" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Your Email</label>
        <button id="dropdown-button" data-dropdown-toggle="dropdown" class="flex-shrink-0 z-10 inline-flex items-center py-2.5 px-4 text-sm font-medium text-center text-gray-900 bg-gray-100 border border-gray-300 rounded-s-lg hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 " type="button">Toutes les catégories <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
            </svg></button>
        <div id="dropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44">
            <ul class="py-2 text-sm text-gray-700 " aria-labelledby="dropdown-button">
                <?php foreach ($categories as $category): ?>
                    <li>
                        <button type="button" class="inline-flex w-full px-4 py-2 hover:bg-gray-100"><?= htmlspecialchars($category['name']) ?></button>
                    </li>
                <?php endforeach; ?>

            </ul>
        </div>
        <div class="relative w-full">
            <input type="search" type="text" name="search" placeholder="Rechercher..."
                value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>" id="search-dropdown" class="block p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 rounded-e-lg border-s-gray-50 border-s-2 border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Rechercher des sujets, des posts, des utilisateurs..." required />
            <button type="submit" class="absolute top-0 end-0 p-2.5 text-sm font-medium h-full text-white bg-blue-700 rounded-e-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                </svg>
                <span class="sr-only">Rechercher</span>
            </button>
        </div>
    </div>
</form>