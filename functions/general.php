<?



function  specharrep ($str ) {

$search = array ("\"","\'", "$", "&", "(", ")", "*", ",", "/") ; 

$replace = array("&#34;" ,"&#39;" , "&#36;" , "&#38;" ,"&#40;" ,"&#41;" , "&#42;" ,"&#44;" , "&#47;");  

return str_replace($search, $replace , $str ) ;



}

//password generation



function genpassword($length){







    srand((double)microtime()*1000000);







    $vowels = array("a", "e", "i", "o", "u");



    $cons = array("b", "c", "d", "g", "h", "j", "k", "l", "m", "n", "p", "r", "s", "t", "u", "v", "w", "tr",



    "cr", "br", "fr", "th", "dr", "ch", "ph", "wr", "st", "sp", "sw", "pr", "sl", "cl");







    $num_vowels = count($vowels);



    $num_cons = count($cons);







    for($i = 0; $i < $length; $i++){



        $password .= $cons[rand(0, $num_cons - 1)] . $vowels[rand(0, $num_vowels - 1)];



    }







    return substr($password, 0, $length);



}







//generate the numeric code randomly



function genNumericCode($length){







    srand((double)microtime()*1000000);







    $vowels = array("1", "3", "5", "7", "9");



    $cons = array("0", "2", "4", "6", "8", "15", 



	"46", "85", "05", "03", "92", "33", "41", 



	"68", "51", "53", "55", "56", "97");







    $num_vowels = count($vowels);



    $num_cons = count($cons);







    for($i = 0; $i < $length; $i++){



        $password .= $cons[rand(0, $num_cons - 1)] . $vowels[rand(0, $num_vowels - 1)];



    }

    $check = strlen(substr($password, 0, $length));

   if ($check != $length)

   	{

		genNumericCode($length);

	}else {

    return substr($password, 0, $length);

     }

}







//function for random no generation seeding



function make_seed() {



    list($usec, $sec) = explode(' ', microtime());



    return (float) $sec + ((float) $usec * 100000);



}







//seeding the above function



function new_pass()



{



    $nums=array('6','7','8','9','10','11','12');



    srand(make_seed());



    $randval = rand();



    $randval = $randval % 7;



    return genpassword($nums[$randval]);



}







//function to generate email



function SendEmail($mTo,$mFrom,$mSubject,$mMessage)



{//TODO*/ enable it


	
    mail($mTo, $mSubject, $mMessage, "MIME-Version: 1.0\r\nContent-type: text/html; charset=iso-8859-1\r\nFrom: $mFrom\r\nX-Priority: 1 (Normal)" );



}







//function for check email syntax



function emailsyntax_is_valid($email) {



  list($local, $domain) = explode("@", $email);







  $pattern_local = '^([0-9a-z]*([-|_]?[0-9a-z]+)*)(([-|_]?)\.([-|_]?)[0-9a-z]*([-|_]?[0-9a-z]+)+)*([-|_]?)$';



  $pattern_domain = '^([0-9a-z]+([-]?[0-9a-z]+)*)(([-]?)\.([-]?)[0-9a-z]*([-]?[0-9a-z]+)+)*\.[a-z]{2,4}$';







  $match_local = eregi($pattern_local, $local);



  $match_domain = eregi($pattern_domain, $domain);







  if ($match_local && $match_domain) {







  	//if valid email then



    return true;







  } else {







  	//if not valid email



    return false;







  }



}







/* This function accepts a credit card number and, optionally, a code for



* a credit card name. If a Name code is specified, the number is checked



* against card-specific criteria, then validated with the Luhn Mod 10



* formula. Otherwise it is only checked against the formula. Valid name



* codes are:



*



*    mcd - Master Card



*    vis - Visa



*    amx - American Express



*    dsc - Discover



*    dnc - Diners Club



*    jcb - JCB */







