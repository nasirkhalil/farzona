<?

//include_once("../config.php");
class DBAccess extends config {
      var $DBlink;

      var $Result;

      var $LastMsg;

	  //var $DBname='niit-hamid';
      function connectToDB()
      {

          $this->DBlink = mysql_connect( $this->db_host, $this->db_user, $this->db_pass );

          if (!$this->DBlink)

            die("Could not connect to mysql");
			
			mysql_set_charset('utf8', $this->DBlink);
            
			mysql_select_db( $this->db_name, $this->DBlink)
			
            or die( "Couldn't connect to database : ".mysql_error() );

      }





      //function to check the prexistance of a field

      function GetRecord($table, $fnm, $fval)

      {

          $this->Result = mysql_query ( "SELECT * FROM $table WHERE $fnm='$fval'" , $this->DBlink );

          if ( ! $this->Result )

          die( "getRow fatal error: ".mysql_error() );

          return mysql_fetch_array( $this->Result );

      }



      //function to check username and password

      function CheckUser($table, $fnm, $fval, $fnm1, $fval1)

      {

           $this->Result = mysql_query ( "SELECT * FROM $table WHERE $fnm='$fval'&&$fnm1='$fval1'" , $this->DBlink );

           if ( ! $this->Result )

           		return false;

           return mysql_num_rows( $this->Result );

		

      }

	  

	  //returns number of records a query will generate

	  function RecordsInQuery($query)

		{

			$this->Result = mysql_query ( $query , $this->DBlink );

			   if ( ! $this->Result )

					return false;

			   return mysql_num_rows( $this->Result );

		}



      //getting total no of a particular record

      function GetNumberOfRecords($table, $fnm, $fval)

      {

           $this->Result = mysql_query ( "SELECT * FROM $table WHERE $fnm='$fval'" , $this->DBlink );

           if ( ! $this->Result )

           		return false;

           return mysql_num_rows( $this->Result );



	}

	

	   //getting total no of a particular record

	   function OverloadsGetNumberOfRecord($table, $fnm, $fval,$fnm1, $fval1)

	       {

	    $this->Result = mysql_query ( "SELECT * FROM $table WHERE $fnm='$fval'&&$fnm1='$fval1'" , $this->DBlink );

	    if ( ! $this->Result )

	       die( "getRow fatal error: ".mysql_error() );

	    return mysql_num_rows( $this->Result );

	

	}

	

	//function to get the manximum of all

	function GetRecordByCriteria($table, $fnm, $fval, $required)

	{

	    $this->Result = mysql_query ( "SELECT $required FROM $table WHERE $fnm='$fval'" , $this->DBlink );

	    if ( ! $this->Result )

	        return false;

	

	    while($row= mysql_fetch_array( $this->Result )){

	        $back = $row["$required"];

	    }

	    return $back;

	}

	

	//function to get the manximum of all

	function OverloadsGetRecordByCriteria($table, $required)

	{

	    $this->Result = mysql_query ("SELECT $required FROM $table " , $this->DBlink );

	    if ( ! $this->Result )

	        return false;

	

	    while($row= mysql_fetch_array( $this->Result )){

	        $back = $row["$required"];

	    }

	    return $back;

	}

	

	

	//function to insert data into the table

	function InsertRecord($table, $insert, $vals, $show=0 )

