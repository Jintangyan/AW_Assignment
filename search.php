<?php 
session_start();
?>
<!DOCTYPE html>
<html>
<head>
     <title>Search</title>
    <?php include "pagesParts/head.php"; ?>
</head>
<body>
    <?php include "pagesParts/header.php"; ?>
    <?php include "db_connection.php"; ?> 
    
    <div class="search-container">
        <div class="search">
            <input type="text" class="search-bar" placeholder="Search for a movie..." id="searchInput">
        </div>
        <div class="hints" id="hints">Search:</div>
        <div class="horizontal-line"></div>
        <div class="search-result">
            <!-- The JavaScript code will generate the movie items here -->
        </div>
    </div>
    <?php include "pagesParts/footer.php"; ?>
    <script src="script/script.js"></script>
</body>
</html>