function CCVal($Num, $Name = 'n/a') {







//  Innocent until proven guilty



    $GoodCard = true;







//  Get rid of any non-digits



    $Num = ereg_replace("[^[:digit:]]", "", $Num);







//  Perform card-specific checks, if applicable



    switch ($Name) {







    case "mcd" :



      $GoodCard = ereg("^5[1-5].{14}$", $Num);



      break;







    case "vis" :



      $GoodCard = ereg("^4.{15}$|^4.{12}$", $Num);



      break;







    case "amx" :



      $GoodCard = ereg("^3[47].{13}$", $Num);



      break;







    case "dsc" :



      $GoodCard = ereg("^6011.{12}$", $Num);



      break;







    case "dnc" :



      $GoodCard = ereg("^30[0-5].{11}$|^3[68].{12}$", $Num);



      break;







    case "jcb" :



      $GoodCard = ereg("^3.{15}$|^2131|1800.{11}$", $Num);



      break;



    }







//  The Luhn formula works right to left, so reverse the number.



    $Num = strrev($Num);







    $Total = 0;







    for ($x=0; $x<strlen($Num); $x++) {



      $digit = substr($Num,$x,1);











//    If it's an odd digit, double it



      if ($x/2 != floor($x/2)) {



        $digit *= 2;







//    If the result is two digits, add them



        if (strlen($digit) == 2)



          $digit = substr($digit,0,1) + substr($digit,1,1);



      }







//    Add the current digit, doubled and added if applicable, to the Total



      $Total += $digit;



    }







//  If it passed (or bypassed) the card-specific check and the Total is



//  evenly divisible by 10, it's cool!



    if ($GoodCard && $Total % 10 == 0) return true; else return false;



}







//function to check login name validation



function invalids($login)



{



    $i=0;



    while ($login[$i]!=''){



	   // echo "$login[$i]<br>";



	    if($login[$i]==' '||$login[$i]=='@'||$login[$i]=='!'||$login[$i]=='`'||$login[$i]=='/'||$login[$i]==','||$login[$i]=='.'||$login[$i]=='<'||$login[$i]=='>'||$login[$i]=='?'||$login[$i]=='"'||$login[$i]==':'||$login[$i]==';'||$login[$i]=='='||$login[$i]=='+'||$login[$i]=='-'||$login[$i]=='_'||$login[$i]==')'||$login[$i]=='('||$login[$i]=='*'||$login[$i]=='&'||$login[$i]=='^'||$login[$i]=='%'||$login[$i]=='$'||$login[$i]=='#'||$login[$i]=='@'||$login[$i]=='['||$login[$i]==']'||$login[$i]=='{'||$login[$i]=='}'){



	                     return true;



	                     break;



	    }



	    $i+=1;



	}



return false;//no error found



}







//checking for email mx records



function checkMxRecord($email)



{



	$domain = substr(strstr($email, '@'), 1);



    //$x = getmxrr($domain, $mxs);



    



    #$mxs[0] will return the first (or only) MX record



    #of the domain. If $mxs[0] has a value, the email



    #address is good, if $mxs[0] comes up empty, the



    #domain has no MX record(s) and cannot receive mail.



    



    if ($mxs[0]=='') {



    	return false;



    }



    



    return true;



}







//get student password encypted



function encStudentPass($pass)



{



	//first encrpting the password



	$pass=md5($pass);



	



	//now trimiming the paaword



	//ecece$pass=substr($pass,0,$trimChar);



	



	//return password



	return $pass;



}







//function to validate some html text area format



function htmlFormat($text)



{



	$msg=nl2br(stripslashes(strip_tags($text, '<b><i><u><center><img><a><hr><p>')));



	



	return $msg;



}







//function to add,subtract date and time



define("ADD","add",false);



define("SUB","sub",false);



/**



 * @return date



 * @param day day



 * @param month month



 * @param year year



 * @param sec = null second



 * @param min = null minutes



 * @param hr = null hours



 * @param to_day = null to add/subtract days



 * @param to_month = null to add/subtract month



 * @param to_year = null to add/subtract year



 * @param to_sec = null to add/subtract second



 * @param to_min = null to add/subtract minutes



 * @param to_hr = null to add/subtract hours



 * @param Flag ADD | SUB



 * @param format format of the returned date



 * @desc Date Processor



 */



