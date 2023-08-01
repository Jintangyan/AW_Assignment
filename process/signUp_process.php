<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $db = "reviewsite";
    $fname = "";
    $lname = "";
    $email = "";

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $db);

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    } else {
        $fname = sanitizeInput($_POST["fname"]);
        $lname = sanitizeInput($_POST["lname"]);
        $password = sanitizeInput($_POST["password"]);
        $email = sanitizeInput($_POST["email"]);

        $query = "INSERT INTO account (fname, lname,  password, email) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "ssss", $fname, $lname, $password, $email);

       if (mysqli_stmt_execute($stmt)) {
            // Record inserted successfully
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            // Redirect to the index page
            header("Location: index.php");
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
