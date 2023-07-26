<?php

session_start();

if(!isset($_SESSION["login"])) {
  header("Location: login.php");
  exit;
}

//connect to database
require 'functions.php';

//add button pressed
if(isset($_POST["submit"])) {


  if(add($_POST) > 0) {
    echo "
    <script>
      alert('Data has been successfully added!');
      document.location.href = 'index.php';
    </script>";
  } else {
    echo "
    <script>
      alert('Failed to add data!');
      document.location.href = 'index.php';
    </script>";
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
  <title>Add Song</title>
</head>

<body>
<nav class="navtop">
    	<div>
    		<h1><i class="fas fa-music"></i>iPlaylist</h1>
            <!-- <a href="index.php"><i class="fas fa-home"></i>Home</a> -->
    		<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Log Out</a>
    	</div>
    </nav>

  <h2>Add Song</h2>

  <div class="container login">
  <h1>Add Song</h1>


  <form class="login" action=""  method="post" enctype="multipart/form-data">

   <div class="info2">

   


        <label for="song_name">Enter Song Name : </label>
        <input type="text" name="song_name" id="song_name" required size="40">
   </div>

   <div class="addsong">

   
        <label class="file" for="song">Select File </label>
        <input type="file" name="song" id="song" required size="40">
    
        <button type="submit" name="submit">Add</button>

      
        </div>
        <a href="index.php">Back</a>
  </div>

  </form>

  </div>
  
</body>

</html>