	{
	    if (!$this->Result = mysql_query( " INSERT INTO $table ($insert)

	            VALUES ($vals)", $this->DBlink) ) die (mysql_error())  ;

	            return mysql_insert_id( $this->DBlink);

				return true;

	

	}

	

	

	//function to retrieve a single field

	function GetSingleField($table, $fnm, $fval, $required)

	{

	    $this->Result = mysql_query ( "SELECT * FROM $table WHERE $fnm='$fval'" , $this->DBlink );

	    if ( ! $this->Result )

	       return false;

	    while($row= mysql_fetch_array( $this->Result )){

	        $back = $row["$required"];

	    }

	    return $back;

	}

	

	function OverloadsGetSingleField($table, $fnm, $fval, $fnm1, $fval1, $required)

	{

	    $this->Result = mysql_query ( "SELECT * FROM $table WHERE $fnm='$fval' && $fnm1='$fval1'" , $this->DBlink );

	    if ( ! $this->Result )

	       return false;

	    while($row= mysql_fetch_array( $this->Result )){

	        $back = $row["$required"];

	    }

	    return $back;

	

	}

	

	//function to get an array of something

	function ArrayOfSingleField($table, $fnm, $fval, $required)

	{

	    $this->Result = mysql_query ( "SELECT * FROM $table WHERE $fnm='$fval'" , $this->DBlink );

	    if ( ! $this->Result )

	       return false;

	    while($row= mysql_fetch_array( $this->Result )){

	        $RecArray[] = $row["$required"];

	    }

	    return $RecArray;

	

	}

	

	

	//function to modify an existing record

	function ModifyRecord($table, $fnm, $fval, $fnm1, $fval1)

	{

	  echo   $query="UPDATE $table set $fnm1='$fval1' WHERE $fnm='$fval'";

		$this->Result = mysql_query($query, $this->DBlink) ;

	    if (! $this->Result)

	       return false; 

	

	    return true;

	

	}

	

	//function to modify fields by passing query

	function CustomModify($Cquery)

	{

		$query=$Cquery;

	    $this->Result = mysql_query($query, $this->DBlink) ;

	    if (! $this->Result)

	       return false;

		 else return true;	

	}

	

	//function to modify fields by passing query

	function CustomModifynew($Cquery)

	{

		$query=$Cquery;

	    $this->Result = mysql_query($query) ;

	    if (! $this->Result)

	       return false;

		 else return true;	

	}

	

	//fucntion to modify existing field with two where parammeters

	function OverloadsModifyRecord($table, $fnm, $fval, $fnm0, $fval0, $fnm1, $fval1)

	{

	    $query="UPDATE $table set $fnm1='$fval1' WHERE $fnm='$fval'&&$fnm0='$fval0'";

	    $this->Result = mysql_query($query, $this->DBlink);

	    if (! $this->Result)

	       return false;

	    else  return true;

	

	}

	

	//function to delete a whole record

	function DeleteSingleRecord($table, $frn, $fval, $frn1, $fval1)

	{

	    $query="DELETE FROM $table WHERE $frn='$fval' && $frn1='$fval1'";

	    $this->Result = mysql_query($query, $this->DBlink);

	    if (! $this->Result)

	       return false;

	       

	     return true;

	

	}

	

	//delete function

	//function to delete a whole record

	function DeleteSetOfRecords($table, $frn, $fval)

	{
		
  	  $query="DELETE FROM $table WHERE $frn='$fval'";
	  		
	  $this->Result = mysql_query($query, $this->DBlink) ;
	    if (! $this->Result)

	       return false;

	     return true;

	}

	

	//function to delete all records

	function DeleteAllRecords($table)

	{

	    $query="DELETE FROM $table ";

	    $this->Result = mysql_query($query, $this->DBlink);

	    if (! $this->Result)

	       return false;

	       

	     return true;

	

	}

	

	function CustomQuery($Query_C)

	{

	    $Return_Result[]=NULL;

	    $Count=0;

	    $Query = "$Query_C";

		$Show_Query_Reuslt = mysql_query($Query, $this->DBlink);

	    $Query_Result_Final = mysql_fetch_assoc($Show_Query_Reuslt);

	    if(sizeof($Query_Result_Final)==1 && $Query_Result_Final==null){
			return null;}
	    do{

	        $Return_Result[$Count]=$Query_Result_Final;

	        $Count++;

	    }while($Query_Result_Final=mysql_fetch_assoc($Show_Query_Reuslt));    

	    return $Return_Result;

	

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

	    $this->Result = mysql_query($query, $this->DBlink);

	    if (! $this->Result)

	       return false;

	       

	     return true;

	

	}


}

?>