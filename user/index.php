<?php   
include "../config/security.php";
include "../config/connection.php";
    $user_id = $_SESSION['id'];
    // $email = $_SESSION['email'];
    // $username = $_SESSION['username'];
    // $fullname = $_SESSION['fullname'];
    // $img = $_SESSION['img'];
    
    $sql1 = "SELECT * FROM tbpriority";
	$query1 = mysqli_query($conn,$sql1);
 	
 	$sql2 = "SELECT * FROM category";
	$query2 = mysqli_query($conn,$sql2);
 	
 	$sql3 = "SELECT * FROM reminder";
	$query3 = mysqli_query($conn,$sql3);

	$sql4 = "SELECT * FROM pet";
	$query4 = mysqli_query($conn,$sql4);

	$sql5 = "SELECT * FROM task WHERE status_id = 1 AND user_id=$user_id";
	$query5 = mysqli_query($conn,$sql5);

	$sql6 = "SELECT * FROM ringtone";
	$query6 = mysqli_query($conn,$sql6);

	$sql7 = "SELECT * FROM tbuser WHERE id NOT IN($user_id)";
	$query7 = mysqli_query($conn,$sql7);

	$sql8 = "SELECT * FROM collaborator WHERE user_id=$user_id";
	$query8 = mysqli_query($conn,$sql8);
	
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<!-- <body class="body" style="background-image:url('assets/images/desktop1.png');background-size: cover;"> -->
<body class="body">
<!-- <body> -->
<div id="check_reminder" style="display: none;">

</div>
	
<div class="container-fluid">
	<div class="row">
		<div class="col-6">		
			
			<div class="row">
				<div class="col-12">
<!-- show profile -->
					<div class="d-flex flex-row bd-highlight" style="margin-top:4.4%;margin-left: 2.9%;" id="user_profile">  
					  
					</div>

<!-- profile modal start  -->
					<div id="profileModal" class="modal">
					<!-- Modal content -->
					  	<div class="modal-content" style="width: 60%;margin: auto;">
						    <div class="modal-header">
						      <span class="close_profile">&times;</span>
						      <h2>Edit Profile</h2>
						    </div>
						    <form method="POST">
							    <div class="modal-body">
							      <table  style="margin: auto;width: 80%;">

							      	<tr>
							      		<td><input type="hidden" name="profile_id" class="profile_id form-control" id="profile_id" value=""></td>
							      	</tr>
	
							      	<tr>
							      		<td><input type="text" name="profile_name" class="profile_name form-control" id="profile_name" placeholder="Name" value=""></td>
							      	</tr>
	
							      	<tr>
							      		<td><input type="email" name="profile_email" class="profile_email form-control" id="profile_email" placeholder="Email" value=""></td>
							      	</tr>

									<tr>
							      		<td><input type="password" name="old_password" class="old_password form-control" id="old_password" placeholder="Old Password" value=""></td>
							      	</tr>

									  <tr>
							      		<td><input type="password" name="new_password" class="new_password form-control" id="new_password" placeholder="New Password" value=""></td>
							      	</tr>

									  <tr>
							      		<td><input type="password" name="confirm_new_password" class="confirm_new_password form-control" id="confirm_new_password" placeholder="Confirm New Password" value=""></td>
							      	</tr>

									<tr>
							      		<td><input type="file" name="profile_pict" class="profile_pict form-control" id="profile_pict" value=""></td>
							      	</tr>
	
							      	<tr>
										<td>
											<div class="row" style="margin: 5px;" >
											<input type="hidden" name="pet_id" class="pet_id form-control" id="pet_id" value="">
											<h3 style="color: #121212;"><b>Pick Your Pet</b></h3>
										    	<?php 
										    	while($num4 = mysqli_fetch_array($query4)){
													$id_pet = $num4['id'];
													$pet_name = $num4['pet_name'];
													$demo_img = $num4['demo_img'];
										    	?>
														<button type="button" id="pet_card_<?php echo $id_pet;?>" class="col-3 select_pet" style="background-color: #303030;margin-left:15px;margin-top:15px;border-radius:10px;" onclick="select_pet(<?php echo $id_pet;?>)">
															<img src="assets/images/default/<?php echo $demo_img;?>" width="140px" style="margin-top:15px;margin-bottom:5px;border-radius:5px;">
															<h5 style="text-align: center;color:#FEFEFE;"><?php echo $pet_name;?></h5>
														</button>
										    		<!-- <option id="<?php echo $pet_name;?>" name="<?php echo $pet_name;?>" value="<?php echo $id_pet;?>"><?php echo $pet_name;?></option> -->
										    	<?php 
										    	}
										    	?>
										    </div>
										</td>
									</tr>
							      </table>
							    </div>
							    
							    <div class="modal-footer" style="background-color:#303030;">
							      <input type="button" name="edit_profile" class="edit_profile tambah" id="edit_profile" value="Edit Profile" onclick="update_profile(<?php echo $user_id;?>)">
							    </div>
						    </form>
					  	</div>
					</div>
<!-- profile modal end -->
				</div>
			</div>

