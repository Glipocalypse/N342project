<?php
	session_start();

	require_once "util/function.php";
    require_once "dbconnect.php";
	if(!isset($_SESSION['username'])) {
		header("Location: index.php");
    }
	$intOrd = $_GET["intOrd"];
?>
<!DOCTYPE html>

<!--
    Filename: updateorders.html
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
			
			<h2>Update Order <?php echo $intOrd ?></h2>
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
                    if ($intOrd!=$newION)
                    {
                        $sql = "select count(*) as c from Aegis_Order where `InternalOrder#` ='" . $newION . "'";
                        $result = mysqli_query($con, $sql) or die("Error in the consult.." . mysqli_error($con)); //send the query to the database or quit if cannot connect
                        $count = 0;
                        $field = mysqli_fetch_object($result); //the query results are objects, in this case, one object
                        $count = $field->c;

                        //if address does not yet exist
                        if ($count != 0) {
                            $requiredCheck = false;
                            $error = $error . "There is already an order with this internal order number.";
                        }
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
                    $sql = "UPDATE `Aegis_Order` SET `InternalOrder#`='".$newION."',`ClientOrder#`='".$newCON."',`Loan#`='".$newLN."',`FHAVA#`='".$newFHA."',`OrderType`='".$newOType."',`AddressID`='".$row["AddressID"]."',`DateAccepted`='".$newdateAcc."',`DateDue`='".$newdateDue."',`BorrowerName`='".$newborrow."',`Notes`='".$newnotes."',`Client#`='".$newClient."',`Fee`='".$newFee."',`InspectionDate`='".$newINS."',`InspectionTime`='".$newINTime."',`Employee#`='".$newEmN."',`StatusID`='".$newStat."' WHERE `InternalOrder#` ='". $intOrd . "'";
                    $result = mysqli_query($con, $sql) or die("Error in the consult.." . mysqli_error($con)); //send the query to the database or quit if cannot connect

                    Header("Location: orders.php"); //where we go after we get this working

                }

            }

            $error = "<h3>" . $error . "</h3>";
			?>
			
			<form method = "post" action = "deleteOrder.php"><!--Edit the url here-->
				<h3>If Order is to be deleted from records, click the button below</h3>
				<input type = "submit" value = "Delete Order">
			</form>
			
			<form method = "post" action = "">
			
				<?php
					print $error;
					$sql = "SELECT `ClientOrder#`, `Loan#`, `FHAVA#`, `OrderType`, `AddressID`, `DateAccepted`, `DateDue`, `BorrowerName`, `Notes`, `Client#`, `Fee`, `InspectionDate`, `InspectionTime`, `Employee#`, `StatusID` FROM `Aegis_Order` WHERE `InternalOrder#` = '" . $intOrd . "'";
					$result = mysqli_query($con, $sql) or die("Error in the consult.." . mysqli_error($con)); //send the query to the database or quit if cannot connect
                    $row = $result->fetch_array(MYSQLI_ASSOC)
				?>
                <h3>All required fields marked with asterisk (*)</h3>
                <h3>Insert Data to be changed (empty fields will not update)</h3>

                <br/>
				<label for = "myION">*Internal Order Number: </label>
                <input name = "myION" id = "myION" value = <?php echo "'". $intOrd . "'" ?>>
				<br/>

				
				<label for = "myCON">Client Order Number: </label>
				<input name = "myCON" id = "myCON" value = <?php echo "'". $row["ClientOrder#"] . "'" ?>>
				<br/>
				
				<label for = "myLN">Loan Number:</label>
				<input name = "myLN" id = "myLN" value = <?php echo "'" . $row["Loan#"] . "'"?>>
				<br/>
				
				<label for = "myFHA">FHA/VA Number:</label>
				<input name = "myFHA" id = "myFHA" size = 10 value = <?php echo "'" . $row["FHAVA#"] . "'"?>>
				<br/>
				
				<label>Order Type:</label>
				<select name = "orderType">
					<option <?php  if("first" == $row["OrderType"]){echo "selected='selected' ";}?> value = "first" selected = "selected">Type 1</option>
					<option <?php  if("second" == $row["OrderType"]){echo "selected='selected' ";}?> value = "second">Type 2</option>
					<option <?php  if("third" == $row["OrderType"]){echo "selected='selected' ";}?> value = "third">Type 3</option>
					<option <?php  if("fourth" == $row["OrderType"]){echo "selected='selected' ";}?> value = "fourth">Type 4</option>
				</select>
				<br/>

                <?php
                $sql = "SELECT `Street`, `City`, `State`, `Zip` FROM `Aegis_Address` WHERE `AddressID` = '" . $row["AddressID"] . "'";
                $addrResult = mysqli_query($con, $sql) or die("Error in the consult.." . mysqli_error($con)); //send the query to the database or quit if cannot connect
                $addrRow = $addrResult->fetch_array(MYSQLI_ASSOC)
                ?>

                <label for = "myStreet">Street:</label>
                <input name = "myStreet" id = "myStreet" value = <?php echo "'" . $addrRow["Street"] . "'"?> >
                <br/>

                <label for = "myCity">City:</label>
                <input name = "myCity" id = "myCity" value = <?php echo "'" . $addrRow["City"] . "'"?> >
                <br/>

                <label for = "myState">State:</label>
                <?php $states = statesList(); ?>
                <select name = "myState" id = "myState">
                    <?php foreach($states as $key=>$value) { ?>
                        <option <?php  if($key == $addrRow["State"]){echo "selected='selected' ";}?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                    <?php } ?>
                </select>
                <br/>

                <label for = "myZip">Zip:</label>
                <input name = "myZip" id = "myZip" value = <?php echo "'" . $addrRow["Zip"] . "'"?> >
                <br/>

                <label for = "myAcc">Date Accepted:</label>
				<input name = "myAcc" type = "date" id = "myAcc" value = <?php echo "'" . $row["DateAccepted"] . "'"?>>
				<br/>
				
				<label for = "myDue">Date Due:</label>
				<input name = "myDue" type = "date" id = "myDue" value = <?php echo "'" . $row["DateDue"] . "'"?>>
				<br/>
				
				<label for = "myborrow">Borrower Name:</label>
				<input name = "myborrow" id = "myborrow" value = <?php echo "'" . $row["BorrowerName"] . "'"?>>
				<br/>
				
				<label for = "myNotes">Notes:</label>
				<textarea name = "myNotes" rows = "10" cols = "100">
				    <?php echo $row["Notes"]?>
				</textarea>
				<br/>

                <label for = "myClient">*Client:</label>
                <?php
                $sql = "SELECT `Client#`, FirstName, LastName from Aegis_Client order by FirstName";
                $clientResult = mysqli_query($con, $sql) or die("Error in the consult.." . mysqli_error($con)); //send the query to the database or quit if cannot connect
                ?>
                <select name = "myClient" id = "myClient">
                    <?php while ($clientRow = $clientResult->fetch_assoc()) {?>
                        <option <?php  if($row["Client#"] == $clientRow["Client#"]){echo "selected='selected' ";}?> value="<?php echo $clientRow["Client#"]; ?>"><?php echo $clientRow["FirstName"]." ".$clientRow["LastName"]; ?></option>
                    <?php } ?>
                </select>
                <br/>
				
				<label for = "myFee">Fee Amount:</label>
				<input name = "myFee" id = "myFee" value = <?php echo "'" . $row["Fee"] . "'"?>>
				<br/>

                <label for = "myINS">Inspection Date:</label>
                <input name = "myINS" id = "myINS" type = "date" value = <?php echo "'". $row["InspectionDate"] . "'"?>>
                <br/>

                <label for = "myINTime">Inspection Time:</label>
                <input name = "myINTime" id = "myINTime" type = "time" value = <?php echo "'" . $row["InspectionTime"] . "'"?>>
                <br/>

                <label for = "myEmN">Employee:</label>
                <?php
                $sql = "SELECT `Employee#`, FirstName, LastName from Aegis_Employee order by FirstName";
                $empResult = mysqli_query($con, $sql) or die("Error in the consult.." . mysqli_error($con)); //send the query to the database or quit if cannot connect
                ?>
                <select name = "myEmN" id = "myEmN">
                    <?php while ($empRow = $empResult->fetch_assoc()) {?>
                        <option <?php  if($row["Employee#"] == $empRow["Employee#"]){echo "selected='selected' ";}?> value="<?php echo $empRow["Employee#"]; ?>"><?php echo $empRow["FirstName"]." ".$empRow["LastName"]; ?></option>
                    <?php } ?>
                </select>
                <br/>

                <label for = "myStat">Status:</label>
                <?php
                $sql = "SELECT `StatusID`, Value from Aegis_Status";
                $statusResult = mysqli_query($con, $sql) or die("Error in the consult.." . mysqli_error($con)); //send the query to the database or quit if cannot connect
                ?>
                <select name = "myStat" id = "myStat">
                    <?php while ($statusRow = $statusResult->fetch_assoc()) {?>
                        <option <?php  if($row["StatusID"] == $statusRow["StatusID"]){echo "selected='selected' ";}?> value="<?php echo $statusRow["StatusID"]; ?>"><?php echo $statusRow["Value"]; ?></option>
                    <?php } ?>
                </select>
				<br/>
				<br/>
				
				<!--Submit Button-->
				<div id = "subButton">
					<input name = "SubButton" type = "submit" value = "Update Event">
				</div>
				
			</form>
			
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