 <?
class DBAccess extends config {
      var $DBlink;

      var $Result;

      var $LastMsg;

	  //var $DBname='niit-hamid';
      function connectToDB()
      {

          $this->DBlink = mysqli_connect( $this->db_host, $this->db_user, $this->db_pass,$this->db_name ,'3306');

          if (!$this->DBlink)

            die("Could not connect to mysql");
			
			mysqli_set_charset($this->DBlink,'utf8');
            
			mysqli_select_db( $this->DBlink,$this->db_name)
			
            or die( "Couldn't connect to database : ".mysql_error() );

      }





      //function to check the prexistance of a field

      function GetRecord($table, $fnm, $fval)

      {

          $this->Result = mysqli_query ($this->DBlink , "SELECT * FROM $table WHERE $fnm='$fval'");

          if ( ! $this->Result )

          die( "getRow fatal error: ".mysql_error() );

          return mysqli_fetch_array( $this->Result );

      }



      //function to check username and password

      function CheckUser($table, $fnm, $fval, $fnm1, $fval1)

      {

           $this->Result =mysqli_query ($this->DBlink , "SELECT * FROM $table WHERE $fnm='$fval'&&$fnm1='$fval1'" );

           if ( ! $this->Result )

           		return false;

           return mysqli_num_rows( $this->Result );

		

      }

	  

	  //returns number of records a query will generate

	  function RecordsInQuery($query)

		{

			$this->Result =mysqli_query ($this->DBlink, $query  );

			   if ( ! $this->Result )

					return false;

			   return mysqli_num_rows( $this->Result );

		}



      //getting total no of a particular record

      function GetNumberOfRecords($table, $fnm, $fval)

      {

           $this->Result =mysqli_query ($this->DBlink, "SELECT * FROM $table WHERE $fnm='$fval'"   );

           if ( ! $this->Result )

           		return false;

           return mysqli_num_rows( $this->Result );



	}

	

	   //getting total no of a particular record

	   function OverloadsGetNumberOfRecord($table, $fnm, $fval,$fnm1, $fval1)

	       {

	    $this->Result =mysqli_query ($this->DBlink, "SELECT * FROM $table WHERE $fnm='$fval'&&$fnm1='$fval1'"   );

	    if ( ! $this->Result )

	       die( "getRow fatal error: ".mysql_error() );

	    return mysqli_num_rows( $this->Result );

	

	}

	

	//function to get the manximum of all

	function GetRecordByCriteria($table, $fnm, $fval, $required)

	{

	    $this->Result =mysqli_query ($this->DBlink , "SELECT $required FROM $table WHERE $fnm='$fval'" );

	    if ( ! $this->Result )

	        return false;

	

	    while($row= mysqli_fetch_array( $this->Result )){

	        $back = $row["$required"];

	    }

	    return $back;

	}

	

	//function to get the manximum of all

	function OverloadsGetRecordByCriteria($table, $required)

	{

	    $this->Result =mysqli_query ($this->DBlink ,"SELECT $required FROM $table " );

	    if ( ! $this->Result )

	        return false;

	

	    while($row= mysqli_fetch_array( $this->Result )){

	        $back = $row["$required"];

	    }

	    return $back;

	}

	

	

	//function to insert data into the table

	function InsertRecord($table, $insert, $vals, $show=0 )

