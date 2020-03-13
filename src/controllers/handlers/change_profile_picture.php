<?php
$error_message = '';

if (isset($_POST['submit'])) {
    // Handler for uploading images.
    $uploadOk = 1;
    $image_name = $_FILES['fileToUpload']['name'];
    $username = $_POST['username'];

    // Remove spaces in images.
    $image_name = preg_replace('/\s+/', '_', $image_name);
    $error_message = '';

    if ($image_name != '') {
        $target_directory = 'assets/images/profile_pics/profile_users/';
        $image_name = $target_directory . uniqid() . basename($image_name);
        $image_file_type = pathinfo($image_name, PATHINFO_EXTENSION);

        if ($_FILES['fileToUpload']['size'] > 10000000) {
            $error_message = "Sorry, your file is too large!";
            $uploadOk = 0;
        }

        if (strtolower($image_file_type) != "jpeg" && strtolower($image_file_type) != "jpg" && strtolower($image_file_type) != "png" && strtolower($image_file_type) != "gif") {
            $error_message = "Sorry, only JPEG, JPG, PNG, and GIF file formats are allowed.";
            $uploadOk = 0;
        }

        if ($uploadOk == 1) {
            if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $image_name)) {
                // Successful upload.
            } else {
                // Fail to upload.
                $uploadOk = 0;
            }
        }
    }

    if ($uploadOk == 1) {
        $error_message = "Your profile picture has already changed. Please relog to apply the changes.";
        $sql = "UPDATE users SET profile_pic = '$image_name' WHERE username = '$username'";
        mysqli_query($db, $sql);
        header("location: $username");
    }
}
?>