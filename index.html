<!DOCTYPE html>
<html lang="en">
<head>

    <title>Reviews of 60s</title>
    <?php include "pagesParts/head.php"; ?>
    
</head>
<body>
    <?php include "pagesParts/header.php"; ?>
    <?php include "db_connection.php"; ?> 

    <main class="homeContent">
        <div class="homeContentContainer">
            <img src="graphics/landscape/1960s.png" alt="1960s" class="homeImage">
        </div>
    </main>

    <h2>Top Movies</h2>
    <div class="galleryContainer">
        <?php
        // Fetch top 5 movies' 
        $query = "SELECT * FROM movie ORDER BY rating DESC LIMIT 5";
        $result = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_assoc($result)) {
           echo '
              <div class="col-sm-3">
                <div class="movie-container"> 
                  <img src="data:image/jpeg;base64,' . base64_encode($row["image"]) . '" class="img-responsive" alt="Image">
                  <p class="movie-name">' . $row["mname"] . '</p>
                  <p class="movie-rating">Rating: ' . $row["rating"] . '</p>
                </div>
              </div>
            
            ';
        }
        ?>
    </div>

    <div class="reviewContainer">
        <h3 >Top Reviews</h3>
        <?php
        $query = "SELECT review.*, movie.image, movie.rating, account.fname FROM review 
                  JOIN movie ON review.movieID = movie.movieID 
                  JOIN account ON review.accountID = account.accountID";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) === 0) {
            echo '<p>No reviews found.</p>';
        } else {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="reviewItem">';
                echo '<div class="reviewImage">';
                if (!empty($row["image"])) {
                    echo '<img src="data:image/jpeg;base64,' . base64_encode($row["image"]) . '" class="img-responsive" alt="Image">';
                } else {
                    echo '<p>No image available</p>';
                }
                echo '</div>';
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
