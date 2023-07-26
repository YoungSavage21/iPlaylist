<?php 

require 'functions.php';

if(isset($_POST["register"])) {
  if(registration($_POST) > 0) {
    echo "<script>
      alert('New User Has Been Added');
    </script>";

  } else {
    echo mysqli_error($conn);
  }

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
  <title>Registration Page</title>
  <style>
    label {
      display: block;
    }
  </style>
</head>

<body>
<nav class="navtop">
    	<div>
    		<h1><i class="fas fa-music"></i>iPlaylist</h1>
            <!-- <a href="index.php"><i class="fas fa-home"></i>Home</a> -->
    		<a href="login.php"><i class="fas fa-user"></i>Login</a>
    	</div>
    </nav>

<div class="container login">

  <h1>Registration</h1>

  <form class="login" action="" method="post">

  <div class="info">
    
        <label for="email">Email : </label>
        <input type="text" name="email" id="email">
      
        <label for="password">Password : </label>
        <input type="password" name="password" id="password">
      
        <label for="password2">Confirm Your Password : </label>
        <input type="password" name="password2" id="password2">
      
        <label for="email">Username : </label>
        <input type="text" name="username" id="username">

  </div>
      
        <button type="submit" name="register" href="login.php">Register</button>
      

  </form>
  
  </div>
</body>

</html>