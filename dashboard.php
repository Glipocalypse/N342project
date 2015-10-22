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
				
				<?php
					if ($_SESSION["permissions"] == "Owner")
						print "
					<li>
						<a href = \"employees.php\">Employee Management</a>
					</li>";
				?>
				
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
			
			<h4>Events for the Week</h4>
			
			<iframe src="https://www.google.com/calendar/embed?mode=WEEK&amp;height=600&amp;wkst=1&amp;bgcolor=%23FFFFFF&amp;src=djantoc%40gmail.com&amp;color=%2329527A&amp;ctz=America%2FNew_York" frameborder="0" scrolling="no" id = "calendar"></iframe>
			
			
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