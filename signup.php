<!DOCTYPE html>
<html lang="en">
<head>
  
<title>Sign Up</title>
 
     <?php include "pagesParts/head.php"; ?>
</head>
<body>
<?php include "pagesParts/header.php"; ?>
    
<div class="signup_container">
  <h2>Sign Up</h2>
    <p>Already have an account? Click Login!</p>
  <form method = "POST" action="process/signUp_process.php">
    <div class="form-group">
      <label for="fname">First Name:</label>
      <input type="text" class="form-control" id="fname" placeholder="Enter First Name" name="fname">
    </div>
      <div class="form-group">
      <label for="lname">Last Name:</label>
      <input type="text" class="form-control" id="lname" placeholder="Enter Last Name" name="lname">
    </div>
    <div class="form-group">
      <label for="email">Email:</label>
      <input type="email" class="form-control" id="email" placeholder="Enter Email" name="email">
    </div>
      <div class="form-group">
      <label for="addr">User Name:</label>
      <input type="text" class="form-control" id="userName" placeholder="Enter user name" name="userName">
    </div>
       <div class="form-group">
      <label for="password">Password</label>
      <input type="password" class="form-control" id="password" placeholder="Enter Password" name="password">
    </div>
    <button type="submit" name="submit" class="btn btn-default">Submit</button>
      <a href="login.php"  class="btn btn-default" style="color: red;">Login</a> 
      <br>
       
      
  </form>
</div>
<?php include "pagesParts/footer.php"; ?>
</body>
</html>