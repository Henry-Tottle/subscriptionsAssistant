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
        $query = $this->db->prepare("SELECT * FROM books ORDER BY picksCount DESC LIMIT 50");
        $query->execute();
        $books = $query->fetchAll();
        return $books;
    }
    public function getBooksByCategory($category)
    {
        $query = $this->db->prepare('SELECT * FROM `books` WHERE `subject` = :category ORDER BY picksCount DESC LIMIT 100');
        $query->execute(['category' => $category]);
        $books = $query->fetchAll();
        return $books;
    }

    public function getCategories()
    {
        $query = $this->db->prepare('SELECT DISTINCT `subject` FROM `books`');
        $query->execute();
        $categories = $query->fetchAll();
        return $categories;
    }

    public function getBooksByID($id)
    {
        $query = $this->db->prepare('SELECT * FROM `books` WHERE `id` = :id');
        $query->execute(['id' => $id]);
        $books = $query->fetch();
        return $books;
    }
}