function ProcessDate($day,$month,$year,$sec=0,$min=0,$hr=0,$to_day=0,$to_month=0,$to_year=0,$to_sec=0,$to_min=0,$to_hr=0,$Flag,$format)



{



	if($Flag==ADD)



	{



		$form_D= mktime ($hr+$to_hr,$min+$to_min,$sec+$to_sec,$month+$to_month,$day+$to_day,$year+$to_year);		



	}



	elseif ($Flag==SUB)



	{



		$form_D= mktime ($hr-$to_hr,$min-$to_min,$sec-$to_sec,$month-$to_month,$day-$to_day,$year-$to_year);



	}



	



	return date($format,$form_D);



}







//function to upload images--can be used to upload other files



//with little modifications



/*



returned values



-1=file size increased



-2=file type does not match



-3=unknown upload error







$myFile=uploaded successfully and returns file name



0=file not set







type=0 means just to validate file not to upload



type=1 means to validate and upload



*/



function nowUpload($name,$dir,$size,$type=1)



{

    

	ini_set("upload_max_filesize","100M");

	    

	//valid and active images types



	$cert1 = "image/pjpeg"; //Jpeg type 1



	$cert2 = "image/jpeg"; //Jpeg type 2



	$cert3 = "image/gif"; //Gif type



	//$cert4 = "text/plain"; //Ief type



	$cert5 = "image/png"; //Png type



	//$cert6 = "image/tiff"; //Tiff type



	//$cert7 = "image/bmp"; //Bmp Type



	//$cert8 = "application/msword"; //Wbmp type---



	//$cert9 = "application/mspowerpoint"; //Ras type---power point



	//$cert10 = "application/vnd.ms-powerpoint"; //Pnm type--ppt



	//$cert11 = "application/vnd.ms-powerpoint"; //Pbm type--ppt



	//$cert12 = "application/powerpoint"; //Pgm type--ppt



	//$cert13 = "application/x-mspowerpoint"; //Ppm type---ppt



	//$cert14 = "application/pdf"; //Rgb type---pdf



	//$cert15 = "application/x-bzip2"; //Xbm type--zip



	//$cert16 = "application/x-bzip"; //Xpm type---zip



	//$cert17 = "application/x-gtar"; //Xpm type---zip



	//$cert18 = "multipart/x-gzip"; //Xpm type---zip



	//$cert19 = "application/x-compressed"; //Xpm type---zip



	//$cert20 = "application/x-zip-compressed"; //Xpm type---zip



	//$cert21 = "application/zip"; //Xpm type---zip



	//$cert22 = "multipart/x-zip"; //Xpm type---zip



	//$cert23="text/csv";



	//$cert24="text/comma-separated-values";



	//$cert25="application/csv";



	//$cert26="application/excel";



	//$cert27="application/vnd.ms-excel";



	//$cert28="application/vnd.msexcel";



	//$cert29="text/anytext";



	//$cert30="application/octet-stream";



	//link: http://www.webmaster-toolkit.com/mime-types.shtml 



	//checking that if the file name exists



	if(isset($_FILES[$name]['name']) && !empty($_FILES[$name]['name']))



	{//upload checks				



		



		//checking for the valid file size



		if($_FILES[$name]['size']>$size || $_FILES[$name]['size']<=0)



		{//not valid



			



			//echo "Max size increased ".$_FILES[$name]['size'];



			return -1;



			



		}



		



		//checking for valid file type



		if(($_FILES[$name]['type']==$cert1) || ($_FILES[$name]['type']==$cert2) 



		|| ($_FILES[$name]['type']==$cert3) || ($_FILES[$name]['type']==$cert5)  



		 )



		{}else



		{



			//echo "file type not supported";



			return -2;



		}



		



		//checking if the file already exists



		$copy="";



		$n=0;



		



		//spliting the extension and name



		$arr=split("\.",$_FILES[$name]['name']);



		



		//storing file name



		$myFile=$arr[0];

		

		$myFile=strtolower($myFile);



		



		//storing extension



		$myExtension=".".$arr[1];

		

		$myExtension= strtolower($myExtension);



		



		//comparing the existance and renaming new file



		while(file_exists($dir.$myFile.$copy.$myExtension)) {



			$copy = "_copy" . $n;



			$n++;



		}



		



		//storing the new file name



		$myFile = $myFile.$copy.$myExtension;



		



		//setting up the directory variable



		$uploaddir = $dir;



		



		//print "<pre>";







		//checking condition of 'type'



		if($type==1)



		{//valid type



		



			//uploading here



			if (@move_uploaded_file($_FILES[$name]['tmp_name'], $uploaddir . $myFile)) {



				



				//successful upload



			    //print_r($_FILES);



				$nfwd = $uploaddir.$myFile;

				$image_attribs = getimagesize($nfwd);

				$im_old = imageCreateFromJpeg($nfwd);

				if (($image_attribs[0] <= 700) && ($image_attribs[1] <= 700))

				{return $myFile;}

				else

				{

				

				$size_large = ($image_attribs[0] > $image_attribs[1]) ? $image_attribs[0] : $image_attribs[1]; 

				$size_large_ratio = $size_large /700 ;

				

				$new_w = $image_attribs[0]/$size_large_ratio; 

				$new_h = $image_attribs[1]/$size_large_ratio; 

				//echo $new_w."width n now heigt".$new_h;

				//die();

				$im_new = imagecreatetruecolor($new_w,$new_h); 

				imageAntiAlias($im_new,true); 

		

				//$th_file_name = '/product_images/' . $_FILES['product_image']['name']; 

				imageCopyResampled($im_new,$im_old,0,0,0,0,$new_w,$new_h, $image_attribs[0], $image_attribs[1]); 

				imageJpeg($im_new,$nfwd,100);

				$nmyFile=$myFile;

				@unlink($myFile);

				//echo 

				return $nmyFile;

				}



			    



			    



			} else {//failed to upload--unknown reason



			    //print "Possible file upload attack!  Here's some debugging info:\n";



			    //print_r($_FILES);



			    return -3;



			}



		} else 



			return true;



	



	}



	



	//file not set



	return 0;



}
function nowDirectImage($name,$dir,$size="999M",$type=1)
{
	ini_set("upload_max_filesize","100M");
		//checking if the file already exists
		$copy="";
		$n=0;
		//spliting the extension and name
		$arr=explode(".",$_FILES[$name]['name']);
		//storing file name
	    $myFile=$arr[0];
		
		
		//$myFile=strtolower($myFile);
		//storing extension
		$myExtension=".".$arr[1];
		$myFile = $myFile.time().$myExtension;
		//setting up the directory variable
		$uploaddir = $dir;
		//print "<pre>";
		//checking condition of 'type'
		if($type==1)
		{//valid type
			//uploading here
			
			if (@move_uploaded_file($_FILES[$name]['tmp_name'], $uploaddir . $myFile)) {
				//successful upload
				return $myFile;
			} else {//failed to upload--unknown reason

			    //print "Possible file upload attack!  Here's some debugging info:\n";
			    //print_r($_FILES);
			    return -3;
			}
		}else
			return true;
}

