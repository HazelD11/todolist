<?php   
include "../config/security.php";
include "../config/connection.php";
    $user_id = $_SESSION['id'];
    $email = $_SESSION['email'];
    $username = $_SESSION['username'];
    $img = $_SESSION['img'];
    
    $sql1 = "SELECT * FROM priority";
	$query1 = mysqli_query($conn,$sql1);
 	
 	$sql2 = "SELECT * FROM category";
	$query2 = mysqli_query($conn,$sql2);
 	
 	$sql3 = "SELECT * FROM reminder";
	$query3 = mysqli_query($conn,$sql3);
 
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<!-- <body class="body" style="background-image:url('assets/images/desktop1.png');background-size: cover;"> -->
<body class="body">
<!-- <body> -->
<div class="container-fluid">
	<div class="row">
		<div class="col-6">		
			
			<div class="row">
				<div class="col-12">
					<div class="d-flex flex-row bd-highlight" style="margin-top:4.4%;margin-left: 2.9%;">  
					  <div class="p-2 bd-highlight">
					  	<img src="assets/images/<?php echo $img;?>" class="profile_pict">
					  </div>
					  <div class="p-2 bd-highlight">
					  	<h4><?php echo $username;?></h4>
					  	<span><?php echo $email;?></span>
					  	<span><button type="button" class="logout" onclick="logout()">Logout</button></span>
					  </div>
					</div>					
				</div>
			</div>

			<div class="row" style="margin-top: 20%;">
				<div class="col-12" style="width:60%;margin: auto;">
					<img src="assets/images/icon1.png">
				</div>
			</div>

		</div>

		<div class="col-6">
			<div class="todolist">
					<div class="row mt-2 mb-5">
						<div class="col-3"><h5>Your Task</h5></div>
						<div class="col-5"></div>
						<div class="col-2"><button onclick="report()" class="logout">Report</button></div>
						<div class="col-1"></div>
						<div class="col-1">
							<button type="button" class="plus_button" id="myBtn" onclick="add_task()">
								<i class="fa fa-plus"></i>
							</button>
						</div>
					</div>

					<div id="myModal" class="modal">
					<!-- Modal content -->
					  	<div class="modal-content" style="width: 60%;margin: auto;">
						    <div class="modal-header">
						      <span class="close">&times;</span>
						      <h2>Add Task</h2>
						    </div>
						    <form method="POST">
							    <div class="modal-body">
							      <table  style="margin: auto;width: 80%;">

							      	<tr>
							      		<td><input type="hidden" name="id" class="id form-control" id="id" value=""></td>
							      	</tr>
	
							      	<tr>
							      		<td><input type="text" name="task_name" class="task_name form-control" id="task_name" placeholder="Task Name" value=""></td>
							      	</tr>
	
							      	<tr>
							      		<td><input type="date" name="task_date" class="task-date form-control" id="task_date" value=""></td>
							      	</tr>
	
							      	<tr>
							      		<td>
											<select class="form-select" id="priority_id" name="priority_id" style="margin: 5px;" >
										    	<option>Priority</option>
										    	<?php 
										    	while($num1 = mysqli_fetch_assoc($query1)){
													$id_priority = $num1['id'];
													$title = $num1['title'];

													$_SESSION['priority_id'] = $priority_id;
										    	?>
										    		<option id="<?php echo $title;?>" name="<?php echo $title;?>" value="<?php echo $id_priority;?>"><?php echo $title;?></option>
										    	<?php 
										    	}
										    	?>
										    </select>
							      		</td>
							      	</tr>
	
							      	<tr>
							      		<td><input type="hidden" name="user_id" class="form-control" id="user_id" value="<?php echo $user_id;?>"></td>
							      	</tr>
	
							      	<tr>
							      		<td>
							      			<select class="form-select" id="category_id" name="category_id" style="margin:5px;">
										    	<option>Category</option>
										    	<?php 
										    	while($num2 = mysqli_fetch_array($query2)){
													$id_category = $num2['id'];
													$cat_name = $num2['category_name'];
										    	?>
										    		<option id="<?php echo $cat_name;?>" name="<?php echo $cat_name;?>" value="<?php echo $id_category;?>"><?php echo $cat_name;?></option>
										    	<?php 
										    	}
										    	?>
										    </select>
							      		</td>
							      	</tr>
	
							      	<tr>
							      		<td>
							      			<!-- harus revisi -->
							      			<select class="form-select" id="reminder_id" name="reminder_id" style="margin:5px;">
										    	<option>Reminder</option>
										    	<?php 
										    	while($num3 = mysqli_fetch_array($query3)){
													$id_reminder = $num3['id'];
													$reminder_time = $num3['reminder_time'];
										    	?>
										    		<option id="<?php echo $reminder_time;?>" name="<?php echo $reminder_time;?>" value="<?php echo $id_reminder;?>"><?php echo $reminder_time;?></option>
										    	<?php 
										    	}
										    	?>
										    </select>
							      		</td>
							      	</tr>
	
							      	<tr>
							      		<td><input type="hidden" name="status_id" class="form-control" id="status_id" value=""></td>
							      	</tr>
							      	<tr>
							      		<td><textarea name="task_desc" id="task_desc" class="form-control" placeholder="description"></textarea>
							      	</tr>
							      </table>
							    </div>
							    
							    <div class="modal-footer" style="background-color:#303030;">
							      <input type="button" name="tambah" class="tambah" id="tambah" value="ADD" onclick="insert_task()">
							    </div>
						    </form>
					  	</div>
					</div>

					<div class="row">
						<div class="col-6"><h6>ACTIVE TASK</h6></div>
					</div>

					<div id="active_tasks">
						<font color="#FEFEFE">Loading . . . . . . . . . . .</font>
					</div>

					<div class="row">
						<div class="col-6"><h6>COMPLETED TASK</h6></div>
					</div>

					<div id="completed_task">
						<font color="#FEFEFE">Loading . . . . . . . . . . .</font>
					</div>
			</div>
		</div>
	</div>
</div>

<script src="assets/js/jquery-3.7.0.js"></script>
<script src="https://kit.fontawesome.com/67a87c1aef.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/user.js"></script>

<script>
    $(document).ready(function() {
        get_data();
        completed_tasks();
    });
</script>
</body>
</html>