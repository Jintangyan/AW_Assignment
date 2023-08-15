<?php
session_start(); 
include "db_connection.php";

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    
    if ($action == 'fetch_top_movies') {
        fetch_top_movies($conn);
    } elseif ($action == 'fetch_top_reviews') {
        fetch_top_reviews($conn);
    } elseif ($action == 'add_favorite') {
        add_favorite($conn);
    } elseif ($action == 'update_session') {
        updateSession($conn);
    }
}


function fetch_top_movies($conn) {
    $query = "SELECT * FROM movie ORDER BY rating DESC LIMIT 5";
    $result = mysqli_query($conn, $query);
    $movies = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $movies[] = $row;
    }
    echo json_encode($movies);
}

function fetch_top_reviews($conn) {
    $query = "SELECT review.*, movie.image, movie.rating, account.fname FROM review 
              JOIN movie ON review.movieID = movie.movieID 
              JOIN account ON review.accountID = account.accountID";
    $result = mysqli_query($conn, $query);
    $reviews = [];
    if (mysqli_num_rows($result) !== 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $reviews[] = $row;
        }
    }
    echo json_encode($reviews);
}

function add_favorite($conn) {
    $movieID = $_POST['movieID'];
    $accountID = $_POST['accountID'];

    $query = "INSERT INTO favlist (movieID, accountID) VALUES (?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $movieID, $accountID);
    $stmt->execute();

    echo 'Success';
}

function updateSession($conn) {
    if(isset($_POST['movieID']) && isset($_POST['mname'])) {
        $_SESSION['selectedMovieID'] = $_POST['movieID'];
        $_SESSION['selectedMname'] = $_POST['mname'];
        echo 'Session updated successfully.';
    } else {
        echo 'Error updating session.';
    }
}


    
?>
