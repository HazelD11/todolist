<?php
include "../config/security.php";
include "../config/connection.php";

date_default_timezone_set("Asia/Bangkok");
$user_id = $_SESSION['id'];
$pet_id = $_SESSION['pet_id'];
$act = $_POST['act']; //membedakan prosesnya
// $task_id = $_POST['id'] ?? '';

if($act == "edit_profile") {
    $sql = "select id,fullname,email from tbuser where id='$user_id'";
    $query = mysqli_query($conn, $sql);
    $result = mysqli_fetch_array($query);

    $profile_id = $result['id']; 
    $profile_name = $result['fullname']; 
    $profile_email = $result['email']; 

    echo "|".$profile_id."|".$profile_name."|".$profile_email."|";

}else if ($act == "update_profile") {
    $profile_id = $_POST['id'];
    $pet_id = $_POST['pet_id'];
    $profile_name = $_POST['profile_name'];
    $profile_email = $_POST['profile_email'];
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_new_password = $_POST['confirm_new_password'];
    $profile_pict = '';

    $sql_pwd = "SELECT user_password FROM tbuser WHERE id='$user_id'";
    $query_pwd = mysqli_query($conn,$sql_pwd);
    $result = mysqli_fetch_array($query_pwd); 
    $current_password = $result['user_password'];

    
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
        $sql = "UPDATE tbuser SET fullname = '$profile_name', email = '$profile_email', img = '$profile_pict', pet_id = '$pet_id' WHERE id = '$user_id'";
        mysqli_query($conn, $sql);     
    } else {
        $sql = "UPDATE tbuser SET fullname = '$profile_name', email = '$profile_email', pet_id = '$pet_id' WHERE id = '$user_id'";
        mysqli_query($conn, $sql);
    }
    
    if($old_password != '' && $old_password == $current_password){
        if($new_password == $confirm_new_password && $new_password != $old_password){
            $sql_upwd = "UPDATE tbuser SET user_password = '$new_password' WHERE id = '$user_id'";
            $query_upwd = mysqli_query($conn, $sql_upwd);
            
            ?> 
            <script>alert('Password Berhasil Diubah!');</script>
            <?php   
        }else {
            echo "
            <script>alert('Password Baru Salah atau sama dengan Password Lama!');</script>
            ";
        }
    }else {
        echo "
            <script>alert('Password Lama Kosong atau Password Salah!');</script>
            ";
    }

    
}else if($act == "show_profile"){
    $sql4 = "SELECT * FROM tbuser WHERE id='$user_id'";
	$query4 = mysqli_query($conn,$sql4);
	$result = mysqli_fetch_array($query4);
	$email = $result['email'];
	$username = $result['username'];
	$fullname = $result['fullname'];
	$img = $result['img'];
    ?>

    <div class="p-2 bd-highlight">
        <img src="assets/images/<?php echo $img;?>" class="profile_pict show_profile_pict" id="show_profile_pict" name="show_profile_pict">
    </div>

    <div class="p-2 bd-highlight">
        <h4 id="show_profile_fullname" name="show_profile_fullname"><?php echo $fullname;?></h4>
        <span id="show_profile_email" name="show_profile_email"><?php echo $email;?></span>
        <span><button type="button" class="logout" id="edit_profile" onclick="edit_profile()">Edit Profile</button></span>
        <span><button type="button" class="logout" onclick="logout()">Logout</button></span>
    </div>
<?php
}

?>