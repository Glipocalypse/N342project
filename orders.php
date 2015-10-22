<?php
	session_start();
	require_once "util/function.php";
	require_once "dbconnect.php";
    if(!isset($_SESSION['username'])) {
		header("Location: index.php");
    }
?>


<!DOCTYPE html>

<!--
    Filename: orders.html
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
	
	<title>Aegis Appraisals Database:: Orders Management Page</title>	
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
			<h4>Events for the Month</h4>
			
			<iframe src="https://www.google.com/calendar/embed?height=600&amp;wkst=1&amp;bgcolor=%23FFFFFF&amp;src=djantoc%40gmail.com&amp;color=%2329527A&amp;ctz=America%2FNew_York" frameborder="0" scrolling="no" id = "calendar"></iframe>
			
			<hr/>
			
			<div id = "orderManage">
				<button type = "button" onclick = "location.href='addOrder.php'">Add Order</button>
	            <br><br>
				<label id = "title">Manage Orders</label>
			</div>	
			
			<br/>			
			
			<table>
				<tr>
					<th>
						Order Number
					</th>
					
					<th>
						Address
					</th>
					
					<th>
						Due Date
					</th>
					
					<th>
						Borrower Name
					</th>
					
					<th>
						Client
					</th>
					
					<th>
						Inspection Date
					</th>

					<th>
						Employee
					</th>

					<th>
						Status
					</th>
				</tr>

				<?php
				$sql = "SELECT `InternalOrder#`, `ClientOrder#`, `Loan#`, `FHAVA#`, `OrderType`, `AddressID`, `DateAccepted`, `DateDue`, `BorrowerName`, `Notes`, `Client#`, `Fee`, `InspectionDate`, `InspectionTime`, `Employee#`, `StatusID` FROM `Aegis_Order`";
				$result = mysqli_query($con, $sql) or die("Error in the consult.." . mysqli_error($con)); //send the query to the database or quit if cannot connect

				while ($row = $result->fetch_assoc())
				{
					echo"<tr>";
						echo "<td>" . "<a href = 'updateOrder.php?intOrd=" . $row["InternalOrder#"] . "'>" . $row["InternalOrder#"] . "</td>";

						$sql = "SELECT `Street`, `City`, `State`, `Zip` FROM `Aegis_Address` WHERE `AddressID` = '" . $row["AddressID"] . "'";
						$addrResult = mysqli_query($con, $sql) or die("Error in the consult.." . mysqli_error($con)); //send the query to the database or quit if cannot connect
						$addrRow = $addrResult->fetch_assoc();
						echo "<td>" . $addrRow["Street"] . " " . $addrRow["City"] . ", " . $addrRow["State"] . " " . $addrRow["Zip"] . "</td>";

						echo "<td>" . $row["DateDue"] . "</td>";
						echo "<td>" . $row["BorrowerName"] . "</td>";

						$sql = "SELECT `FirstName`, `LastName` FROM `Aegis_Client` WHERE `Client#` = '" . $row["Client#"] . "'";
						$clientResult = mysqli_query($con, $sql) or die("Error in the consult.." . mysqli_error($con)); //send the query to the database or quit if cannot connect
						$clientRow = $clientResult->fetch_assoc();
						echo "<td>" . $clientRow["FirstName"] . " " . $clientRow["LastName"] . "</td>";

						echo "<td>" . $row["InspectionDate"] . " " . $row["InspectionTime"] . "</td>";

						$sql = "SELECT `FirstName`, `LastName` FROM `Aegis_Employee` WHERE `Employee#` = '" . $row["Employee#"] . "'";
						$empResult = mysqli_query($con, $sql) or die("Error in the consult.." . mysqli_error($con)); //send the query to the database or quit if cannot connect
						$empRow = $empResult->fetch_assoc();
						echo "<td>" . $empRow["FirstName"] . " " . $empRow["LastName"] . "</td>";

						$sql = "SELECT `Value` FROM `Aegis_Status` WHERE `StatusID` = '" . $row["StatusID"] . "'";
						$statusResult = mysqli_query($con, $sql) or die("Error in the consult.." . mysqli_error($con)); //send the query to the database or quit if cannot connect
						$statusRow = $statusResult->fetch_assoc();
						echo "<td>" . $statusRow["Value"] . "</td>";

					echo"</tr>";
				}
				?>
				
			</table>
			
			<hr/>
			
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