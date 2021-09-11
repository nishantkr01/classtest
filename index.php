<?php
session_start();

	if($REQUEST_METHOD == "POST")
	{
		$chk = true;
		if($chk)
		{
			include('classes/clsLoginManager.php');

			$username = trim($_POST['txtname']);
			$userpassword = trim($_POST['txtpwd']);

			$Query = "select * from userlogin where username='$username' and password='$userpassword' and isactive='t'";
			
			$objclsLoginSet = new clsLoginSet();
			$objclsLoginManager = new clsLoginManager();
			
			$objclsLoginSet = $objclsLoginManager->RetrieveUserLogin($Query);
			$count = $objclsLoginSet->GetCount();
			
			if($count>0)
			{
				for($i=0; $i<$count; $i++)
				{
					$ObjLogin = new clsLogin();
					$ObjLogin = $objclsLoginSet->GetItem($i);
					
					$UserID = $ObjLogin->getUserID();
					$userName = $ObjLogin->getUserName();
					$isActive = $ObjLogin->getIsActive();
				}
				
				if($isActive==TRUE)
				{
					$_SESSION['user_name'] = $userName ;
					echo "<script>window.location='forms/registration.php'</Script>";
				}
			}
			else
			{
				echo "<script>alert('User Name or Password is Wrong.')</Script>";
				echo "<script>window.location='index.php'</Script>";
			}
		}
	}
?>

	<html>
		<head>
			<style type="text/css">
				.loginform
				{
					height:155px;
					width:180px;
					background-color:#eee;
					padding:15px;
					margin:200px auto;
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
			</style>
		</head>
		<body>
			<fieldset class="loginform">
				<legend>User Login</legend>
				<form method="POST" name="userform" id="userform" action="">
					<span class="msg" id="errmsg"></span>
					<span class="msg"><?php echo $err; ?></span>
					
					<p>User Name * <input type="text" name="txtname" id="txtname"  /></p>
					<p>Password *<input type="password" name="txtpwd" id="txtpwd"  /></p>
					
					<input type="hidden" name="hidvalue" id="hidvalue" value="" />
					<p><input type="button" name="lgn" value="Login" onclick="validateForm()"/></p>
				</form>
			</fieldset>
		</body>
		
		<script>
			function validateForm()
			{
				var name = document.getElementById('txtname').value;
				var password = document.getElementById('txtpwd').value;
				
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
				
				var val = document.getElementById('hidvalue').value=1;	
				
				if(val==1)
				{
					document.getElementById('userform').submit();
				}
			}
		</script>
	</html>