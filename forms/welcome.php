<?php
session_start();

	$User = $_SESSION['user_name'];
	include("../dbconnect.php");
	include "../classes/clsUserRegistrationManager.php";
	
	if($REQUEST_METHOD == "POST")
	{
		$name = $_POST['txtname'];
		$pwd = $_POST['txtpwd'];
		$mob = $_POST['txtmob'];
		$IsActive = $_POST['rdStatus'];
		
		$UserID = $_POST['hidID'];
		$hiddenValue = $_POST['hidvalue'];
		
		$ObjUserRegistrationMaster = new clsUserRegistrationMaster();
		$ObjUserRegistrationManager = new clsUserRegistrationManager();
		
		if($hiddenValue==2)
		{
			$ObjUserRegistrationMaster->setUserID($UserID);
			$ObjUserRegistrationMaster->setName($name);
			$ObjUserRegistrationMaster->setPassword($pwd);
			$ObjUserRegistrationMaster->setContactNo($mob);
			$ObjUserRegistrationMaster->setIsActive($IsActive);
			
			//echo "<pre>";
			//print_r($ObjUserRegistrationMaster);
			//exit;
			
			$updated = $ObjUserRegistrationManager->UpdateUserDetails($ObjUserRegistrationMaster,$connection);
			if($updated)
			{
				echo "<script>alert('Data updated successfully')</script>";
			}
			else
			{
				echo "<script>alert('Data not updated. Try again !!')</script>";
			}
		}
		
		if($hiddenValue==3)
		{
			$ObjUserRegistrationMaster->setUserID($UserID);
			$deleted = $ObjUserRegistrationManager->DeleteUser($ObjUserRegistrationMaster,$connection);
	
			if($deleted)
			{
				echo "<script>alert('Record deleted successfully')</script>";
			}
			else
			{
				echo "<script>alert('Data not deleted. Try again !!')</script>";
			}
		}
	}
?>

	<html>
		<head>
			<style type="text/css">
				.form
				{
					background-color:#eee;
					border:1px solid #aaa;
					height:220px;
					width:180px;
					padding:10px;
					margin-left:700px;
					margin-top:20px;
					font-family:Arial;
					font-size:0.8em;
				}
				.btn
				{
					border:none;
					background-color:#fff;
					color:#003399;
					cursor:pointer;
					font-size:13px;
					font-family:Arial;
					float:left;
				}
				.btn:hover
				{
					background-color:#0cc;
					color:#fff;
					border:1px solid #000;
				}
				.table
				{
					width:40%;
					border-collapse:collapse;
					font-family:Arial;
					font-size:13px;
					float:left;
				}
				th
				{
					background-color:green;
					color:#fff;
					font-size:12px;
					height:10px;
				}
			</style>
		</head>
		
		<body>
			<h4>Welcome <span style="color:red"><?php echo ucfirst($User);?></span></h4>
			<h4><a href="registration.php">Back to Home</a> || <a href="../index.php">logout</a> || <a href="welcome.php">Refresh</a></h4>
			
			<table border="1" cellpadding="5" cellspacing="0"  class="table">
				<tr>
					<th width="5%">SL No</th>
					<th width="12%">User Name</th> 
					<th width="9%">Password</th>
					<th width="8%">Contact No</th>
					<th width="8%">Status</th>
					<th width="5%">Action</th>
				</tr>
				<?php
				$Query ="SELECT * FROM userdetails order by id";
			
				$clsUserRegistrationSet = new clsUserRegistrationSet();
				$clsUserRegistrationManager = new clsUserRegistrationManager();
				
				$clsUserRegistrationSet = $clsUserRegistrationManager->RetrieveUserSet($Query);
				$count = $clsUserRegistrationSet->GetCount();
				
				if($count>0)
				{
					for($i=0; $i<$count; $i++)
					{
						$ObjclsUserRegistrationMaster = new clsUserRegistrationMaster();
						$ObjclsUserRegistrationMaster = $clsUserRegistrationSet->GetItem($i);
						
						$UserID = $ObjclsUserRegistrationMaster->getUserID();
						$userName = $ObjclsUserRegistrationMaster->getName();
						$userPassword = $ObjclsUserRegistrationMaster->getPassword();
						$userMobile = $ObjclsUserRegistrationMaster->getContactNo();
						$isActive = $ObjclsUserRegistrationMaster->getIsActive();
						
						if($isActive=='t')
						{
							$status="Active";
						}
						if($isActive=='f')
						{
							$status="InActive";
						}
					?>	
						<tr>
							<td><?php echo $i+1;?></td>
							<td><?php echo $userName;?></td>
							<td><?php echo $userPassword;?></td>
							<td><?php echo $userMobile;?></td>
							<td><?php echo $status;?></td>
							<td width="11%">
								<input type="button" value="Edit" class="btn"
										onclick="dataUpdate('<?php echo $UserID;?>','<?php echo $userName;?>','<?php echo $userPassword;?>','<?php echo $userMobile;?>','<?php echo $isActive;?>')" />
										
								<input type="button" value="Delete" class="btn" onclick="RowDelete('<?php echo $UserID;?>')" />
							</td>
						</tr>
					<?php
					}
				}
				?>
			</table>
			
			<form method="POST" name="updateform" id="updateform" class="form">
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
				
				<p>
					<input type="radio" name="rdStatus" id="rdStatusTrue" value="1">&nbsp;Active &nbsp;&nbsp;&nbsp;
					<input type="radio" name="rdStatus" id="rdStatusFalse" value="0">&nbsp;Inactive
				</p>
				
				<input type="hidden" name="hidID" id="hidID" value="" />
				<input type="hidden" name="hidvalue" id="hidvalue" value="" />
				
				<p>
					<input type="button" name="updt" value="Update" onclick="update()" />
					<input type="button" name="cncl" value="Cancel" onclick="Cancel()" />
				</p>
			</form>
		</body>
		
		<script>
			function dataUpdate(id,name,pwd,mob,status)
			{
				document.getElementById('txtname').value=name;
				document.getElementById('txtpwd').value=pwd;
				document.getElementById('txtmob').value=mob;
				
				if(status=='t')
				{
					document.getElementById('rdStatusTrue').checked=true;
				}
				if(status=='f')
				{
					document.getElementById('rdStatusFalse').checked=true;
				}

				document.getElementById('hidID').value=id;
			}
			
			function update()
			{
				var nm = document.getElementById('txtname').value;
				var pw = document.getElementById('txtpwd').value;
				var mob = document.getElementById('txtmob').value;
				
				if(nm=="" || pw=="" || mob=="")
				{
					alert('Field should not be blank.');
				}
				else
				{
					if(isNaN(mob))
					{
						alert('Mobile number must be number.');
						window.document.updateform.txtmob.focus();
						return;
					}
					else
					{
						var val = document.getElementById('hidvalue').value=2;
					
						if(val==2)
						{
							var ok = confirm('Confirm to update record');
							if(ok)
							{
								document.getElementById('updateform').submit();
							}
						}
					}
				}
			}
			
			function RowDelete(id)
			{
				document.getElementById('hidID').value=id;
				var val = document.getElementById('hidvalue').value=3;
				
				if(val==3)
				{
					var ok = confirm('Confirm to delete record');
					if(ok)
					{
						document.getElementById('updateform').submit();
					}
				}
			}
			
			function Cancel()
			{
				window.location.href='welcome.php';
			}
		</script>
	</html>