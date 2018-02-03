<?php
	session_start();
	if (isset($_SESSION['Username'])) {
		
		$pageTitle = 'Dashboard';

		include("init.php");

		?>
		<div class="home-stats">
			<div class="container  text-center">
				<h1 class="text-center">Dashboard</h1>

				<div class="col-md-3">
					<div class="stat">
						Total Members
						<span><a href='members.php?action=Manage'><?php rowsCount('Username', 'users'); ?></a></span>
					</div>
				</div>
				<div class="col-md-3">
					<div class="stat">
						Pending Members
						<span><a href='members.php?action=Pending'><?php rowsCount('Username', 'users', 'WHERE RegStatus = 0'); ?></a></span>
					</div>
				</div>
				<div class="col-md-3">
					<div class="stat">
						Total Items
						<span>2222</span>
					</div>
				</div>
				<div class="col-md-3">
					<div class="stat">
						Total Comments
						<span>2050</span>
					</div>
				</div>

			</div>
		</div>
		<div class="latest">
			<div class="container">
				<div class="col-sm-6">
					<div class="panel panel-default">
						<div class="panel-heading">
							<i class="fa fa-users"></i> Latest Registered Members
						</div>
						<div class="panel-body">
							Mohamed Farouk
						</div>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="panel panel-default">
						<div class="panel-heading">
							<i class="fa fa-tag"></i> Latest Items
						</div>
						<div class="panel-body">
							Hammer	
						</div>						
					</div>
				</div>
			</div>
		</div>



		<?php 


		include($tpl . "footer.inc");

	} else {
		header('location: index.php');
	}

