<!DOCTYPE html>
<html lang="en">
<head>
  <title>LogIn</title>
 
     <?php include "pagesParts/head.php"; ?>
</head>
<body>
<?php include "pagesParts/header.php"; ?>
 <?php include "process/login_process.php"; ?>
  
<div class="Login_container">
    <h2>Log In</h2>
    <p>Don't have an account? Make a new one by clicking Sign Up</p>
    <form method="POST" action="login_process.php">
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" class="form-control" id="email" placeholder="Enter Email" name="email">
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" id="password" placeholder="Enter Password" name="password">
      </div>
      <button type="submit" class="btn btn-default">Log In</button>
      <a href="signup.php" class="btn btn-default">Sign Up</a>
    </form>
  </div>

    <?php include "pagesParts/footer.php"; ?>
</body>
</html>