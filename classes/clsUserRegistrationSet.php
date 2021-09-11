	<?Php
	include_once("clsUserRegistrationMaster.php");
	class clsUserRegistrationSet
	{ 
		var $Users = array();
		
		function Add($obj)
		{
			$this->Users[] = $obj;
		}
		function GetCount()
		{
			return count($this->Users);
		}
		function GetItem($lIndex)
		{
			$lLastEntry = $this->GetCount();
			if($lIndex < 0 || $lIndex > $lLastEntry-1)
			{
				echo " MyError: Illegal index Passed to clsUserRegistrationSet:GetItem()";
				exit;
			}
			return $this->Users[$lIndex];
		}
		function Remove($lIndex)
		{
			$lLastEntry = $this->GetCount();
			if($lIndex < 0 || $lIndex > $lLastEntry-1)
			{
				echo " MyError: Illegal index Passed to clsUserRegistrationSet:Remove()";
				exit;
			}
			for($i = $lIndex; $i < $lLastEntry; $i++)
			{
				$this->Users[$i] = $this->Users[$i+1];
			}
			array_pop($this->Users);
		}
	}
	?>