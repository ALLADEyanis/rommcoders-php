<!-- 
 //table réponses a la réponse
CREATE TABLE repliestoreplies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    topic_id INT NOT NULL,
    user_id INT NOT NULL,
    parent_id INT DEFAULT NULL, -- Référence à une réponse existante
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (topic_id) REFERENCES topics(id),
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (parent_id) REFERENCES replies(id) -- Référence à la table replies
);

- `users` : Pour les informations des utilisateurs.
CREATE TABLE users (
id INT AUTO_INCREMENT PRIMARY KEY,
username VARCHAR(50) NOT NULL,
email VARCHAR(100) NOT NULL UNIQUE,
password VARCHAR(255) NOT NULL,
role ENUM('member', 'moderator', 'admin') DEFAULT 'member',
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
- `categories` : Pour les catégories de discussion.
CREATE TABLE categories (
id INT AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(100) NOT NULL,
description TEXT
);

- `topics` : Pour les sujets créés par les utilisateurs.
CREATE TABLE topics (
id INT AUTO_INCREMENT PRIMARY KEY,
user_id INT NOT NULL,
category_id INT NOT NULL,
title VARCHAR(255) NOT NULL,
content TEXT NOT NULL,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
FOREIGN KEY (user_id) REFERENCES users(id),
FOREIGN KEY (category_id) REFERENCES categories(id)
);
- `replies` : Pour les réponses aux sujets.
CREATE TABLE replies (
id INT AUTO_INCREMENT PRIMARY KEY,
topic_id INT NOT NULL,
user_id INT NOT NULL,
content TEXT NOT NULL,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
FOREIGN KEY (topic_id) REFERENCES topics(id),
FOREIGN KEY (user_id) REFERENCES users(id)
); -->

<?php

// Assuming $userId is the id of the user to be deleted
$userId = $_POST["id"];

// Connect to the database

include_once 'CONFIG/db.php';
// Start a transaction
// Assuming $userId is the id of the user to be deleted
$userId = $_POST["id"];

// Connect to the database
include_once 'CONFIG/db.php';

// Start a transaction
$pdo->beginTransaction();

try {
    // Check if there are any replies to topics by the user
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM replies WHERE user_id = :userId");
    $stmt->bindParam(':userId', $userId);
    $stmt->execute();
    $replyCount = $stmt->fetchColumn();

    if ($replyCount > 0) {
        echo "Impossible de supprimer l'utilisateur. Il existe des réponses associées  à ses sujets.";
echo "<script type=\"text/javascript\"> alert('Impossible de supprimer l'utilisateur. Il existe des réponses à des sujets.') </script>";
        exit;
    }
    // Delete from repliestoreplies table
    $stmt = $pdo->prepare("DELETE FROM repliestoreplies WHERE user_id = :userId");
    $stmt->bindParam(':userId', $userId);
    $stmt->execute();

    // Delete from replies table
    $stmt = $pdo->prepare("DELETE FROM replies WHERE user_id = :userId");
    $stmt->bindParam(':userId', $userId);
    $stmt->execute();

    // Delete from topics table
    $stmt = $pdo->prepare("DELETE FROM topics WHERE user_id = :userId");
    $stmt->bindParam(':userId', $userId);
    $stmt->execute();

    // Delete from users table
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = :userId");
    $stmt->bindParam(':userId', $userId);
    $stmt->execute();

    // Commit the transaction
    $pdo->commit();

    echo "User and related data deleted successfully.";
} catch (PDOException $e) {
    // Rollback the transaction in case of any error
    $pdo->rollBack();
    echo "Error deleting user and related data: " . $e->getMessage();
}

?>
