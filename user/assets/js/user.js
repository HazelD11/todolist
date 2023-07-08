
function logout(){
	location.href="../index.php";
}

function report(){
  location.href="report.php";
}

function home(){
  location.href="index.php";
}

function delete_task(task_id) {
  $.ajax({
    url: 'sv_task.php',
    method: 'POST',
    data: {
      id: task_id,
      act: 'delete'
    },
    success: function(result) {
      get_data();
      completed_tasks();
    }
  });
}

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

// function edit_task(task_id,task_name,task_date,task_desc,priority_id,user_id,category_id,reminder_id,status_id){
//   $.ajax({
//     url: 'crud_file.php',
//     method: 'POST',
//     data: {
//       id: task_id,
//       act: 'edit'
//     },
//     success: function(result) {
//       document.getElementById("tambah").value = 'Edit';
//       document.getElementById("id").value = task_id;
//       document.getElementById("task_name").value = task_name;
//       document.getElementById("task_date").value = task_date;
//       document.getElementById("task_desc").value = task_desc;
//       document.getElementById("priority_id").value = priority_id;
//       document.getElementById("user_id").value = user_id;
//       document.getElementById("category_id").value = category_id;
//       document.getElementById("reminder_id").value = reminder_id;
//       document.getElementById("status_id").value = status_id;

//       modal.style.display = "block";
//       get_data();
//       completed_tasks();
//     }
//   });
// }

function edit_task(id){
  $.ajax({
    url: 'sv_task.php',
    method: 'POST',
    data: {
      id: id,
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
      $("#reminder_id").val(data[8]);
      $("#status_id").val(data[9]);
      // document.getElementById("title_task").innerHTML = 'Edit Task';
      // document.getElementById("tambah").value = 'Edit';
      // document.getElementById("id").value = data[1];
      // document.getElementById("task_name").value = data[2];
      // document.getElementById("task_date").value = data[3];
      // document.getElementById("task_desc").value = data[4];
      // document.getElementById("priority_id").value = data[5];
      // document.getElementById("user_id").value = data[6];
      // document.getElementById("category_id").value = data[7];
      // document.getElementById("reminder_id").value = data[8];
      // document.getElementById("status_id").value = data[9];
      
      modal.style.display = "block";
      $('#tambah').unbind('click');
      $('#tambah').on("click",function(){
        update_task();
});
      // document.getElementById("title_task").innerHTML = 'Add Task';
      
    }
  });
}

function update_task(){
  var id = $("#id").val();
  var task_name = $("#task_name").val();
  var task_date = $("#task_date").val();
  var task_desc = $("#task_desc").val();
  var priority_id = $("#priority_id").val();
  var user_id = $("#user_id").val();
  var category_id = $("#category_id").val();
  var reminder_id = $("#reminder_id").val();
  var status_id = $("#status_id").val();
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
      reminder_id: reminder_id,
      status_id: status_id,
      act: 'update'
    },
    success: function(result) {   
      get_data();
      completed_tasks();
      modal.style.display = "none";   
    }
  });
}

function add_task(){
  modal.style.display = "block";
      $("title_task").html("Add Task");
      $("id").val("");
      $("task_name").val("");
      $("task_date").val("");
      $("task_desc").val("");
      $("priority_id").val("title_priority");
      $("category_id").val("title_category");
      $("reminder_id").val("title_reminder");
      $("status_id").val("");
    // document.getElementById("id").value = '';
    // document.getElementById("task_name").value = '';
    // document.getElementById("task_date").value = '';
    // document.getElementById("task_desc").value = '';
    // document.getElementById("priority_id").value = 'title_priority';
    // document.getElementById("category_id").value = 'title_category';
    // document.getElementById("reminder_id").value = 'title_reminder';
    // document.getElementById("status_id").value = '';
  // $("#title_task").html("Add Task");
  // $.ajax({
  //   url: 'sv_task.php',
  //   method: 'POST',
  //   data: {
  //     id: id,
  //     act: 'add'
  //   },
  //   success: function(result) {
      
  //     // document.getElementById("title_task").innerHTML = 'Add Task';
  //     document.getElementById("tambah").value = 'ADD';
  //     document.getElementById("task_name").value = '';
  //     // modal.style.display = "block";
      
  //   }
  // });
}

function insert_task(){
  var id = $("#id").val();
  var task_name = $("#task_name").val();
  var task_date = $("#task_date").val();
  var task_desc = $("#task_desc").val();
  var priority_id = $("#priority_id").val();
  var category_id = $("#category_id").val();
  var reminder_id = $("#reminder_id").val();
  var status_id = $("#status_id").val();
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
      reminder_id: reminder_id,
      status_id: status_id,
      act: 'add'
    },
    success: function( result ) {
      get_data();
      completed_tasks();
      modal.style.display = "none";
      
    }
  });  


}

function check_task(task_id){
  $.ajax({
    url: 'sv_task.php',
    method: 'POST',
    data: {
      id: task_id,
      act: 'set_done'
    },
    success: function( result ) {
      get_data();
      completed_tasks();
      
    }
  });  
}

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
    }
  });
}

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



// Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
// var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
// btn.onclick = function() {
//   modal.style.display = "block";
// }


// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
