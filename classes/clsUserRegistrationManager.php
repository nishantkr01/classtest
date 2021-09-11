	<?Php
		include_once("clsUserRegistrationSet.php");
		
		class clsUserRegistrationManager
		{
			function SaveUser($ObjUserRegistrationMaster, $myConn=null)
			{
				$UserName = $ObjUserRegistrationMaster->getName();
				$Password = $ObjUserRegistrationMaster->getPassword();
				$ContactNo = $ObjUserRegistrationMaster->getContactNo();
				$IsActive = $ObjUserRegistrationMaster->getIsActive();
				
				if($UserName==null)
					$UserName='null';
				else
					$UserName="'$UserName'";

				if($Password==null)
					$Password='null';
				else
					$Password="'$Password'";

				if($ContactNo==null)
					$ContactNo='';
				else
					$ContactNo="'$ContactNo'";

				if($IsActive == null)
					$IsActive = '0';
				else
					$IsActive = "'$IsActive'";
				
				$sQuery = "insert into userdetails(name,password,contactno,isactive) values ($UserName,$Password,$ContactNo,$IsActive)";
				
				if(is_resource($myConn) and get_resource_type($myConn)== 'pgsql link')
				{
					$rsltSUser = pg_exec($myConn,$sQuery) or die ("Couldn't execute query in clsUserRegistrationManager:SaveUser");
					$lNumTuples = pg_cmdtuples($rsltSUser);
				}
				else
				{
					@pg_close();
					include("../dbconnect.php");
					$rsltSUser = pg_exec($connection,$sQuery) or die ("Couldn't execute query in clsUserRegistrationManager:SaveUser");
					$lNumTuples = pg_cmdtuples($rsltSUser);
					pg_close();
				}
				return $lNumTuples;
			}
			
			function RetrieveUserSet($sQuery)
			{
				include("../dbconnect.php");

				$clsUserRegistrationSet = new clsUserRegistrationSet();
				
				$rsltAllSUser = pg_exec($connection,$sQuery) or die ("Couldn't execute query in clsUserRegistrationManager:RetrieveUserSet.");
				$lNumRows = pg_numrows($rsltAllSUser);
				if($lNumRows == 0)
				{
					pg_close();
					return $clsUserRegistrationSet;
				}
				for($lCount = 0; $lCount < $lNumRows; $lCount++)
				{
					$ObjclsUserRegistrationMaster = new clsUserRegistrationMaster();
					$arrAllSUser = pg_fetch_array($rsltAllSUser,$lCount);
					
					$ObjclsUserRegistrationMaster->setUserID($arrAllSUser[id]);
					$ObjclsUserRegistrationMaster->setName($arrAllSUser[name]);
					$ObjclsUserRegistrationMaster->setPassword($arrAllSUser[password]);
					$ObjclsUserRegistrationMaster->setContactNo($arrAllSUser[contactno]);
					$ObjclsUserRegistrationMaster->setIsActive($arrAllSUser[isactive]);
					
					$clsUserRegistrationSet->Add($ObjclsUserRegistrationMaster);
				}
				pg_close();
				return $clsUserRegistrationSet;
			}

			/* function RetrieveUserLogin($Query)
			{
				include("dbconnect.php");

				$objclsLogin = new clsLogin();
				$objclsLoginSet = new clsLoginSet();
				
				$rsltUser = pg_exec($connection,$Query) or die ("Couldn't execute query in clsLoginManager:RetrieveUserLogin.");
				$lNumRows = pg_numrows($rsltUser);
				
				if($lNumRows == 0)
				{
					pg_close();
					return $objclsLoginSet;
				}
				
				for($lCount = 0; $lCount < $lNumRows; $lCount++)
				{
					$arrUser = pg_fetch_array($rsltUser,$lCount);
					
					$objclsLogin->setUserID($arrUser[id]);
					$objclsLogin->setUserName($arrUser[username]);
					$objclsLogin->setUserPassword($arrUser[password]);
					$objclsLogin->setIsActive($arrUser[isactive]);
					
					$objclsLoginSet->Add($objclsLogin);
				}
				pg_close();
				return $objclsLoginSet;
			} */
			
			function UpdateUserDetails($ObjUserRegistrationMaster, $myConn=null)
			{
				$UserID = $ObjUserRegistrationMaster->getUserID();
				$UserName = $ObjUserRegistrationMaster->getName();
				$Password = $ObjUserRegistrationMaster->getPassword();
				$ContactNo = $ObjUserRegistrationMaster->getContactNo();
				$IsActive = $ObjUserRegistrationMaster->getIsActive();
				
				$sQuery = "update userdetails set name='$UserName',password='$Password',contactno=$ContactNo,isactive='$IsActive' where id=$UserID";
			
				if(is_resource($myConn) and get_resource_type($myConn)== 'pgsql link')
				{
					$Result = pg_exec($myConn,$sQuery) or die ("Couldn't execute query in clsUserRegistrationManager:UpdateUserDetails");
					$lNumTuples = pg_cmdtuples($Result);
				}
				else
				{
					include("../dbconnect.php");
					$Result = pg_exec($connection,$sQuery) or die ("Couldn't execute query in clsUserRegistrationManager:UpdateUserDetails");
					$lNumTuples = pg_cmdtuples($Result);
					pg_close();
				}
				return $lNumTuples;
			}
			
			function DeleteUser($ObjUserRegistrationMaster, $myConn=null)
			{
				$UserID = $ObjUserRegistrationMaster->getUserID();

				if($UserID==null)
					$UserID='null';
				
				$sQuery = "delete from userdetails where id=$UserID";
				
				if(is_resource($myConn) and get_resource_type($myConn)== 'pgsql link')
				{
					$rsltUser = pg_exec($myConn,$sQuery) or die ("Couldn't execute query in clsUserRegistrationManager:DeleteUser");
					$lNumTuples = pg_cmdtuples($rsltUser);
				}
				else
				{
					@pg_close();
					include("../dbconnect.php");
					$rsltUser = pg_exec($connection,$sQuery) or die ("Couldn't execute query in clsUserRegistrationManager:DeleteUser");
					$lNumTuples = pg_cmdtuples($rsltUser);
					pg_close();
				}
				return $lNumTuples;
			}
		}
	?>