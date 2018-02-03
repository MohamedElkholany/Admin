<?php
	session_start();
	$pageTitle = 'Members';
	if (isset($_SESSION['Username'])) {
		
		include("init.php");
		$action = isset($_GET['action'])? $_GET['action'] : 'Manage';
		
		//$id = isset($_GET['id'])? $_GET['id'] : '';
		
		if ($action == 'Manage') {  // Manage Page  

			$stmt = $con->prepare("SELECT * FROM users WHERE GroupID != 1");
			$stmt->execute();
			$rows = $stmt->fetchall();


		?>
			
			<div class="container">
				<h1 class="text-center">Mange Members</h1>
			<?php	
				
			?>
				<div class="table-responsive">
					<table class="main-table text-center table table-bordered">
						<tr>
							<th>#ID</th>
							<th>Username</th>							
							<th>E-mail</th>
							<th>FullName</th>							
							<th>Registerd date</th>
							<th>Control</th>
						</tr>
						<?php  
							foreach ($rows as $row) {
									echo '<tr>';
										echo '<td>' . $row['UserID'] . '</td>';
										echo '<td>' . $row['Username'] . '</td>';
										echo '<td>' . $row['Email'] . '</td>';
										echo '<td>' . $row['FullName'] . '</td>';
										echo '<td>' . $row['Date'] . '</td>';
											echo '<td>
													 <a href="members.php?action=Edit&id='. $row["UserID"] .'" class="btn btn-success"><i class="fa fa-edit"></i> Edit</a> 
													 <a href="members.php?action=Delete&id='. $row["UserID"] .'" class="btn btn-danger confirm"><i class="fa fa-close"></i> Delete</a>
												  </td>';
									echo '</tr>';								
							}
						?>

					</table>
				</div>
				<a href='?action=Add' class="btn btn-primary"><i class="fa fa-plus"></i> New Member</a>	
			</div>
			

		 
		<?php 
		}
		if ($action == 'Pending') {  // Manage Pending Members Page  

			$stmt = $con->prepare("SELECT * FROM users WHERE RegStatus = 0");
			$stmt->execute();
			$rows = $stmt->fetchall();


		?>
			
			<div class="container">
				<h1 class="text-center">Mange Members</h1>
			<?php	
				
			?>
				<div class="table-responsive">
					<table class="main-table text-center table table-bordered">
						<tr>
							<th>#ID</th>
							<th>Username</th>							
							<th>E-mail</th>
							<th>FullName</th>							
							<th>Registerd date</th>
							<th>Control</th>
						</tr>
						<?php  
							foreach ($rows as $row) {
									echo '<tr>';
										echo '<td>' . $row['UserID'] . '</td>';
										echo '<td>' . $row['Username'] . '</td>';
										echo '<td>' . $row['Email'] . '</td>';
										echo '<td>' . $row['FullName'] . '</td>';
										echo '<td>' . $row['Date'] . '</td>';
											echo '<td>
													 <a href="members.php?action=Active&id='. $row["UserID"] .'" class="btn btn-info confirm"><i class="fa fa-thumbs-up"></i> Active</a>
													 <a href="members.php?action=Edit&id='. $row["UserID"] .'" class="btn btn-success"><i class="fa fa-edit"></i> Edit</a> 
													 <a href="members.php?action=Delete&id='. $row["UserID"] .'" class="btn btn-danger confirm"><i class="fa fa-close"></i> Delete</a>

												  </td>';
									echo '</tr>';								
							}
						?>

					</table>
				</div>
				<a href='?action=Add' class="btn btn-primary"><i class="fa fa-plus"></i> New Member</a>	
			</div>
			

		 
		<?php 
		}
		if ($action == 'Active') {  // Active Page  

				$userid = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0 ;

				$check = checkItem('UserID', 'users', $userid);


				echo '<div class="container">';
				echo "<h1 class='text-center'>Delete Member</h1>";
				if ($check > 0) {
						
				$stmt =$con->prepare('UPDATE users SET RegStatus = 1 WHERE UserID = :userid');
				$stmt->bindParam(':userid' , $userid);
				$stmt->execute();
				$theMsg =  '<div class="alert alert-success">' . $stmt -> rowcount() . "  record Approved</div>";	
				redirectTo ($theMsg,'back');

				} 
				else {
				$theMsg = '<div class="alert alert-danger">there\'s No Such ID</div>';	
				redirectTo($theMsg,'back', 3);
				}
				echo "</div>";

		 
		}		
		elseif ($action == 'Add') { // Add new member Page ?>
				<div class="container">	
					<h1 class="text-center">Add New Member</h1>
					<form class="form-horizontal" action="?action=Insert" method="POST">
						<!--Start Username Field-->
						<div class="form-group form-group-lg">				
							<label class="col-sm-2 label-control">Username</label>
							<div class="col-sm-10 col-md-5">
								<input type="text"  name="username" class="form-control" required='required' minlength='4' maxlength='20'>
							</div>				
						</div>
						<!--End Username Field-->
						<!--Start Password Field-->
						<div class="form-group form-group-lg">				
							<label class="col-sm-2 label-control">Password</label>
							<div class="col-sm-10 col-md-5">
								<input type="password"  name="password" required="required" class="password form-control">
								<i class="show-pass fa fa-eye fa-2x"></i>
							</div>
						</div>
						<!--End Password Field-->
						<!--Start E-mail Field-->
						<div class="form-group form-group-lg">				
							<label class="col-sm-2 label-control">E-mail</label>
							<div class="col-sm-10 col-md-5">
								<input type="email" name="email" class="form-control"  required='required'>
							</div>
						</div>
						<!--End E-mail Field-->
						<!--Start FullName Field-->
						<div class="form-group form-group-lg">				
							<label class="col-sm-2 label-control">Full Name</label>
							<div class="col-sm-10 col-md-5">
								<input type="text" name="fullname" class="form-control">
							</div>
						</div>
						<!--End FullName Field-->
						<!--Start Submit Field-->
						<div class="form-group">				
							<div class="col-sm-offset-2 col-sm-10">
								<input type="submit" value="Add New Member" class="btn btn-primary btn-lg">
							</div>
						</div>
						<!--End Submit Field-->
						
					</form>
				</div>
			
		<?php
		}elseif ($action == 'Insert') {  // Insert Page
			
			echo "<div class='container'>";

			if ($_SERVER['REQUEST_METHOD'] == 'POST') {			
				echo '<h1 class="text-center">Insert Page</h1>';
				//Get Variables
				
				$user = $_POST['username'];
				$email = $_POST['email'];
				$fullname = $_POST['fullname'];
				//PASSWORD
				$pass = $_POST['password'] ;
				$hashedPass = sha1($pass);
				$formErrors = array();
				if (strlen($user) < 4) {
					$formErrors[] = 'Username Can\'t be less than <strong>4 characters</strong>';
				}
				if (strlen($user) > 20) {
					$formErrors[] = 'Username Can\'t be more than <strong>20 characters</strong>';
				}
				if (empty($user)) {
					$formErrors[] = 'Username Can\'t be <strong>Empty</strong>';
				}
				if (empty($pass)) {
					$formErrors[] = 'Password Can\'t be <strong>Empty</strong>';
				}
				if (empty($email)) {
					$formErrors[] = 'Email Can\'t be <strong>Empty</strong>';
				}
				
				foreach ($formErrors as $error) {
					echo "<div class='alert alert-danger>' " . $error . "</div>" ;  
				}
				if (empty($formErrors)) {

					$check = checkItem ('Username' , 'users', $user);
					if ($check > 0 ) {
	                	$theMsg =  '<div class="alert alert-danger">This Username is already exist in Database</div>' ;
						redirectTo($theMsg, 'back', 2);
					}else{	
					$stmt = $con ->prepare("INSERT INTO  users (Username, Email, FullName, UserPassword, RegStatus, Date) VALUES ( ?, ?, ?, ?, ?, Now())");			
					$stmt ->execute( array( $user, $email, $fullname, $hashedPass, 1) );

					$theMsg = '<div class="alert alert-success">' . $stmt -> rowcount() . " row Inserted</div>";	
					redirectTo ($theMsg,null,5);
					}
				}
			}
			else{
				$theMsg = '<div class="alert alert-danger"You can\'t Browse This Page Directly</div>';
				redirectTo($theMsg, null, 5);
			} 
			echo '</div>';

		} 

		elseif ($action == 'Edit' ){
        	    
			$userid = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0 ;
			$stmt = $con->prepare("SELECT * FROM users WHERE UserID = $userid  LIMIT 1");

			$stmt ->execute(array($userid));
			$row = $stmt->fetch();
			$count = $stmt->rowcount();
			echo '<div class="container">';

			if ($count > 0) {
						
		?>

					<h1 class="text-center">Edit Profile</h1>
					<form class="form-horizontal" action="?action=Update" method="POST">
						<!--Start Username Field-->
						<div class="form-group form-group-lg">				
							<label class="col-sm-2 label-control">Username</label>
							<div class="col-sm-10 col-md-5">
								<input type="hidden"  name="id" value="<?php echo $row['UserID'] ?>">
								<input type="text" value="<?php echo $row['Username'] ?>" name="username" class="form-control" required='required' minlength='4' maxlength='20'>
								<input type="hidden"  name="olduser" value="<?php echo $row['Username'] ?>">
							</div>							
						</div>
						<!--End Username Field-->
						<!--Start Password Field-->
						<div class="form-group form-group-lg">				
							<label class="col-sm-2 label-control">Password</label>
							<div class="col-sm-10 col-md-5">
								<input type="hidden"  name="oldpassword" value="<?php echo $row['UserPassword'] ?>">
								<input type="password"  name="newpassword" class="form-control">
							</div>
						</div>
						<!--End Password Field-->
						<!--Start E-mail Field-->
						<div class="form-group form-group-lg">				
							<label class="col-sm-2 label-control">E-mail</label>
							<div class="col-sm-10 col-md-5">
								<input type="email" value="<?php echo $row['Email'] ?>" name="email" class="form-control"  required='required'>
							</div>
						</div>	
						<!--End E-mail Field-->
						<!--Start FullName Field-->
						<div class="form-group form-group-lg">				
							<label class="col-sm-2 label-control">Full Name</label>
							<div class="col-sm-10 col-md-5">
								<input type="text" value="<?php echo $row['FullName'] ?>" name="fullname" class="form-control">
							</div>
						</div>
						<!--End FullName Field-->
						<!--Start Submit Field-->
						<div class="form-group">				
							<div class="col-sm-offset-2 col-sm-10">
								<input type="submit" value="Save" class="btn btn-primary btn-lg">
							</div>
						</div>
						<!--End Submit Field-->
						
					</form>
				

	<?php
		
		    } else {
				$theMsg = '<div class="alert alert-danger">there\'s No Such Row</div>';	
				redirectTo($theMsg,null,5);		
			}
			echo "</div>";
	}elseif ($action == 'Update') {
		echo '<h1 class="text-center">Update Profile</h1>';
		echo "<div class='container'>";
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			//Get Variables
			
			$user = $_POST['username'];
			$id = $_POST['id'];
			$email = $_POST['email'];
			$fullname = $_POST['fullname'];
			//PASSWORD
			$pass = empty($_POST['newpassword']) ? $_POST['oldpassword'] : sha1($_POST['newpassword']) ;

			$formErrors = array();
			if (strlen($user) < 4) {
				$formErrors[] = 'Username Can\'t be less than <strong>4 characters</strong>';
			}
			if (strlen($user) > 20) {
				$formErrors[] = 'Username Can\'t be more than <strong>20 characters</strong>';
			}
			if (empty($user)) {
				$formErrors[] = 'Username Can\'t be <strong>Empty</strong>';
			}
			if (empty($email)) {
				$formErrors[] = 'Email Can\'t be <strong>Empty</strong>';
			}

			foreach ($formErrors as $error) {
				echo "<div class='alert alert-danger>' " . $error . "</div>" ;  
			}
			if (empty($formErrors)) {

					$check = checkItem ('Username' , 'users', $user);
					if ($check > 0 && $user !== $_POST['olduser']) {
	                	$theMsg =  '<div class="alert alert-danger">This Username is already exist in Database</div>' ;
						redirectTo($theMsg, 'back', 2);
					}else{
						$stmt = $con ->prepare("UPDATE users SET Username = ?, Email = ?, FullName = ? , UserPassword = ? WHERE UserID = ?");			
						$stmt ->execute( array($user, $email, $fullname, $pass, $id) );

						$theMsg= '<div class="alert alert-success">' . $stmt -> rowcount() . "  record updated</div>";
						redirectTo ($theMsg,'back');							
					}
			}
			
		}else {
			$theMsg= "<div class='alert alert-danger'>You Can\'t Browse This Page Directly</div>";
			redirectTo($theMsg,null,5);
		}
		echo '</div>';
	}
	elseif ($action == "Delete") {
		
		$userid = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0 ;
		
		$check = checkItem('UserID', 'users', $userid);


		echo '<div class="container">';
			echo "<h1 class='text-center'>Delete Member</h1>";
			if ($check > 0) {
						
				$stmt =$con->prepare('DELETE FROM users WHERE UserID = :userid ');
				$stmt->bindParam(':userid' , $userid);
				$stmt->execute();
				$theMsg =  '<div class="alert alert-success">' . $stmt -> rowcount() . "  record Deleted</div>";	
				redirectTo ($theMsg,'back');

			} 
			else {
				$theMsg = '<div class="alert alert-danger">there\'s No Such ID</div>';	
				redirectTo($theMsg,'back', 3);
			}
		echo "</div>";
	}


	include($tpl . "footer.inc");

	} else {
		header('location: index.php');
	}