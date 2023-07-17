<?php
include "../config/security.php";
include "../config/connection.php";

date_default_timezone_set("Asia/Bangkok");
$user_id = $_SESSION['id'];
$pet_id = $_SESSION['pet_id'];
$act = $_POST['act']; //membedakan prosesnya
// $task_id = $_POST['id'] ?? '';

if($act == "edit_profile") {
    $sql = "select * from tbuser where id='$user_id'";
    $query = mysqli_query($conn, $sql);
    $result = mysqli_fetch_array($query);

    $profile_id = $result['id']; 
    $profile_name = $result['fullname']; 
    $profile_email = $result['email']; 

    echo "|".$profile_id."|".$profile_name."|".$profile_email."|";

}else if ($act == "update_profile") {
    $profile_id = $_POST['id'];
    $profile_name = $_POST['profile_name'];
    $profile_email = $_POST['profile_email'];
    $profile_pict = '';

    if (isset($_FILES['profile_pict']) && $_FILES['profile_pict']['size'] > 0) {
        // User uploads a new file
        $file = $_FILES['profile_pict'];
        $file_name = $file['name'];
        $file_tmp = $file['tmp_name'];

        // Destination folder
        $folder = './assets/images/';

        // Move the file to the destination folder
        if (move_uploaded_file($file_tmp, $folder . $file_name)) {
            echo 'File successfully uploaded to the destination folder.';

            // Set profile_pict = $file_name
            $profile_pict = $file_name;
        } else {
            echo 'Failed to upload the file.';
        }
    }
     
    if ($profile_pict != "") {
        $sql = "UPDATE tbuser SET fullname = '$profile_name', email = '$profile_email', img = '$profile_pict' WHERE id = '$user_id'";
        mysqli_query($conn, $sql);     
    } else {
        $sql = "UPDATE tbuser SET fullname = '$profile_name', email = '$profile_email' WHERE id = '$user_id'";
        mysqli_query($conn, $sql);
    }
}

?>