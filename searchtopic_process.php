<?php
include_once 'CONFIG/db.php';

      // Récupération des sujets récents avec recherche
      $search = isset($_GET['search']) ? '%' . $_GET['search'] . '%' : '%';
      $stmt = $pdo->prepare("
        SELECT topics.id, topics.title, topics.content, topics.created_at, topics.user_id, users.username 
        FROM topics 
        JOIN users ON topics.user_id = users.id 
        WHERE topics.title LIKE ? 
        ORDER BY topics.created_at DESC 
        LIMIT 10
      ");
      $stmt->execute([$search]);
      $topics = $stmt->fetchAll(PDO::FETCH_ASSOC);

      //si il n' y a pas de topics un message doit s'afficher
      if (count($topics) === 0) {
        $msg = '<div class="grid place-items-center">
            <h2 class="text-xl font-bold">Aucun sujet trouvé.</h2>
          </div>';
        echo $msg;
      } 

?>