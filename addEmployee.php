<?php
	session_start();

	require_once "util/function.php";
    require_once "dbconnect.php";

    if(!isset($_SESSION['username'])) {
        header("Location: index.php");
    }

    $sql = "SELECT `Permissions` FROM `Aegis_Employee` WHERE `Email` = '" . $_SESSION['username'] . "'";
    $result = mysqli_query($con, $sql) or die("Error in the consult.." . mysqli_error($con)); //send the query to the database or quit if cannot connect

    while ($row = $result->fetch_assoc())
    {
        if($row["Permissions"] != "Owner")
            header("Location: dashboard.php");
    }

?>
<!DOCTYPE html>

<!--
    Filename: addEmployee.php
    Written by: Denver Huynh
    Purpose: Add Employee Prototype for Aegis Appraisals
    Date Created: 10/22/15
    Modification History: NA
    Last Modified: 
	
-->

<!-- Note: Make sure you use the Save as and not overwrite this original file! -->


<html lang="en">
<head>

	<meta  charset="utf-8" />
	<!-- This will house all the needed CSS and JavaScript -->
	<link rel = "stylesheet" type = "text/css" href = "proto.css">
	
	<title>Aegis Appraisals Database:: Employee Management Page</title>
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
			<h2>Add new Employee</h2>
			
			<?php
				$error = "";
			
				//check if the form is made
				if(isset($_POST['SubButton']))
				{
					//set up our booleans for the items 
					$requiredCheck = false;
					
					$newfn = trim($_POST['fn']);
					$newln = trim($_POST['ln']);
					$newjT = trim($_POST['jobTitle']);
					$newpass = trim($_POST['pass']);
					$newEmail = trim($_POST['email']);
					$newPermissions = trim($_POST['permission']);
					
					
					//check for empty first name/company name
					if(emptyTest($newfn) && emptyTest($newln) && emptyTest($newpass) && emptyTest($newEmail) && emptyTest($newPermissions))
					{
						$requiredCheck = true;
					}
					else
					{
						$error = $error . "Check your required fields!";
					}
					
					if($requiredCheck)
					{
                        //insert employee into database
                        $sql = "INSERT INTO Aegis_Employee (FirstName, LastName, JobTitle, Password, Email, Permissions) VALUES('".$newfn."','".$newln."','".$newjT."','".$newpass."','".$newEmail."','".$newPermissions."')";
                        $result = mysqli_query($con, $sql) or die("Error in the consult.." . mysqli_error($con)); //send the query to the database or quit if cannot connect

						Header("Location: employees.php"); //where we go after we get this working
					}
					
				}
				
				$error = "<h3>" . $error . "</h3>";
			?>
			
			<form method = "post" action = "">
				<?php
					print $error;
				?>	
			
				<h3>All required fields marked with asterisk (*)</h3>
				
				<label for = "fn">*First Name:</label>
				<input name = "fn" id = "fn">
				<br/>
				
				<label for = "ln">*Last Name: </label>
				<input name = "ln" id = "ln">
				<br/>
				
				<label for = "jobTitle">Job Title:</label>
				<input name = "jobTitle" id = "jobTitle" >
				<br/>
				
				<label for = "pass">*Password:</label>
				<input name = "pass" id = "pass" type = "password">
				<br/>
				
				<label for = "email">*Email:</label>
				<input name = "email" id = "email">
				<br/>

				<label for = "permission">*Permissions:</label>
				<select name = "permission">
					<option value = "" selected = "selected"></option>
					<option value = "Owner">Owner</option>
					<option value = "Employee">Employee</option>
				</select>
                <br/><br>

				<!--Submit Button-->
				<div id = "subButton">
					<input name = "SubButton" type = "submit" value = "Add Employee">
				</div>
				
			</form>
			
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