<?php
class SimpleUrl extends DBAccess
{
	/*var $site_path;
	
	function __construct($site_path)
	{
		$this->site_path = $this->removeslash($site_path);
	}
	function __toString()
	{
		return $this->site_path;
	}
	private function removeslash($string)
	{
		if($string[strlen($string) - 1] == '/')
			$string = rtrim($string, '/');
		return $string;
	}*/
	function returnURL($rootdir="")
	{
		//echo($this->site_path);
		if($rootdir=="/"){
			$url = $_SERVER['REQUEST_URI'];
		}else{
			$url = str_replace($rootdir, ' ', $_SERVER['REQUEST_URI']);
		}
		$url = substr($url,1);
		//echo $url; die();
		if($url==FALSE){
			return "";
		}else{
			return $url;
		}
		
	}
	
}
?>