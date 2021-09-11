<?php
session_start();

	$User = $_SESSION['user_name'];
	include("../dbconnect.php");
	$succ = '';
	$error = '';

	if($REQUEST_METHOD == "POST")
	{
		$name = $_POST['txtname'];
		$pwd = $_POST['txtpwd'];
		$mob = $_POST['txtmob'];
		$IsActive = $_POST['isactive'];
		$hiddenValue = $_POST['hidvalue'];
		
		if($hiddenValue==1)
		{
			include "../classes/clsUserRegistrationManager.php";
			
			$ObjUserRegistrationMaster = new clsUserRegistrationMaster();
			$ObjUserRegistrationManager = new clsUserRegistrationManager();
			
			$ObjUserRegistrationMaster->setName($name);
			$ObjUserRegistrationMaster->setPassword($pwd);
			$ObjUserRegistrationMaster->setContactNo($mob);
			$ObjUserRegistrationMaster->setIsActive($IsActive);
			
			$success = $ObjUserRegistrationManager->SaveUser($ObjUserRegistrationMaster,$connection);
			if($success)
			{
				$succ = "Registration Successfull.";
			}
			else
			{
				$error = "Registration not Success. Try Again !!";
			}
		}
	}
?>

	<html>
		<style type="text/css">
			.loginform
			{
				height:220px;
				width:180px;
				background-color:#eee;
				padding:10px;
				margin:20px auto;
				border:1px solid #aaa;
				font-family:Arial;
				font-size:0.8em;
			}
			.msg
			{
				color:#ff0000;
				font-size:12px;
				font-family:Arial;
			}
			h3
			{
				text-align:center;
				font-family:Arial;
				color:#fff;
				font-size:13px;
				background-color:#aaa;
				padding:5px;
				width:50%;
				margin:20px auto;
			}
		</style>
		<body>
			<h4>Welcome <span style="color:red"><?php echo ucfirst($User);?></span></h4>
			<h3>User Registration</h3>
			
			<form class="loginform" method="POST" name="userform" id="userform" action="">
			
				<span class="msg" style="color:green"><?php echo $succ; ?></span>
				<span class="msg"><?php echo $error; ?></span>
			
				<span id="errmsg" class="msg"></span>
				
				<p>
					Name:</br>
					<input type="text" name="txtname" id="txtname"  />
				</p>
				
				<p>
					Password:</br>
					<input type="password" name="txtpwd" id="txtpwd"  />
				</p>
				
				<p>
					Mob:</br>
					<input type="text" name="txtmob" id="txtmob" maxlength="10" />
				</p>
				
				<input type="hidden" name="hidvalue" id="hidvalue" value="" />
				<input type="hidden" name="isactive" id="isactive" value="1" />
				<p>
					<input type="button" name="sv" value="Save Data" onclick="validateForm()" />
					<input type="button" name="rld" value="Refresh" onclick="refresh()" />
				</p>
				<h5 align="right"><a href="welcome.php" style="color:green">Details</span></h5>
			</form>
		</body>
		
		<script>
			function validateForm()
			{
				var name = document.getElementById('txtname').value;
				var password = document.getElementById('txtpwd').value;
				var mobile = document.getElementById('txtmob').value;
				
				if(name=="")
				{
					document.getElementById('errmsg').innerHTML='User name is empty.';
					window.document.userform.txtname.focus();
					return;
				}
				
				if(password=="")
				{
					document.getElementById('errmsg').innerHTML='Password is empty.';
					window.document.userform.txtpwd.focus();
					return;
				}
				
				if(mobile=="")
				{
					document.getElementById('errmsg').innerHTML='Mobile no is empty.';
					window.document.userform.txtmob.focus();
					return;
				}
				if(mobile.length < 10)
				{
					document.getElementById('errmsg').innerHTML='Mobile no must be 10 digit.';
					window.document.userform.txtmob.focus();
					return;
				}
				if(isNaN(mobile))
				{
					document.getElementById('errmsg').innerHTML='Mobile number must be number.';
					window.document.userform.txtmob.focus();
					return;
				}
				
				var val = document.getElementById('hidvalue').value=1;	
				
				if(val==1)
				{
					document.getElementById('userform').submit();
				}
			}
			function refresh()
			{
				window.location.href='registration.php';
			}
		</script>
	</html>