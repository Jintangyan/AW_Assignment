<?php 
session_start();
$selectedGenre = isset($_GET['genre']) ? $_GET['genre'] : null;
$accountID = isset($_SESSION["accountID"]) ? $_SESSION["accountID"] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Movie</title>
    <?php include "pagesParts/head.php"; ?>
    <style>



        /* Custom CSS styles */
        .main_container {
            width: 90%;
            margin: 0 auto;
            display: flex; /* Flexbox to align filter and mcategory horizontally */
        }
        .filter {
            width: 20%;
            display: flex;
            flex-direction: column;
            align-items: center; /* Center buttons horizontally */
            justify-content: center; /* Center buttons vertically */
        }
        .mcategory {
            width: 80%;
        }
        .genre-btn:hover {
            background-color: #007BFF;
            color: white;
        }
        .genre-btn:active {
            background-color: #0056b3;
            color: white;
        }
    </style>
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
 <?php include "db_connection.php"; ?> 
<?php
// fetch and store movie data
function fetchMovieData($conn) {
  // Fetch 10 random movies
  $sql = "SELECT * FROM movie ORDER BY RAND() LIMIT 20";
  $result = $conn->query($sql);
  $movieData = array();

  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $movieData[] = $row;
    }
  }

  return $movieData;
}

// generate carousel slides function
function generateCarouselSlides($movieData) {
  if (!empty($movieData)) {
    echo '<div id="movieCarousel" class="carousel slide" data-ride="carousel">';
    echo '<ol class="carousel-indicators">';
    
    // Calculate the number of indicators based on groups of 4 movies
    $numIndicators = ceil(count($movieData) / 4);
    for ($i = 0; $i < $numIndicators; $i++) {
      echo '<li data-target="#movieCarousel" data-slide-to="' . $i . '"';
      if ($i === 0) { // The first indicator is active
        echo ' class="active"';
      }
      echo '></li>';
    }

    echo '</ol>';
    echo '<div class="carousel-inner">';

    foreach ($movieData as $index => $movie) {
      // Start a new slide for every group of 4 movies
      if ($index % 4 == 0) {
        echo '<div class="item';
        if ($index === 0) { // The first slide is active
          echo ' active';
        }
        echo '">';
      }

      echo '<img src="graphics/' . $movie["poster"] . '.jpg" alt="' . $movie["mname"] . '" class="carousel-image" >';

      // Close the slide after every group of 4 movies or at the end
      if ($index % 4 == 3 || $index == count($movieData) - 1) {
        echo '</div>';
      }
    }

    echo '</div>';
    echo '<a class="left carousel-control" href="#movieCarousel" data-slide="prev">';
    echo '<span class="glyphicon glyphicon-chevron-left"></span>';
    echo '<span class="sr-only">Previous</span>';
    echo '</a>';
    echo '<a class="right carousel-control" href="#movieCarousel" data-slide="next">';
    echo '<span class="glyphicon glyphicon-chevron-right"></span>';
    echo '<span class="sr-only">Next</span>';
    echo '</a>';
    echo '</div>';
  } else {
    echo '<p>No movies found for carousel.</p>';
  }
}

// Fetch and store movie data
$movieData = fetchMovieData($conn);
?>

<div class="jumbotron">
  <div class="carousel-container">
    <!-- Call generate carousel slides function -->
    <?php generateCarouselSlides($movieData); ?>
  </div>
</div>

<div class="main_container">
    <div class="filter">
        <?php
        $genres = array("Action", "Romance", "Horror", "Spy", "Western", "Crime", "Drama", "Comedy", "Family");
        foreach ($genres as $genre) {
            echo '<a href="?genre=' . urlencode($genre) . '" class="btn btn-primary genre-btn">' . $genre . '</a><br>';
        }
        ?>
    </div>

    <div class="mcategory">
        <?php
        if ($selectedGenre) {
            $sql = "SELECT * FROM movie WHERE genre LIKE '%$selectedGenre%'";
        } else {
            $sql = "SELECT * FROM movie";
        }
        $result = $conn->query($sql);

        if ($result === false) {
            echo "Error executing the query: " . $conn->error;
        } else {
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
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
            } else {
                echo "No movies found for this genre.";
            }
        }
        $conn->close();
        ?>
    </div>
</div>

<?php include "pagesParts/footer.php"; ?>
</body>    
</html>