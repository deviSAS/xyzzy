<?php
	/*
	 * OpenSim j2p Xy text upload.
	 * Developed by devi S.A.S - http://devi.com.co
	 * Tested with OpenSim 0.7.0.2
	 * ***************************
	 * Double check database details and defaults.
	 */
	 
	 ////////////////////////////////////////////
	 // SETTINGS:                              //
	 ////////////////////////////////////////////

	 $db_name = 'opensim';
	 $db_host = 'localhost';
	 $db_user = 'opensim';
	 $db_pass = 'password';
	 $os_assets_table = 'assets';
	 
	 /* File Info */
	 $creator_uuid = 'c2ed6439-b5c6-493d-861d-a5feb6031baf';
	 $default_desc = 'http://foravatars.com';
	 
	 ////////////////////////////////////////////
	 
	 
	 // Based on the following structure:
	 // name  description  assetType  local	temporary	data	id	create_time	access_time	asset_flags	CreatorID
	 //                        0        0        0                                               0
	 
	 $files = array();
	 $handle = opendir('./files/');
	 
	 $db = @mysql_connect($db_host,$db_user,$db_pass) or die(mysql_error());
		   @mysql_select_db($db_name,$db);

	echo '> Uploading textures, please wait.<br/>'; flush(); sleep(3);
	
	 while (false !== ($file = readdir($handle))) {
		if ($file != "." && $file != "..") {
            $file_name = $file;
			$file_id = substr($file,0,strpos($file_name,'.jp2'));
			
			$create_time = time();
			 
			$contenido = file_get_contents('./files/'.$file_name);
			$contenido = addslashes($contenido);
				   
			$query = "INSERT INTO `$os_assets_table` (`name`, `description`, `assetType`, `local`, `temporary`, `data`, `id`, `create_time`, `access_time`, `asset_flags`, `CreatorID`)
			 VALUES('$file_name','$default_desc',0,0,0,'$contenido','$file_id','$create_time',0,0,'$creator_uuid') ON DUPLICATE KEY UPDATE data='$contenido';";
			 
			$do_query = mysql_query($query, $db) or die(mysql_error());
			echo '> ' . $file_id . ' uploaded!<br/>'; flush();
        }
	 }
	 
	 mysql_close($db);
	 
	 echo '> Done! :)';
     closedir($handle);
	 exit;
?>