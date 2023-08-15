<?php session_start();

if(isset($_POST['movieID']) && isset($_POST['mname'])) {
    $_SESSION['selectedMovieID'] = $_POST['movieID'];
    $_SESSION['selectedMname'] = $_POST['mname'];
    echo 'Session updated successfully.';
} else {
    echo 'Error updating session.';
}
?>
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
                <a href="details.php?movieID=' . $row["movieID"] . '" onclick="updateSession(' . $row["movieID"] . ', \'' . $row["mname"] . '\')">
                  <img src="data:image/jpeg;base64,' . base64_encode($row["image"]) . '" class="img-responsive" alt="Image">
                </a>;
                  <p class="movie-name">' . $row["mname"] . '</p>
                  <p class="movie-rating">Rating: ' . $row["rating"] . '</p>
                   <button style="float:right;background-color: white;" class="btn btn-info btn-xs add_movie" mid="movieID" id="' . $row["movieID"] . '" onclick="addFav(' . $row["movieID"] . ', ' . $_SESSION['accountID'] . ')"><i class="fas fa-heart" style="color: red;"></i></button> 
              </div>
              </div>
            
            ';
        }
        ?>
    </div>

    <div class="reviewContainer">
        <h3 >Top Reviews</h3>
        <?php
        $query = "SELECT review.*, movie.image, movie.mname, movie.rating, account.fname FROM review 
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
                   echo '<a href="details.php?movieID=' . $row["movieID"] . '" onclick="updateSession(' . $row["movieID"] . ', \'' . $row["mname"] . '\')">';
                    echo '<img src="data:image/jpeg;base64,' . base64_encode($row["image"]) . '" class="img-responsive" alt="Image">';
                    echo '</a>';

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
