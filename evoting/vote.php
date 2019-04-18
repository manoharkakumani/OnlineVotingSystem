<!DOCTYPE html>
<?php
include('server.php');
if (!isset($_SESSION['name'])) {
		header('location: login.php');
	}
if ($_SESSION['result']){
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
  <li><a href="index.php">Home</a></li>
  <li><a class="active" href="vote.php">Vote</a></li>
  <li><a href="#contact">About</a></li>
  <li><a href="chpass.php">Change Password</a></li>
  <li class="right"><a href="index.php?logout='1'">Logout</a></li>
</ul>
<div class='form'>
<form id='login-form' action="vote.php" method='post'>
  <center><span class="head">ONLINE VOTING MECHINE</span></center><br></br> 
			<?php
			if($_SESSION['election']){
			  echo "<select name='candidate'>
            <option value='m'>--- Select Candidate ---</option>";            
            $list=mysqli_query($db ,"select * from `candidate`");
            while($row_list=mysqli_fetch_assoc($list)){
                
                   echo" <option value='".$row_list['candidateid']."'>".$row_list['name']."-".$row_list['candidateid']."
                    </option>";
                }
				echo"  </select><br></br>
  <center><button type='submit' name='vote'>Vote</button>&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
  <a class='square' href='vote.php'>Reset</a></center><br></br>";
			}else{
				echo "<center><b><i class='square'>ELECTION IS NOT STARTED YET</i></b></center><br></br>";
			}
                ?>
	<center><?php include('errors.php'); ?></center>
  </form>
  </div>
</body>
<style>
.head{
    padding:5px;
	font-size:25px;
	color: #464a92;
	border: none;
}
form{
  margin:0 auto;
  width:258px;
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
	font-size:15px;
	color: white;
	background:#464a92;
	border: none;
	border-radius:2px;
	cursor:pointer;
 }

</style>
</body>
</html>
