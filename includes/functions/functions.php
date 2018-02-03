<?php



	function getTitle (){  //function that gets the title of the page
		global $pageTitle;

		if (isset($pageTitle)) {
			echo $pageTitle;
		}else {
			echo 'Default';
		}
	}


	function redirectTo ($theMsg, $url = null, $seconds = 3) { // function that redirect to Another page 
			
			$link = 'Homepage';	
			if ($url === null) {
				$url = 'index.php';

			}else{
				$url = isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== '' ? $_SERVER['HTTP_REFERER'] : 'index.php';
				
			}
			if ($url !== 'index.php') {
				$link = 'the Previous Page';
			}
			echo $theMsg;
			echo "<div class='alert alert-info'>You will be redirected to $link after $seconds seconds.</div>";
			header("refresh:$seconds;url=$url");
	
	}

/*
==============================================================
==============================================================
======= checkItem function v1.0 
======= check items from database are duplicate or not
======= accept parameters
======= $column -> the column you want to check
======= $table-> the table you want to check 
======= $value-> the value compare with
==============================================================
==============================================================
*/
	function checkItem ($column , $table, $value) {
		global $con;
		$statment = $con->prepare("SELECT $column FROM $table WHERE $column = ?");

		$statment->execute( array($value ));

		$count = $statment->rowcount();
		return  $count;	
	}
/*
=========================================================================
=========================================================================
======= rowsCount function v1.0 
======= count rows from database at specificed condition
======= accept parameters
======= $column -> the column you want to check
======= $table-> the table you want to check 
======= $condition-> the condition you want to calcute rows when happend			 
=========================================================================
=========================================================================
*/
	function rowsCount ($column, $table, $conition = ''){
		global $con;
		$stmt = $con->prepare("SELECT COUNT($column) FROM $table  $conition");
		$stmt->execute();
		echo ($stmt -> fetchColumn());
	}