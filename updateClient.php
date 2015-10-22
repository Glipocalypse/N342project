<?php
session_start();
require_once "util/function.php";
require_once "dbconnect.php";
    if(!isset($_SESSION['username'])) {
		header("Location: index.php");
    }
$clientNum = $_GET["clientNum"];
?>
<!DOCTYPE html>

<!--
    Filename: updateClient.php
    Written by: Denver Huynh
    Purpose: Update Client Prototype for Aegis Appraisals
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

    <title>Aegis Appraisals Database:: Client Page</title>
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
        <h2>Client</h2>

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
                //update database
                $sql = "UPDATE `Aegis_Client` SET `FirstName`='".$newFname."',`LastName`='".$newLname."',`EandO`='".$newEO."',`CompanyPhone`='".$newCPhone."',`ContactPerson`='".$newCperson."',`ContactPhone`='".$newCPhone."',`Email`='".$newEmail."',`WebsiteURL`='".$newWebsite."',`Notes`='".$newNotes."',`CompanyUsername`='".$newCUsername."',`CompanyPassword`='".$newCPassword."' WHERE `Client#` ='" . $clientNum . "'";
                $result = mysqli_query($con, $sql) or die("Error in the consult.." . mysqli_error($con)); //send the query to the database or quit if cannot connect

                Header("Location: clients.php"); //where we go after we get this working
            }

        }
        else if(isset($_POST['deleteBtn']))
        {
            $sql = "DELETE FROM `Aegis_Client` WHERE `Client#` = '" . $clientNum . "'";
            $result = mysqli_query($con, $sql) or die("Error in the consult.." . mysqli_error($con)); //send the query to the database or quit if cannot connect

            Header("Location: clients.php"); //where we go after we get this working
        }
        ?>
		
        <form method = "post" action = "">
            <?php
            print $error;
            $sql = "SELECT `FirstName`, `LastName`, `EandO`, `CompanyPhone`, `ContactPerson`, `ContactPhone`, `Email`, `WebsiteURL`, `Notes`, `CompanyUsername`, `CompanyPassword` FROM `Aegis_Client` WHERE `Client#` = '" . $clientNum . "'";
            $result = mysqli_query($con, $sql) or die("Error in the consult.." . mysqli_error($con)); //send the query to the database or quit if cannot connect
            $row = $result->fetch_array(MYSQLI_ASSOC)
            ?>
            <h3>Update Client</h3>
            <h3>All required fields marked with asterisk (*)</h3>
            <h3>Company Fields only marked with dual asterisk (**)</h3>

            <label for = "myFname">*First Name (**Company Name):</label>
            <input name = "myFname" id = "myFname" value = <?php echo "'". $row["FirstName"] . "'" ?>>
            <br/>

            <label for = "myLname">Last Name: </label>
            <input name = "myLname" id = "myLname" value = <?php echo "'". $row["LastName"] . "'" ?>>
            <br/>

            <label for = "EO">E and O: </label>
            <input type="radio" name="EO" value="Yes" <?php if($row["EandO"] == "Yes") {echo "checked";} ?>>Yes
            <input type="radio" name="EO" value="No" <?php if($row["EandO"] == "No") {echo "checked";} ?>>No
            <br/>

            <label for = "myPhone">*Phone:</label>
            <input name = "myPhone" type = "tel" id = "myPhone" value = <?php echo "'". $row["CompanyPhone"] . "'" ?>>
            <br/>

            <label for = "myCperson">**Contact Person:</label>
            <input name = "myCperson" id = "myCperson" size = 10  value = <?php echo "'". $row["ContactPerson"] . "'" ?>>
            <br/>

            <label for = "myCphone">**Contact Phone:</label>
            <input name = "myCphone" type = "tel" id = "myCphone"  value = <?php echo "'". $row["ContactPhone"] . "'" ?>>
            <br/>

            <label for = "myEmail">*Email:</label>
            <input name = "myEmail" type = "email" id = "myEmail"  value = <?php echo "'". $row["Email"] . "'" ?>>
            <br/>

            <label for = "myWeb">Website:</label>
            <input name = "myWeb" id = "myWeb"  value = <?php echo "'". $row["WebsiteURL"] . "'" ?>>
            <br/>

            <label for = "cUsername">Company Username:</label>
            <input name = "cUsername" id = "cUsername"  value = <?php echo "'". $row["CompanyUsername"] . "'" ?>>
            <br/>

            <label for = "cPassword">Company Password:</label>
            <input name = "cPassword" type = "password" id = "cPassword"  value = <?php echo "'". $row["CompanyPassword"] . "'" ?>>
            <br/>

            <label for = "myNotes">Notes:</label>
				<textarea rows = "10" cols = "100" name = "myNotes">
				     <?php echo $row["Notes"]?>
				</textarea>
            <br/>

            <!--Submit Button-->
            <div id = "subButton">
                <input name = "SubButton" type = "submit" value = "Update Client">
            </div>

            <h3>If Client is to be deleted from records, click the button below</h3>
            <input name = "deleteBtn" type = "submit" value = "Delete Client">
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