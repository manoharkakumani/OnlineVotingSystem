<?php 
	$name = "";
	$email    = "";
	$voteid="";
	$errors = array();
     $msg="Code was sent to your email ";
	 $db = mysqli_connect('localhost','root','', 'evotingdb');
if (session_id() == "")
  session_start();
	// REGISTER USER
	if (isset($_GET['newelection'])) {
		mysqli_query($db,"UPDATE `users` SET `result`='0'");
		mysqli_query($db,"UPDATE `users` SET `status`='0'");
		mysqli_query($db,"UPDATE `users` SET `election`='0'");
		mysqli_query($db,"TRUNCATE `candidate`");
		header("location: index.php");
	}
	if (isset($_GET['startelection'])) {
		mysqli_query($db,"UPDATE `users` SET `election`='1'");
		header("location: index.php");
	}
	if (isset($_GET['logout'])) {
		session_destroy();
		unset($_SESSION['name']);
		unset($_SESSION['result']);
		unset($_SESSION['phone']);
		unset($_SESSION['email']);
		unset($_SESSION['aadhar']);
		unset($_SESSION['voterid']);
		header("location: login.php");
	}
	if (isset($_POST['signup_user'])) {
		// receive all input values from the form
		$name = mysqli_real_escape_string($db, $_POST['name']);
		$password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
		$password_2 = mysqli_real_escape_string($db, $_POST['password_2']);
		$phone = mysqli_real_escape_string($db, $_POST['phone']);
		$aadhar = mysqli_real_escape_string($db, $_POST['aadhar']);
		$email = mysqli_real_escape_string($db, $_POST['email']);
		//form validation: ensure that the form is correctly filled
		if (empty($name)) { array_push($errors, "Name is required"); }
		if (empty($email)) { array_push($errors, "Email is required"); }
		if (empty($password_1)) { array_push($errors, "Password is required");}
		if (empty($phone)) { array_push($errors, "Phone NO is required"); }
		if (empty($aadhar)) { array_push($errors, "AADHAR is required");}
		if ($password_1 != $password_2) {
		array_push($errors, "Passwords didn't matched");
		}
		if ($name=='admin'){ array_push($errors, "Name is not allowed"); }
		elseif (mysqli_num_rows(mysqli_query($db,"SELECT * FROM users WHERE name='$name'")) == 1){array_push($errors, "Name is already in Use");}
		if (mysqli_num_rows(mysqli_query($db,"SELECT * FROM users WHERE email='$email'")) == 1){array_push($errors, "Email is already in Use");}
		if (mysqli_num_rows(mysqli_query($db,"SELECT * FROM users WHERE phone='$phone'")) == 1){array_push($errors, "Phone no is already in Use");}
		if (mysqli_num_rows(mysqli_query($db,"SELECT * FROM users WHERE aadhar='$aadhar'")) == 1){array_push($errors, "AADHAR is already in Use");}
		
		// register user if there are no errors in the form
		if (count($errors) == 0) {
			 $rand=rand(999,9999);
             $from='@noreplay';
             $sub="ACCOUNT VERIFICATION";
             $meg="Your CODE IS :".$rand;
			  $voteid=voterid();
      //  mail($email,$from,$sub,$meg);
			$password = ($password_1);//encrypt the password before saving in the database
			$query = "INSERT INTO users (name, email, password,verify,code,phone,aadhar,voterid) 
					  VALUES('$name', '$email', '$password','0','$rand','$phone','$aadhar','$voteid')";
			mysqli_query($db, $query);
			$_SESSION['email'] = $email;
			header('location: verify.php');
		}
	}	
	function voterid($length =6) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
//------------------------------------------------------------------------------------------------
	// LOGIN USER
	if (isset($_POST['signin_user'])) {
		$email=mysqli_real_escape_string($db,$_POST['email']);
		$password = mysqli_real_escape_string($db,$_POST['password']);
        
		if (empty($email)){
			array_push($errors, "Email is required");
		}
		if (empty($password)) {
			array_push($errors, "Password is required");
		}
		if (count($errors) == 0) {
			$query = "SELECT * FROM users WHERE email='$email'AND password='$password'";
				$results = mysqli_query($db,$query);
				$row = mysqli_fetch_array($results);
		         if (mysqli_num_rows($results) == 1)
					 {
					 	$_SESSION['email'] = $row['email'];
					 	$op = $row['verify'];
						$op1 = $row['verify1'];
					 	if($op){      
							 if($op1)
						 {
							  $_SESSION['name'] = $row['name'];
							  $_SESSION['voterid'] = $row['voterid'];
							  $_SESSION['phone'] = $row['phone'];
							  $_SESSION['aadhar'] = $row['aadhar'];
							  $_SESSION['result'] = $row['result'];
							  $_SESSION['election'] = $row['election'];
							  header('location: index.php');
						 }
						 else{
				              header('location: verify1.php'); 
						 }
				         }
						
						 else{
							 
							 header('location: verify.php'); 
						 }
						 
			}else {
				array_push($errors, "Wrong Email/Password combination");
			}
		}
	}
