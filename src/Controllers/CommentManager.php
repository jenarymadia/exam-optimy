<?php

namespace Controllers;

use Models\Comment;
use Core\Database;

class CommentManager
{
    private Comment $commentModel;

    public function __construct(Comment $commentModel)
    {
        $this->commentModel = $commentModel;
    }

    public function listComments()
    {
        $rows = $this->commentModel->getAllComments();

        $comments = [];
        $database = new Database(DB_DSN, DB_USER, DB_PASSWORD);
		foreach($rows as $row) {
			$n = new Comment($database);
			$comments[] = $n->setId($row['id'])
			  ->setBody($row['body'])
			  ->setCreatedAt($row['created_at'])
			  ->setNewsId($row['news_id']);
		}
		return $comments;
    }

}