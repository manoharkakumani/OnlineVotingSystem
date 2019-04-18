<!DOCTYPE html>
<?php
include('server.php');
if (!isset($_SESSION['name'])) {
		header('location: login.php');
	}
if ($_SESSION['name']!="admin") {
		header('location: index.php');
	}
?>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<ul class="topnav">
  <li><a href="index.php">Add Candidate</a></li>
  <li><a class="active"  href="delete.php">Delete Candidate</a></li>
  <li><a href="result.php">Results</a></li>
  <li><a href="index.php?newelection='1'">New Election</a></li>
  <li><a href="index.php?startelection='1'">Start Election</a></li>
  <li><a href="chpass.php">Change Password</a></li>
  <li class="right"><a href="index.php?logout='1'">Logout</a></li>
</ul>
<div class='form'>
<form id='login-form' action="delete.php" method='post'>
  <center><span class="head">Delete Candidate</span></center><br></br> 
			<select name="candidate">
            <option value="m">--- Select Candidate ---</option>
            <?php
            $list=mysqli_query($db ,"select * from `candidate`");
            while($row_list=mysqli_fetch_assoc($list)){
                
                   echo" <option value='".$row_list['candidateid']."'>".$row_list['name']."-".$row_list['candidateid']."
                    </option>";
                }
                ?>
            </select><br></br>
  <center><button type='submit' name="delete">Delete</button>&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
  <a class="square" href='delete.php'>Reset</a></center><br></br>
	<center><?php include('errors.php'); ?></center>
  </form>
  </div>
</body>
<style>
.head{
   position:relative;
   text-decoration:none;
	padding:8px;
	font-size:25px;
	color: white;
	background:#464a92;
	border: none;
	border-radius:2px;
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
select{
  margin-bottom:3px;
  padding:10px;
  font-size:18px;
  width: 250px;
  border:1px solid #CCC;
  color: #464a92;
}
button,.square{
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
