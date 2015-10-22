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
			
			<h2>Add new Client</h2>
			
			<?php
				$error = "";
				//check if the form is made
				if(isset($_POST['SubButton']))
				{
			
					
					//set up our variables
					$newFname = "";
					$newLname = "";
                    $newEO = "";
					$newPhone = "";
					$newCperson = "";
					$newCPhone = "";					
					$newEmail = "";
					$newWebsite = "";
					$newNotes = "";
                    $newCUsername = "";
                    $newCPassword = "";
					
					
					//set up our booleans for the items 
					$emailcheck = false;
					$namescheck = false;
					$telephonecheck = false;
					
					$newFname = trim($_POST['myFname']);
					$newLname = trim($_POST['myLname']);
                    $newEO = $_POST['EO'];
					$newPhone = trim($_POST['myPhone']);
					$newCperson = trim($_POST['myCperson']);
					$newCPhone = trim($_POST['myCphone']);					
					$newEmail = trim(filter_input(INPUT_POST, 'myEmail'));
					$newWebsite = trim($_POST['myWeb']);
					$newNotes = trim($_POST['myNotes']);
                    $newCUsername = trim($_POST['cUsername']);
                    $newCPassword = trim($_POST['cPassword']);

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
					
					
					if(phoneCheck($newPhone, 10))
					{
						$telephonecheck = true;
					}

					else
					{
						$error = $error . "Invalid Phone.";
					}
					
					if($emailcheck == true && $namescheck == true && $telephonecheck == true)
					{
                        //insert into database
                        $sql = "INSERT INTO Aegis_Client (FirstName, LastName, EandO, CompanyPhone, ContactPerson, ContactPhone, Email, WebsiteURL, Notes, CompanyUsername, CompanyPassword) VALUES('".$newFname."','".$newLname."','".$newEO."','".$newPhone."','".$newCperson."','".$newCPhone."','".$newEmail."','".$newWebsite."','".$newNotes."','".$newCUsername."','".$newCPassword."')";

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

                        //EO
                        $index = count($_SESSION['EO']); // should give us the next available index to use
                        $_SESSION['EO'][$index] = $newEO;
					
						//email
						$index = count($_SESSION['email']); // should give us the next available index to use
						$_SESSION['email'][$index] = $newEmail;
						
						
						//phone
						$index = count($_SESSION['phone']); // should give us the next available index to use
						$_SESSION['phone'][$index] = $newPhone;
						
						//Contact Person
						$index = count($_SESSION['contact']); // should give us the next available index to use
						$_SESSION['contact'][$index] = $newCperson;
						
						//Contact's Phone
						$index = count($_SESSION['cPhone']); // should give us the next available index to use
						$_SESSION['cPhone'][$index] = $newCPhone;
						
						//Website
						$index = count($_SESSION['website']); // should give us the next available index to use
						$_SESSION['website'][$index] = $newWebsite;
						
						//Notes
						$index = count($_SESSION['notes']); // should give us the next available index to use
						$_SESSION['notes'][$index] = $newNotes;

                        //Company Username
                        $index = count($_SESSION['cUsername']); // should give us the next available index to use
                        $_SESSION['cUsername'][$index] = $newCUsername;

                        //Company Password
                        $index = count($_SESSION['cPassword']); // should give us the next available index to use
                        $_SESSION['cPassword'][$index] = $newCPassword;
					}
					
				}
			?>
			
			<form method = "post" action = "addClient.php">
				<?php
					print $error;
				?>			
				<h3>New Client</h3>	
				<h3>All required fields marked with asterisk (*)</h3>
				<h3>Company Fields only marked with dual asterisk (**)</h3>
				
				<label for = "myFname">*First Name (**Company Name):</label>
				<input name = "myFname" id = "myFname">
				<br/>
				
				<label for = "myLname">Last Name: </label>
				<input name = "myLname" id = "myLname">
				<br/>

				<label for = "EO">E and O: </label>
                <input type="radio" name="EO" value="Yes">Yes
                <input type="radio" name="EO" value="No" checked>No
				<br/>

				<label for = "myPhone">*Phone:</label>
				<input name = "myPhone" type = "tel" id = "myPhone">
				<br/>
				
				<label for = "myCperson">**Contact Person:</label>
				<input name = "myCperson" id = "myCperson" size = 10>
				<br/>
				
				<label for = "myCphone">**Contact Phone:</label>
				<input name = "myCphone" type = "tel" id = "myCphone">
				<br/>
				
				<label for = "myEmail">*Email:</label>
				<input name = "myEmail" type = "email" id = "myEmail">
				<br/>
				
				<label for = "myWeb">Website:</label>
				<input name = "myWeb" id = "myWeb">
				<br/>

                <label for = "cUsername">Company Username:</label>
                <input name = "cUsername" id = "cUsername">
                <br/>

                <label for = "cPassword">Company Password:</label>
                <input name = "cPassword" type = "password" id = "cPassword">
                <br/>

				<label for = "myNotes">Notes:</label>
				<textarea rows = "10" cols = "100" name = "myNotes">
				
				</textarea>
				<br/>
				
				<!--Submit Button-->
				<div id = "subButton">
					<input name = "SubButton" type = "submit" value = "Add Client">
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