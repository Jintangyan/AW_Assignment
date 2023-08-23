<?php   
session_start();

 include "db_connection.php";

// Check if accountID is set in the session
if(isset($_SESSION["accountID"])) {
    $accountID = $_SESSION["accountID"];
} else {
    // Redirect to login page if accountID is not set
    header("Location: login.php");
    exit;
}

/// Fetch account details
$query = "SELECT * FROM account WHERE accountID = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $accountID);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$account = mysqli_fetch_assoc($result);

// Get the favlist value
$favlist = $account['favlist'];

// Close the statement object
mysqli_stmt_close($stmt);

// Update account details
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["updateAccount"])) {
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT); // Hash the password
    $query = "UPDATE account SET fname=?, lname=?, userName=?, email=?, password=? WHERE accountID=?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "sssssi", $firstname, $lastname, $username, $email, $password, $accountID);
    mysqli_stmt_execute($stmt);
    header("Location: account.php");
    exit;
}

// Update favlist name
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["updateFavlist"])) {
    $newFavlist = $_POST["listname"];
    $query = "UPDATE account SET favlist=? WHERE accountID=?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "si", $newFavlist, $accountID);
    mysqli_stmt_execute($stmt);
    header("Location: account.php");
    exit;
}

// Logout
if(isset($_GET["action"]) && $_GET["action"] == "logout") {
    unset($_SESSION["accountID"]);
    header("Location: login.php");
    exit;
}



 // Fetch favorite list data
    $query = "SELECT movie.* FROM favlist INNER JOIN movie ON favlist.movieID = movie.movieID WHERE favlist.accountID = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $_SESSION["accountID"]);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $favourites = mysqli_fetch_all($result, MYSQLI_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["movieID"])) {
    $movieID = $_POST["movieID"];
    $query = "DELETE FROM favlist WHERE movieID = ? AND accountID = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ii", $movieID, $_SESSION["accountID"]);
    mysqli_stmt_execute($stmt);
    header('Content-Type: application/json');
    echo json_encode(["status" => "success"]);
    exit;
}

// ... your existing code ...

// Check if reviewID is set in the URL
if (isset($_GET["reviewID"])) {
    $reviewID = $_GET["reviewID"];
    
    // Prepare the delete query
    $query = "DELETE FROM review WHERE reviewID = ? AND accountID = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ii", $reviewID, $accountID);
    if (mysqli_stmt_execute($stmt)) {
        // Successful deletion
        $_SESSION['message'] = "Review deleted successfully!";
    } else {
        // Error during deletion
        $_SESSION['message'] = "Error deleting the review.";
    }
    mysqli_stmt_close($stmt);
    
    // Redirect back to account.php
    header("Location: account.php");
    exit;
}


?>


<!DOCTYPE html>
<html>
<head>
    <title>Account Page</title>
     <?php include "pagesParts/head.php"; ?>
    <?php include "pagesParts/header.php"; ?>
    
    
<script>
    function confirmLogout() {
        var r = confirm("Do you want to logout?");
        if (r == true) {
            window.location.href = "account.php?action=logout";
        }
    }
    
    $(document).ready(function() {
    $("body").on("click", ".remove-movie", function(event) {
        event.preventDefault();
        var movieID = $(this).attr('data-id');
        $.ajax({
            url: "account.php",
            method: "POST",
            data: { movieID: movieID },
            dataType: "json",  // Expect a JSON response
            success: function(response) {
                if (response.status == "success") {
                    alert("Movie item deleted successfully!");
                    // Remove the item from the DOM without a full page reload
                    $(".favourite-item[data-id='" + movieID + "']").remove();
                } else {
                    alert("Error removing the item from the list.");
                    console.log(response);
                }
            },
            error: function(){
                alert("Error removing the item from the list.");
            }
        });

    });
});


</script>

