<?php

function displayLoginOption() {
    if (isset($_SESSION['accountID']) && isset($_SESSION['userName'])) {
        return $_SESSION['userName'] . "/SignOut";
    } else {
        return "Login/SignUp";
    }
}
?>
<header class="header">
  <nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="index.php"><img src="graphics/logo2.png" alt="Logo"></a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li><a href="index.php">Home</a></li>
        <li ><a href="movie.php">Movie</a></li>
          <li><a href="details.php">Sample of Detail</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="<?php echo (isset($_SESSION['accountID']) && isset($_SESSION['userName'])) ? 'account.php' : 'login.php'; ?>"><span class="glyphicon glyphicon-log-in"></span> <?php echo displayLoginOption(); ?></a></li>
    </ul>
    </div>
  </div>
</nav>
</header>