function nowUploadFiles($name,$dir,$size,$type=1)
{
	ini_set("upload_max_filesize","100M");
	$cert1 = "text/plain"; //Ief type
	$cert2= "application/msword"; //Wbmp type---
	$cert3 = "application/mspowerpoint"; //Ras type---power point
	$cert4 = "application/vnd.ms-powerpoint"; //Pnm type--ppt
	$cert5 = "application/pdf"; //Rgb type---pdf
	$cert6="text/anytext";
	if(isset($_FILES[$name]['name']) && !empty($_FILES[$name]['name']))
	{//upload checks				
		if($_FILES[$name]['size']>$size || $_FILES[$name]['size']<=0)
		{//not valid
			//echo "Max size increased ".$_FILES[$name]['size'];
			return -1;
		}
		//checking for valid file type
		/*if(($_FILES[$name]['type']==$cert1) || ($_FILES[$name]['type']==$cert2)	|| ($_FILES[$name]['type']==$cert3) || ($_FILES[$name]['type']==$cert4) || ($_FILES[$name]['type']==$cert5))
		{}else
		{
			//echo "file type not supported";
			return -2;
		}*/

		//checking if the file already exists
		$copy="";
		$n=0;
		//spliting the extension and name
		$arr=split("\.",$_FILES[$name]['name']);
		//storing file name
		$myFile=$arr[0];
		$myFile=strtolower($myFile);
		//storing extension
		$myExtension=".".$arr[1];
		$myExtension= strtolower($myExtension);
		//comparing the existance and renaming new file
		while(file_exists($dir.$myFile.$copy.$myExtension)) {
			$copy = "_copy" . $n;
			$n++;
		}
		//storing the new file name
		$myFile = $myFile.$copy.$myExtension;
		//setting up the directory variable
		$uploaddir = $dir;
		//print "<pre>";
		//checking condition of 'type'
		if($type==1)
		{//valid type
			//uploading here
			if (@move_uploaded_file($_FILES[$name]['tmp_name'], $uploaddir . $myFile)) {
				//successful upload
				return $myFile;
			} else {//failed to upload--unknown reason

			    //print "Possible file upload attack!  Here's some debugging info:\n";
			    //print_r($_FILES);
			    return -3;
			}
		}else
			return true;
	}

	//file not set
	return 0;
}







