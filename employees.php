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
    Filename: clients.php
    Written by: Denver Huynh
    Purpose: Clients Prototype for Aegis Appraisals
    Date Created: 10/20/15
    Modification History: NA
    Last Modified: 
	
-->

<!-- Note: Make sure you use the Save as and not overwrite this original file! -->


<html lang="en">
<head>

    <meta  charset="utf-8" />
    <!-- This will house all the needed CSS and JavaScript -->
    <link rel = "stylesheet" type = "text/css" href = "proto.css">

    <title>Aegis Appraisals Database:: Clients Management Page</title>
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
				<a href = "clients.php">Client Management</a>
			</li>
			
			<li>
				<a href = "employee.php">Employee Management</a>
			</li>
			
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

        <table>
            <tr>
                <th>
                    Employee#
                </th>

                <th>
                    Name
                </th>

                <th>
                    Email
                </th>

                <th>
                    Password
                </th>

                <th>
                    Job Title
                </th>

                <th>
                    Permissions
                </th>
            </tr>

            <?php
            $sql = "SELECT `Employee#`, `FirstName`, `LastName`, `Email`, `Password`, `JobTitle`, `Permissions` FROM `Aegis_Employee`";
            $result = mysqli_query($con, $sql) or die("Error in the consult.." . mysqli_error($con)); //send the query to the database or quit if cannot connect

            while ($row = $result->fetch_assoc())
            {
                echo"<tr>";
                    echo "<td>" . "<a href = 'updateEmployee.php?employeeNum=" . $row["Employee#"] . "'>" . $row["Employee#"] . "</td>";
                    echo "<td>" . $row["FirstName"] . " " . $row["LastName"] ."</td>";
                    echo "<td>" . $row["Email"] . "</td>";
                    echo "<td>" . $row["Password"] . "</td>";
                    echo "<td>" . $row["JobTitle"] . "</td>";
                    echo "<td>" . $row["Permissions"] . "</td>";
                echo"</tr>";
            }
            ?>
        </table>

        <hr/>

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