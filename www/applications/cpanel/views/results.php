<?php 
if(!defined("_access")) die("Error: You don't have permission to access here..."); 
	
print isset($search) 	 ? $search 	   : NULL;
print isset($table) 	 ? $table 	   : NULL;
print isset($pagination) ? $pagination : NULL;