<?php
session_start(); 

include "../db_connection.php";

$email = trim($_POST["email"]); 
$password = trim($_POST["password"]); 

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} else {
    $query = "SELECT * FROM account WHERE email = ? LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_array(MYSQLI_ASSOC);
        if (password_verify($password, $row["password"])) {
            // Store the account ID and userName in the session
            $_SESSION["accountID"] = $row["accountID"];
            $_SESSION["userName"] = $row["userName"]; // 

            // Redirect to index.php
            header("Location: ../index.php");
            exit;
        } else {
            // Debugging output
            echo "<p>Entered password: " . htmlspecialchars($password) . "</p>
            <p>Hashed password from database: " . htmlspecialchars($row["password"]) . "</p>
            <p>Password is Invalid ....</p>";
        }
    } else {
        echo "<p>Email not found ....</p>";
    }
}
?>
