<?php   
session_start();

if (isset($_GET['movieID'])) {
    $_SESSION['movieID'] = $_REQUEST['movieID'];
}

if (isset($_GET['mname'])) {
    $_SESSION['mname'] = $_REQUEST['mname'];
}

$selectedMovieID = $_SESSION['movieID'];
$selectedMname = $_SESSION['mname'];

if (isset($_GET['action'])) {
    include "../db_connection.php";
    $action = $_GET['action'];
    if ($action == 'getMovieDetails') {
        $stmt = $conn->prepare("SELECT * FROM movie WHERE movieID = ?");
        $stmt->bind_param("i", $selectedMovieID);
        $stmt->execute();
        $result = $stmt->get_result();
        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            echo json_encode($row);
        }
    } elseif ($action == 'getReviews') {
        $stmt = $conn->prepare("SELECT review.*, account.fname FROM review 
                        JOIN account ON review.accountID = account.accountID
                        WHERE review.movieID = ?");
        $stmt->bind_param("i", $selectedMovieID);
        $stmt->execute();
        $result = $stmt->get_result();
        $reviews = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $reviews[] = $row;
        }
        echo json_encode($reviews);
    }
}
?>
