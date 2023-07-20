<?php
session_start();

include 'connection.php';
if(isset($_SESSION['login'])){
    header("location:../user/index.php");
    exit;
}

if(isset($_POST['login'])){
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = md5($_POST['password']);
        $sql = "SELECT * FROM tbuser WHERE username = '$username' AND user_password = '$password'";
        $query = mysqli_query($conn, $sql);
                
        if (mysqli_num_rows($query) > 0) {
            $row = mysqli_fetch_array($query);

            $status = $row['status'];
            $id = $row['id'];
            // $username = $row['username'];
            // $fullname = $row['fullname'];
            $pet_id = $row['pet_id'];
            // $img = $row['img'];
            
            $_SESSION['id'] = $id;
            // $_SESSION['email'] = $email;
            $_SESSION['username'] = $username;
            // $_SESSION['fullname'] = $fullname;
            $_SESSION['pet_id'] = $pet_id;
            // $_SESSION['img'] = $img;
            if ($status == "admin") {
            // User is an admin (status = 1)
            ?>
                <script>
                    // location.href = "../admin/index.php";
                </script>
            <?php
                exit();
            
            } else if ($status == "user") {
                // User is not an admin (status = 0)
            ?>
                <script>
                    location.href = "../user/index.php";
                </script>
            <?php
            }

        } else {
            ?>
            <script>
                alert("Invalid Data");
                location.href = "../index.php";
            </script>
            <?php
        }
    }
}
?>
