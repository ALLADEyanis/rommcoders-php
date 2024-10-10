<?php include_once 'CONFIG/db.php' ?>

<?php
if (isset($_GET['id'])) {
  $topic_id = intval($_GET['id']);

  // Requête pour récupérer les détails du sujet
  $query = "SELECT t.id, t.title, t.content, t.created_at, u.username, c.name AS category_name 
              FROM topics t 
              JOIN users u ON t.user_id = u.id 
              JOIN categories c ON t.category_id = c.id 
              WHERE t.id = :id"; 

  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':id', $topic_id, PDO::PARAM_INT);
  $stmt->execute();
  $topic_details = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
  echo "<p>Aucun sujet spécifié.</p>";
}
?>

<?php  
//Récupération des sujets avec les informations nécessaires
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

<?php
if (isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];
} else {
  $msg = '<main id="content">
    <div class="px-4 py-10 text-center sm:px-6 lg:px-8">
      <h1 class="block text-xl font-bold text-red-400 sm:text-4xl">Section indisponible</h1>
      <p class="mt-3 text-lg text-gray-800">Veuillez vous connectez pour répondre au sujet.</p>
      <div class="flex flex-col items-center justify-center gap-2 mt-5 sm:flex-row sm:gap-3">
        <a class="inline-flex items-center justify-center w-full px-4 py-3 text-sm font-medium text-white bg-blue-500 border border-transparent rounded-lg sm:w-auto gap-x-2 hover:bg-blue-600 focus:outline-none focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none" href="login.php">
          <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
          Se connecter
        </a>
      </div>
    </div>
  </main>';
  echo $msg;
  exit;
}
$topic_id = htmlspecialchars($topic_details['id']);
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

$query = "SELECT r.content, r.id, r.created_at, u.username, r.user_id 
                  FROM replies r 
                  JOIN users u ON r.user_id = u.id 
                  WHERE r.topic_id = :topic_id 
                  ORDER BY r.created_at ASC";

$stmt = $pdo->prepare($query);

$stmt->bindParam(':topic_id', $topic_id, PDO::PARAM_INT);
$stmt->execute();
$comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
 