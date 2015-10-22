<?php
	session_start();
    if(!isset($_SESSION['username'])) {
		header("Location: index.php");
    }

	if(!isset($_SESSION["Fname"]))
	{
		$fnameArray = array("Chris");
		
		$_SESSION["Fname"] = $fnameArray;
	}
	
	if(!isset($_SESSION["Lname"]))
	{
		$lnameArray = array("Antolin");
		
		$_SESSION["Lname"] = $lnameArray;
	}

    if(!isset($_SESSION["EO"]))
    {
        $EOArray = array("No");

        $_SESSION["EO"] = $EOArray;
    }

	if(!isset($_SESSION["email"]))
	{
		$emailArray = array("cantolin@iupui.edu");
		
		$_SESSION["email"] = $emailArray;
	}
	
	if(!isset($_SESSION["phone"]))
	{
		$phoneArray = array("(765)465-1804");
		
		$_SESSION["phone"] = $phoneArray;
	}
	
	if(!isset($_SESSION["contact"]))
	{
		$contactArray = array("Trinidad Antolin");
		
		$_SESSION["contact"] = $contactArray;
	}
	
	if(!isset($_SESSION["cPhone"]))
	{
		$cPhoneArray = array("(765)465-0134");
		
		$_SESSION["cPhone"] = $cPhoneArray;
	}
	
	if(!isset($_SESSION["website"]))
	{
		$websiteArray = array("cs.iupui.edu/~cantolin");
		
		$_SESSION["website"] = $websiteArray;
	}
	
	if(!isset($_SESSION["notes"]))
	{
		$notesArray = array("test Entry");
		
		$_SESSION["notes"] = $notesArray;
	}

    if(!isset($_SESSION["cUsername"]))
    {
        $cUsernameArray = array("testUser");

        $_SESSION["cUsername"] = $cUsernameArray;
    }

    if(!isset($_SESSION["cPassword"]))
    {
        $cPasswordArray = array("testPass");

        $_SESSION["cPassword"] = $cPasswordArray;
    }

	require_once "util/function.php";
    require_once "dbconnect.php";
?>
<!DOCTYPE html>

<!--
    Filename: addorders.html
    Written by: Chris Antolin 
    Purpose: Orders Prototype for Aegis Appraisals
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
			
			<h2>Add new Client</h2>
			
			<?php
				$error = "";
				//check if the form is made
				if(isset($_POST['SubButton']))
				{
			
					
					//set up our variables
					$newFname = "";
					$newLname = "";
					$newJobTitle = "";
					$newPassword = "";
					$newEmail = "";
					$newPermissions = "";


					//set up our booleans for the items
					$emailcheck = false;
					$namescheck = false;

					$newFname = trim($_POST['myFname']);
					$newLname = trim($_POST['myLname']);
					$newJobTitle = $_POST['JobTitle'];
					$newPassword = trim($_POST['myPass']);
					$newEmail = trim(filter_input(INPUT_POST, 'myEmail'));
					$newPermissions = trim($_POST['myPerm']);

					//check for empty first name/company name
					if(emptyTest($newFname))
					{
						$namescheck = true;
					}
					else
					{
						$error = $error . "First Name Required!";
					}

					//check email
					if(emailCheck($newEmail))
					{
						$emailcheck = true;
					}

					else
					{
						$error = $error . "Invalid Email.";
					}

					if($emailcheck == true && $namescheck == true)
					{
                        //insert into database
                        $sql = "INSERT INTO Aegis_Employee (FirstName, LastName, JobTitle, Password, Email, Permissions) VALUES('".$newFname."','".$newLname."','".$newJobTitle."','".$newPassword."','".$newEmail."','".$newPermissions."')";

                        $result = mysqli_query($con, $sql) or die("Error in the consult.." . mysqli_error($con)); //send the query to the database or quit if cannot connect

                        //add our elements to the the respective arrays
						//initialize variables
						$index = 0;
						//fname first
						$index = count($_SESSION['Fname']); // should give us the next available index to use
						$_SESSION['Fname'][$index] = $newFname;
						
						//lname
						$index = count($_SESSION['Lname']); // should give us the next available index to use
						$_SESSION['Lname'][$index] = $newLname;

                        //JobTitle
						$index = count($_SESSION['JobTitle']); // should give us the next available index to use
						$_SESSION['JobTitle'][$index] = $newJobTitle;
						
						//password
						$index = count($_SESSION['password']); // should give us the next available index to use
						$_SESSION['password'][$index] = $newPassword;

						//email
						$index = count($_SESSION['email']); // should give us the next available index to use
						$_SESSION['email'][$index] = $newEmail;

						//permissions
						$index = count($_SESSION['perm']); // should give us the next available index to use
						$_SESSION['perm'][$index] = $newPermissions;
					}
					
				}
			?>
			
			<form method = "post" action = "addEmployee.php">
				<?php
					print $error;
				?>			
				<h3>New Employee</h3>	
				<h3>All required fields marked with asterisk (*)</h3>
				
				<label for = "myFname">*First Name:</label>
				<input name = "myFname" id = "myFname">
				<br/>
				
				<label for = "myLname">Last Name: </label>
				<input name = "myLname" id = "myLname">
				<br/>

				<label for = "JobTitle">Job Title: </label>
				<input name = "JobTitle" id = "JobTitle" value = <?php echo "'". $row["JobTitle"] . "'" ?>>
				<br/>

				<label for = "myPass">*Password:</label>
				<input name = "myPass" id = "myPass" value = <?php echo "'". $row["Password"] . "'" ?>>
				<br/>

				<label for = "myEmail">*Email:</label>
				<input name = "myEmail" type = "email" id = "myEmail"  value = <?php echo "'". $row["Email"] . "'" ?>>
				<br/>

				<label for = "myPerm">Permissions:</label>
				<input name = "myPerm" id = "myPerm"  value = <?php echo "'". $row["Permissions"] . "'" ?>>
				<br/>
				
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