<?php
	session_start();
	
	require_once "util/function.php";
		
    if(!isset($_SESSION['username'])) {
		header("Location: index.php");
    }
?>

<!DOCTYPE html>

<!--
    Filename: Dashboard.html
    Written by: Chris Antolin 
    Purpose: Dashboard Prototype for Aegis Appraisals
    Date Created: 9/27/15
    Modification History: NA
    Last Modified: 
	
-->

<!-- Note: Make sure you use the Save as and not overwrite this original file! -->


<html lang="en">
<head>

	<meta  charset="utf-8" />
	<!-- This will house all the needed CSS and JavaScript -->
	<link rel = "stylesheet" type = "text/css" href = "proto.css">
	<link href='fullcalendar/fullcalendar.css' rel='stylesheet' />
	<link href='fullcalendar/fullcalendar.print.css' rel='stylesheet' media='print' />
	<script src='fullcalendar/lib/moment.min.js'></script>
	<script src='fullcalendar/lib/jquery.min.js'></script>
	<script src='fullcalendar/fullcalendar.min.js'></script>
	<script src = 'calendar.js'></script>
	
	<title>Aegis Appraisals Database:: Management Page</title>	
</head>

<body>
	<div id = "wrapper">
		<!--Place the headings here -->
		<header>
			<a href = "index.php"><img src = "logo38251.png"></img></a>
		</header>
		<!-- Navbar here-->
		<nav>
			<ul>
				
				<li>
					<a href = "dashboard.php">Dashboard</a>
				</li>
				
				<li>
					<a href = "orders.php">Orders/Appraisals</a>
				</li>
				
				<li>
					<a href = "clients.php">Client Management</a>
				</li>

				<li>
					<a href = "updateSelf.php">My Profile</a>
				</li>

				<?php
					if ($_SESSION["permissions"] == "Owner")
						print "
					<li>
						<a href = \"employees.php\">Employee Management</a>
					</li>";
				?>
				 
				<li>
					<a href = "calendar.php">View Calendar</a>
				</li>
				
				<li>
					<a href = "stats.php">Company Statistics</a>
				</li>
				
				<li>
					<a href = "index.php">Sign Out</a>
				</li>
			</ul>
		</nav>
		
		<div id = "content">
			<h2>Welcome Back <?php print greetName($_SESSION['username']); ?>!</h2>
			
			<h3>Weekly Announcements</h3>
		
			<p>Steven, We found the drones you are looking for!</p>
			
			<h3>Upcoming Orders</h3>
			
			<p>This would show any of the upcoming orders within the next two weeks</p>
			
			<hr/>
			
			<h4>Mobile Modules</h4>
			
			<div id = "modulePanel">
				<a href = "orders.php" class = "greenModule">
					<img src = "orders.png" alt = "image failed to load" height = "70" width = "70">
					<h5>Manage All Orders</h5>
				</a>
				
				
				<a href = "clients.php" class = "greenModule">
					<img src = "clients.png" alt = "image failed to load" height = "70" width = "70">
					<h5>Manage All Clients</h5>
				</a>
				
				
				<a href = "stats.php" class = "greenModule">
					<img src = "stats.png" alt = "image failed to load" height = "70" width = "70">
					<h5>View Statistics</h5>
				</a>
				
				<a href = "calendar.php" class = "greenModule">
					<img src = "calendar.png" alt = "image failed to load" height = "70" width = "70">
					<h5>View Calendar</h5>
				</a>

				<?php
				if ($_SESSION["permissions"] == "Owner")
					print "<a href = 'employees.php' class = 'greenModule'>
					<img src = 'employee.png' alt = 'image failed to load' height = '70' width = '70'>
					<h5>Manage Employees</h5>
					</a>";
				?>

				<a href = "index.php" class = "greenModule">
					<img src = "signout.png" alt = "image failed to load" height = "70" width = "70">
					<h5>Log out</h5>
				</a>
			</div>
			
		</div>
		
				<!-- Footer here -->
		<footer>
			Copyright &copy; 2015 Aegis Appraisals Inc.
			<br>
			Portions Copyright &copy 2015 Group 2, N342.
		</footer>

	</div>
</body>
</html>