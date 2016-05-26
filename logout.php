<?php
    
    //Handling user sign out - ending session

	session_start();
	
	session_unset();
	
	header('Location: index.php');

?>