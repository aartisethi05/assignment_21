<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">  
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <title>Recover Password</title>
    <style>
    .size{
        width:70%;
    }
    </style>
</head>
<body>
<div class="container">
  <div class="row mt-5">
  <div class="col-sm-3"></div>
    <div class="col-sm-6">
    (For reference: Please enter email: test@gmail.com)
    <input type="text" name="email" id="email" placeholder="Enter your email" class="size"><br>
    <button type="submit" id="recover" class="btn btn-primary mt-3 mb-3">Recover Password</button>
    <p id="text"></p>
  </div>
  </div>
  <div class="row">
  <div class="col-sm-3"></div>
  <div id="changeDiv" style="display:none"  class="col-sm-6">
    <input type="password" name="password" id="password" placeholder="New Password" class="size mt-3"><br>
    <input type="password" name="confirm_password" id="confirm_password" class="mt-3 size" placeholder="Confirm Password">
    <br><button type="submit" id="change" class="btn btn-primary mt-3">Submit</button>
  </div>
  </div>
  </div>
</body>
<script>
 function changePassword(){
     $('#password, #confirm_password').val('');
     $('#text,#recover').hide();
      $('#changeDiv').show();
  }
  function validEmail(email) {
    var pattern = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i;

    if(pattern.test(email))
      return true;
}
$(document).ready(function(){
  $('#recover').click(function(){
    var email = $('#email').val();
    if(email=='')
        alert('Please enter your email.');
    else if(!validEmail(email))
        alert('Please enter valid email format.');
    else{
    $.ajax({
        url: "{{url('/recover_password')}}",
        method:'POST',
        data:{'_token': "{{ csrf_token() }}",'email':email},
        success: function(result){
    (result==false)?alert('Email doesnot exist.'):$("#text").html(`Your password is : ${JSON.parse(result.password)} <br>Password in DB is : ${JSON.parse(result.original)} <br><a onclick="changePassword()" style="color:blue;text-decoration:underline;cursor:pointer">Click here </a>to change your password` ).show();
    }});
    }
  });

  $('#change').click(function(){
    var email = $('#email').val();
    var password = $('#password').val();
    var confirm = $('#confirm_password').val();
    if(email=='')
        alert('Please enter your email');
    else if(!validEmail(email))
        alert('Please enter valid email format.');
    else if(password=='')
        alert('Please enter new password');
    else if(confirm=='')
        alert('Confirm your password');
    else if(password!==confirm)
        alert('Confirm password doesnot match');
    else{
    $.ajax({
        url: "{{url('/change_password')}}",
        method:'POST',
        data:{'_token': "{{ csrf_token() }}",'email':email,'password':password},
        success: function(result){
        if(result){
         alert('Your password has been changed successfully.'); 
         $('#changeDiv').hide();
         $("#text").html('');
         $("#recover").show();
        }
        else
          alert('Email doesnot exist.');
       
    }});
   }
  });
});
</script>
</html>