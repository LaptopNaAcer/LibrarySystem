<?php
require_once 'connect.php';

// Get the book_id from the request
$book_id = $_REQUEST['book_id'];

// Check the current status of the book
$result = $conn->query("SELECT `status` FROM `borrowing` WHERE `book_id` = '$book_id'");

if ($result) {
    $row = $result->fetch_assoc();
    
    // Check if the book's status is 'Borrowed'
    if ($row['status'] == 'Borrowed') {
        // If the book is currently being borrowed, show an alert and do not delete
        echo "<script>alert('The book is currently being borrowed and cannot be deleted.');</script>";
        echo "<script>window.location = 'book.php';</script>";
    } else {
        // Delete the book record and its borrowing record if status is not 'Borrowed'
        $conn->query("DELETE FROM `book` WHERE `book_id` = '$book_id'") or die(mysqli_error());
        $conn->query("DELETE FROM `borrowing` WHERE `book_id` = '$book_id'") or die(mysqli_error());
        header("location: book.php");
    }
} else {
    // Handle case if no book is found with the given book_id
    die("Book not found.");
}
?>
