<?php   
session_start();

if (isset($_GET['movieID'])) {
    $_SESSION['movieID'] = $_REQUEST['movieID'];
}

if (isset($_GET['mname'])) {
    $_SESSION['mname'] = $_REQUEST['mname'];
}

$selectedMovieID = $_SESSION['movieID'];
$selectedMname = $_SESSION['mname'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Details</title>
    <?php include "pagesParts/head.php"; ?>
    <style>
        /* Add this CSS to center the reviewContainer div */
    
        .reviewContainer {
            width: 80%; /* Set a width for the reviewContainer div */
            margin: 150px auto; /* Center the div horizontally */
        }
    </style>

</head>
<body>
    <?php include "pagesParts/header.php"; ?>
    <?php include "db_connection.php"; ?> 
   
    <br><br><br>
    
    <main class="homeContent" margin="30">
        <div class="homeContentContainer" height="510">     
           <img src="graphics/landscape/<?php echo $selectedMname;?>.jpg" alt="<?php echo $selectedMname;?>" class="homeImage"  height="500">
        </div>
    <br>  <br>       
    
    <?php
    $stmt = $conn->prepare("SELECT * FROM movie WHERE movieID = ?");
    $stmt->bind_param("i", $selectedMovieID); // "i" indicates the variable type is an integer
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if there is exactly one row returned from the query
    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        echo '
            <div class="galleryContainer">
            
                <div class="imag-container"> 
                  <img src="graphics/' . $row["poster"] . '.jpg" class="img-responsive" alt="Image">
            </div>
            <div class="info-container" width 350px;>
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

    <div class="reviewContainer" style="margin=150px;">
    <h3>Reviews</h3>
    <button onclick="openReviewForm()">Review this Movie</button>
    <?php
    $stmt = $conn->prepare("SELECT review.*, movie.poster, movie.mname, movie.rating, account.fname FROM review 
                    JOIN movie ON review.movieID = movie.movieID
                    JOIN account ON review.accountID = account.accountID
                    WHERE movie.movieID = ?");
    $stmt->bind_param("i", $selectedMovieID);
    $stmt->execute();
    $result = $stmt->get_result();

    if (mysqli_num_rows($result) === 0) {
        echo '<p>No reviews found.</p>';
    } else {
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="reviewInfo">';
            if (!empty($row["fname"])) {
                echo '<p>User: ' . $row["fname"] . '</p>';
            } else {
                echo '<p>User: Not available</p>';
            }
            if (!empty($row["rating"])) {
                echo '<p>Rate: ' . $row["rating"] . '</p>';
            } else {
                echo '<p>Rate: Not available</p>';
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
<div id="reviewModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeReviewForm()">&times;</span>
        <iframe src="review.php?movieID=<?php echo $selectedMovieID; ?>&movieName=<?php echo urlencode($row['mname']); ?>" width="100%" height="400"></iframe>
    </div>
</div>
<script>
    function openReviewForm() {
        document.getElementById('reviewModal').style.display = 'block';
    }
    function closeReviewForm() {
        document.getElementById('reviewModal').style.display = 'none';
    }
    
     function fetchLatestReviews() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'detail_process.php?action=getReviews', true);
    xhr.onload = function() {
        if (this.status == 200) {
            var reviews = JSON.parse(this.responseText);
            var output = '';
            for (var i in reviews) {
                output += '<div class="reviewInfo">';
                output += '<p>User: ' + (reviews[i].fname || 'Not available') + '</p>';
                output += '<p>Rate: ' + (reviews[i].rating || 'Not available') + '</p>';
                output += '<p>Review: ' + (reviews[i].description || 'Not available') + '</p>';
                output += '</div>';
            }
            document.querySelector('.reviewContainer').innerHTML = output;
        }
    }
    xhr.send();
}
    window.onload = function() {
    fetchLatestReviews(); // Fetch reviews when the page loads
    setInterval(fetchLatestReviews, 1000); // Fetch reviews every 3 seconds
}

</script>

</main>
    <?php include "pagesParts/footer.php"; ?>
        
</body>
</html>
