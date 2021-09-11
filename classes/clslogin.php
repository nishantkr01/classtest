	<?Php 
		class clsLogin
		{
			var $userID;
			var $userName;
			var $userPassword;
			var $IsActive;
			
			function setUserID($Data)
			{
				return $this->userID = $Data;
			}
			function getUserID()
			{
				return $this->userID;
			}
			
			function getUserName()
			{
				return $this->userName;
			}
			function setUserName($Data)
			{
				return $this->userName = $Data;
			}
			
			function getUserPassword()
			{
				return $this->userPassword;
			}
			function setUserPassword($Data)
			{
				return $this->userPassword = $Data;
			}

			function getIsActive()
			{
				return $this->IsActive;
			}
			function setIsActive($Data)
			{
				return $this->IsActive = $Data;
			}
		}
	?>