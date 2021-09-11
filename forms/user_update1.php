	
	<?php
		include('connection.php');
		include "classes/clsUserRegistrationManager.php";
	?>

	<html>
		<head>
			<style type="text/css">
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
			<form method="POST" name="updateform1" id="updateform1">
				<table border="0" cellpadding="5" cellspacing="0" class="table">
					<tr>
						<th width="6%">SL No</th>
						<th width="7%">User Name</th> 
						<th width="6%">Password</th>
						<th width="4%">Contact No</th>
						<th width="4%">Action</th>
					</tr>
					
					<?php
					$objdls = new clsUserManager();

					if(isset($_POST['uid']))
					{
						$rid = $_POST['uid'];
						$result = $objdls->usrDetailsById($rid);
						if($result)
						{
							while($data = mysql_fetch_array($result))
							{
								$rowid = $data['id'];
							?>	<tr>
									<td><input type="hidden" name="hidID" id="hidID" value="" /> <?php echo $rowid;?></td>
									<td><input type="text" name="txtname" id="txtname" value="<?php echo $data['username'];?>" /></td>
									<td><input type="text" name="txtpwd" id="txtpwd" value="<?php echo $data['password'];?>" /></td>
									<td><input type="text" name="txtmob" id="txtmob" value="<?php echo $data['mobileno'];?>" maxlength="10" /></td>
									<td width="11%">
										<input type="button" value="Update" class="btn"
												onclick="update('<?php echo $rowid;?>')" />
												
										<input type="button" value="Cancel" class="btn" onclick="Cancel()" />
									</td>
								</tr>
							<?php
							}
						}
					}
					?>
				</table>
				
				<input type="hidden" name="hidvalue" id="hidvalue" value="" />
			</form>
		</body>
		
		<script>
			function Cancel()
			{
				window.location.href='userupdate.php';
			}
		</script>
	</html>