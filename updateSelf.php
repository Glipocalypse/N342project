<?php
session_start();
require_once "util/function.php";
require_once "dbconnect.php";

if(!isset($_SESSION['username'])) {
    header("Location: index.php");
}

$sql = "SELECT `Employee#` FROM `Aegis_Employee` WHERE `Email` = '" . $_SESSION['username'] . "'";
$result = mysqli_query($con, $sql) or die("Error in the consult.." . mysqli_error($con)); //send the query to the database or quit if cannot connect

while ($row = $result->fetch_assoc())
{
    $employeeNum = $row["Employee#"];
}
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

    <title>Aegis Appraisals Database:: Employee Page</title>
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
        <h2>Employee</h2>

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
                //update employee in database
                $sql = "UPDATE `Aegis_Employee` SET `FirstName`='".$newfn."',`LastName`='".$newln."',`JobTitle`='".$newjT."',`Password`='".$newpass."',`Email`='".$newEmail."',`Permissions`='".$newPermissions."' WHERE `Employee#` ='" . $employeeNum . "'";
                $result = mysqli_query($con, $sql) or die("Error in the consult.." . mysqli_error($con)); //send the query to the database or quit if cannot connect

                Header("Location: dashboard.php"); //where we go after we get this working
            }
        }
        ?>

        <form method = "post" action = "">
            <?php
            print $error;
            $sql = "SELECT `FirstName`, `LastName`, `JobTitle`, `Password`, `Email`, `Permissions` FROM `Aegis_Employee` WHERE `Employee#` = '" . $employeeNum . "'";
            $result = mysqli_query($con, $sql) or die("Error in the consult.." . mysqli_error($con)); //send the query to the database or quit if cannot connect
            $row = $result->fetch_array(MYSQLI_ASSOC)
            ?>
            <h3>Update Profile</h3>
            <h3>All required fields marked with asterisk (*)</h3>

            <label for = "fn">*First Name:</label>
            <input name = "fn" id = "fn" value = <?php echo "'". $row["FirstName"] . "'" ?>>
            <br/>

            <label for = "ln">*Last Name: </label>
            <input name = "ln" id = "ln" value = <?php echo "'". $row["LastName"] . "'" ?>>
            <br/>

            <label for = "jobTitle">Job Title:</label>
            <input name = "jobTitle" id = "jobTitle"  value = <?php echo "'". $row["JobTitle"] . "'" ?>>
            <br/>

            <label for = "pass">*Password:</label>
            <input name = "pass" id = "pass" type = "password" value = <?php echo "'". $row["Password"] . "'" ?>>
            <br/>

            <label for = "email">*Email:</label>
            <input name = "email" id = "email" value = <?php echo "'". $row["Email"] . "'" ?>>
            <br/>

            <label for = "permission">*Permissions:</label>
            <select name = "permission">
                <?php  if("Owner" == $row["Permissions"]){echo "<option selected='selected' value = 'Owner'>Owner</option>";}?>
                <?php  if("Employee" == $row["Permissions"]){echo "<option selected='selected' value = 'Employee'>Employee</option>";}?>
            </select>
            <br/><br>

            <!--Submit Button-->
            <div id = "subButton">
                <input name = "SubButton" type = "submit" value = "Update Profile">
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