// Get the modal
var modal = document.getElementById("myModal");
var modal_profile = document.getElementById("profileModal");
var modal_menu = document.getElementById("remind_menu");
var modal_reminder = document.getElementById("AEreminder");

// Get the button that opens the modal
// var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];
var span2 = document.getElementsByClassName("close_profile")[0];
var span3 = document.getElementsByClassName("close_remind_menu")[0];
var span4 = document.getElementsByClassName("close_AEreminder")[0];

// When the user clicks the button, open the modal 
// btn.onclick = function() {
//   modal.style.display = "block";
// }


// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

span2.onclick = function() {
  modal_profile.style.display = "none";
}

span3.onclick = function() {
  modal_menu.style.display = "none";
}

span4.onclick = function() {
  modal_reminder.style.display = "none";
}
// span.onclick = function() {
//   modal_profile.style.display = "none";
// }

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
  if (event.target == modal_profile) {
    modal_profile.style.display = "none";
  }
  if (event.target == modal_menu) {
    modal_menu.style.display = "none";
  }
  if (event.target == modal_reminder) {
    modal_reminder.style.display = "none";
  }
}

function logout(){
	location.href="../index.php";
}

function report(){
  location.href="report.php";
}

function home(){
  location.href="index.php";
}

//task crud function
//show the form for adding task
function add_task(){
  const date = new Date();

  let day = date.getDate();
  let month = date.getMonth() + 1;
  let year = date.getFullYear();
  if(month < 10){
    month = "0"+month;
    // return month;
  }
  // This arrangement can be altered based on how we want the date's format to appear.
  let currentDate = `${year}-${month}-${day}`;
  modal.style.display = "block";
      $("#title_task").html("Add Task");
      $("#tambah").val("ADD");
      $("#id").val("");
      $("#task_name").val("");
      $("#task_date").val(currentDate);
      $("#task_desc").val("");
      $("#priority_id").val("title_priority");
      $("#category_id").val("title_category");
      $("#task_time").val("title_reminder");
      $("#team_name").val("");
      // $("#select_user").val("");
      $("#select_user").val([]).trigger("change");
      $("#status_id").val("");
}

//proccess the form for add task
function insert_task(){
  var id = $("#id").val();
  var task_name = $("#task_name").val();
  var task_date = $("#task_date").val();
  var task_desc = $("#task_desc").val();
  var priority_id = $("#priority_id").val();
  var category_id = $("#category_id").val();
  var task_time = $("#task_time").val();
  var status_id = $("#status_id").val();
  var collaborator = $("#select_user").val();
  var team_name = $("#team_name").val();

  $.ajax({
    url: 'sv_task.php',
    method: 'POST',
    data: {
      id: id,
      task_name: task_name,
      task_date: task_date,
      task_desc: task_desc,
      priority_id: priority_id,
      category_id: category_id,
      task_time: task_time,
      collaborator:collaborator,
      team_name:team_name,
      status_id: status_id,
      act: 'add'
    },
    success: function( result ) {
      get_data();
      completed_tasks();
      expired_task();
      collaborator_tasks();
      modal.style.display = "none";
    }
    
  });  
}

//show the form for edit task
function edit_task(id,task_team){
  $.ajax({
    url: 'sv_task.php',
    method: 'POST',
    data: {
      id: id,
      task_team: task_team,
      act: 'edit'
    },
    success: function(result) {
      var data = result.split("|");
      
      var id = $("#id").val(data[1]);
      $("#title_task").html("Edit Task");
      $("#tambah").val("Edit");
      $("#id").val(data[1]);
      $("#task_name").val(data[2]);
      $("#task_date").val(data[3]);
      $("#task_desc").val(data[4]);
      $("#priority_id").val(data[5]);
      $("#user_id").val(data[6]);
      $("#category_id").val(data[7]);
      $("#task_time").val(data[8]);
      $("#status_id").val(data[9]);
      $("#task_team").val(data[10]);
      $("#team_name").val(data[11]);
      // const a = JSON.parse(data[12]);
      // const b = JSON.stringify(a);
      // console.log(a);
      
      modal.style.display = "block";
      $('#tambah').unbind('click');
      $('#tambah').on("click",function(){
        update_task();
      });     
    }
  });
}

//proccess the form for edit task
function update_task(){
  var id = $("#id").val();
  var task_name = $("#task_name").val();
  var task_date = $("#task_date").val();
  var task_desc = $("#task_desc").val();
  var priority_id = $("#priority_id").val();
  var user_id = $("#user_id").val();
  var category_id = $("#category_id").val();
  var task_time = $("#task_time").val();
  var status_id = $("#status_id").val();
  var collaborator = $("#select_user").val();
  var team_name = $("#team_name").val();
  var task_team = $("#task_team").val();
  $.ajax({
    url: 'sv_task.php',
    method: 'POST',
    data: {
      id: id,
      task_name: task_name,
      task_date: task_date,
      task_desc: task_desc,
      priority_id: priority_id,
      user_id: user_id,
      category_id: category_id,
      task_time: task_time,
      status_id: status_id,
      collaborator: collaborator,
      team_name: team_name,
      task_team: task_team,
      act: 'update'
    },
    success: function(result) {   
      get_data();
      completed_tasks();
      expired_task();
      collaborator_tasks();
      modal.style.display = "none";   
    }
  });
}

