<?php
	session_start();
	$noNavbar = '';
	$pageTitle = 'Login';
	if (isset($_SESSION['Username'])) {
			print_r($_SESSION);
			header('location: dashboard.php');
			print_r($_SESSION);
	}
	
	include("init.php"); 
	

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		
		$username = $_POST['username'];
		$password = $_POST['password'];
		$hashedPass = sha1($password);

		$stmt = $con->prepare("SELECT 
									UserID, Username, UserPassword 
								FROM 
									users 
								WHERE 
									Username = ? 
								AND 
									UserPassword = ? 
								AND 
									GroupID = 1
								LIMIT 1");

		$stmt ->execute(array($username, $hashedPass));
		$row = $stmt->fetch();
		$count = $stmt->rowcount();

		if ($count  > 0) {
			
			$_SESSION['Username'] = $username;
			$_SESSION['UserID'] = $row['UserID'];
			header('location: dashboard.php');			
			exit();
		}
	}

?>
	
	<form class="login" action = " <?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
		<h4 class="text-center">ADMIN LOGIN</h4>
		<input type="text" placeholder="Username" name="username" class="form-control input-lg" autocomplete="off">
		<input type="password" placeholder="Password" name="password" class="form-control input-lg" autocomplete="new-password">
		<input type="submit" value="LOGIN" class="btn btn-primary btn-block">		
	</form>
<?php include($tpl . "footer.inc") ?>