//------------------------------------------------------------------------------------------------------------
//verification of mail	
	if (isset($_POST['verify'])) {
		$email=$_SESSION['email'];
		$code= $_POST['code'];
		if (empty($code)) {
			array_push($errors, "CODE is required");
		}
		if (count($errors) == 0) {
			$query = "SELECT * FROM `users` WHERE email='$email'AND code='$code'";
				$results = mysqli_query($db,$query);
				$row = mysqli_fetch_array($results);
		         if (mysqli_num_rows($results) == 1)
		          {				
				mysqli_query($db,"UPDATE `users` SET `verify`='1' WHERE email='$email'");
							  $_SESSION['name'] = $row['name'];
							  $_SESSION['voterid'] = $row['voterid'];
							  $_SESSION['phone'] = $row['phone'];
							  $_SESSION['aadhar'] = $row['aadhar'];
							  $_SESSION['result'] = $row['result'];	
							  $_SESSION['election'] = $row['election'];
				        header('location: index.php');
			}else {
				array_push($errors, "YOU ENTERED WRONG CODE");
			}
		}
	}	
if (isset($_POST['resend'])) {
		$email=$_SESSION['email'];        
		 $rand=rand(999,9999);
             $from='@noreplay';
             $sub="ACCOUNT VERIFICATION";
             $meg="Your CODE IS :".$rand;
        //mail($email,$from,$sub,$meg);	
			$query = "SELECT * FROM `users` WHERE email='$email'";
				$results = mysqli_query($db,$query);
				$row = mysqli_fetch_array($results);
		         if (mysqli_num_rows($results) == 1)
					 {
							  $_SESSION['email'] = $row['email'];
				mysqli_query($db,"UPDATE `users` SET `code`='$rand' WHERE email='$email'");
				    header('location: verify.php');
					}
	}

//--------------------------------------------------------------------
//change email
		if (isset($_POST['chmail'])) {
		$email1=$_SESSION['email'];
		$email= mysqli_real_escape_string($db,$_POST['email']);
		if (mysqli_num_rows(mysqli_query($db,"SELECT * FROM users WHERE email='$email'")) == 1){array_push($errors, "Email is already in Use");}
		if (empty($email)) {
			array_push($errors, "Email is required");
		}
		if (count($errors) == 0) {		
				     mysqli_query($db,"UPDATE `users` SET `email`='$email' WHERE email='$email1'");
				        $_SESSION['email'] = $email;				
				        header('location: verify.php');
		}
	}
	
//===========================================================================
// Change password
		if (isset($_POST['chpass'])) {
		$email= $_SESSION['email'];
		$password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
		$password_2 = mysqli_real_escape_string($db, $_POST['password_2']);
		$password_3 = mysqli_real_escape_string($db, $_POST['password_3']);
		// form validation: ensure that the form is correctly filled
		if (empty($password_1)) { array_push($errors, "Current Password is required"); }
        if (empty($password_2)) { array_push($errors, "New Password is required"); }
		if ($password_2 != $password_3) {array_push($errors, "The two passwords didn't matched");}
		if (count($errors) == 0) {	
		         if (mysqli_num_rows(mysqli_query($db,"SELECT * FROM users WHERE `email`='$email' AND `password`='$password_1'")) == 1)
					 {	
					 	mysqli_query($db,"UPDATE `users` SET `password`='$password_2'WHERE `email`='$email' AND `password`='$password_1'");
					 	$_SESSION['success']="Password is succesfully Changed";
                 header('location:index.php');
			       	}
	     else{
	     	array_push($errors, "Current Password is Wrong"); 
	     }
}
else
$_SESSION['success']="";
}

//=============================================================================
	//forgot password
		if (isset($_POST['forgotpass'])) {
		$email=mysqli_real_escape_string($db, $_POST['email']);  
		if (empty($email)) { array_push($errors, "Email is required"); }
		elseif (mysqli_num_rows(mysqli_query($db,"SELECT * FROM users WHERE email='$email'")) == 0){array_push($errors, "Email NOT FOUND ");}	
	if (count($errors) == 0) {	
		mysqli_query($db,"UPDATE `users` SET `verify1`='0' WHERE email='$email'");
		 $rand=rand(999,9999);
             $from='@noreplay';
             $sub="ACCOUNT VERIFICATION";
             $meg="Your CODE IS :".$rand;
           mail($email,$from,$sub,$meg);	
			$query = "SELECT * FROM users WHERE email='$email'";
				$results = mysqli_query($db,$query);
				$row = mysqli_fetch_array($results);
		         if (mysqli_num_rows($results) == 1)
					 {
				        $_SESSION['email'] = $row['email'];				
				mysqli_query($db,"UPDATE `users` SET `verify1`='0',`code`='$rand' WHERE email='$email'");
				    header('location: verify1.php');
					
					 }
				}
	}
