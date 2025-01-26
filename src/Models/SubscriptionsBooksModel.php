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

    public function getAll($qty, $format = null)
    {
        $sql = "SELECT `books`.`id`, `isbn`, `title`, `author`, `format`, `pubDate`, `publisher`, `subject`, `price`, `picksCount`, `image`  FROM `books`";
        if ($format != null) {
            $sql .= " WHERE `format` = :format";
        }
        $sql .= " ORDER BY `books`.`picksCount` DESC LIMIT :limit";
        $query = $this->db->prepare($sql);
        if ($format)
        {
            $query->bindValue(':format', $format, PDO::PARAM_STR);
        }
        $query->bindParam(":limit", $qty, PDO::PARAM_INT);
        $query->execute();
        $books = $query->fetchAll();
        return $books;
    }

    public function getBooksByCategory($category, $qty)
    {
        $query = $this->db->prepare('SELECT `books`.`id`, `isbn`, `title`, `author`, `format`, `pubDate`, `publisher`, `subject`, `price`, `picksCount`, `image`  FROM `books` WHERE `subject` = :category ORDER BY picksCount DESC LIMIT :offset');
        $query->bindValue(':category', $category, PDO::PARAM_STR);
        $query->bindValue(':offset', $qty, PDO::PARAM_INT);
        $query->execute();
        $books = $query->fetchAll(PDO::FETCH_ASSOC);
        return $books;
    }

    public function getCategories()
    {
        $query = $this->db->prepare('SELECT DISTINCT `subject` FROM `books` ORDER BY `subject`');
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

    public function getTags()
    {
        $query = $this->db->prepare('SELECT DISTINCT `tag` FROM `tags` ORDER BY `tag`');
        $query->execute();
        $tags = $query->fetchAll(PDO::FETCH_ASSOC);
        return $tags;
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

    public function getBooksByTag($tag)
    {
        $query = $this->db->prepare('SELECT `books`.`id`, `isbn`, `title`, `author`, `format`, `pubDate`, `publisher`, `subject`, `price`, `picksCount`, `image` FROM `books` INNER JOIN `tags` ON `books`.`id` = `tags`.`book_id` WHERE `tags`.`tag` = :tag');
        $query->execute(['tag' => $tag]);
        $books = $query->fetchAll(PDO::FETCH_ASSOC);
        return $books;
    }

    public function getBooksBySearch($search, $qty)
    {
        $query = $this->db->prepare('SELECT `id`, `isbn`, `title`, `author`, `format`, `pubDate`, `publisher`, `subject`, `price`, `picksCount`, `image` FROM `books` WHERE `title` LIKE :search OR `author` LIKE :search OR `isbn` LIKE :search LIMIT :qty');
        $query->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
        $query->bindValue(':qty', $qty, PDO::PARAM_INT);
        $query->execute();
        $books = $query->fetchAll(PDO::FETCH_ASSOC);
        return $books;
    }

    public function getCount()
    {
        $query = $this->db->prepare('SELECT count(*) as count FROM `books`');
        $query->execute();
        $count = $query->fetch(PDO::FETCH_ASSOC);
        return $count;
    }
}