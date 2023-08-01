  <?php
include"db_connection.php";
if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
    }
    else{
        $email = $_POST["email"];
        $password = $_POST["password"];

        $query = "SELECT * FROM account WHERE email ='".$email."' LIMIT 1";
        $result = mysqli_query($conn,$query);     
        if(mysqli_num_rows ($result) > 0){
            $row =mysqli_fetch_array($result);
            if(password_verify($password, $row["password"])){
                $email = $row["email"];
                echo  "<p> Password is Valid for the email : ".$email."</p>";            
            }
            else{
                echo "<p> Password is Invalid ....</p>";
            }
            
        }
        }
    ?> 