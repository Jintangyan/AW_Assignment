<?php
// Ensure that the database connection is available in this script
define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT'] . '/9092_1_9180_2_Website_Prototypel/');
include ROOT_PATH . 'db_connection.php';

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    
    if ($action == 'fetch_top_movies') {
        fetch_top_movies($conn);
    } elseif ($action == 'fetch_top_reviews') {
        fetch_top_reviews($conn);
    } elseif ($action == 'add_favorite') {
        add_favorite($conn);
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

function add_favorite($conn) {
    $paramMovieID = $_POST['movieID'];
    $paramAccountID = $_POST['accountID'];

    $query = "INSERT INTO favlist (movieID, accountID) VALUES (?, ?)";
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        echo json_encode(['status' => 'error', 'message' => $conn->error]);
        return;
    }
    $stmt->bind_param("ii", $paramMovieID, $paramAccountID);
    if (!$stmt->execute()) {
        echo json_encode(['status' => 'error', 'message' => $stmt->error]);
        return;
    }
    echo json_encode(['status' => 'success', 'message' => 'Movie Added Successfully']);
}

?>