	{
		//echo " INSERT INTO $table ($insert)  VALUES ($vals)";
	    if (!$this->Result =mysqli_query( $this->DBlink," INSERT INTO $table ($insert)

	            VALUES ($vals)") ) die (mysqli_error($this->DBlink))  ;

	            return mysqli_insert_id( $this->DBlink);

				return true;

	

	}

	

	

	//function to retrieve a single field

	function GetSingleField($table, $fnm, $fval, $required)

	{

	    $this->Result =mysqli_query ( $this->DBlink, "SELECT * FROM $table WHERE $fnm='$fval'" );

	    if ( ! $this->Result )

	       return false;

	    while($row= mysqli_fetch_array( $this->Result )){

	        $back = $row["$required"];

	    }

	    return $back;

	}

	

	function OverloadsGetSingleField($table, $fnm, $fval, $fnm1, $fval1, $required)

	{

	    $this->Result =mysqli_query ($this->DBlink, "SELECT * FROM $table WHERE $fnm='$fval' && $fnm1='$fval1'"  );

	    if ( ! $this->Result )

	       return false;

	    while($row= mysqli_fetch_array( $this->Result )){

	        $back = $row["$required"];

	    }

	    return $back;

	

	}

	

	//function to get an array of something

	function ArrayOfSingleField($table, $fnm, $fval, $required)

	{

	    $this->Result =mysqli_query ($this->DBlink,  "SELECT * FROM $table WHERE $fnm='$fval'"  );

	    if ( ! $this->Result )

	       return false;

	    while($row= mysqli_fetch_array( $this->Result )){

	        $RecArray[] = $row["$required"];

	    }

	    return $RecArray;

	

	}

	

	

	//function to modify an existing record

	function ModifyRecord($table, $fnm, $fval, $fnm1, $fval1)

	{

	  echo   $query="UPDATE $table set $fnm1='$fval1' WHERE $fnm='$fval'";

		$this->Result =mysqli_query($this->DBlink,$query) ;

	    if (! $this->Result)

	       return false; 

	

	    return true;

	

	}

	

	//function to modify fields by passing query

	function CustomModify($Cquery)

	{

		$query=$Cquery;

	    $this->Result =mysqli_query($this->DBlink,$query) ;

	    if (! $this->Result)

	       return false;

		 else return true;	

	}

	

	//function to modify fields by passing query

	function CustomModifynew($Cquery)

	{

		$query=$Cquery;

	    $this->Result =mysqli_query($this->DBlink,$query) ;

	    if (! $this->Result)

	       return false;

		 else return true;	

	}

	

	//fucntion to modify existing field with two where parammeters

	function OverloadsModifyRecord($table, $fnm, $fval, $fnm0, $fval0, $fnm1, $fval1)

	{

	    $query="UPDATE $table set $fnm1='$fval1' WHERE $fnm='$fval'&&$fnm0='$fval0'";

	    $this->Result =mysqli_query($this->DBlink,$query);

	    if (! $this->Result)

	       return false;

	    else  return true;

	

	}

	

	//function to delete a whole record

	function DeleteSingleRecord($table, $frn, $fval, $frn1, $fval1)

	{

	    $query="DELETE FROM $table WHERE $frn='$fval' && $frn1='$fval1'";

	    $this->Result =mysqli_query($this->DBlink,$query);

	    if (! $this->Result)

	       return false;

	       

	     return true;

	

	}

	

	//delete function

	//function to delete a whole record

	function DeleteSetOfRecords($table, $frn, $fval)

	{
		
  	  $query="DELETE FROM $table WHERE $frn='$fval'";
	  		
	  $this->Result =mysqli_query($this->DBlink,$query) ;
	    if (! $this->Result)

	       return false;

	     return true;

	}

	

	//function to delete all records

	function DeleteAllRecords($table)

	{

	    $query="DELETE FROM $table ";

	    $this->Result =mysqli_query($this->DBlink,$query);

	    if (! $this->Result)

	       return false;

	       

	     return true;

	

	}

	

	function CustomQuery($Query_C)

	{

	    $Return_Result[]=NULL;

	    $Count=0;

	    $Query = "$Query_C";
		//print_r( $Query); die();

		$Show_Query_Reuslt =mysqli_query($this->DBlink,$Query);
		//print_r($Query); //die();
		if(mysqli_num_rows($Show_Query_Reuslt)>0){
			
	    $Query_Result_Final = mysqli_fetch_assoc($Show_Query_Reuslt);

	    if(sizeof($Query_Result_Final)==1 && $Query_Result_Final==null){
			return null;}
	    do{

	        $Return_Result[$Count]=$Query_Result_Final;

	        $Count++;

	    }while($Query_Result_Final=mysqli_fetch_assoc($Show_Query_Reuslt));    

	    return $Return_Result;

	

	}
	}

	

	//funtion to free and close sql result and connection

	function DBDisconnect()

	{

		if($this->Result)

			//mysql_free_result($this->Result);

	

	    mysql_close($this->DBlink);

	

	}

	

	//function to report bug incase of database errors

	function ReportBug($line,$file,$error)

	{

		return true;

	}/////
	
	function DeleteAllRecordsNew($table, $where)

	{

	    $query="DELETE FROM $table ".$where;

	    $this->Result =mysqli_query($this->DBlink,$query);

	    if (! $this->Result)

	       return false;

	       

	     return true;

	

	}


}

?>