<!-- pet loader start-->
			<div id="pet_loader">
				
			</div>
<!-- pet loader end -->

		</div>

<!-- task menu -->
		<div class="col-6">
			<div class="todolist">
					<div class="row mt-2 mb-5">
						<div class="col-3"><h5>Your Task</h5></div>
						<div class="col-2"></div>
						<div class="col-3"><button type="button" onclick="report()" class="logout">Filter Task</button></div>
						<div class="col-3"><button type="button" onclick="remind_menu()" class="logout">Remind Me</button></div>
						<div class="col-1">
							<button type="button" class="plus_button" id="myBtn" onclick="add_task()">
								<i class="fa fa-plus"></i>
							</button>
						</div>
					</div>

<!-- show reminder menu start -->
					<div id="remind_menu" class="modal">
						<div class="modal-content" style="width: 60%;margin: auto;">
						    <div class="modal-header">
						      <span class="close_remind_menu">&times;</span>
						      <h2 id="title_remind">Remind Me</h2>
							  <input type="button" name="add_reminder" class="add_reminder logout" id="add_reminder" value="ADD REMINDER" onclick="add_reminder()">
						    </div>

							<div class="modal-body">
								<span id="reminder_list">

								</span>
							</div>
					  	</div>
					</div>
<!-- show reminder menu end -->

<!-- add & edit reminder modal start-->
					<div id="AEreminder" class="modal">
					<!-- Modal content -->
					  	<div class="modal-content" style="width: 60%;margin: auto;">
						    <div class="modal-header">
						      <span class="close_AEreminder">&times;</span>
						      <h2 id="title_reminder">Add Reminder</h2>
						    </div>
							    <div class="modal-body">
							      <table  style="margin: auto;width: 80%;">

							      	<tr>
							      		<td><input type="hidden" name="reminder_id" class="reminder_id form-control" id="reminder_id" value=""></td>
							      	</tr>

							      	<tr>
							      		<td>
											<select class="form-select" id="reminder_task_select" name="reminder_task_select" style="margin: 5px;" >
										    	<option value="title_select_task">Select Task</option>
										    	<?php 
										    	while($num5 = mysqli_fetch_array($query5)){
													$reminder_task_id = $num5['id'];
													$reminder_task_name = $num5['task_name'];
													$reminder_task_date = $num5['task_date'];
													$reminder_task_time = $num5['task_time'];
										    	?>
										    		<option id="<?php echo $reminder_task_name;?>" name="<?php echo $reminder_task_name;?>" value="<?php echo $reminder_task_id;?>"><?php echo "Task : ".$reminder_task_name.","." Date : ".$reminder_task_date.","." Time : ".$reminder_task_time;?></option>
										    	<?php 
										    	}
										    	?>
										    </select>
							      		</td>
							      	</tr>

									<tr>
										<td><h5 style="color:#121212;">Remind In</h5></td>
									</tr>
									
									<tr>
							      		<td>
											<label style="margin-left: 5px;color:black;"><h6>Date : </h6></label>
							      			<input type="date" class="form-control" id="reminder_task_date" name="reminder_task_date" value="">
							      		</td>
							      	</tr>
							      	
									<tr>
							      		<td>
											<label style="margin-left: 5px;color:black;"><h6>Time : </h6></label>
							      			<input type="time" class="form-control" id="reminder_task_time" name="reminder_task_time" value="">
							      		</td>
							      	</tr>

									  <tr>
							      		<td>
											<select class="form-select" id="ringtone_id" name="ringtone_id" style="margin: 5px;" >
										    	<option value="title_select_ringtone">Select Ringtone</option>
										    	<?php 
										    	while($num6 = mysqli_fetch_array($query6)){
													$reminder_ringtone_id = $num6['id'];
													$reminder_ringtone_name = $num6['ringtone_name'];
										    	?>
										    		<option id="<?php echo $reminder_ringtone_name;?>" name="<?php echo $reminder_ringtone_name;?>" value="<?php echo $reminder_ringtone_id;?>"><?php echo $reminder_ringtone_name;?></option>
										    	<?php 
										    	}
										    	?>
										    </select>
							      		</td>
							      	</tr>
							      	</table>
							    </div>
							    
							    <div class="modal-footer" style="background-color:#303030;">
							      <input type="button" name="insert_reminder" class="insert_reminder logout" id="insert_reminder" value="ADD" onclick="insert_reminder()">
							    </div>
					  	</div>
					</div>
<!-- add & edit reminder modal end -->

