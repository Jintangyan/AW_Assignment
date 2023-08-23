<?php 
session_start();   
include "db_connection.php";
include "process/index_process.php";

// Check if accountID is set in the session
$accountID = isset($_SESSION["accountID"]) ? $_SESSION["accountID"] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>   
    <title>Reviews of 60s</title>
    <?php include "pagesParts/head.php"; ?>
    <script>
        function addToSession(movieID, mname) {
           window.location.href = "details.php?movieID=" + movieID + "&mname=" + encodeURIComponent(mname);
        }

        document.addEventListener("DOMContentLoaded", function() {
            let addFavoriteButtons = document.querySelectorAll('.add_favorite');
            addFavoriteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    let movieID = this.getAttribute('mid');
                    let accountID = this.getAttribute('accountID');
                    addMovieToFavList(movieID, accountID);
                });
            });
        });

        function addMovieToFavList(movieID, accountID) {
            let xhr = new XMLHttpRequest();
            xhr.open('POST', 'process/index_process.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (this.status == 200) {
            let response = JSON.parse(this.responseText);
            if (response.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: response.message
                });
            } else if (response.status === 'error') {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message
                });
            }
                }
            }
            xhr.send('action=add_favorite&movieID=' + movieID + '&accountID=' + accountID);
        }
    </script>
</head>
<body>
    <?php include "pagesParts/header.php"; ?>

    <main class="homeContent">
        <div class="homeContentContainer">
            <img src="graphics/landscape/1960s.png" alt="1960s" class="homeImage">
        </div>
    </main>

    <h2 style="margin-left=30px;">Top Movies</h2> 
    <div class="galleryContainer">  
        <?php     
        $query = "SELECT * FROM movie ORDER BY rating DESC LIMIT 8";
        $result = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_assoc($result)) {
           echo '
              <div class="col-sm-3">
                <div class="movie-container"> 
                  <img src="graphics/' . $row["poster"] . '.jpg" class="img-responsive" alt="Image" onclick="addToSession(' . $row["movieID"] . ', \'' . $row["mname"] . '\')">
                  <p class="movie-name">' . $row["mname"] . '</p>
                  <p class="movie-rating">Rating: ' . $row["rating"] . '</p>
                  <button style="float:right;background-color: white;" class="btn btn-info btn-xs add_favorite" mid="' . $row["movieID"] . '" accountID ="' . $accountID . '" id="' . $row["movieID"] . '"><i class="fas fa-heart" style="color: red;"></i></button> 
                </div>
              </div>
            ';
        }
        ?>
    </div>
    
    <h2 style="margin-left=30px;">Guess You Like</h2> 
    <div class="guessContainer">  
        <?php     
        $random_ids = array_rand(range(1, 20), 4);
        $query = "SELECT * FROM movie WHERE movieID IN (" . implode(',', $random_ids) . ")";
        $result = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_assoc($result)) {
           echo '
              <div class="col-sm-3">
                <div class="movie-container"> 
                  <img src="graphics/' . $row["poster"] . '.jpg" class="img-responsive" alt="Image" onclick="addToSession(' . $row["movieID"] . ', \'' . $row["mname"] . '\')">
                  <p class="movie-name">' . $row["mname"] . '</p>
                  <p class="movie-rating">Rating: ' . $row["rating"] . '</p>
                  <button style="float:right;background-color: white;" class="btn btn-info btn-xs add_favorite" mid="' . $row["movieID"] . '" accountID ="' . $_SESSION["accountID"] . '" id="' . $row["movieID"] . '"><i class="fas fa-heart" style="color: red;"></i></button> 
                </div>
              </div>
            ';
        }
        ?>
    </div>

    <?php include "pagesParts/footer.php"; ?>
</body>
</html>