//delete task
function delete_task(task_id,task_team) {
  let text = "You sure want to delete task?";
  if (confirm(text) == true) {
    $.ajax({
      url: 'sv_task.php',
      method: 'POST',
      data: {
        id: task_id,
        task_team:task_team,
        act: 'delete'
      },
      success: function(result) {
        get_data();
        completed_tasks();
      collaborator_tasks();
      expired_task();
      }
    });
  }
  
}

//report||filter based on date function
function vw_result(){
  var from_date = $("#from_date").val();
  var to_date = $("#to_date").val();
  var status = $("#status").val();
  $.ajax({
    url: 'sv_task.php',
    method: 'POST',
    data: {
      from_date:from_date,
      to_date:to_date,
      status:status,
      act: 'view'
    },
    success: function( result ) {
      $("#tdl").css({"display" :"none"});
      $("#report_result").html( result );
    }
  });
}

//check task function
function check_task(task_id){
  var user_exp = $("#user_exp").html();
  console.log(user_exp);
  $.ajax({
    url: 'sv_task.php',
    method: 'POST',
    data: {
      user_exp: user_exp,
      id: task_id,
      act: 'set_done'
    },
    success: function( result ) {
      get_data();
      completed_tasks();
      load_pet();
      collaborator_tasks();
      expired_task();
    }
  });  
}

//uncheck task function
function uncheck_task(task_id){
  $.ajax({
    url: 'sv_task.php',
    method: 'POST',
    data: {
      id: task_id,
      act: 'set_undone'
    },
    success: function( result ) {
      get_data();
      completed_tasks();
      expired_task();
      collaborator_tasks();
      load_pet();
    }
  });
}

//show active task
function get_data(){
  $.ajax({
    url: 'sv_task.php',
    method: 'POST',
    data: {
      act: 'loading'
    },
    success: function( result ) {
      $("#active_tasks").html( result );
    }
  });
}

//show collaborator task
function collaborator_tasks(){
  var collab_team = $("#collab_team").val();
  $.ajax({
    url: 'sv_task.php',
    method: 'POST',
    data: {
      collab_team:collab_team,
      act: 'show_collab'
    },
    success: function( result ) {
      $("#collaborator_tasks").html( result );
    }
  });
}

//show completed task
function completed_tasks(){
  $.ajax({
    url: 'sv_task.php',
    method: 'POST',
    data: {
      act: 'complete'
    },
    success: function( result ) {
      $("#completed_task").html( result );
    }
  });
}

//show expired task
function expired_task(){
  $.ajax({
    url: 'sv_task.php',
    method: 'POST',
    data: {
      act: 'expired'
    },
    success: function( result ) {
      $("#expired_tasks").html( result );
    }
  });
}

//show profile
function show_profile(){
  $.ajax({
    url: 'sv_profile.php',
    method: 'POST',
    data: {
      act: 'show_profile'
    },
    success: function( result ) {
      $("#user_profile").html( result );
    }
  });
}

//show form for edit profile
function edit_profile(){
  $.ajax({
    url: 'sv_profile.php',
    method: 'POST',
    data: {
      act: 'edit_profile'
    },
    success: function(result) {
      var data = result.split("|");
      
      $("#profile_id").val(data[1]);
      $("#profile_name").val(data[2]);
      $("#profile_email").val(data[3]);
      $("#profile_pict").val(data[4]);
      $("#old_password").val('');
      $("#new_password").val('');
      $("#confirm_new_password").val('');
      
      modal_profile.style.display = "block";
       
    }
  });
}

//proccess the form for edit profile
function update_profile(id){
  var id = $("#profile_id").val();
  var pet_id = $("#pet_id").val();
  var profile_name = $("#profile_name").val();
  var profile_email = $("#profile_email").val();
  var old_password = CryptoJS.MD5($("#old_password").val());
  var new_password = CryptoJS.MD5($("#new_password").val());
  var confirm_new_password = CryptoJS.MD5($("#confirm_new_password").val());
  var profile_pict = $("#profile_pict")[0].files[0];
  
  fd = new FormData();
  fd.append('id', id);
  fd.append('pet_id', pet_id);
  fd.append('profile_name', profile_name);
  fd.append('profile_email', profile_email);
  fd.append('old_password', old_password);
  fd.append('new_password', new_password);
  fd.append('confirm_new_password', confirm_new_password);
  fd.append('profile_pict', profile_pict);
  fd.append('act','update_profile');
  
  $.ajax({
    url: 'sv_profile.php',
    method: 'POST',
    data: fd,
    contentType: false,
    processData: false,
    success: function(result) {   
      get_data();
      completed_tasks();
      expired_task();
      show_profile();
      load_pet();
      modal_profile.style.display = "none";
    }
  });
}

