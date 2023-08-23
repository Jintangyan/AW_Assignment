<?php
include "../db_connection.php";
session_start();

if (isset($_POST['movieID']) && isset($_POST['mname'])) {
    $_SESSION['movieID'] = $_POST['movieID'];
    $_SESSION['mname'] = $_POST['mname'];
}


$search = $_GET['search'];

$sql = "SELECT * FROM movie WHERE mname LIKE '%$search%'";
$result = $conn->query($sql);

$movies = [];
while ($row = $result->fetch_assoc()) {
    $movies[] = $row;
}

echo json_encode($movies);
?>
