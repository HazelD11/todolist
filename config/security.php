<?php
session_start();
if (!isset($_SESSION['username'])) {
    ?>
    <script>
        alert("Please Login!");
        location.href = "../index.php";
    </script>
    <?php
    // exit(); // Add exit() after the redirect to stop further code execution
}
?>