	<?Php
		include_once("clsLoginSet.php");
		class clsLoginManager
		{
			function RetrieveUserLogin($Query)
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
			}
		}
	?>