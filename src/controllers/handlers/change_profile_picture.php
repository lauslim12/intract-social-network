<?php
  include '../../../config/config.php';
  $username = $_POST['username'];

  $target_dir = "../../../assets/images/profile_pics/profile_users/";
  $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  
  // Check if image file is a actual image or fake image
  if(isset($_POST["submit"])) {
      $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
      if($check !== false) {
          echo "File is an image - " . $check["mime"] . ".";
          $uploadOk = 1;
      } 
      else {
          echo "File is not an image.";
          $uploadOk = 0;
      }
  }
  
  // Check file size
  if ($_FILES["fileToUpload"]["size"] > 500000) {
      echo "Sorry, your file is too large.";
      $uploadOk = 0;
  }
  
  // Allow certain file formats
  if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
  && $imageFileType != "gif" ) {
      echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
      $uploadOk = 0;
  }
  
  // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
      echo "Sorry, your file was not uploaded.";
    } 
    else {
      $destination_path_and_rename = $target_dir . $username . "." . $imageFileType;
      if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $destination_path_and_rename)) {
          echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded. Please relog to apply the changes.";

          // Insert into sql. 9 is to cut the leading '../../../' part in the target file.
          $string = $target_file;
          $string = substr($string, 9);

          $sql = "UPDATE users SET profile_pic = '$string' WHERE username = '$username'";
          mysqli_query($db, $sql);
      } 
      else {
          echo "Sorry, there was an error uploading your file.";
      }
  }
