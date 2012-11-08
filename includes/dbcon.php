<?php 		
	
	require_once("config.php");
    require_once("dbcon/mysql_database.inc.php");	
		
	$db = DBFactory::CreateDatabaseObject("MySqlDatabase");
	
    $db->Connect($hostname, $database, $username, $password);

    $db->Begin();
 ?>