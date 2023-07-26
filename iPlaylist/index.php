<?php

session_start();

if(!isset($_SESSION["login"])) {
  header("Location: login.php");
  exit;
}

//connect to database
require 'functions.php';

//fetch data from result object
$songs = query("SELECT * FROM adam ORDER BY id DESC");

//search button pressed
if(isset($_POST["search"])) {
  $songs = search($_POST["keyword"]);
}

//reset button pressed
if(isset($_POST["reset"])) {
  $songs;
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
  <title>Album</title>
</head>

<body>
<nav class="navtop">
    	<div>
    		<h1><i class="fas fa-music"></i>iPlaylist</h1>
            <!-- <a href="index.php"><i class="fas fa-home"></i>Home</a> -->
    		<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Log Out</a>
    	</div>
    </nav>


  <h2>List of Songs</h2>

  <div class="content">

  <a class="link" href="add.php">Add Playlist</a>
  <br/><br/>

  <form action="" method="post">

    <input type="text" name="keyword" size="40" autofocus placeholder="Enter your keyword..."
    autocomplete="off">
    <button class="search" type="submit" name="search">Search</button>
    <button class="search" type="submit" name="reset">Reset</button>

  </form>

  <br/>

  <table cellpadding="10" cellspacing="0">


    <tr class="top">
      <th>No.</th>
      <th>Song Name</th>
      <th>Song</th>
      <th>Action</th>
    </tr>

    <?php $i = 1; ?>
    <?php foreach($songs as $row) : ?>

    <tr>
      <td><?= $i; ?></td>
      <td><?= $row["song_name"]; ?></td>
      <td>
        <audio controls src="music/<?=$row['song']; ?>"></audio>
      </td>
      <td>
        <a class = "btn" href="edit.php?id=<?= $row["id"]; ?>"><i class="fas fa-pen fa-xs"></i></a>
        <a class = "btn" href="delete.php?id=<?= $row["id"]; ?>" onclick=
        "return confirm('Are you sure you want to delete this song from your album?')">
        <i class="fas fa-trash fa-xs"></i></a>
      </td>
    </tr>

    <?php $i++; ?>
    <?php endforeach; ?>

  </table>

  </div>

</body>

</html>