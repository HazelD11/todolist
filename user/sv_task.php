<?php
include "../config/security.php";
include "../config/connection.php";

$user_id = $_SESSION['id'];
$act = $_POST['act']; //membedakan prosesnya
$id = $_POST['id'] ?? '';

if($act == "set_done") {
    $sql = "UPDATE task SET status_id=2 WHERE id='$id'";
    $query = mysqli_query($conn, $sql);
}else if($act == "set_undone") {
    $sql = "UPDATE task SET status_id=1 WHERE id='$id'";
    $query = mysqli_query($conn, $sql);
}else if($act == "loading") {
    $sql = "SELECT t.*, c.category_name, c.category_img FROM task t LEFT JOIN category c ON t.category_id = c.id WHERE user_id='$user_id' AND status_id=1 ORDER BY t.task_date DESC";
    $query = mysqli_query($conn, $sql);
    while ($result = mysqli_fetch_array($query)) {
        $task_id = $result['id'];
        $task_name = $result['task_name'];
        $task_date = $result['task_date'];
        $task_desc = $result['task_desc'];
        $priority_id = $result['priority_id'];
        $user_id = $result['user_id'];
        $category_id = $result['category_id'];
        $reminder_id = $result['reminder_id'];
        $status_id = $result['status_id'];
        $category = $result['category_name'];   
        $category_img = $result['category_img'];
        ?>
        
        <div class="row" style="border :1px solid #FEFEFE;border-radius: 20px;">
            <div class="col-2">
                <img class="task_pict" src="./assets/images/<?php echo $category_img;?>" width="70px" alt="" style="margin-top: 10px;">
            </div>
            <div class="col-5">
                <p style="margin-bottom:-5px;"><?php echo $task_name; ?></p>
                <i class="fa-solid fa-clock" style="color: white;"></i>
                <span><?php echo $task_date; ?></span>
                <p><?php echo $task_desc; ?></p>
            </div>
            <div class="col-2" style="margin-top:25px;">
                <input type="button" name="delete_task" class="logout" id="delete_task<?php echo $task_id; ?>" value="Delete" onclick="delete_task(<?php echo $task_id; ?>)">
            </div>

            <div class="col-2" style="margin-top:25px;">
                <input type="button" name="edit_task" class="logout" id="edit_task<?php echo $task_id; ?>" value="Edit" onclick="edit_task(<?php echo"'$task_id','$task_name','$task_date','$task_desc','$priority_id','$user_id','$category_id','$reminder_id','$status_id'"?>)">
            </div>

            <div class="col-1">
                <form>
                    <input type="checkbox" id="done<?php echo $task_id; ?>" style="margin-top: 30px;" onclick="check_task(<?php echo $task_id; ?>)"/>
                </form>
            </div>
        </div>
        <br>
    <?php
    }
}else if($act == "complete") {
    $sql = "SELECT t.*, c.category_name, c.category_img FROM task t LEFT JOIN category c ON t.category_id = c.id WHERE user_id='$user_id' AND status_id=2 ORDER BY t.task_date DESC";
    $query = mysqli_query($conn, $sql);
    while ($result = mysqli_fetch_array($query)) {
        $task_id = $result['id'];
        $task_name = $result['task_name'];
        $task_date = $result['task_date'];
        $task_desc = $result['task_desc'];
        $priority_id = $result['priority_id'];
        $user_id = $result['user_id'];
        $category_id = $result['category_id'];
        $reminder_id = $result['reminder_id'];
        $status_id = $result['status_id'];
        $category = $result['category_name'];   
        $category_img = $result['category_img'];
        ?>
        
        <div class="row" style="border :1px solid #FEFEFE;border-radius: 20px;">
            <div class="col-2">
                <img class="task_pict" src="./assets/images/<?php echo $category_img;?>" width="70px" alt="" style="margin-top: 10px;">
            </div>
            <div class="col-6">
                <p style="margin-bottom:-5px;"><?php echo $task_name; ?></p>
                <i class="fa-solid fa-clock" style="color: white;"></i>
                <span><?php echo $task_date; ?></span>
                <p><?php echo $task_desc; ?></p>
            </div>
            <div class="col-2" style="margin-top:25px;">
                <input type="button" name="delete_task" class="logout" id="delete_task<?php echo $task_id; ?>" value="Delete" onclick="delete_task(<?php echo $task_id; ?>)">
            </div>
            <div class="col-1"></div>
            <div class="col-1">
                <form>
                    <input type="checkbox" id="done<?php echo $task_id; ?>" style="margin-top: 30px;" onclick="uncheck_task(<?php echo $task_id; ?>)" checked/>
                </form>
            </div>
            <div class="col-1"></div>
        </div>
        <br>
    <?php
    }
}else if($act == "delete"){
    $sql = "DELETE FROM task WHERE id='$id'";
    $query = mysqli_query($conn, $sql);
}
?>