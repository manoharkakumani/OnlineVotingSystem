<!DOCTYPE html>
<?php
include('server.php');
if (!isset($_SESSION['name'])) {
		header('location: login.php');
	}
else{
  $n1=$_SESSION['name'];
  $n2=$_SESSION['phone'];
   $query = "SELECT * FROM users WHERE name ='$n1' AND phone='$n2'";
        $results = mysqli_query($db,$query);
        $row = mysqli_fetch_array($results);
                $_SESSION['result'] = $row['result'];
                $_SESSION['election'] = $row['election'];
}
?>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<ul class="topnav">
  <li><a class="active" href="index.php">Home</a></li>
 
  <?php 
  if($_SESSION['result']){
  echo" <li><a href='result.php'>Results</a></li>"; 
  }else {
	  echo" <li><a href='vote.php'>Vote</a></li>";
  }?>
  <li><a href="#contact">About</a></li>
  <li><a href="chpass.php">Change Password</a></li>
  <li class="right"><a href="index.php?logout='1'">Logout</a></li>
</ul>
<div class='form'>
<form id='login-form' action="#" method='post'>
  <center><span class="head">USER DETAILS</span></center><br></br> 
  <center><span class="select">Name : <?php echo $_SESSION['name'];?></span></center><br></br>
  <center><span class="select">Email : <?php echo $_SESSION['email'];?></span></center><br></br> 
  <center><span class="select">Phone : <?php echo $_SESSION['phone'];?></span></center><br></br> 
  <center><span class="select">Aadhar : <?php echo $_SESSION['aadhar'];?></span></center><br></br>   
  <center><span class="select">VoterId : <?php echo $_SESSION['voterid'];?></span></center><br></br>			
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
.select{
  margin-bottom:3px;
  padding:0px;
  font-size:18px;
  width: 250px;
  color: #464a92;
}


</style>
</html>
