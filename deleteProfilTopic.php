<?php 

include_once 'CONFIG/db.php';

if(isset($_POST["deleteTopicUser"])) {
  $user_id = $_SESSION["user_id"];
  $topic_id = $_POST['topic_id'];
  // supprimer sujet de la table topics et replies 
  $query = "DELETE t, r FROM topics  t JOIN replies  r on t.id = r.topic_id WHERE t.id = ? ";
  $result = $pdo->prepare($query);
  $result->execute([$topic_id]);

  header("Location: profile.php" );

}

?>