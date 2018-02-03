<?php
		

			include 'connect.php';
		//Routes


			$tpl  = "includes/templates/";   //templates Directory
			$lang =	"includes/languages/";  //languages Directory
			$func = "includes/functions/"; //functions Directory
			$css  = "layout/css/";		  //css Directory
			$js   = "layout/js/"	;	 //js Directory

		// Important Files	
			include $func . 'functions.php';
			include($lang .  "english.php");
			include($tpl  .  "header.inc"); 
			
			if (!isset($noNavbar)) {	include $tpl . 'nav.php'; }
