<?php
	session_start();

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
			<h2>Add new Order</h2>
			
			<?php
				$error = "";
			
				//check if the form is made
				if(isset($_POST['SubButton']))
				{
					//set up our booleans for the items 
					$requiredCheck = false;
					
					$newION = trim($_POST['myION']);
					$newCON = trim($_POST['myCON']);
					$newLN = trim($_POST['myLN']);
					$newFHA = trim($_POST['myFHA']);
					$newOType = trim($_POST['orderType']);					
					$newStreet = trim($_POST['myStreet']);
                    $newCity = trim($_POST['myCity']);
                    $newState = trim($_POST['myState']);
                    $newZip = trim($_POST['myZip']);
					$newdateAcc = trim($_POST['myAcc']);
					$newdateDue = trim($_POST['myDue']);
					$newborrow = trim($_POST['myborrow']);
					$newnotes = trim($_POST['myNotes']);
					$newClient = trim($_POST['myClient']);
					$newFee = trim($_POST['myFee']);
					$newINS = trim($_POST['myINS']);
                    $newINTime = trim($_POST['myINTime']);
					$newEmN = trim($_POST['myEmN']);
					$newStat = trim($_POST['myStat']);
					
					
					
					//check for empty first name/company name
					if(emptyTest($newION) && emptyTest($newCON) && emptyTest($newOType) && emptyTest($newStreet) && emptyTest($newCity) && emptyTest($newState) && emptyTest($newZip) && emptyTest($newdateAcc) && emptyTest($newdateDue) && emptyTest($newborrow) && emptyTest($newClient) && emptyTest ($newFee))
					{
						$requiredCheck = true;
                        $sql = "select count(*) as c from Aegis_Order where `InternalOrder#` ='" . $newION . "'";
                        $result = mysqli_query($con, $sql) or die("Error in the consult.." . mysqli_error($con)); //send the query to the database or quit if cannot connect
                        $count = 0;
                        $field = mysqli_fetch_object($result); //the query results are objects, in this case, one object
                        $count = $field->c;

                        //if address does not yet exist
                        if($count!=0)
                        {
                            $requiredCheck = false;
                            $error = $error . "There is already an order with this internal order number.";
                        }
					}
					else
					{
						$error = $error . "Check your required fields!";
					}
					
					if($requiredCheck)
					{
                        //check for preexisting address
						$sql = "select count(*) as c from Aegis_Address where Street = '" . $newStreet. "' and City = '".$newCity."' and State = '".$newState."' and Zip = '".$newZip."'";
						$result = mysqli_query($con, $sql) or die("Error in the consult.." . mysqli_error($con)); //send the query to the database or quit if cannot connect
						$count = 0;
						$field = mysqli_fetch_object($result); //the query results are objects, in this case, one object
						$count = $field->c;

                        //if address does not yet exist
                        if($count==0)
                        {
                            //insert into database
                            $sql = "INSERT INTO Aegis_Address (Street, City, State, Zip) VALUES('" . $newStreet . "','" . $newCity . "','" . $newState . "','" . $newZip . "')";
                            $result = mysqli_query($con, $sql) or die("Error in the consult.." . mysqli_error($con)); //send the query to the database or quit if cannot connect
                        }

                        //find addressID of given address
                        $sql = "SELECT AddressID FROM Aegis_Address WHERE Street = '" . $newStreet. "' and City = '".$newCity."' and State = '".$newState."' and Zip = '".$newZip."'";
                        $result = mysqli_query($con, $sql) or die("Error in the consult.." . mysqli_error($con)); //send the query to the database or quit if cannot connect
                        $row = $result->fetch_assoc();

                        //insert order into database
                        $sql = "INSERT INTO Aegis_Order VALUES('".$newION."','".$newCON."','".$newLN."','".$newFHA."','".$newOType."','".$row[AddressID]."','".$newdateAcc."','".$newdateDue."','".$newborrow."','".$newnotes."','".$newClient."','".$newFee."','".$newINS."','".$newINTime."','".$newEmN."','".$newStat."')";
                        $result = mysqli_query($con, $sql) or die("Error in the consult.." . mysqli_error($con)); //send the query to the database or quit if cannot connect

                        //add our elements to the the respective arrays
						//initialize variables
						$index = 0;
						//orderNumber first
						$index = count($_SESSION['ion']); // should give us the next available index to use
						$_SESSION['ion'][$index] = $newION;
						
						//ordertype
						$index = count($_SESSION['ordertype']); // should give us the next available index to use
						$_SESSION['ordertype'][$index] = $newOType;
					
					
						//address
						$index = count($_SESSION['street']); // should give us the next available index to use
						$_SESSION['street'][$index] = $newStreet;

                        $index = count($_SESSION['city']); // should give us the next available index to use
                        $_SESSION['city'][$index] = $newCity;

                        $index = count($_SESSION['state']); // should give us the next available index to use
                        $_SESSION['state'][$index] = $newState;

                        $index = count($_SESSION['zip']); // should give us the next available index to use
                        $_SESSION['zip'][$index] = $newZip;

						//date accepted
						$index = count($_SESSION['d_acc']); // should give us the next available index to use
						$_SESSION['d_acc'][$index] = $newdateAcc;
						
						//date due
						$index = count($_SESSION['d_due']); // should give us the next available index to use
						$_SESSION['d_due'][$index] = $newdateDue;
						
						//Fee
						$index = count($_SESSION['fee']); // should give us the next available index to use
						$_SESSION['fee'][$index] = $newFee;

						Header("Location: orders.php"); //where we go after we get this working
						
					}
					
				}
				
				$error = "<h3>" . $error . "</h3>";
			?>
			
			<form method = "post" action = "">
				<?php
					print $error;
				?>	
			
				<h3>All required fields marked with asterisk (*)</h3>
				
				<label for = "myION">*Internal Order Number:</label>
				<input name = "myION" id = "myION">
				<br/>
				
				<label for = "myCON">*Client Order Number: </label>
				<input name = "myCON" id = "myCON">
				<br/>
				
				<label for = "myLN">Loan Number:</label>
				<input name = "myLN" id = "myLN" >
				<br/>
				
				<label for = "myFHA">FHA/VA Number:</label>
				<input name = "myFHA" id = "myFHA" size = 10>
				<br/>
				
				<label>*Order Type:</label>
				<select name = "orderType">
					<option value = "" selected = "selected"></option>
					<option value = "Type A">Type A</option>
					<option value = "Type B">Type B</option>
					<option value = "Type C">Type C</option>
					<option value = "Type D">Type D</option>					
				</select>
				<br/>
				
				<label for = "myStreet">*Street:</label>
				<input name = "myStreet" id = "myStreet">
				<br/>

				<label for = "myCity">*City:</label>
				<input name = "myCity" id = "myCity">
				<br/>

                <label for = "myState">*State:</label>
                <?php $states = statesList(); ?>
                <select name = "myState" id = "myState">
                    <option selected="selected" value="TX">Texas</option>
                    <?php foreach($states as $key=>$value) { ?>
                        <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                    <?php } ?>
                </select>
                <br/>

                <label for = "myZip">*Zip:</label>
                <input name = "myZip" id = "myZip">
                <br/>

				<label for = "myAcc">*Date Accepted:</label>
				<input name = "myAcc" type = "date" id = "myAcc">
				<br/>
				
				<label for = "myDue">*Date Due:</label>
				<input name = "myDue" type = "date" id = "myDue">
				<br/>

				<label for = "myborrow">*Borrower Name:</label>
				<input name = "myborrow" id = "myborrow">
				<br/>
				
				<label for = "myNotes">Notes:</label>
				<textarea rows = "10" cols = "100" name = "myNotes">
				
				</textarea>
				<br/>

                <label for = "myClient">*Client:</label>
                <?php
                    $sql = "SELECT `Client#`, FirstName, LastName from Aegis_Client order by FirstName";
                    $result = mysqli_query($con, $sql) or die("Error in the consult.." . mysqli_error($con)); //send the query to the database or quit if cannot connect
                ?>
                    <select name = "myClient" id = "myClient">
                    <?php while ($row = $result->fetch_assoc()) {?>
                        <option value="<?php echo $row["Client#"]; ?>"><?php echo $row["Client#"]." ".$row["FirstName"]." ".$row["LastName"]; ?></option>
                    <?php } ?>
                </select>
                <br/>

				<label for = "myFee">*Fee Amount:</label>
				<input name = "myFee" id = "myFee">
				<br/>
				
				<label for = "myINS">Inspection Date:</label>
				<input name = "myINS" id = "myINS" type = "date">
				<br/>

                <label for = "myINTime">Inspection Time:</label>
                <input name = "myINTime" id = "myINTime" type = "time" value="01:00">
                <br/>

                <label for = "myEmN">Employee:</label>
                <?php
                $sql = "SELECT `Employee#`, FirstName, LastName from Aegis_Employee order by FirstName";
                $result = mysqli_query($con, $sql) or die("Error in the consult.." . mysqli_error($con)); //send the query to the database or quit if cannot connect
                ?>
                <select name = "myEmN" id = "myEmN">
                    <?php while ($row = $result->fetch_assoc()) {?>
                        <option value="<?php echo $row["Employee#"]; ?>"><?php echo $row["FirstName"]." ".$row["LastName"]; ?></option>
                    <?php } ?>
                </select>
                <br/>

                <label for = "myStat">Status:</label>
                <?php
                $sql = "SELECT `StatusID`, Value from Aegis_Status";
                $result = mysqli_query($con, $sql) or die("Error in the consult.." . mysqli_error($con)); //send the query to the database or quit if cannot connect
                ?>
                <select name = "myStat" id = "myStat">
                    <?php while ($row = $result->fetch_assoc()) {?>
                        <option value="<?php echo $row["StatusID"]; ?>"><?php echo $row["Value"]; ?></option>
                    <?php } ?>
                </select>
                <br/>
                <br/>

				<!--Submit Button-->
				<div id = "subButton">
					<input name = "SubButton" type = "submit" value = "Add Order">
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