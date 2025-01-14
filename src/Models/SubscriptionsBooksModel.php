<?php

namespace App\Models;

use PDO;


class SubscriptionsBooksModel
{
    protected $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }
    public function getAll()
    {
        $query = $this->db->prepare("SELECT `books`.`id`, `isbn`, `title`, `author`, `format`, `pubDate`, `publisher`, `subject`, `price`, `picksCount`, `image`  FROM `books` ORDER BY picksCount DESC LIMIT 50");
        $query->execute();
        $books = $query->fetchAll();
        return $books;
    }
    public function getBooksByCategory($category)
    {
        $query = $this->db->prepare('SELECT `books`.`id`, `isbn`, `title`, `author`, `format`, `pubDate`, `publisher`, `subject`, `price`, `picksCount`, `image`  FROM `books` WHERE `subject` = :category ORDER BY picksCount DESC LIMIT 50');
        $query->execute(['category' => $category]);
        $books = $query->fetchAll(PDO::FETCH_ASSOC);
        return $books;
    }

    public function getCategories()
    {
        $query = $this->db->prepare('SELECT DISTINCT `subject` FROM `books`');
        $query->execute();
        $categories = $query->fetchAll(PDO::FETCH_ASSOC);
        return $categories;
    }

    public function getBooksByID($id)
    {
        $query = $this->db->prepare('
        SELECT 
            `books`.`id`, 
            `isbn`, 
            `title`, 
            `author`, 
            `format`, 
            `pubDate`, 
            `publisher`, 
            `subject`, 
            `price`, 
            `picksCount`, 
            `image`
        FROM `books` 
        WHERE `books`.`id` = :id');
        $query->execute(['id' => $id]);
        $books = $query->fetch(PDO::FETCH_ASSOC);
        return $books;
    }

    public function getTagsByBookID($id)
    {
        $query = $this->db->prepare('SELECT * FROM `tags` WHERE `book_id` = :id');
        $query->execute(['id' => $id]);
        $tags = $query->fetchAll(PDO::FETCH_ASSOC);
        return $tags;
    }

    public function addTag($id, $tag)
    {
        $query = $this->db->prepare('INSERT INTO `tags` (`book_id`, `tag`) VALUES (:book_id, :tag)');
        $query->execute(['book_id' => $id, 'tag' => $tag]);

    }
}