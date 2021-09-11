	<?Php 
		class clsUserRegistrationMaster
		{
			var $userID;
			var $Name;
			var $Password;
			var $contactNo;
			var $IsActive;
			
			function setUserID($Data)
			{
				return $this->userID = $Data;
			}
			function getUserID()
			{
				return $this->userID;
			}
			
			function getName()
			{
				return $this->userName;
			}
			function setName($Data)
			{
				return $this->userName = $Data;
			}
			
			function getPassword()
			{
				return $this->userPassword;
			}
			function setPassword($Data)
			{
				return $this->userPassword = $Data;
			}
			
			
			function getContactNo()
			{
				return $this->contactNo;
			}
			function setContactNo($Data)
			{
				return $this->contactNo = $Data;
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