<?php
include('server.php');
if (isset($_SESSION['name'])) {
		header('location: index.php');
	}
?>
<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
</head>
<body>
<div class='form'>
<form id='register-form' action="chpass1.php" method='post'>
  <center><span class="head">Reset Password</span></center><br>
  <input type="password" placeholder="Password" name="password_1">
  <input type="password" placeholder="Re Password" name="password_2">
  <center><button type='submit' name="chpass1">Reset</button></center></br>
  <center><?php include('errors.php'); ?></center>
  </form>
  </div>
</body>
<style>
.head{
    padding:5px;
	font-size:28px;
	color: #464a92;
	border: none;
}
form{
  margin:0 auto;
  width:250px;
  padding:48px;
  border:5px solid #464a92;
}
.form{
	padding:5%;
}
input {
  margin-bottom:3px;
  padding:10px;
  width: 200px;
  border:1px solid #CCC;
  color: #464a92;
}
button {
	position:relative;
   text-decoration:none;
	padding:8px;
	font-size:14px;
	color: white;
	background:#464a92;
	border: none;
	border-radius:2px;
	cursor:pointer;
 }

</style>
</html>
