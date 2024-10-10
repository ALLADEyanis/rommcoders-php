<?php
          include_once 'CONFIG/db.php';
          $categorie = $_POST['category'];
          $query = "DELETE  FROM categories WHERE id = ?";
          $stmt = $pdo->prepare($query);
          $stmt->execute([$categorie]);
          

          // Message de confirmation de l'insertion
          $msg = "La catégorie a été supprimée avec succès";
          header("Location: dashboard.php");
          ?>