<!-- add & edit task modal start -->
					<div id="myModal" class="modal">
					<!-- Modal content -->
					  	<div class="modal-content" style="width: 60%;margin: auto;">
						    <div class="modal-header">
						      <span class="close">&times;</span>
						      <h2 id="title_task">Add Task</h2>
						    </div>
						    <form method="POST">
							    <div class="modal-body">
							      <table  style="margin: auto;width: 80%;">

								  	<tr>
							      		<td><input type="hidden" name="id" class="id form-control" id="id" value=""></td>
							      	</tr>
									
									<tr>
							      		<td><input type="hidden" name="task_team" class="task_team form-control" id="task_team" value=""></td>
							      	</tr>
	
							      	<tr>
							      		<td><input type="text" name="task_name" class="task_name form-control" id="task_name" placeholder="Task Name" value=""></td>
							      	</tr>
	
							      	<tr>
							      		<td><input type="date" name="task_date" class="task_date form-control" id="task_date" value=""></td>
							      	</tr>
	
							      	<tr>
							      		<td>
											<select class="form-select" id="priority_id" name="priority_id" style="margin: 5px;" >
										    	<option value="title_priority">Priority</option>
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
										    	<option value="title_category">Category</option>
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
											<label style="margin-left: 5px;color:black;"><h6>Time : </h6></label>
							      			<input type="time" class="form-control" id="task_time" name="task_time" value="">
							      		</td>
							      	</tr>
									
									<tr>
										<td>
											<input type="text" id="team_name" class="form-control" name="team_name" value="" placeholder="Insert Team Name">
										</td>
									</tr>
									
									<tr>
										<td>
											<select class="user_collab select2" name="user[]" id="select_user" multiple="multiple">
											<?php 
										    	while($num7 = mysqli_fetch_array($query7)){
													$uid = $num7['id'];
													$user_fullname = $num7['fullname'];
										    	?>
										    		<option value="<?php echo $uid;?>"><?php echo $user_fullname;?></option>
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
<!-- add task modal end -->

<!-- place for show expired task -->
					<div class="row">
						<div class="col-6"><h6>EXPIRED TASK</h6></div>
					</div>
<br>
					<div id="expired_tasks" style="overflow-y: auto;max-height:250px;">
						<font color="#FEFEFE">Loading . . . . . . . . . . .</font>
					</div>
<br>
<!-- place for show active task -->
					<div class="row">
						<div class="col-6"><h6>ACTIVE TASK</h6></div>
					</div>
					
					<br>

					<div id="active_tasks" style="overflow-y: auto;max-height:250px;">
						<font color="#FEFEFE">Loading . . . . . . . . . . .</font>
					</div>
<br>
<!-- place for show collaborator task -->
					<div class="row">
						<div class="col-6"><h6>COLLABORATOR TASK</h6>
							<select class="form-select" id="collab_team" name="collab_team" style="margin:5px;">
								<option value="title_team">Select Team</option>
								<?php 
								while($num8 = mysqli_fetch_array($query8)){
									$team = $num8['team'];
									$team_name = $num8['team_name'];
								?>
									<option id="<?php echo $team_name;?>" name="<?php echo $team_name;?>" value="<?php echo $team;?>"><?php echo $team_name;?></option>
								<?php 
								}
								?>
							</select>
							<input type="button" name="filter_team" id="filter_team" class="logout" value="filter" onclick="collaborator_tasks()">
						</div>
					</div>

					<br>
					
					<div id="collaborator_tasks" style="overflow-y: auto;max-height:250px;">
						<font color="#FEFEFE">Loading . . . . . . . . . . .</font>
					</div>
<br>
<!-- place for show completed task -->
					<div class="row">
						<div class="col-6"><h6>COMPLETED TASK</h6></div>
					</div>

					<br>

					<div id="completed_task" style="overflow-y: auto;max-height:250px;">
						<font color="#FEFEFE">Loading . . . . . . . . . . .</font>
					</div>
			</div>
		</div>
	</div>
</div>

<script src="assets/js/jquery-3.7.0.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://kit.fontawesome.com/67a87c1aef.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/crypto-js.min.js"></script>
<script src="assets/js/user.js"></script>

<script>
    $(document).ready(function() {
		$('.user_collab').select2({
			placeholder: 'Choose Collaborator',
			dropdownParent: $('#myModal')
		});
		load_pet();
        get_data();
        completed_tasks();
		expired_task();
		collaborator_tasks();
		show_profile();
		check_reminder();
		// setInterval('refreshPage()', 5000);
		
	});

		// setTimeout(function(){
		// window.location.reload(1);
		// }, 10000);


		function refreshPage() { 
			// location.reload(); 
		}



// document.addEventListener("DOMContentLoaded", () => {
// const audio = document.querySelector("audio");

//   // Function to request audio playback permission
//   function requestAudioPermission() {
//     // Try to play the audio programmatically
//     audio.play()
//       .then(() => {
//         // Permission granted, show the audio element
//         audio.style.display = "block";
//         // Pause the audio to avoid autoplaying on subsequent visits
//         audio.pause();
//       })
//       .catch((err) => {
//         console.error("Error accessing audio playback:", err);
//       });
//   }

//   // Check if the user has already granted permission
//   const audioPermissionStatus = localStorage.getItem("audioPermission");

//   if (audioPermissionStatus !== "granted") {
//     // Request audio playback permission if it's the user's first visit
//     requestAudioPermission();

//     // Cache the permission status in localStorage after requesting permission
//     localStorage.setItem("audioPermission", "granted");
//   } else {
//     // Permission already granted, show the audio element
//     audio.style.display = "block";
//   }
// });


</script>
</body>
</html>