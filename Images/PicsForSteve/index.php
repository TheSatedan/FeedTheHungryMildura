<?php 

if ($handle = opendir('.')) {
	while (false !== ($entry = readdir($handle))) {
		if ($entry != "." && $entry != ".." && $entry != "auth.css" && $entry != "web-settings.php") {
				
			echo '<img src="'.$entry.'">';	
			
				
		}
	}
	closedir($handle);
}
?>