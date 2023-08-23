<?php
$movieID = $_POST['movieID'];
$accountID = $_POST['accountID'];
$description = $_POST['description'];
$rate = $_POST['rate'];

include "../db_connection.php"; 

if ($conn->connect_error) {
    die(json_encode(['status' => 'error', 'message' => "Connection failed: " . $conn->connect_error]));
}

$stmt = $conn->prepare("INSERT INTO review (movieID, accountID, description) VALUES (?, ?, ?)");
if (!$stmt) {
    die(json_encode(['status' => 'error', 'message' => "Prepare failed: " . $conn->error]));
}
$stmt->bind_param("iis", $movieID, $accountID, $description);
if (!$stmt->execute()) {
    die(json_encode(['status' => 'error', 'message' => "Execute failed: " . $stmt->error]));
}
$stmt->close();

$stmt = $conn->prepare("UPDATE movie SET total_rate = total_rate + ?, num_of_rate = num_of_rate + 1 WHERE movieID = ?");
if (!$stmt) {
    die(json_encode(['status' => 'error', 'message' => "Prepare failed: " . $conn->error]));
}
$stmt->bind_param("ii", $rate, $movieID);
if (!$stmt->execute()) {
    die(json_encode(['status' => 'error', 'message' => "Execute failed: " . $stmt->error]));
}
$stmt->close();

echo json_encode(['status' => 'success', 'message' => 'Review added successfully']);
$conn->close();
?>