//function to maintain the state



/**



 * @return void



 * @param $name colname



 * @param $state state-1=dropdown--state-2=radio--state-3=textarea--no-state=textfield



 * @param $val value



 * @desc post method has more periority :-)



 */



function State($name,$state=0,$val=null)



{



	if(isset($_POST[$name]) && !empty($_POST[$name]))



	{



		if($state==1 && $val==$_POST[$name])



			echo "selected";



		elseif ($state==2 && $val==$_POST[$name])



			echo "checked";



		elseif($state==3)



			echo stripslashes($_POST[$name]);//Fahad Pervaiz/ added stripslashes function



		else



			echo "value=\"".$_POST[$name]."\"";



	} 



	else if(isset($_GET[$name]) && !empty($_GET[$name]))



	{



		if($state==1 && $val==$_GET[$name])



			echo "selected";



		elseif ($state==2 && $val==$_GET[$name])



			echo "checked";



		elseif($state==3)



			echo $_GET[$name];



		else



			echo "value=\"".$_GET[$name]."\"";



	} 



}







//this is the similar function as above but with little modification



//that is used to handle the categories in autoselect



function State2($name,$state=0,$val=null)



{



	if(isset($_POST[$name]) && !empty($_POST[$name]))



	{



		if($state==1 && $val==$_POST[$name])



			return "selected";



		/*elseif ($state==2 && $val==$_POST[$name])



			echo "checked";



		elseif($state==3)



			echo $_POST[$name];



		else



			echo "value=\"".$_POST[$name]."\"";*/



	} 



	else if(isset($_GET[$name]) && !empty($_GET[$name]))



	{



		if($state==1 && $val==$_GET[$name])



			return "selected";



		/*elseif ($state==2 && $val==$_GET[$name])



			echo "checked";



		elseif($state==3)



			echo $_GET[$name];



		else



			echo "value=\"".$_GET[$name]."\"";*/



	} 



}







//function to maintain the state



/**



 * @return void



 * @param $name colname



 * @param $state state-1=dropdown--state-2=radio--state-3=textarea--no-state=textfield



 * @param $val value



 * @desc post method has more periority :-)



 *///just returns instead of echo



