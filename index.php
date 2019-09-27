<html>
 <head>
  <title>PHP CRUD</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <style>
   body
   {
    margin:0;
    padding:0;
    background-color:#f1f1f1;
   }
   .box
   {
    width:1270px;
    padding:20px;
    background-color:#fff;
    border:1px solid #ccc;
    border-radius:5px;
    margin-top:100px;
   }
  </style>
 </head>
 <body>
  <div class="container box">
   <h1 align="center">PHP PDO CRUD</h1>
   <br />
   <div align="right">
    <button type="button" id="modal_button" class="btn btn-info">Create Records</button>
   </div>
   <br />
   <div id="result" class="table-responsive"> 

   </div>
  </div>
 </body>
</html>

<div id="customerModal" class="modal fade">
 <div class="modal-dialog">
  <div class="modal-content">
   <div class="modal-header">
    <h4 class="modal-title">Create New Records</h4>
   </div>
   <div class="modal-body">
    <label>Customer Name</label>
    <input type="text" name="name" id="name" class="form-control" />
    <br />
    <label>Customer Address</label>
    <input type="text" name="address" id="address" class="form-control" />
    <br />
    <label>Customer Number</label>
    <input type="text" name="contact" id="contact" class="form-control" />
   </div>
   <div class="modal-footer">
    <input type="hidden" name="customer_id" id="customer_id" />
    <input type="submit" name="action" id="action" class="btn btn-success" />
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
   </div>
  </div>
 </div>
</div>

<script>
$(document).ready(function(){
 fetchUser(); 
 function fetchUser() 
 {
  var action = "Load";
  $.ajax({
   url : "action.php", 
   method:"POST", 
   data:{action:action}, 
   success:function(data){
    $('#result').html(data); 
   }
  });
 }

 
 $('#modal_button').click(function(){
  $('#customerModal').modal('show'); 
  $('#first_name').val(''); 
  $('#last_name').val(''); 
  $('.modal-title').text("Create New Records"); 
  $('#action').val('Create'); 
 });

 
 $('#action').click(function(){
  var name = $('#name').val(); 
  var address = $('#address').val(); 
  var contact = $('#contact').val(); 
  var id = $('#customer_id').val();  
  var action = $('#action').val();  
  if(name != '' && address != '')
  {
   $.ajax({
    url : "action.php",   
    method:"POST",     
    data:{name:name, address:address,contact:contact, id:id, action:action}, 
    success:function(data){
     alert(data);   
     $('#customerModal').modal('hide'); 
     fetchUser();   
    }
   });
  }
  else
  {
   alert("Fields are Required");
  }
 });


 $(document).on('click', '.update', function(){
  var id = $(this).attr("id"); 
  var action = "Select";   
  $.ajax({
   url:"action.php",   
   method:"POST",    
   data:{id:id, action:action},
   dataType:"json",  
   success:function(data){
    $('#customerModal').modal('show');   
    $('.modal-title').text("Update Records"); 
    $('#action').val("Update");    
    $('#customer_id').val(id);    
    $('#name').val(data.customer_name);  
    $('#address').val(data.address); 
    $('#contact').val(data.contact); 
   }
  });
 });

 $(document).on('click', '.delete', function(){
  var id = $(this).attr("id"); 
  if(confirm("Are you sure you want to remove this data?"))
  {
   var action = "Delete"; 
   $.ajax({
    url:"action.php",    
    method:"POST",     
    data:{id:id, action:action},
    success:function(data)
    {
     fetchUser();    
     alert(data);    
    }
   })
  }
  else 
  {
   return false; 
  }
 });
});
</script>
 