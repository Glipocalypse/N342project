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

    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="DataTables-1.10.10/media/css/jquery.dataTables.css">

    <!-- jQuery -->
    <script type="text/javascript" charset="utf8" src="DataTables-1.10.10/media/js/jquery.js"></script>

    <!-- DataTables -->
    <script type="text/javascript" charset="utf8" src="DataTables-1.10.10/media/js/jquery.dataTables.js"></script>

    <script type="text/javascript" language="javascript" class="init">
        $(document).ready( function () {
            $('#info').DataTable( {
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
            });
        } );
    </script>

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
			<h4>Events for the Month</h4>
			<h2>Manage Orders</h2>

			<div id = "modulePanel">
				<a href = "addOrder.php" class = "greenModule">
					<img src = "addOrders.png" alt = "image failed to load" height = "70" width = "70">
					<h5>Add new Order</h5>
				</a>
			</div>

			<br/>
			<br/>
			<br/>
			<br/>
			<br/>
			<br/>
			<br/>
			<br/>
			<br/>

			<hr/>

			<h2>Active Orders</h2>

			<table id="info" class="display">
                <thead>
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
                </thead>

                <tbody>
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
                </tbody>
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