function State3($name,$state=0,$val=null)



{



	if(isset($_POST[$name]) && !empty($_POST[$name]))



	{



		if($state==1 && $val==$_POST[$name])



			return "selected";



		elseif ($state==2 && $val==$_POST[$name])



			return "checked";



		elseif($state==3)



			return $_POST[$name];



		else



			return "value=\"".$_POST[$name]."\"";



	} 



	else if(isset($_GET[$name]) && !empty($_GET[$name]))



	{



		if($state==1 && $val==$_GET[$name])



			return "selected";



		elseif ($state==2 && $val==$_GET[$name])



			return "checked";



		elseif($state==3)



			return $_GET[$name];



		else



			echo "value=\"".$_GET[$name]."\"";



	} 



}
function crop_img($imgSrc,$Thumbname,$thSize){
	//getting the image dimensions
    list($width, $height) = getimagesize($imgSrc);


  $ext=substr($imgSrc,-4);
	//echo substr($ext,0,1);
	if(substr($ext,0,1)!=".")
	{
		$ext=substr($imgSrc,-5);
	}
	
	if(substr($ext,0,1)!=".")
	{
		$ext=substr($imgSrc,-5);
	}
		$myExtension=$ext;
	//echo $myExtension;
	
	if($myExtension=='.gif')
	{
		$myImage = imagecreatefromgif($imgSrc);
	}
	elseif($myExtension=='.jpg' || $myExtension=='.JPG')
	{ 

		$myImage = imagecreatefromjpeg($imgSrc);
	}
	elseif($myExtension=='.png')
	{
		$myImage = imagecreatefrompng($imgSrc);
	}
	else
	{
		 $myImage = imagecreatefromjpeg($imgSrc);	
	}
    //saving the image into memory (for manipulation with GD Library)
   

    // calculating the part of the image to use for thumbnail
    if ($width > $height) {
        $y = 0;
        $x = ($width - $height) / 2;
        $smallestSide = $height;
    } else {
        $x = 0;
        $y = ($height - $width) / 2;
        $smallestSide = $width;
    }
	
	/*if($smallestSide>250){
		$smallestSide = 250;
	}*/

    // copying the part into thumbnail
    $thumbSize = min($width,$height);
	
	if($thumbSize>$thSize){
		$thumbSize=$thSize;
	}
	
    $thumb = imagecreatetruecolor($thumbSize, $thumbSize);
    imagecopyresampled($thumb, $myImage, 0, 0, $x, $y, $thumbSize, $thumbSize, $smallestSide, $smallestSide);

    //unlink($imgSrc);
    imagejpeg($thumb,$Thumbname);
    @imagedestroy($myImage);
    @imagedestroy($thumb);
}

function crop_img_rectangle($imgSrc,$Thumbname,$thumb_width,$thumb_height){
		//getting the image dimensions
		$ext=substr($imgSrc,-4);
	//echo substr($ext,0,1);
	if(substr($ext,0,1)!=".")
	{
		$ext=substr($imgSrc,-5);
	}
	
	if(substr($ext,0,1)!=".")
	{
		$ext=substr($imgSrc,-5);
	}
		$myExtension=$ext;
	//echo $myExtension;
	
	if($myExtension=='.gif')
	{
		$myImage = imagecreatefromgif($imgSrc);
	}
	elseif($myExtension=='.jpg' || $myExtension=='.JPG')
	{ 

		$myImage = imagecreatefromjpeg($imgSrc);
	}
	elseif($myExtension=='.png')
	{
		$myImage = imagecreatefrompng($imgSrc);
	}
	else
	{
		 $myImage = imagecreatefromjpeg($imgSrc);	
	}
		//$image = imagecreatefromjpeg($imgSrc);
		$filename = $Thumbname;
	
	//$thumb_width = 220;
	//$thumb_height = 180;
	
	$width = imagesx($image);
	$height = imagesy($image);
	
	$original_aspect = $width / $height;
	$thumb_aspect = $thumb_width / $thumb_height;
	
	if ( $original_aspect >= $thumb_aspect )
	{
	   // If image is wider than thumbnail (in aspect ratio sense)
	   $new_height = $thumb_height;
	   $new_width = $width / ($height / $thumb_height);
	}
	else
	{
	   // If the thumbnail is wider than the image
	   $new_width = $thumb_width;
	   $new_height = $height / ($width / $thumb_width);
	}
	
	$thumb = imagecreatetruecolor( $thumb_width, $thumb_height );
	
	// Resize and crop
	imagecopyresampled($thumb,$image, 0 - ($new_width - $thumb_width) / 2, 0 - ($new_height - $thumb_height) / 2,0, 0,
	 $new_width, $new_height, $width, $height);
	imagejpeg($thumb, $filename, 80);
		@imagedestroy($myImage);
		@imagedestroy($thumb);
}




