<?php 

session_start();

if(!isset($_SESSION["login"])) {
  header("Location: login.php");
  exit;
}

//connect to database
require 'functions.php';

$id = $_GET["id"];

$song = query("Select * FROM adam WHERE id = $id")[0];

//add button pressed
if(isset($_POST["submit"])) {
  if(edit($_POST) > 0) {
    echo "
    <script>
      alert('Data has been edited!');
      document.location.href = 'index.php';
    </script>";
  } else {
    echo "
    <script>
      alert('Failed to edit data!');
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
  <title>Edit Song</title>
</head>

<body>
<nav class="navtop">
    	<div>
    		<h1><i class="fas fa-music"></i>iPlaylist</h1>
            <!-- <a href="index.php"><i class="fas fa-home"></i>Home</a> -->
    		<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Log Out</a>
    	</div>
    </nav>

  <h2>Edit Song</h2>

  <div class="container login">
  <h1>Edit Song</h1>

  <form class= "login" action=""  method="post" enctype="multipart/form-data">

  <input type="hidden" name="id" value="<?= $song["id"]; ?>">
  <input type="hidden" name="oldSong" value="<?= $song["song"]; ?>">

  <div class="info2">
  

        <label for="song_name">Edit Song Name : </label>
        <input type="text" name="song_name" id="song_name" required 
        value="<?= $song["song_name"]; ?>" size="40">
        <audio src="music/<?=$song['song']?>" controls></audio>

</div>

<div class="addsong">
      
        <label class="file" for="song">Add File </label>
      
        <input type="file" name="song" id="song" size="40">
     
        <button type="submit" name="submit">Edit</button>
        
     
</div>
<a href="index.php">Back</a>

  </form>

</div>
  
</body>

</html>