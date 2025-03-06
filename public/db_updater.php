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


## To Do

//This works great to import subjects into the list, consider reworking and making a function that can be used by a front end?

$fantasyBooks = file_get_contents('newerSciFi.txt');
$fantasyBooksArray = explode(PHP_EOL,$fantasyBooks);
echo gettype($fantasyBooksArray);
//var_dump($fantasyBooksArray);
foreach($fantasyBooksArray as $fantasyBook){
    $subject = '["SCIENCE-FICTION"]';
    $fantasyBook = trim($fantasyBook);
    try {
        $query = $db->prepare('UPDATE `books` SET `subject` = :subject WHERE `isbn` = :isbn');
        $query->execute(['subject' => $subject, 'isbn' => $fantasyBook]);
    } catch(PDOException $e) {
        echo 'It didn\'t work...' . $e->getMessage();
    }
}


//$bulkTagImportBooks = file_get_contents('translatedFiction.txt');
//$bookArray = explode(PHP_EOL, $bulkTagImportBooks);
//echo gettype($bookArray);
////var_dump($bookArray);
//foreach ($bookArray as $book) {
//    $tag = 'translated fiction';
//    $book = rtrim($book, ',');
//    echo 'Book: ' . $book;
//    try {
//        $query = $db->prepare('SELECT `id` FROM `books` WHERE `isbn` = :book');
//        $query->execute(['book' => $book]);
//        $bookId = $query->fetchColumn();
//    } catch (PDOException $e) {
//        echo 'It didn\'t work: ' . $e->getMessage();
//    }
//
//    try {
//        $query = $db->prepare('INSERT INTO `tags` (`book_id`, `tag`) VALUES (:id, :tag)');
//        $query->execute(['id' => $bookId, 'tag' => $tag]);
//
//    } catch (PDOException $e) {
//        echo 'It didn\'t work: ' . $e->getMessage();
//    }
//}