<!DOCTYPE html>
<html lang="en">
<title>Movie</title>
<?php include "pagesParts/head.php"; ?>

<body>
 <?php include "pagesParts/header.php"; ?>
 <?php include "db_connection.php"; ?> 
<?php
// fetch and store movie data
function fetchMovieData($conn) {
  $sql = "SELECT * FROM movie ORDER BY rating DESC LIMIT 5";
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
    $activeIndex = 0; // Initialize the active index
    echo '<div id="movieCarousel" class="carousel slide" data-ride="carousel">';
    echo '<ol class="carousel-indicators">';
    
    for ($i = 0; $i < count($movieData); $i++) {
      echo '<li data-target="#movieCarousel" data-slide-to="' . $i . '"';
      if ($i === $activeIndex) { // Check if this indicator is for the active slide
        echo ' class="active"';
      }
      echo '></li>';
    }

    echo '</ol>';
    echo '<div class="carousel-inner">';

    foreach ($movieData as $index => $movie) {
      echo '<div class="item';
      if ($index === $activeIndex) { // Check if this slide is the active slide
        echo ' active';
      }
      echo '">';
      echo '<img src="data:image/jpeg;base64,' . base64_encode($movie["image"]) . '" alt="' . $movie["mname"] . '" class="carousel-image">';
      echo '</div>';
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

    return $activeIndex;
    
  } else {
    echo '<p>No movies found for carousel.</p>';
    return -1; // Return -1 to indicate no active index
  }
}

// generate movie information function 
function generateMovieInfo($movieData, $activeIndex) {
  if (!empty($movieData) && isset($movieData[$activeIndex])) {
    $movie = $movieData[$activeIndex];
    echo '<div class="movieInfo">
    <p>Movie Title: ' . $movie["mname"] . '</p>
    <p>Genre: ' . $movie["genre"] . '</p>
    <p>Director: ' . $movie["director"] . '</p>
    <p>Release Date: ' . $movie["releaseDate"] . '</p>
    <p>Rating: ' . $movie["rating"] . '</p>
    <p>Duration: ' . $movie["runtime"] . '</p>
    </div>';
  } else {
    echo '<p>No movies found for movie info.</p>';
  }
}

// Fetch and store movie data
$movieData = fetchMovieData($conn);
?>

<div class="jumbotron">
  <div class="carousel-container">
    <!-- Call generate carousel slides funtion and get the active index -->
    <?php $activeIndex = generateCarouselSlides($movieData); ?>
  </div>
  
  <!-- Call generate movie information function-->
  <?php generateMovieInfo($movieData, $activeIndex); ?>
</div>

<div class="mcategory"> <!-- Wrap the entire content in the new container 'mcategory' -->
    <?php
    $genres = array("Action", "Romance", "Horror");

    foreach ($genres as $genre) {
      echo '<div class="container-fluid bg-1 text-left" id="' . $genre . '">';
      echo '<h3>' . $genre . '</h3><br>';
      echo '<div class="row">';

      // Fetch movies based on the genre
      $sql = "SELECT * FROM movie WHERE genre LIKE '%$genre%'";
      $result = $conn->query($sql);

      if ($result === false) {
        echo "Error executing the query: " . $conn->error;
      } else {
        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
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
            
        } else {
          echo "No movies found for this genre.";
        }
      }

      echo '</div></div><br>';
    }

    $conn->close();
    ?>
    </div>
    

<?php include "pagesParts/footer.php"; ?>


</body>
      
</html> 