//load the pet to the UI
function load_pet(){
  $.ajax({
    url: 'sv_task.php',
    method: 'POST',
    data: {
      act: 'pets_loader'
    },
    success: function(result) {
      $("#pet_loader").html( result );
    }
  });
}

//select pet function, so we can see which pet is selected when we clicked the edit profile
function select_pet(id){
  $("#pet_id").val(id);
  $(".select_pet").removeClass("selected");
  $("#pet_card_" + id).addClass("selected");
}

//show reminder menu and load the list
function remind_menu(){
  modal_menu.style.display = "block";
  $.ajax({
    url: 'sv_task.php',
    method: 'POST',
    data: {
      act: 'load_reminder'
    },
    success: function( result ) {
      $("#reminder_list").html( result );
    }
  });
}

//show the form for add reminder
function add_reminder(){
  // This arrangement can be altered based on how we want the date's format to appear.
  modal_reminder.style.display = "block";
      $("#title_reminder").html("Add Reminder");
      $("#insert_reminder").val("ADD");
      $("#reminder_id").val("");
      $("#reminder_task_select").val("title_select_task");
      $("#reminder_task_name").val("");
      $("#reminder_task_date").val("");
      $("#reminder_task_time").val("");
      $("#ringtone_id").val("title_select_ringtone");
}

//proccess the form for add task
function insert_reminder(){
  var reminder_id = $("#reminder_id").val();
  var reminder_task_date = $("#reminder_task_date").val();
  var reminder_task_time = $("#reminder_task_time").val();
  var reminder_task_select = $("#reminder_task_select").val();
  var ringtone_id = $("#ringtone_id").val();
  $.ajax({
    url: 'sv_task.php',
    method: 'POST',
    data: {
      reminder_id: reminder_id,
      reminder_task_date: reminder_task_date,
      reminder_task_time: reminder_task_time,
      reminder_task_select: reminder_task_select,
      ringtone_id: ringtone_id,
      act: 'add_reminder'
    },
    success: function( result ) {
      modal_reminder.style.display = "none";
      remind_menu();
    }
  });  
}

// //show the form for edit reminder
function edit_reminder(id){
  $.ajax({
    url: 'sv_task.php',
    method: 'POST',
    data: {
      id: id,
      act: 'edit_reminder'
    },
    success: function(result) {
      var data = result.split("|");
      
      $("#title_reminder").html("Edit Reminder");
      $("#insert_reminder").val("EDIT");
      $("#reminder_id").val(data[1]);
      $("#reminder_task_select").val(data[2]);
      $("#reminder_task_date").val(data[3]);
      $("#reminder_task_time").val(data[4]);
      $("#ringtone_id").val(data[5]);
      
      modal_reminder.style.display = "block";
      $('#insert_reminder').unbind('click');
      $('#insert_reminder').on("click",function(){
        update_reminder();
      });     
    }
  });
}

// //proccess the form for edit task
function update_reminder(){
  var reminder_id = $("#reminder_id").val();
  var reminder_task_select = $("#reminder_task_select").val();
  var reminder_task_date = $("#reminder_task_date").val();
  var reminder_task_time = $("#reminder_task_time").val();
  var ringtone_id = $("#ringtone_id").val();
  $.ajax({
    url: 'sv_task.php',
    method: 'POST',
    data: {
      reminder_id: reminder_id,
      reminder_task_select: reminder_task_select,
      reminder_task_date: reminder_task_date,
      reminder_task_time: reminder_task_time,
      ringtone_id: ringtone_id,
      act: 'update_reminder'
    },
    success: function(result) {   
      modal_reminder.style.display = "none";   
      remind_menu();
    }
  });
}

//delete reminder
function delete_reminder(reminder_id) {
  let text = "You sure want to delete reminder?";
  if (confirm(text) == true) {
    $.ajax({
      url: 'sv_task.php',
      method: 'POST',
      data: {
        reminder_id: reminder_id,
        act: 'delete_reminder'
      },
      success: function(result) {
        remind_menu();
      }
    });
  } 
  
}

//check reminder
function check_reminder(){
  $.ajax({
    url: 'sv_task.php',
    method: 'POST',
    data: {
      act: 'check_reminder'
    },
    success: function( result ) {
      $("#check_reminder").html( result );
    }
  });
}
