<?php 

session_start();

require 'functions.php';

//check cookie
if(isset($_COOKIE['id']) && isset($_COOKIE['key'])) {
    $id = $_COOKIE['id'];
    $key = $_COOKIE['key'];

    //take username based on id
    $result = mysqli_query($conn, "SELECT username FROM users WHERE
    id = $id");
    $row = mysqli_fetch_assoc($result);

    //check cookie and username
    if($key === hash('sha256', $row['username'])) {
      $_SESSION['login'] = true;
    }
  }

if(isset($_SESSION["login"])) {
  header("Location: index.php");
  exit;
}

if(isset($_POST["login"])) {
  $username = $_POST["username"];
  $password = $_POST["password"];

  $result = mysqli_query
  ($conn, "SELECT * FROM users WHERE username = '$username'");

  //check username
  if(mysqli_num_rows($result) === 1) {
    //check password
    $row = mysqli_fetch_assoc($result);
    if(password_verify($password, $row["password"])) {
      //set session
      $_SESSION["login"] = true;

      //check remember me
      if(isset($_POST['remember'])) {
        //create cookie
        
        setcookie('id', $row['id'], time() + 60);
        setcookie('key', hash('sha256', $row['username']), time() + 60);
      }

      header("Location: index.php");
      exit;
    }
  }
  $error = true;
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="style.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
  <title>Login Page</title>
</head>

<body>
<nav class="navtop">
    	<div>
    		<h1><i class="fas fa-music"></i>iPlaylist</h1>
            <!-- <a href="index.php"><i class="fas fa-home"></i>Home</a> -->
    		<a href="registration.php"><i class="fas fa-user"></i>Register</a>
    	</div>
    </nav>

<div class = "container login">
  <h1>Login To Continue</h1>

  <?php if(isset($error)) : ?>
    <p style="color: red;" font-style: italic;>
    Incorrect username / password</p>
  <?php endif; ?>

  <form class="login" action="" method="post">

   
    <div class="info">
      
        <label for="username">Username : </label>
        <input type="text" name="username" id="username">
     
        <label for="password">Password : </label>
        <input type="password" name="password" id="password">
    <ul class = "checklist">
      <li>
        <input type="checkbox" name="remember" id="remember">
        <label for="remember">Remember me</label>
      </li>

      <li>
        <p>Don't Have an Account? <a href="registration.php">Click Here!</a></p> 
      </li>
    </ul>
    </div>
        
    
    <button type="submit" name="login">Login</button>
      

    

  </form>
  </div>
  
</body>

</html>