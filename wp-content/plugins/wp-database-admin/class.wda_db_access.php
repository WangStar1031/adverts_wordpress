<?php
	class wdaDatabaseAccess
	{
		private $_serverName;
		private $_userName;
		private $_databaseName;
		private $_password;
		
		public function wdaDatabaseAccess($Sname,$Uname,$Pass,$DBname)
		{
			$this->_serverName=$Sname;
			$this->_userName=$Uname;
			$this->_password=$Pass;
			$this->_databaseName=$DBname;
		}
		
		public function ExecuteNoneQuery($query)
		{
			$con=mysql_connect($this->_serverName,$this->_userName,$this->_password)
			or 
			die(mysql_error()."<br>");
			
			mysql_select_db($this->_databaseName,$con)
			or 
			die(mysql_error()."<br>");
			
			mysql_query($query,$con)
			or
			//die(mysql_error()."<br>");
			$error = mysql_error()."<br>";
			if(isset($error)){ return $error; }
			$affectedRow=mysql_affected_rows();
			
			mysql_close($con)
			or
			die(mysql_error()."<br>");
			
			return $affectedRow;
		}
		public function ExecuteQuery($query)
		{
			$con=mysql_connect($this->_serverName,$this->_userName,$this->_password)
			or 
			die(mysql_error()."<br>");

			mysql_select_db($this->_databaseName,$con)
			or 
			die(mysql_error()."<br>");

			$resultSet=mysql_query($query,$con)
			or 
			//die(mysql_error()."<br>");
			$error = mysql_error()."<br>";
			if(isset($error)){ return $error; }
			
			mysql_close($con)
			or
			die(mysql_error()."<br>");
			
			return $resultSet;
		}
	
		public function FillDropDown( $query ,$Selected=false)
		{
		
		
			$con=mysql_connect($this->_serverName,$this->_userName,$this->_password)
			or 
			die(mysql_error()."<br>");
			
			mysql_select_db($this->_databaseName,$con)
			or 
			die(mysql_error()."<br>");
			
			$resultSet=mysql_query($query,$con)
			or 
			die(mysql_error()."<br>");
			
			
			if($resultSet)
			{
				while($row=mysql_fetch_row($resultSet))
				{
					if($row[0]==$Selected && $Selected!=false)
					{
						echo '<option value='.$row[0].' selected>'.$row[1].'</option>';
					}
					else
					{
						echo '<option value='.$row[0].'>'.$row[1].'</option>';	
					}
				}
			}
			
			mysql_close($con)
			or
			die(mysql_error()."<br>");
			return true;

		}
	
		function DisplayTable($ResultSet)
		{
			if(gettype($ResultSet)=="resource")
			{
				$No=mysql_num_fields($ResultSet)
				or
				die(mysql_error()."<br>");
				echo "<table border='1' cellspacing='0'  bordercolor='#222' class='table-list' >";
				echo "<tr class='header'>";
				for($i=0;$i<$No;$i++)
				{
					$FieldName=mysql_field_name($ResultSet,$i)
					or
					die(mysql_error()."<br>");
					echo "<th><label>".$FieldName."</label></th>";
				}
				echo "</tr>";
				while($row=mysql_fetch_row($ResultSet))
				{
					echo "<tr>";
					for($i=0;$i<$No;$i++)
					{
						 echo "<td> <label>".$row[$i]."</label></td>";
					}
					echo "</tr>";
				}
				echo "</table>";
				return true;
			}
			else
			{
				return false;
			}
	}
	
}
?>
