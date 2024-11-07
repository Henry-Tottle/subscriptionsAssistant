<?php
$db = new PDO('mysql:host=db; dbname=subscription_books', 'root','password');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

$json = file_get_contents('./subsBooks.json');
$booksData = json_decode($json, true);


foreach($booksData as $book)
{
    $suppliedID = $book['id'];
    $isbn = strval($book['isbn']);
    $title = $book['title'];
    $author = $book['author'];
    $format = $book['format'];
    $hardback = $book['hardback'] ? 1 : 0;
    $pubDate = $book['publish_date'];
    $subject = $book['subject'] ? $book['subject'][0] : "";
    $price = $book['price'];
    $blocked = $book['blocked'] ? 1 : 0;
    $picksCount = $book['picks_count'];
    $firstEight = substr($isbn, 0, 8);
    $image = $firstEight . '/' . $isbn;
    $query = $db->prepare('INSERT INTO `books` 
    (`suppliedID`, `isbn`, `title`, `author`, `format`, `hardback`, `pubDate`, `subject`, `price`, `blocked`, `picksCount`, `image`) 
VALUES (:suppliedID, :isbn, :title, :author, :format, :hardback, :pubDate, :subject, :price, :blocked, :picksCount, :image)');

    $query->execute(['suppliedID' => $suppliedID,
        'isbn' => $isbn,
        'title' => $title,
        'author' => $author,
        'format' => $format,
        'hardback' => $hardback,
        'pubDate' => $pubDate,
        'subject' => $subject,
        'price' => $price,
        'blocked' => $blocked,
        'picksCount' => $picksCount,
        'image' => $image]);
}
