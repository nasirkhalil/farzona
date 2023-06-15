<?php  
   class Pager  
   {  
       static function getPagerData($numHits, $limit, $page)  
       {  
           $numHits  = (int) $numHits; 
           $limit    = max((int) $limit, 1); 
           $page     = (int) $page;  
           $numPages = ceil($numHits / $limit);  

           $page = max($page, 1);  
           $page = min($page, $numPages);  

           $offset = ($page - 1) * $limit;  
			
			if($offset<0)
				$offset=0;
				
           $ret = new stdClass;  

           $ret->offset   = $offset;  
           $ret->limit    = $limit;  
           $ret->numPages = $numPages;  
           $ret->page     = $page;  

           return $ret;  
       }  
   }  
?>