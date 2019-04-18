<!DOCTYPE html>
<?php
include('server.php');
if (!isset($_SESSION['name'])) {
		header('location: login.php');
	}
?>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="style.css">
</head><body>

<?php if ($_SESSION['name']=="admin") {
echo"
<ul class='topnav'>
  <li><a href='index.php'>Add Candidate</a></li>
  <li><a href='delete.php'>Delete Candidate</a></li>
  <li><a class='active'  href='result.php'>Results</a></li>
  <li><a href='index.php?newelection='1''>New Election</a></li>
  <li><a href='index.php?startelection='1''>Start Election</a></li>
  <li><a href='chpass.php'>Change Password</a></li>
  <li class='right'><a href='index.php?logout='1''>Logout</a></li>
</ul>";}
elseif ($_SESSION['result']){
	echo "<ul class='topnav'>
  <li><a href='index.php'>Home</a></li>
  <li><a class='active' href='result.php'>Results</a></li>
  <li><a href='#contact'>About</a></li>
   <li><a href='chpass.php'>Change Password</a></li>
  <li class='right'><a href='index.php?logout='1''>Logout</a></li>
</ul>";
}
else{
	header('location: index.php');
}
?>
<div class='form'>
 <form action="result.php" method='post'>
<center><span class="head">RESULTS </span></center><br></br> 
  <table>
  <tr>
    <th>Candidate ID</th>
    <th>Candidate NAME</th> 
    <th>VOTES</th>
  </tr>
             <?php
            $list=mysqli_query($db ,"select * from `candidate` ORDER BY votes desc");
            while($row_list=mysqli_fetch_assoc($list)){
                
                   echo " <tr><td>".$row_list['candidateid']."</td><td>".$row_list['name']."</td><td>".$row_list['votes']."</td></tr>";
                }
                ?>
				 </table>
             <br></br>
<?php 
if ($_SESSION['name']=="admin") {
  echo"<center><button type='submit' name='release'>Release</button>";
}?>
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
  width:50%;
  padding:48px;
  border:5px solid #464a92;
}
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
  color:#464a92;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
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
