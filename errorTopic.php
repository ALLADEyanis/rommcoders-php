
<?php  
include_once 'INCLUDES/head.php';
include_once 'INCLUDES/header.php';

$topic_id = $_GET["id"];
$query = "SELECT t.id, t.title, t.content, t.created_at, u.username, c.name AS category_name 
              FROM topics t 
              JOIN users u ON t.user_id = u.id 
              JOIN categories c ON t.category_id = c.id 
              WHERE t.id = :id";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $topic_id, PDO::PARAM_INT);
    $stmt->execute();
    $topic_details = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<div class="h-[90vh]">
<section class="mt-4 bg-white">
    <div class="max-w-screen-xl px-4 py-8 mx-auto lg:py-16 lg:px-6">
        <div class="max-w-screen-sm mx-auto text-center">
            <h1 class="mb-4 text-2xl font-extrabold tracking-tight lg:text-9xl text-primary-600">Oups !!</h1>
            <p class="mb-4 text-xl font-bold tracking-tight text-gray-900 md:text-4xl">un sujet avec ce titre existe déja.</p>
            <p class="mb-4 text-lg font-light text-gray-500">Voulez vous voir ce sujet ?.</p>
            <a href="topics.php?id=<?= $topic_id ?>" class="inline-flex text-white bg-blue-500 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center ">voir le sujet</a>
        </div>   
    </div>
</section>
<?php include_once 'INCLUDES/footer.php'  ?>
</div>

