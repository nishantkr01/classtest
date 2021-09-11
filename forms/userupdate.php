	
	<?php
		include('connection.php');
		include "classes/clsUserRegistrationManager.php";
		$objUser = new clsUserManager();

		if($REQUEST_METHOD == "POST")
		{
			$rowid = $_POST['hidID'];
			$name = $_POST['txtname'];
			$pwd = $_POST['txtpwd'];
			$mob = $_POST['txtmob'];

			$hidval = $_POST['hidvalue'];
			
			if($hidval==2)
			{
				$updated = $objUser->usrUpdate($rowid,$name,$pwd,$mob);
				if($updated)
				{
					echo "<script>alert('Data updated successfully')</script>";
				}
				else
				{
					echo "<script>alert('Data not updated. Try again !!')</script>";
				}
			}
			
			if($hidval==3)
			{
				$deleted = $objUser->userDelete($rowid);
				if($deleted)
				{
					echo "<script>alert('Data deleted successfully')</script>";
				} 
			}
		}
	?>

	<html>
		<head>
			<style type="text/css">
				h3
				{
					text-align:center;
					font-family:Arial;
					color:#fff;
					font-size:13px;
					background-color:#aaa;
					padding:5px;
					width:49%;
					word-spacing:80px;
				}
				a
				{
					text-decoration:none;
					color:#dedede;
				}
				
				.table
				{
					width:50%;
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
					border:none;
				}
				td
				{
					border:1px solid #ccc;
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
					word-spacing:80px;
				}
				.btn:hover
				{
					color:#0cc;
					font-weight:bold;
					text-decoration:underline;
				}
			</style>
		</head>
		
		<body>
			<h3><a href="registration.php">Back</a>   <a href="userupdate.php">Refresh</a>  <a href="index.php">Logout</a></h3>
			
			<form method="POST" name="updateform" id="updateform">
				<table border="0" cellpadding="5" cellspacing="0" class="table">
					<tr>
						<th width="4%">SL No</th>
						<th width="7%">User Name</th> 
						<th width="6%">Password</th>
						<th width="4%">Contact No</th>
						<th width="4%">Action</th>
					</tr>
					
					<?php					
					$objdls = new clsUserManager();
					$result = $objdls->userDetails();
					if($result)
					{
						$i = 1;
						while($data = mysql_fetch_array($result))
						{
							$rowid = $data['id'];
						?>	<tr>
								<td><?php echo $i;?></td>
								<td><?php echo $data['username'];?></td>
								<td><?php echo $data['password'];?></td>
								<td><?php echo $data['mobileno'];?></td>
								<td width="11%">
									<!--<input type="button" value="Edit" class="btn"
											onclick="dataUpdate('<?php //echo $rowid;?>','<?php //echo $data['username'];?>','<?php //echo $data['password'];?>','<?php //echo $data['mobileno'];?>')" />-->
										
									<input type="button" value="Edit" class="btn" onclick="dataUpdate('<?php echo $rowid;?>')" />	
									<input type="button" value="Delete" class="btn" onclick="RowDelete('<?php echo $rowid;?>')" />
								</td>
							</tr>
						<?php
						$i++;
						}
					}
					?>
				</table>
				<input type="hidden" name="hidID" id="hidID" value="" />
				<input type="hidden" name="hidvalue" id="hidvalue" value="" />
			</form>
		</body>
		
		<script type="text/javascript" src="jquery.min.js"></script> 
		<script>
			function dataUpdate(id)
			{
				$.ajax(
				{
					type: "POST",
					url: "user_update1.php",
					data: {uid:id},
					success: function(res)
					{
						$('#updateform').html(res);						
					}
				});
			}
			
			function update(id)
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
						window.document.updateform1.txtmob.focus();
						return;
					}
					else
					{
						document.getElementById('hidID').value=id;
						var val = document.getElementById('hidvalue').value=2;
						if(val==2)
						{
							var ok = confirm('Confirm to update record');
							if(ok)
							{
								document.getElementById('updateform1').submit();
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
		</script>
	</html>