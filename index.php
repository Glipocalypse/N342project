<?php
	session_start();

	//destroy session if one exists
	//will only destroy once the user has logged in!
	if(isset($_SESSION["username"]))
	{
		//destroy session
		session_destroy();
	}
	
	require_once "util/function.php";
	require_once "dbconnect.php";
?>
<!DOCTYPE html>

<!--
    Filename: index.html
    Written by: Chris Antolin 
    Purpose: Home Prototype for Aegis Appraisals
    Date Created: 9/27/15
    Modification History: Denver Huynh - Connect to database
    Last Modified: 10/19/15
	
-->

<!-- Note: Make sure you use the Save as and not overwrite this original file! -->


<html lang="en">
<head>

	<meta  charset="utf-8" />
	<!-- This will house all the needed CSS and JavaScript -->
	<link rel = "stylesheet" type = "text/css" href = "proto.css">
	
	<title>Aegis Appraisals Database:: Main Page</title>	
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
					<a href = "index.php">Sign In</a>
				</li>
			</ul>
		</nav>
		
		<div id = "content">
			<h2>Welcome User, Please Log in for more information!</h2>
			
			<?php
				$mess = "";
				
				
				if(isset($_POST['SubButton']))
				{
					if(!isset($_SESSION["count"]))
					{
						$_SESSION["count"] = 0;
					}
					
					if($_SESSION["count"] != 3)
					{
						$_SESSION["count"] = $_SESSION["count"] + 1;
					}
					
					$userNameIn = trim($_POST['myUname']);
					$pwdIn = trim($_POST['myPass']);
					
					if($_SESSION["count"] < 3) //allows us to prevent action
					{
                        $userNameIn = mysqli_real_escape_string($con,$userNameIn);
                        $pwdIn = mysqli_real_escape_string($con,$pwdIn);

                        //now veriy the username and password
                        if (emailcheck($userNameIn)) //if the email is not a valid format, don't need to continue at all
                        {
                            $count = 0;
                            //check if the username and password exists in the database
                            $sql = "Call SP_COUNT_Aegis_Employee('".$userNameIn."', '".$pwdIn."',@count);select @count as c";
                            if (mysqli_multi_query($con,$sql))
                            {
                                do
                                {
                                    // Store first result set
                                    if ($result=mysqli_store_result($con))
                                    {
                                        // Fetch one and one row
                                        while ($row=mysqli_fetch_row($result))
                                        {
                                            $count= $row[0];  //the second result is the count. It overwrites the first $count value.
                                        }
                                        // Free result set
                                        mysqli_free_result($result);
                                    }
                                }
                                while (mysqli_next_result($con));
                            }
                            if ($count == 1) {
                                $_SESSION['username'] = $userNameIn;
                                $_SESSION["count"] = 0; //resets the counter

                                $sql = "select Permissions from Aegis_Employee where email = '" . $userNameIn. "' and password = '".$pwdIn."'";
                                $result = mysqli_query($con, $sql) or die("Error in the consult.." . mysqli_error($con)); //send the query to the database or quit if cannot connect
                                $field = mysqli_fetch_object($result); //the query results are objects, in this case, one object

                                $_SESSION["permissions"] = $field->Permissions;
                                print "Login Successful!";
                                Header("Location: dashboard.php"); //where we go after we get this working
                            } else {

                                $mess = $mess . "The information entered is incorrect.";
                                $mess = $mess . "You have used up " . $_SESSION["count"] . "/3 tries.";
                            }
                        }
					}
					
					else
					{
						$mess = $mess . "You have reached the maximum allowed tries. Please contact your admin...if you are the admin, What...were you thinking?";
					}
				}
				
				$mess = "<h3>" . $mess . "</h3>";
			
			?>
			
			<form method = "post" action = "index.php">
				<?php 
					print $mess;
				?>
				<label>UserName:</label>
				<input name = "myUname" id = "myUname" value = "sfrankeny@gmail.com">
				<br/>
				
				<label>Password:</label>
				<input name = "myPass" id = "myPass" type = "password" value = "Aegis">
				<br/>
				
				<input type = "submit" value = "Login" style = "margin-left: 60px;" name = "SubButton">
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