</head>
<body>
     
    <div class="container">
        <div class="wrapper">
            <div class="main">
                <div class="account-details">
                    <?php
                    if (isset($_SESSION["update_success"])) {
                        echo '<script>alert("Account Information Updated");</script>';
                        unset($_SESSION["update_success"]);
                    }
                    ?>

                    <h1>Welcome, <span id="username"><?php echo $account["userName"]; ?></span></h1>
                    <h2>Account Details</h2>
                    <form action="account.php" method="post">
                        <input type="hidden" name="updateAccount" value="1"> <!-- This hidden input -->
                        <div class="labels">
                            <label for="firstname">First Name:</label><br>
                            <label for="lastname">Last Name:</label><br>
                            <label for="username">Username:</label><br>
                            <label for="email">Email:</label><br>
                            <label for="password">Password:</label><br>
                        </div>
                        <div class="inputs">
                            <input type="text" name="firstname" id="firstname" value="<?php echo $account["fname"]; ?>"><br>
                            <input type="text" name="lastname" id="lastname" value="<?php echo $account["lname"]; ?>"><br>
                            <input type="text" name="username" id="username" value="<?php echo $account["userName"]; ?>"><br>
                            <input type="email" name="email" id="email" value="<?php echo $account["email"]; ?>"><br>
                            <input type="password" name="password" id="password"><br>
                            <input type="submit" value="Update Account">
                            <a href="#" onclick="confirmLogout()" style="float:right;">Logout</a>
                        </div>
                    </form>
                </div>
                <div class="reviews">
                     <?php
                        if (isset($_SESSION['message'])) {
                            echo "<div class='message'>" . $_SESSION['message'] . "</div>";
                            unset($_SESSION['message']); // Clear the message after displaying it
                        }
                        ?>
                    <h2>My Reviews</h2>
                    <?php
                    // Fetch reviews
                   $query = "SELECT review.*, movie.mname, movie.poster, movie.rating FROM review INNER JOIN movie ON review.movieID = movie.movieID WHERE review.accountID = ?";
                    $stmt = mysqli_prepare($conn, $query);
                    mysqli_stmt_bind_param($stmt, "i", $_SESSION["accountID"]);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    $reviews = mysqli_fetch_all($result, MYSQLI_ASSOC);

                    // Close the statement object
                    mysqli_stmt_close($stmt);

                    // Check if the user has written any reviews
                    if (count($reviews) > 0) {
                        foreach ($reviews as $review) {
                            echo "<div class='review' >";
                            echo "<img src='graphics/" . $review["poster"] . ".jpg' alt='" . $review["mname"] . "' width='100'>";
                            echo "<div class='review-content'>";
                            echo "<h5>" . $review["mname"] . "</h5>";
                            echo "<p>Rating: " . $review["rating"] . "</p>"; // Display rating
                            echo "<p>" . $review["description"] . "</p>";
                            echo "<div class='review-actions'>";
                            // Edit link with parameters
                            echo "<a href='javascript:void(0);' onclick=\"window.open('review.php?movieID=" . $review["movieID"] . "&rating=" . $review["rating"] . "&movieName=" . urlencode($review["mname"]) . "&description=" . urlencode($review["description"]) . "', '_blank', 'width=600,height=400');\">Edit</a> | ";
                            // Delete link
                            echo "<a href='account.php?reviewID=" . $review["reviewID"] . "'>Delete</a>";
                            echo "</div>";
                            echo "</div>";
                            echo "</div>";
                        }
                    } else {
                        echo "<p>You haven't written any reviews yet!</p>";
                    }
                    ?>
            </div>
            </div>
               <div class="sidebar">
                   
                    <div class="favourites">               
                        <h4><?php echo htmlspecialchars($favlist); ?></h4>
                        <form method="post" action="account.php">
                            <label for="listname">List Name:</label>
                            <input type="text" name="listname" id="listname" value="<?php echo htmlspecialchars($favlist); ?>">
                            <input type="submit" name="updateFavlist" value="Update">
                        </form>
                    <br>
                        <?php
                            foreach ($favourites as $favourite) {
                                echo "<div class='favourite-item' data-id='" . $favourite["movieID"] . "'>";
                                echo "<img src='graphics/" . $favourite["poster"] . ".jpg' alt='" . $favourite["mname"] . "' width='100'>";
                                echo "<div class='favourite-content'>";
                                echo "<h4>" . $favourite["mname"] . "</h4>";
                                echo "<p>Runtime: " . $favourite["runtime"] . "</p>";
                                echo "<p>Rate: " . $favourite["rating"] . "</p>";
                                echo "<p>Starring: " . $favourite["starring"] . "</p>";
                                echo "</div>";
                                echo "<a class='remove-movie' data-id='" . $favourite["movieID"] . "'>REMOVE</a>";
                                echo "</div>";
                            }
                        ?>
                    </div>
                </div>

            
        </div>
    </div>
</body>
</html>
