<?php
include "../config/security.php";
include "../config/connection.php";
date_default_timezone_set("Asia/Bangkok");
$user_id = $_SESSION['id'];
$pet_id = $_SESSION['pet_id'];
$act = $_POST['act']; //membedakan prosesnya
$id = $_POST['id'] ?? '';

if($act == "set_done") {
    $user_exp = (int)$_POST['user_exp'];
    
    $sql1 = "SELECT p.priority_score FROM task t
            JOIN tbpriority p on p.id = t.priority_id WHERE t.id='$id'";
    $query1 = mysqli_query($conn, $sql1) or die($sql1);
        $result = mysqli_fetch_array($query1);
        $priority_score = (int)$result['priority_score'];
        $total_exp = (int)$user_exp + $priority_score;
            
        $sql2 = "UPDATE tbuser SET user_exp='$total_exp' where id='$user_id'";         
        echo $sql2; 
        $query2 = mysqli_query($conn, $sql2) or die($sql2);

        $sql3 = "UPDATE task SET status_id=2 WHERE id='$id'";
        $query3 = mysqli_query($conn, $sql3);
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
    $task_time = $result['task_time']; 
    $status_id = $result['status_id']; 

    echo "|".$task_id."|".$task_name."|".$task_date."|".$task_desc."|".$priority_id."|".$user_id."|".$category_id."|".$task_time."|".$status_id."|";

}else if($act == "update"){
    $task_id = $_REQUEST['id'];
    $task_name = $_POST['task_name'];
    $task_date = $_POST['task_date'];
    $task_desc = $_POST['task_desc'];
    $priority_id = $_POST['priority_id'];
    $user_id = $_SESSION['id'];
    $category_id = $_POST['category_id'];
    $task_time = $_POST['task_time'];
    $status_id = $_POST['status_id'];

    $sql = "UPDATE task SET task_name = '$task_name', task_date = '$task_date', task_desc = '$task_desc', priority_id = '$priority_id', user_id = '$user_id', category_id = '$category_id', task_time = '$task_time', status_id = '$status_id' WHERE id = '$task_id'";

    mysqli_query($conn, $sql);
    
}else if($act == "add"){
    $task_id = $_REQUEST['id'];
    $task_name = $_POST['task_name'];
    $task_date = $_POST['task_date'];
    $task_desc = $_POST['task_desc'];
    $priority_id = $_POST['priority_id'];
    $user_id = $_SESSION['id'];
    $category_id = $_POST['category_id'];
    $task_time = $_POST['task_time'];
    $status_id = 1;
    $sql = "INSERT INTO task(id,task_name,task_date,task_desc,priority_id,user_id,category_id,task_time,status_id) VALUES ('$task_id','$task_name','$task_date','$task_desc','$priority_id','$user_id','$category_id','$task_time','$status_id')";
        mysqli_query($conn, $sql);
}else if($act == "set_undone") {
    $sql1 = "SELECT tbpriority.priority_score,tbuser.user_exp AS uxp FROM task 
            JOIN tbpriority on tbpriority.id = task.priority_id
            JOIN tbuser on tbuser.id = task.user_id
            WHERE task.id='$id'";
    $query1 = mysqli_query($conn, $sql1) or die($sql1);
        $result = mysqli_fetch_array($query1);
        $priority_id = $result['prio_id'];
        $tbpriority_id = $result['tbprio_id'];
        $priority_score = (int)$result['priority_score'];
        $user_exp = (int)$result['uxp'];
        echo "$priority_id\n";
        echo "$tbpriority_id\n";
        echo "$priority_score\n";
        echo "$user_exp\n";
        
            $total_exp = (int)$user_exp - $priority_score;
            echo "$total_exp\n";
            if($total_exp >= 0){
                $sql2 = "UPDATE tbuser SET user_exp='$total_exp' where id='$user_id'";
                $query2 = mysqli_query($conn, $sql2) or die($sql2);
            }else if($total_exp <= 0){
                $total_exp = 0;
                $sql2 = "UPDATE tbuser SET user_exp='$total_exp' where id='$user_id'";
                $query2 = mysqli_query($conn, $sql2) or die($sql2);
            }

    $sql = "UPDATE task SET status_id=1 WHERE id='$id'";
    $query = mysqli_query($conn, $sql);
}else if($act == "loading") {
    $sql = "SELECT t.*, c.category_name, c.category_img FROM task t LEFT JOIN category c ON t.category_id = c.id WHERE user_id='$user_id' AND status_id=1 ORDER BY t.task_date DESC";
    $query = mysqli_query($conn, $sql);
    $check_none = mysqli_num_rows($query);
    if($check_none == 0){
        ?>
        <div class="row">
            <div class="col-6">
                No Active Task
            </div>
        </div>
        <br>
        <?php
    }
    while ($result = mysqli_fetch_array($query)) {
        $task_id = $result['id'];
        $task_name = $result['task_name'];
        $task_date = $result['task_date'];
        $task_desc = $result['task_desc'];
        $priority_id = $result['priority_id'];
        $user_id = $result['user_id'];
        $category_id = $result['category_id'];
        $task_time = $result['task_time'];
        $status_id = $result['status_id'];
        $category = $result['category_name'];   
        $category_img = $result['category_img'];
        $current_date = date('d-m-Y');
        $current_time = date('H:i:s');
        $format_date = date('d-m-Y', strtotime($task_date));
        if($format_date < $current_date){
            $sql1 = "UPDATE task SET status_id=3 WHERE id='$task_id'";
            $query1 = mysqli_query($conn, $sql1);
        }else if($format_date == $current_date && $task_time < $current_time){
            $sql1 = "UPDATE task SET status_id=3 WHERE id='$task_id'";
            $query1 = mysqli_query($conn, $sql1);
        }else{

            ?>
        
        <div class="row" style="border :1px solid #FEFEFE;border-radius: 20px;">
            <div class="col-2">
                <img class="task_pict" src="./assets/images/<?php echo $category_img;?>" width="70px" alt="" style="margin-top: 10px;">
            </div>
            <div class="col-5">
                <p style="margin-bottom:-5px;"><?php echo $task_name; ?></p>
                <i class="fa-solid fa-calendar" style="color: white;"></i>
                <?php 
                    if($format_date != $current_date){
                        if($task_date == "0000-00-00"){
                ?>
                            <span>
                                <?php echo 'No Limit'; ?>
                            </span>
                <?php
                        }else{
                ?>
                        <span>
                            <?php echo $format_date; ?>
                        </span>
                    
                <?php
                        }
                    }else if($format_date == $current_date){
                ?>
                        <span>
                            <?php echo 'Today'; ?>
                        </span>
                <?php
                    }
                ?>
                <p>
                    <i class="fa-solid fa-clock" style="color: white;"></i>
                    <?php
                        if($task_time == "00:00:00"){
                            echo "00:00";
                        }else{
                            echo $task_time; 
                        }
                    ?>
                    <br>
                    <?php echo $task_desc; ?>
                </p>
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
    }
}else if($act == "complete") {
    $sql = "SELECT t.*, c.category_name, c.category_img FROM task t LEFT JOIN category c ON t.category_id = c.id WHERE user_id='$user_id' AND status_id=2 ORDER BY t.task_date DESC";
    $query = mysqli_query($conn, $sql);
    $check_none = mysqli_num_rows($query);
    if($check_none == 0){
        ?>
        <div class="row">
            <div class="col-6">
                No Completed Task
            </div>
        </div>
        <?php
    }
    while ($result = mysqli_fetch_array($query)) {
        $task_id = $result['id'];
        $task_name = $result['task_name'];
        $task_date = $result['task_date'];
        $task_desc = $result['task_desc'];
        $priority_id = $result['priority_id'];
        $user_id = $result['user_id'];
        $category_id = $result['category_id'];
        $task_time = $result['task_time'];
        $status_id = $result['status_id'];
        $category = $result['category_name'];   
        $category_img = $result['category_img'];
        $current_date = date('d-m-Y');
        $current_time = date('H:i:s');
        $format_date = date('d-m-Y', strtotime($task_date));
    ?>
        
        <div class="row" style="border :1px solid #FEFEFE;border-radius: 20px;">
            <div class="col-2">
                <img class="task_pict" src="./assets/images/<?php echo $category_img;?>" width="70px" alt="" style="margin-top: 10px;">
            </div>
            <div class="col-6">
                <p style="margin-bottom:-5px;"><?php echo $task_name; ?></p>
                <i class="fa-solid fa-calendar" style="color: white;"></i>
                <?php 
                    if($format_date != $current_date){
                        if($task_date == "0000-00-00"){
                ?>
                            <span>
                                <?php echo 'No Limit'; ?>
                            </span>
                <?php
                        }else{
                ?>
                        <span>
                            <?php echo $format_date; ?>
                        </span>
                    
                <?php
                        }
                    }else if($format_date == $current_date){
                ?>
                        <span>
                            <?php echo 'Today'; ?>
                        </span>
                <?php
                    }
                ?>
                <p>
                    <i class="fa-solid fa-clock" style="color: white;"></i>
                    <?php
                        if($task_time == "00:00:00"){
                            echo "00:00";
                        }else{
                            echo $task_time; 
                        }
                    ?>
                    <br>
                    <?php echo $task_desc; ?>
                </p>
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
}else if($act == "expired"){
    $sql = "SELECT t.*, c.category_name, c.category_img FROM task t LEFT JOIN category c ON t.category_id = c.id WHERE user_id='$user_id' AND status_id=3 ORDER BY t.task_date DESC";
    $query = mysqli_query($conn, $sql);
    $check_none = mysqli_num_rows($query);
    if($check_none == 0){
    ?>
        <div class="row">
            <div class="col-6">
                No Expired Task
            </div>
        </div>
        <br>
    <?php
    }
    while ($result = mysqli_fetch_array($query)) {
        $task_id = $result['id'];
        $task_name = $result['task_name'];
        $task_date = $result['task_date'];
        $task_desc = $result['task_desc'];
        $priority_id = $result['priority_id'];
        $user_id = $result['user_id'];
        $category_id = $result['category_id'];
        $task_time = $result['task_time'];
        $status_id = $result['status_id'];
        $category = $result['category_name'];   
        $category_img = $result['category_img'];
        $current_date = date('d-m-Y');
        $current_time = date('H:i:s');
        $format_date = date('d-m-Y', strtotime($task_date));
    ?>
        
        <div class="row all_expired_tasks" style="border :1px solid #FEFEFE;border-radius: 20px;">
            <div class="col-2">
                <img class="task_pict" src="./assets/images/<?php echo $category_img;?>" width="70px" alt="" style="margin-top: 10px;">
            </div>
            <div class="col-9">
                <p style="margin-bottom:-5px;"><?php echo $task_name; ?></p>
                <i class="fa-solid fa-calendar" style="color: white;"></i>
                <?php 
                    echo "<style>
                        .all_expired_tasks { 
                            color: red;
                            text-decoration:line-through;
                        }
                        </style>";
                    if($format_date != $current_date){
                        if($task_date == "0000-00-00"){
                ?>
                            <span>
                                <?php echo 'No Limit'; ?>
                            </span>
                <?php
                        }else{
                ?>
                        <span>
                            <?php echo $format_date; ?>
                        </span>
                    
                <?php
                        }
                    }else if($format_date == $current_date){
                ?>
                        <span>
                            <?php echo 'Today'; ?>
                        </span>
                <?php
                    }
                ?>
                <p>
                    <i class="fa-solid fa-clock" style="color: white;"></i>
                    <?php
                        if($task_time == "00:00:00"){
                            echo "00:00";
                        }else{
                            echo $task_time; 
                        }
                    ?>
                    <br>
                    <?php echo $task_desc; ?>
                </p>
            </div>

            <div class="col-1">
                <form>
                    <input type="checkbox" id="done<?php echo $task_id; ?>" style="margin-top: 30px;" onclick="delete_task(<?php echo $task_id; ?>)"/>
                </form>
            </div>
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

    if($status == "none"){
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

    $sql .= "ORDER BY t.task_date DESC";

    $query = mysqli_query($conn, $sql);
    while ($result = mysqli_fetch_array($query)) {
        $task_id = $result['id'];
        $task_name = $result['task_name'];
        $task_date = $result['task_date'];
        $task_desc = $result['task_desc'];
        $priority_id = $result['priority_id'];
        $user_id = $result['user_id'];
        $category_id = $result['category_id'];
        $task_time = $result['task_time'];
        $status_id = $result['status_id'];
        $category = $result['category_name'];   
        $category_img = $result['category_img'];
        $current_date = date('d-m-Y');
        $current_time = date('H:i:s');
        $format_date = date('d-m-Y', strtotime($task_date));
        ?>
        
        <div class="row" style="border :1px solid #FEFEFE;border-radius: 20px;">
            <div class="col-2">
                <img class="task_pict" src="./assets/images/<?php echo $category_img;?>" width="70px" alt="" style="margin-top: 10px;">
            </div>
            <div class="col-8">
                <p style="margin-bottom:-5px;" class="check_expired"><?php echo $task_name; ?></p>
                <i class="fa-solid fa-calendar check_expired" style="color: white;"></i>
                <?php 
                    if($format_date != $current_date){
                        if($task_date == "0000-00-00"){
                ?>
                            <span>
                                <?php echo 'No Limit'; ?>
                            </span>
                <?php
                        }else{
                ?>
                        <span>
                            <?php echo $format_date; ?>
                        </span>
                    
                <?php
                        }
                    }else if($format_date == $current_date){
                ?>
                        <span>
                            <?php echo 'Today'; ?>
                        </span>
                <?php
                    }
                ?>
                <p class="check-expired">
                    <i class="fa-solid fa-clock" style="color: white;"></i>
                    <?php
                        if($task_time == "00:00:00"){
                            echo "00:00";
                        }else{
                            echo $task_time; 
                        }
                    ?>
                    <br>
                    <?php echo $task_desc; ?>
                </p>
                <input type="hidden" name="status_id" id="status_id" class="status_id" value="<?php echo $status_id;?>">
            </div>
            
            <div class="col-1"></div>
            <div class="col-1">
                <form>
                    <input type="checkbox" id="done<?php echo $task_id; ?>" class="clickme" onclick="return false" 
                    <?php 
                                if($status_id == 1){
                                    echo "style='margin-top: 30px;pointer-events: none;opacity: 1;'";
                                    echo '';
                                }else if($status_id == 2){
                                    echo "style='margin-top: 30px;pointer-events: none;opacity: 1;'";
                                    echo 'checked';
                                }else if($status_id == 3){
                                    echo "style='margin-top: 30px;pointer-events: none;opacity: 1;display:none;'";
                                }
                            ?>/>
                </form>
            </div>
        </div>
        <br>
        <?php
    }
}else if($act == "pets_loader"){
    $sql2 = "SELECT tbuser.pet_id FROM tbuser JOIN pet ON pet.id = tbuser.pet_id WHERE tbuser.id='$user_id'";
    $query2 = mysqli_query($conn,$sql2);
    $result = mysqli_fetch_array($query2);
    $pet_id = $result['pet_id']; 
    // $sql = "SELECT tbuser.pet_id,tbuser.user_exp,pet.id,pet.pet_name,pet_phase.id,pet_phase.pet_id AS phase_id,pet_phase.exp_minimum,pet_phase.exp_maximum,pet_phase.img AS phase_img,pet_phase.phase FROM tbuser 
    //         JOIN pet on pet.id = tbuser.pet_id 
    //         JOIN pet_phase on pet_phase.pet_id = pet.id 
    //         WHERE tbuser.id='$user_id' AND tbuser.pet_id='$pet_id'";
    
    $sql = "SELECT tbuser.pet_id,tbuser.user_exp,pet.id,pet.pet_name,pet_phase.id,pet_phase.pet_id AS phase_id,pet_phase.exp_minimum,pet_phase.exp_maximum,pet_phase.img AS phase_img,pet_phase.phase FROM tbuser 
    JOIN pet on pet.id = tbuser.pet_id 
    JOIN pet_phase on pet_phase.pet_id = pet.id 
    WHERE tbuser.id='$user_id' AND tbuser.pet_id='$pet_id' 
    AND (tbuser.user_exp >= pet_phase.exp_minimum AND tbuser.user_exp <= pet_phase.exp_maximum OR (tbuser.user_exp > pet_phase.exp_maximum)) ORDER BY pet_phase.exp_maximum DESC LIMIT 1;";
    
$query = mysqli_query($conn,$sql);
    $result = mysqli_fetch_array($query);
        $user_exp = $result['user_exp'];
        $pet_img = $result['phase_img'];
        $exp_minimum = $result['exp_minimum'];
        $exp_maximum = $result['exp_maximum'];
        ?>
        
        <div class="row" style="margin-top: 5%;">
            <div class="col-12" style="width:60%;margin: auto;">
                <img src="assets/images/<?php echo $pet_img;?>">
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-1"></div>
            <div style="text-align: right;" id="user_exp" class="col-9"><?php echo $user_exp;?></div>
            <div class="col-2"></div>
        </div>
        <?php 
}else if($act == "load_reminder"){
    $sql = "SELECT t.*, rm.id AS rm_id,rm.reminder_date,rm.reminder_time,rm.task_id,rm.ringtone_id,rt.*,c.category_img FROM task t 
            JOIN reminder rm ON t.id = rm.task_id 
            JOIN ringtone rt ON rm.ringtone_id = rt.id
            JOIN category c ON t.category_id = c.id
            WHERE user_id='$user_id' AND rm.task_id = t.id AND t.status_id=1";
    $query = mysqli_query($conn, $sql);
    $check_none = mysqli_num_rows($query);
    if($check_none == 0){
        ?>
        <div class="row">
            <div class="col-6">
                <br>
                <h4 style="color:black;">No Reminder</h4>
            </div>
        </div>
        <br>
        <?php
    }
    while ($result = mysqli_fetch_array($query)) {
        $reminder_id = $result['rm_id'];
        $task_name = $result['task_name'];
        $task_date = $result['task_date'];
        $task_desc = $result['task_desc'];
        $task_time = $result['task_time'];
        $reminder_date = $result['reminder_date'];
        $reminder_time = $result['reminder_time'];
        $ringtone_name = $result['ringtone_name'];
        $current_date = date('d-m-Y');
        $current_time = date('H:i:s');
        $format_date = date('d-m-Y', strtotime($task_date));
        $format_reminder_date = date('d-m-Y', strtotime($reminder_date));
        if($format_date < $current_date){
            $sql1 = "UPDATE task SET status_id=3 WHERE id='$task_id'";
            $query1 = mysqli_query($conn, $sql1);
        }else if($format_date == $current_date && $task_time < $current_time){
            $sql1 = "UPDATE task SET status_id=3 WHERE id='$task_id'";
            $query1 = mysqli_query($conn, $sql1);
        }else{

            ?>
        
        <div class="row" style="border :1px solid #FEFEFE;border-radius: 20px;background-color:#121212;">
            <div class="col-5">
                <br>
                <p style="margin-bottom:-5px;"><h6><?php echo $task_name; ?></h6></p>
                <i class="fa-solid fa-calendar" style="color: white;"></i>
                <?php 
                    if($format_date != $current_date){
                        if($task_date == "0000-00-00"){
                ?>
                            <span>
                                <?php echo 'No Limit'; ?>
                            </span>
                <?php
                        }else{
                ?>
                        <span>
                            <?php echo $format_date; ?>
                        </span>
                    
                <?php
                        }
                    }else if($format_date == $current_date){
                ?>
                        <span>
                            <?php echo 'Today'; ?>
                        </span>
                <?php
                    }
                ?>
                <p>
                    <i class="fa-solid fa-clock" style="color: white;"></i>
                    <?php
                        if($task_time == "00:00:00"){
                            echo "00:00";
                        }else{
                            echo $task_time; 
                        }
                    ?>
                    <br>
                    <?php echo $task_desc; ?>
                </p>
            </div>

            <div class="col-5">
                <p><h6>Remind In :</h6></p>
                <i class="fa-solid fa-calendar" style="color: white;"></i>
            <?php 
                if($format_reminder_date != $current_date){
            ?>
                    <span>
                        <?php echo $format_reminder_date; ?>
                    </span>                    
            <?php
                }else if($format_reminder_date == $current_date){
            ?>
                    <span>
                        <?php echo 'Today'; ?>
                    </span>
            <?php
                }
            ?>
            <p>
                <i class="fa-solid fa-clock" style="color: white;"></i>
                <?php echo $reminder_time;?>
            </div>
            <div class="col-2" style="margin-top:25px;">
                <input type="button" name="delete_reminder" class="logout" id="delete_reminder<?php echo $reminder_id; ?>" value="Delete" onclick="delete_reminder(<?php echo $reminder_id; ?>)">
                <br>
                <br>
                <input type="button" name="edit_reminder" class="logout" id="edit_reminder<?php echo $reminder_id; ?>" value="Edit" onclick="edit_reminder(<?php echo $reminder_id;?>)">
                <br>
                <br>
            </div>
        </div>
        <br>
        <?php
        }
    }
}else if($act == "add_reminder"){
    $reminder_id = $_POST['reminder_id'];
    $reminder_task_date = $_POST['reminder_task_date'];
    $reminder_task_time = $_POST['reminder_task_time'];
    $reminder_task_select = $_POST['reminder_task_select'];
    $ringtone_id = $_POST['ringtone_id'];
    $sql = "INSERT INTO reminder(id,reminder_date,reminder_time,task_id,ringtone_id) VALUES('$reminder_id','$reminder_task_date','$reminder_task_time','$reminder_task_select','$ringtone_id') ";
    mysqli_query($conn, $sql);    
}else if($act == "edit_reminder") {
    $sql = "SELECT * FROM reminder WHERE id='$id'";
    $query = mysqli_query($conn, $sql);
    $result = mysqli_fetch_array($query);

    $reminder_id = $result['id']; 
    $reminder_task_select = $result['task_id']; 
    $reminder_task_date = $result['reminder_date']; 
    $reminder_task_time = $result['reminder_time']; 
    $ringtone_id = $result['ringtone_id']; 
    
    echo "|".$reminder_id."|".$reminder_task_select."|".$reminder_task_date."|".$reminder_task_time."|".$ringtone_id."|";

}else if($act == "update_reminder"){
    $reminder_id = $_POST['reminder_id'];
    $reminder_task_date = $_POST['reminder_task_date'];
    $reminder_task_time = $_POST['reminder_task_time'];
    $reminder_task_select = $_POST['reminder_task_select'];
    $ringtone_id = $_POST['ringtone_id'];

    $sql = "UPDATE reminder SET reminder_date = '$reminder_task_date', reminder_time = '$reminder_task_time', task_id = '$reminder_task_select', ringtone_id = '$ringtone_id' WHERE id = '$reminder_id'";
    mysqli_query($conn, $sql);
    
}else if($act == "delete_reminder"){
    $reminder_id = $_POST['reminder_id'];
    $sql = "DELETE FROM reminder WHERE id='$reminder_id'";
    $query = mysqli_query($conn, $sql);
}else if($act == "check_reminder"){
    $sql = "SELECT t.*, rm.id AS rm_id,rm.reminder_date,rm.reminder_time,rm.task_id,rm.ringtone_id,rt.id AS rtid, rt.ringtone_name,rt.ringtone_file FROM task t 
            JOIN reminder rm ON t.id = rm.task_id 
            JOIN ringtone rt ON rm.ringtone_id = rt.id
            WHERE user_id='$user_id' AND rm.task_id = t.id AND t.status_id=1";
    $query = mysqli_query($conn, $sql);
    
    while ($result = mysqli_fetch_array($query)) {
        $reminder_id = $result['rm_id'];
        $task_name = $result['task_name'];
        $task_date = $result['task_date'];
        $task_time = $result['task_time'];
        $task_desc = $result['task_desc'];
        $reminder_date = $result['reminder_date'];
        $reminder_time = $result['reminder_time'];
        $ringtone_id = $result['rtid'];
        $ringtone_file = $result['ringtone_file'];
        $current_date = date('d-m-Y');
        $current_time = date('H:i:00');
        $format_date = date('d-m-Y', strtotime($task_date));
        $format_reminder_date = date('d-m-Y', strtotime($reminder_date));
        
       
        if($format_reminder_date <= $current_date){
            if($reminder_time <= $current_time){
                
        ?>
            <audio controls autoplay <?php echo '$muted';?>>
                <source src="assets/ringtones/<?php echo $ringtone_file;?>" type="audio/mpeg">
            </audio>

            <script>
                // alert("<br>Date : "+$task_date+"<br>Time : "+$task_time+"<br>Description : "+$task_desc+"<br>Day Left : "+$dayLeft+" Month Left : "+$monthLeft+" Year Left : "+$yearLeft+"<br>Hour Left : "+$hourLeft+" Minute Left : "+$minuteLeft+" Second Left : "+$secondLeft);
            </script>
        <?php

            $sql = "DELETE FROM reminder WHERE id='$reminder_id'";
            $query = mysqli_query($conn, $sql);
            }

            if($format_reminder_date < $current_date && $reminder_time >= $current_time){
        ?>
                <audio controls autoplay>
                    <source src="assets/ringtones/<?php echo $ringtone_file;?>" type="audio/mpeg">
                </audio>

                <script>
                    // alert("Title : "+$task_name+"<br>Date : "+$task_date+"<br>Time : "+$task_time+"<br>Description : "+$task_desc);
                </script>
<?php
            
            $sql = "DELETE FROM reminder WHERE id='$reminder_id'";
            $query = mysqli_query($conn, $sql);
            }
        }
    }

}

?>