
function logout(){
	location.href="../index.php";
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

function edit_task(task_id,task_name,task_date,task_desc,priority_id,user_id,category_id,reminder_id,status_id){
  $.ajax({
    url: 'crud_file.php',
    method: 'POST',
    data: {
      id: task_id,
      act: 'edit'
    },
    success: function(result) {
      document.getElementById("tambah").value = 'Edit';
      document.getElementById("id").value = task_id;
      document.getElementById("task_name").value = task_name;
      document.getElementById("task_date").value = task_date;
      document.getElementById("task_desc").value = task_desc;
      document.getElementById("sel1").value = priority_id;
      document.getElementById("user_id").value = user_id;
      document.getElementById("sel2").value = category_id;
      document.getElementById("sel3").value = reminder_id;
      document.getElementById("status_id").value = status_id;
      
      modal.style.display = "block";
      get_data();
      completed_tasks();
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
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
  modal.style.display = "block";
}


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
