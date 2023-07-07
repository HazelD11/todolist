<?php
session_start();
include "../config/connection.php";

$button = $_REQUEST['tambah'];
$task_id = $_REQUEST['id'];
$task_name = $_POST['task_name'];
$task_date = $_POST['task_date'];
$task_desc = $_POST['task_desc'];
$priority_id = $_POST['priority_id'];
$user_id = $_SESSION['id'];
$category_id = $_POST['category_id'];
$reminder_id = $_POST['reminder_id'];
$status_id = 1;

if ($button == "ADD") {
        $sql_add = "INSERT INTO task(id,task_name,task_date,task_desc,priority_id,user_id,category_id,reminder_id,status_id) VALUES ('$task_id','$task_name','$task_date','$task_desc','$priority_id','$user_id','$category_id','$reminder_id','$status_id')";
        mysqli_query($conn, $sql_add);

}else if($button = "Edit"){
    $sql = "UPDATE task SET task_name = '$task_name', task_date = '$task_date', task_desc = '$task_desc', priority_id = '$priority_id', user_id = '$user_id', category_id = '$category_id', reminder_id = '$reminder_id', status_id = '$status_id' WHERE id = '$task_id'";

    mysqli_query($conn, $sql);
}


header("location:index.php");
?>