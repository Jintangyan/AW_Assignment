<?php
session_start(); 
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $db = "reviewsite";
    $fname = "";
    $lname = "";
    $userName = ""; 
    $email = "";

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $db);

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    } else {
        $fname = sanitizeInput($_POST["fname"]);
        $lname = sanitizeInput($_POST["lname"]);
        $plain_password = sanitizeInput($_POST["password"]); // Store plain password
        $hashed_password = password_hash($plain_password, PASSWORD_DEFAULT); 
        $userName = sanitizeInput($_POST["userName"]); 
        $email = sanitizeInput($_POST["email"]);

        $query = "INSERT INTO account (fname, lname, password, userName, email) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "sssss", $fname, $lname, $hashed_password, $userName, $email); // Use hashed password

        if (mysqli_stmt_execute($stmt)) {
            
             // Get the last inserted accountID
            $accountID = mysqli_insert_id($conn);
            //put accountID and userNmae into SESSION
            $_SESSION["accountID"] = $accountID;
            $_SESSION["userName"] = $userName;

            // Record inserted successfully
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            // Redirect to the index page
            header("Location: ../index.php");
            exit(); // Ensure that the script stops here to prevent further execution
        } else {
            echo "<p>something went wrong:</p> " . mysqli_error($conn);
        }
    }

    // Close the connection
    mysqli_close($conn);
}

function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>
