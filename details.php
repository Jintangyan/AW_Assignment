<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Details</title>
    <?php include "pagesParts/head.php"; ?>
</head>
<body>
    <?php include "pagesParts/header.php"; ?>
    <?php include "db_connection.php"; ?> 

    <main class="homeContent">
        <div class="homeContentContainer">
            <img src="graphics/landscape/breakfast-at-tiffanys.jpg" alt="1960s" class="homeImage">
        </div>
    </main>
<?php
$query = "SELECT * FROM movie WHERE movieID = 7";
$result = mysqli_query($conn, $query);

// Check if there is exactly one row returned from the query
if (mysqli_num_rows($result) === 1) {
    $row = mysqli_fetch_assoc($result);
    echo '
        <div class="galleryContainer">
            <div class="col-sm-3">
                <div class="imag-container"> 
                    <img src="data:image/jpeg;base64,' . base64_encode($row["image"]) . '" class="img-responsive" alt="Image">
                </div>
            </div>
            <div class="info-container">
                <p>Movie Title: ' . $row["mname"] . '</p>
                <p>Genre: ' . $row["genre"] . '</p>
                <p>Director: ' . $row["director"] . '</p>
                <p>Release Date: ' . $row["releaseDate"] . '</p>
                <p>Rating: ' . $row["rating"] . '</p>
                <p>Duration: ' . $row["runtime"] . ' mins</p>
                <p>Starring: ' . $row["starring"] . ' </p>
            </div>
        </div>';
} else {
    echo '<p>No movie found with the given ID.</p>';
}
?>
    
    <div class="reviewContainer">
        <h3 >Reviews</h3>
        <?php
       $query = "SELECT review.*, movie.image, movie.rating, account.fname FROM review 
          JOIN movie ON review.movieID = movie.movieID
          JOIN account ON review.accountID = account.accountID
          WHERE movie.movieID = 7";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) === 0) {
            echo '<p>No reviews found.</p>';
        } else {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="reviewInfo">';
                if (!empty($row["rating"])) {
                    echo '<p>Rating: ' . $row["rating"] . '</p>';
                } else {
                    echo '<p>Rating: 0</p>';
                }
                if (!empty($row["fname"])) {
                    echo '<p>User: ' . $row["fname"] . '</p>';
                } else {
                    echo '<p>User: Not available</p>';
                }
                if (!empty($row["description"])) {
                    echo '<p>Review: ' . $row["description"] . '</p>';
                } else {
                    echo '<p>Review: Not available</p>';
                }
                echo '</div>';
                echo '</div>';
            }
        }
        ?>
    </div>


    <?php include "pagesParts/footer.php"; ?>
</body>
</html>