//---------------------------------------------------------------
	if (isset($_POST['verify1'])) {
		$email=$_SESSION['email'];
		$code=$_POST['code'];
		if (empty($code)) {
			array_push($errors, "CODE is required");
		}
		if (count($errors) == 0) {
			$query = "SELECT * FROM `users` WHERE email='$email'AND code='$code'";
				$results = mysqli_query($db,$query);
				$row = mysqli_fetch_array($results);
		         if (mysqli_num_rows($results) == 1)
				 {			
				mysqli_query($db,"UPDATE `users` SET `verify1`='1' WHERE `email`='$email'");
				 $_SESSION['email'] = $row['email'];
				
				  header('location: index.php');
			}else {
				array_push($errors, "You Enterd Wrong Code");
			}
		}
	}
	
if (isset($_POST['resend1'])) {
		$email=$_SESSION['email'];
		$_SESSION['verify1']=1;        
		 $rand=rand(999,9999);
             $from='@noreplay';
             $sub="ACCOUNT VERIFICATION";
             $meg="Your CODE IS :".$rand;
       //mail($email,$from,$sub,$meg);	
			$query = "SELECT * FROM `users` WHERE email='$email'";
				$results = mysqli_query($db,$query);
				$row = mysqli_fetch_array($results);
		         if (mysqli_num_rows($results) == 1)
					 {
				  $_SESSION['email'] = $row['email'];				
				mysqli_query($db,"UPDATE `users` SET `code`='$rand' WHERE email='$email'");
				    header('location: verify1.php');
					}
	}

	//-----------------------------------------------------------------------------------------------------
	
	
	//  Forgot change password
		if (isset($_POST['chpass1'])) {
		$email= $_SESSION['email'];
		$password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
		$password_2 = mysqli_real_escape_string($db, $_POST['password_2']);
		// form validation: ensure that the form is correctly filled
		if (empty($password_1)) { array_push($errors, "NEW Password is required"); }
		if ($password_2 != $password_1) {array_push($errors, "The two passwords didn't matched");	}
		if (count($errors) == 0) {	
		         if (mysqli_num_rows(mysqli_query($db,"SELECT * FROM users WHERE `email`='$email'")) == 1)
					 {	
				 $_SESSION['nchp']=0;
				 mysqli_query($db,"UPDATE `users` SET `password`='$password_1'WHERE `email`='$email' ");
                 header('location: login.php');
			       	}
}}

/*------------------vote--------------------------------*/
if (isset($_POST['vote'])) {
		$email=$_SESSION['email'];
		$name=$_SESSION['name'];
		$candi= $_POST['candidate'];
		if ($candi=="m") {
			array_push($errors, "Please Select candidate");
		}
		if (count($errors) == 0) {
			$query = "SELECT * FROM `users` WHERE email='$email'AND name='$name'";
				$results = mysqli_query($db,$query);
				$row = mysqli_fetch_array($results);
		         	
					if($row['status'])
					{
						array_push($errors, "Your Already Voted");
					}
					else{
				mysqli_query($db,"UPDATE `users` SET `status`='1' WHERE email='$email'AND name='$name'");
				mysqli_query($db,"UPDATE `candidate` SET `votes`=votes+1 WHERE `candidateid`='$candi'");
				        header('location: vote.php');
					}
}
}



/*------------------ADD NEW CANDIDATE--------------------------------*/
if (isset($_POST['newcandi'])){
		$candi= $_POST['candidatename'];
		$candid= $_POST['candidateid'];
		if (empty($candi)) { array_push($errors, "NAME is required"); }
		if (empty($candid)) { array_push($errors, "ID is required"); }
		//if (mysqli_num_rows(mysqli_query($db,"SELECT * FROM candidate WHERE candidateid='$candid'")) == 1){array_push($errors, "ID is already in Use");}
		if (count($errors) == 0){			
			$query="INSERT INTO `candidate` (`candidateid`,`name`)VALUES('$candid','$candi')";
			mysqli_query($db, $query);
				        header('location: admin.php');
					}
}
/*------------------Delete--------------------------------*/
if (isset($_POST['delete'])) {
		$candi= $_POST['candidate'];
		if ($candi=="m") {
			array_push($errors, "Please Select candidate");
		}
		if (count($errors) == 0) {
				mysqli_query($db,"Delete from `candidate` Where `candidateid`='$candi'");
				        header('location: delete.php');
					}
}
/*-------------------Result-------------------*/
if (isset($_POST['release'])){
	mysqli_query($db,"UPDATE `users` SET `result`='1'");
	header('location:result.php');
}
?>
