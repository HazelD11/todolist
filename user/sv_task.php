<?php
include "../config/security.php";
include "../config/connection.php";

$user_id = $_SESSION['id'];
$act = $_POST['act']; //membedakan prosesnya
$id = $_POST['id'] ?? '';

if($act == "set_done") {
    $sql = "UPDATE task SET status_id=2 WHERE id='$id'";
    $query = mysqli_query($conn, $sql);
}else if($act == "edit") {
    $sql = "select * from task where id='$id'";
    $query = mysqli_query($conn, $sql);
    $result = mysqli_fetch_array($query);

    $task_id = $result['id']; 
    $task_name = $result['task_name']; 
    $task_date = $result['task_date']; 
    $task_desc = $result['task_desc']; 
    $priority_id = $result['priority_id']; 
    $user_id = $result['user_id']; 
    $category_id = $result['category_id']; 
    $reminder_id = $result['reminder_id']; 
    $status_id = $result['status_id']; 

    echo "|".$task_id."|".$task_name."|".$task_date."|".$task_desc."|".$priority_id."|".$user_id."|".$category_id."|".$reminder_id."|".$status_id."|";

}else if($act == "update"){
    $task_id = $_REQUEST['id'];
    $task_name = $_POST['task_name'];
    $task_date = $_POST['task_date'];
    $task_desc = $_POST['task_desc'];
    $priority_id = $_POST['priority_id'];
    $user_id = $_SESSION['id'];
    $category_id = $_POST['category_id'];
    $reminder_id = $_POST['reminder_id'];
    $status_id = $_POST['status_id'];

    $sql = "UPDATE task SET task_name = '$task_name', task_date = '$task_date', task_desc = '$task_desc', priority_id = '$priority_id', user_id = '$user_id', category_id = '$category_id', reminder_id = '$reminder_id', status_id = '$status_id' WHERE id = '$task_id'";

    mysqli_query($conn, $sql);
    
}else if($act == "add"){
    $task_id = $_REQUEST['id'];
    $task_name = $_POST['task_name'];
    $task_date = $_POST['task_date'];
    $task_desc = $_POST['task_desc'];
    $priority_id = $_POST['priority_id'];
    $user_id = $_SESSION['id'];
    $category_id = $_POST['category_id'];
    $reminder_id = $_POST['reminder_id'];
    $status_id = 1;
    $sql = "INSERT INTO task(id,task_name,task_date,task_desc,priority_id,user_id,category_id,reminder_id,status_id) VALUES ('$task_id','$task_name','$task_date','$task_desc','$priority_id','$user_id','$category_id','$reminder_id','$status_id')";
        mysqli_query($conn, $sql);
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
                <input type="button" name="edit_task" class="logout" id="edit_task<?php echo $task_id; ?>" value="Edit" onclick="edit_task(<?php echo $task_id;?>)">
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
}else if($act == "view"){
    $from_date = $_POST['from_date'];
    $to_date = $_POST['to_date'];
    $status = $_POST['status'];
    // $stat = $_POST['status_id'];
    $checked = '';

    if($status == "none" || $status == 3){
        ?>
        <div id="tdl" style="display:block; height: 200px;"></div>
        <?php
    }
    // $stat = $("#status_id").val();
    $sql = "SELECT t.*, c.category_name, c.category_img FROM task t LEFT JOIN category c ON t.category_id = c.id WHERE user_id='$user_id'";
    
    if($status !== "all"){
         $sql .= " AND status_id = '$status'";
    }

    if ($from_date !== '' && $to_date !=='') {
        $sql .= "AND (t.task_date BETWEEN DATE('$from_date') AND DATE('$to_date'))";
    }else if ($from_date !== '' && $to_date =='') {
        $sql .= "AND (t.task_date BETWEEN DATE('$from_date') AND DATE(0000-00-00))";
    }else if ($from_date == '' && $to_date !=='') {
        $sql .= "AND (t.task_date BETWEEN DATE(0000-00-00) AND DATE('$to_date'))";
    }     

    $sql .= "ORDER BY t.task_date ASC";

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
                <div class="col-8">
                    <p style="margin-bottom:-5px;"><?php echo $task_name; ?></p>
                    <i class="fa-solid fa-clock" style="color: white;"></i>
                    <span><?php echo $task_date; ?></span>
                    <p><?php echo $task_desc; ?></p>
                    <input type="hidden" name="status_id" id="status_id" class="status_id" value="<?php echo $status_id;?>">
                </div>
                
                <div class="col-1"></div>
                <div class="col-1">
                    <form>
                        <input type="checkbox" id="done<?php echo $task_id; ?>" class="clickme" style="margin-top: 30px;pointer-events: none;opacity: 1;" onclick="return false" 
                                <?php 
                                    if($status_id == 1){
                                        echo '';
                                    }else if($status_id == 2){
                                        echo 'checked';
                                    }
                                ?>/>
                    </form>
                </div>
            </div>
            <br>
        <?php
        }
}
?>