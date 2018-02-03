<?php
	

	function lang($pharse){

		static	$lang  = array(


		// DASHBOARD Navbar Links
		
			'HOME' =>'Home',
			'CATEGORIES' => 'Categories',
			'ITEMS' => 'Items',
			'MEMBERS' => 'Members',
			'STATISTICS' => 'Statistics',
			'LOGS' => 'Logs',
		
		//	DASHBOARD Navbar DropDown Menu
			
			'EDIT-PROFILE' => "Edit profile" ,
			'SETTING'   => "Setting",
			'LOGOUT'   => "Log out",
		);

		return $lang[$pharse];
	}