function createthumb($name,$filename,$new_w,$new_h)

{





	ini_set("upload_max_filesize","100M");

	$image_attribs = getimagesize($name);
	
	$arr=split("\.",$name);
	
	$myExtension=".".$arr[1];
	
	if($myExtension=='.gif')
	{
		$im_old = imagecreatefromgif($name);
	}
	elseif($myExtension=='.png')
	{
		$im_old = imagecreatefrompng($name);
	}
	else
	{
		$im_old = imagecreatefromjpeg($name);	
	}
	
	if (($image_attribs[0] <= $new_w) &&  ($image_attribs[1] <= $new_h))

	{

	

	$new_w = $image_attribs[0]; 

	$new_h = $image_attribs[1]; 

	$im_new = imagecreatetruecolor($new_w,$new_h); 

	imageAntiAlias($im_new,true); 



	//$th_file_name = '/product_images/' . $_FILES['product_image']['name']; 

	imageCopyResampled($im_new,$im_old,0,0,0,0,$new_w,$new_h, $image_attribs[0], $image_attribs[1]); 

	imageJpeg($im_new,$filename,100);

		

	}

	else

	{

	$size_large = ($image_attribs[0] > $image_attribs[1]) ? $image_attribs[0] : $image_attribs[1]; 

	$size_large_ratio = $size_large /$new_h;

	$new_w = $image_attribs[0]/$size_large_ratio; 

	$new_h = $image_attribs[1]/$size_large_ratio; 

	$im_new = imagecreatetruecolor($new_w,$new_h); 

	imageAntiAlias($im_new,true); 



	//$th_file_name = '/product_images/' . $_FILES['product_image']['name']; 

	imageCopyResampled($im_new,$im_old,0,0,0,0,$new_w,$new_h, $image_attribs[0], $image_attribs[1]); 

	imageJpeg($im_new,$filename,100);

    }	

}

function createsmallthumbHSSG($name,$filename,$new_w,$new_h)

