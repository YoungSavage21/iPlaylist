<?php
//------------------------------- CONNECT TO DATABAE VARIABLE -------------------------------
$conn = mysqli_connect("localhost", "root", "", "music");

//------------------------------- FUNCTION QUERY -------------------------------
function query($query) {
  global $conn;
  $result = mysqli_query($conn, $query);
  $rows = [];
  while ($row = mysqli_fetch_assoc($result)) {
    $rows[] = $row;
  }
  return $rows;
}

//------------------------------- ADD DATA FUNCTION -------------------------------
function add($data) {
  global $conn;
  $songName = htmlspecialchars($data["song_name"]);

  //upload song
  $songTrack = upload();
  if(!$songTrack) {
    return false;
  }

  $query = "INSERT INTO adam 
              VALUES 
            ('', '', '', '$songName', '$songTrack')";
  mysqli_query($conn, $query);

  return mysqli_affected_rows($conn);
}

//------------------------------- UPLOAD FUNCTION -------------------------------
function upload() {
  $fileName = $_FILES['song']['name'];
  $error = $_FILES['song']['error'];
  $tmpName = $_FILES['song']['tmp_name'];

  //check if no song uploaded
  if($error === 4) {
    echo "<script>
        alert('choose a song first!);
      </script>";
      return false;
  }

  //check if it is a song that is uploaded
  $validSongExtension = ['mp3', 'wav'];
  $songExtension = explode('.', $fileName);
  $songExtension = strtolower(end($songExtension));

  if(!in_array($songExtension, $validSongExtension)) {
    echo "<script>
        alert('Not a song!);
      </script>";
    return false;
  }

  $newFileName = uniqid();
  $newFileName .= '.';
  $newFileName .= $songExtension;

  //song ready to upload
  move_uploaded_file($tmpName, 'music/'.$newFileName);

  return $newFileName;
}

//------------------------------- DELETE FUNCTION -------------------------------
function delete($id) {
  global $conn;

  mysqli_query($conn, "DELETE FROM adam WHERE id = $id");

  return mysqli_affected_rows($conn);
}

//------------------------------- EDIT FUNCTION -------------------------------
function edit($data) {
  global $conn;

  $id = $data["id"];
  $songName = htmlspecialchars($data["song_name"]);
  $oldSong = htmlspecialchars($data["oldSong"]);

  //check if user has new song
  if($_FILES['song']['error'] === 4) {
    $song = $oldSong;
  } else {
    $song = upload();
  }

  $query = "UPDATE adam SET
              song_name = '$songName',
              song = '$song'
              WHERE id = $id
              ";

  mysqli_query($conn, $query);

  return mysqli_affected_rows($conn);
}

//------------------------------- SEARCH KEYWORD FUNCTION -------------------------------
function search($keyword) {
  if(isset($keyword)) {
    $query = "SELECT * FROM adam WHERE song_name LIKE '%$keyword%'";
    return query($query);
  } else {
    $query2 = "SELECT * FROM adam ORDER BY id DESC";
    return query($query2);
  }
}

//------------------------------- REGISTRATION FUNCTION -------------------------------
function registration($data) {
  global $conn;

  $username = strtolower(stripslashes($data["username"]));
  $email = htmlspecialchars($data["email"]);
  $password = mysqli_real_escape_string($conn, $data["password"]);
  $password2 = mysqli_real_escape_string($conn, $data["password2"]);

  //check if username is already exist
  $result = mysqli_query($conn, 
  "SELECT username FROM users WHERE username = '$username'");

  if(mysqli_fetch_assoc($result)) {
    echo "<script>
        alert('username is already registered!');
      </script>";

    return false;
  }

  //check password
  if($password !== $password2) {
    echo "<script>
      alert('password does not match!');
    </script>";
    return false;
  } else {
    //encrypt password
    $password = password_hash($password, PASSWORD_DEFAULT);
    
    mysqli_query($conn, "INSERT INTO users 
                    VALUES
                ('', '$email', '$password', '$username')");

    return mysqli_affected_rows($conn);
  }
}

?>