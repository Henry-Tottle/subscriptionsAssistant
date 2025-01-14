<?php
$db = new PDO('mysql:host=db; dbname=subscriptions_test_database', 'root','password');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);


$query = $db->prepare('SELECT `isbn` FROM `books`');
$query->execute();
$books = $query->fetchAll();


//foreach ($books as $book)
//{
//    $isbn = $book['isbn'];
//    $firstEight = substr($isbn, 0, 8);
//    $image = $firstEight . '/' . $isbn;
//    $query = $db->prepare('UPDATE `books` SET `image` = :image WHERE isbn = :isbn');
//    $query->execute(['image' => $image, 'isbn' => $isbn]);
//
//}

$fantasyBooks = file_get_contents('crimeISBNS.txt');
$fantasyBooksArray = explode(',',$fantasyBooks);
echo gettype($fantasyBooksArray);
//var_dump($fantasyBooksArray);
foreach($fantasyBooksArray as $fantasyBook){
    $subject = '["CRIME & MYSTERY"]';
    $fantasyBook = trim($fantasyBook);
    try {
        $query = $db->prepare('UPDATE `books` SET `subject` = :subject WHERE `isbn` = :isbn');
        $query->execute(['subject' => $subject, 'isbn' => $fantasyBook]);
    } catch(PDOException $e) {
        echo 'It didn\'t work...' . $e->getMessage();
    }
}