{
	$ext=substr($name,-4);
	//echo substr($ext,0,1);
	if(substr($ext,0,1)!=".")
	{
		$ext=substr($name,-5);
	}


	ini_set("upload_max_filesize","1000M");

	$image_attribs = getimagesize($name);
	
	//$arr=split("\.",$name);
	$ext=substr($name,-4);
	//echo substr($ext,0,1);
	if(substr($ext,0,1)!=".")
	{
		$ext=substr($name,-5);
	}
	
	//echo $myExtension=".".$arr[1];
	$myExtension=$ext;
	//echo $myExtension;
	
	if($myExtension=='.gif')
	{
		$im_old = imagecreatefromgif($name);
	}
	elseif($myExtension=='.jpg' || $myExtension=='.JPG')
	{ 

		$im_old = imagecreatefromjpeg($name);
	}
	else
	{
		$im_old = imagecreatefrompng($name);	
	}
	

	//$im_old = imageCreateFromPNG($name);

	if (($image_attribs[0] <= 100) && ($image_attribs[1] <= 100))

	{

	

	$new_w = $image_attribs[0]; 

	$new_h = $image_attribs[1]; 

	$im_new = imagecreatetruecolor($new_w,$new_h); 

	imageAntiAlias($im_new,true); 



	//$th_file_name = '/product_images/' . $_FILES['product_image']['name']; 

	imageCopyResampled($im_new,$im_old,0,0,0,0,$new_w,$new_h, $image_attribs[0], $image_attribs[1]); 

	imageJpeg($im_new,$filename,100);

		

	}

	else

	{

	/*$size_large = ($image_attribs[0] > $image_attribs[1]) ? $image_attribs[0] : $image_attribs[1]; 

	$size_large_ratio = $size_large /100;

	$new_w = $image_attribs[0]/$size_large_ratio; 

	$new_h = $image_attribs[1]/$size_large_ratio; */

	$im_new = imagecreatetruecolor($new_w,$new_h); 

	imageAntiAlias($im_new,true); 



	//$th_file_name = '/product_images/' . $_FILES['product_image']['name']; 

	imageCopyResampled($im_new,$im_old,0,0,0,0,$new_w,$new_h, $image_attribs[0], $image_attribs[1]); 

	imageJpeg($im_new,$filename,100);

    }
		

}           
         

function createsmallthumb($name,$filename,$new_w,$new_h)

{





	ini_set("upload_max_filesize","1000M");

	$image_attribs = getimagesize($name);
	
	$arr=split("\.",$name);
	
	$myExtension=".".$arr[1];
	//echo $myExtension;
	
	if($myExtension=='.gif')
	{
		$im_old = imagecreatefromgif($name);
	}
	elseif($myExtension=='.jpg')
	{
		$im_old = imagecreatefromjpeg($name);
	}
	else
	{
		$im_old = imagecreatefrompng($name);	
	}
	

	//$im_old = imageCreateFromPNG($name);

	if (($image_attribs[0] <= 100) && ($image_attribs[1] <= 100))

	{

	

	$new_w = $image_attribs[0]; 

	$new_h = $image_attribs[1]; 

	$im_new = imagecreatetruecolor($new_w,$new_h); 

	imageAntiAlias($im_new,true); 



	//$th_file_name = '/product_images/' . $_FILES['product_image']['name']; 

	imageCopyResampled($im_new,$im_old,0,0,0,0,$new_w,$new_h, $image_attribs[0], $image_attribs[1]); 

	imageJpeg($im_new,$filename,100);

		

	}

	else

	{

	/*$size_large = ($image_attribs[0] > $image_attribs[1]) ? $image_attribs[0] : $image_attribs[1]; 

	$size_large_ratio = $size_large /100;

	$new_w = $image_attribs[0]/$size_large_ratio; 

	$new_h = $image_attribs[1]/$size_large_ratio; */

	$im_new = imagecreatetruecolor($new_w,$new_h); 

	imageAntiAlias($im_new,true); 



	//$th_file_name = '/product_images/' . $_FILES['product_image']['name']; 

	imageCopyResampled($im_new,$im_old,0,0,0,0,$new_w,$new_h, $image_attribs[0], $image_attribs[1]); 

	imageJpeg($im_new,$filename,100);

    }
		

}
function nowDirectupload($name,$dir,$size="999M",$type=1)
{
	ini_set("upload_max_filesize","100M");
		//checking if the file already exists
		
		$myFile = $_FILES[$name]['name'];
		//setting up the directory variable
		$uploaddir = $dir;
		//print "<pre>";
		//checking condition of 'type'
		if($type==1)
		{//valid type
			//uploading here
			
			if (@move_uploaded_file($_FILES[$name]['tmp_name'], $uploaddir . $myFile)) {
				//successful upload
				return $myFile;
			} else {//failed to upload--unknown reason

			    //print "Possible file upload attack!  Here's some debugging info:\n";
			    //print_r($_FILES);
			    return -3;
			}
		}else
			return true;
}// end function





?>