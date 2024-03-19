<?php

require_once __DIR__ . '/src/Core/Database.php';
require_once __DIR__ . '/src/Models/News.php';
require_once __DIR__ . '/src/Models/Comment.php';
require_once __DIR__ . '/src/Controllers/NewsManager.php';
require_once __DIR__ . '/src/Controllers/CommentManager.php';
require_once __DIR__ . '/config/database.php';

use Controllers\NewsManager;
use Models\News;
use Models\Comment;
use Controllers\CommentManager;
use Core\Database;

// Create a database connection
$database = new Database(DB_DSN, DB_USER, DB_PASSWORD);

// Instantiate the models
$newsModel = new News($database);
$commentModel = new Comment($database);

// Instantiate the controllers
$newsManager = new NewsManager($newsModel);
$commentManager = new CommentManager($commentModel);

// Get all news and comments
$allNews = $newsManager->listNews();
$allComments = $commentManager->listComments();

// Display news and associated comments
foreach ($allNews as $news) {
    echo "############ NEWS " . $news->getTitle() . " ############\n";
    echo $news->getBody() . "\n";
    
    foreach ($allComments as $comment) {
        if ($comment->getNewsId() == $news->getId()) {
            echo "Comment " . $comment->getId() . " : " . $comment->getBody() . "\n";
        }
    }
}