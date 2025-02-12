<?php

namespace App\Models;

use DateTime;
use PDO;
use PDOException;


class SubscriptionsBooksModel
{
    protected $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getAllBooks($category, array $tags = [], ?string $format = null, int $qty = 25, $sort = "picksCount", $order = "DESC")
    {
        $allowedSortColumns = ['picksCount', 'pubDate'];
        $allowedOrders = ['ASC', 'DESC'];

        if (!in_array($sort, $allowedSortColumns, true))
        {
            $sort = "picksCount";
        }

        if (!in_array($order, $allowedOrders, true))
        {
            $order = "DESC";
        }

        $sql = "SELECT DISTINCT `books`.* FROM `books`";
        $params = [];

        if (!empty($tags)) {
            $sql .= " JOIN `tags` ON `books`.`id` = `tags`.`book_id`";
        }

        $conditions = [];

        if (!empty($tags)) {
            $placeholders = implode(',', array_fill(0, count($tags), '?'));
            $conditions[] = "`tags`.`tag` IN ($placeholders)";
            $params = array_merge($params, $tags);
        }

        if ($format) {
            $conditions[] = "`books`.`format` = ?";
            $params[] = $format;
        }

        if ($category) {
            $conditions[] = "`books`.`subject` = ?";
            $params[] = $category;
        }

        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }

        $sql .= " ORDER BY `books`.{$sort} {$order} LIMIT ?";

        $params[] = $qty;

        $query = $this->db->prepare($sql);

        foreach ($params as $index => $param) {
            $query->bindValue($index + 1, $param, is_int($param) ? PDO::PARAM_INT : PDO::PARAM_STR);
        }

        $query->execute();

        return $query->fetchAll();
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

    public function importBooks($books)
    {
        $query = $this->db->prepare('SELECT `isbn` FROM `books`');
        $query->execute();
        $existingBooksArray = $query->fetchAll(PDO::FETCH_COLUMN);

        foreach ($books as $book) {
            if (array_key_exists('PUB/REL DATE', $book)) {

                $isbn = $book['ISBN/Barcode'];
                $firstEight = substr($isbn, 0, 8);
                $image = $firstEight . '/' . $isbn;

                $dateString = $book['PUB/REL DATE'];

                $date = DateTime::createFromFormat('d M Y', $dateString);
                $sqlDate = $date->format('Y-m-d');


                try {
                    $query = $this->db->prepare('INSERT INTO `books` (`isbn`, `title`, `author`, `format`, `pubDate`, `price`, `image`)
    VALUES (:isbn, :title, :author, :format, :pubDate, :price, :image)');
                    $query->execute(['isbn' => $book['ISBN/Barcode'],
                        'title' => $book['TITLE'],
                        'author' => $book['AUTHOR/ARTIST/CONTRIBUTOR/BRAND'],
                        'format' => $book['FORMAT'],
                        'pubDate' => $sqlDate,
                        'price' => $book['RRP'],
                        'image' => $image]);
                } catch (PDOException $e) {
                    echo 'Error: ' . $e->getMessage() . "\n";
                }
            } elseif (array_key_exists('subject', $book)) {
                $isbn = $book['isbn'];
                $firstEight = substr($isbn, 0, 8);
                $image = $firstEight . '/' . $isbn;

                if (in_array($book['isbn'], $existingBooksArray)) {
                    $query = $this->db->prepare('UPDATE `books` SET `picksCount` = :picksCount WHERE `isbn` = :isbn');
                    $query->execute(['isbn' => $book['isbn'],
                        'picksCount' => $book['picks_count']]);
                } else {
                    $query = $this->db->prepare('INSERT INTO `books` (`isbn`, `title`, `author`, `format`, `pubDate`, `publisher`, `subject`, `price`, `picksCount`, `image`) 
                                                        VALUES (:isbn, :title, :author, :format, :pubDate, :publisher, :subject, :price, :picksCount, :image)');

                    $query->execute(['isbn' => $book['isbn'],
                        'title' => $book['title'],
                        'author' => $book['author'],
                        'format' => $book['format'],
                        'pubDate' => $book['publish_date'],
                        'publisher' => $book['publisher'],
                        'subject' => $book['subject'],
                        'price' => $book['price'],
                        'picksCount' => $book['picks_count'],
                        'image' => $image]);
                }
            }
        }
    }

    public function deleteTag($id, $tag): bool
    {
        try {
            $query = $this->db->prepare('DELETE FROM `tags` WHERE `tag` = :tag AND `book_id` = :book_id');
            $query->execute(['tag' => $tag, 'book_id' => $id]);

            $rowsDeleted = $query->rowCount();
            error_log('Rows deleted: ' . $rowsDeleted);
            return $rowsDeleted > 0;
        } catch (PDOException $e) {
        error_log('Error: ' . $e->getMessage() . "\n");
        return false;
    }
}
}