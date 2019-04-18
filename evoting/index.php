<?php
include('server.php');
if ($_SESSION['name']=="admin") {
		header('location: admin.php');
	}
else{
		header('location: user.php');
}
?>