<?php
session_start();

require_once "util/function.php";
require_once "dbconnect.php";

if (!isset($_SESSION['resetUser'])||$_SESSION['resetUser']=="")
{
    $_SESSION['resetUser'] = $_GET["user"];
}

if(!isset($_GET["user"])||!isset($_GET["reset"]))
{
    $_GET["user"] = "";
    $_GET["reset"] = "";
}
?>
<!DOCTYPE html>

<!--
    Filename: reset.php
    Written by: Denver Huynh
    Purpose: Password Reset Prototype for Aegis Appraisals
    Date Created: 11/8/15
    Modification History:
    Last Modified:

-->

<!-- Note: Make sure you use the Save as and not overwrite this original file! -->


<html lang="en">
<head>

    <meta  charset="utf-8" />
    <!-- This will house all the needed CSS and JavaScript -->
    <link rel = "stylesheet" type = "text/css" href = "proto.css">

    <script>
        function checkPass() {
            if (document.getElementById("pass").value.length == 0 || document.getElementById("passConfirm").value.length ==0) {
                document.getElementById("btn").disabled = true;
            }
            else
            {
                if (document.getElementById("pass").value == document.getElementById("passConfirm").value)
                {
                    document.getElementById("btn").disabled = false;
                }
                else
                {
                    document.getElementById("btn").disabled = true;
                }
            }
        }
    </script>

    <title>Reset Password</title>
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
        <h2>New Password</h2>

        <?php
        $mess = "";


        if(isset($_POST['SubButton']))
        {
            $password = trim(filter_input(INPUT_POST, "pass"));
            $passwordConfirm = trim(filter_input(INPUT_POST, "passConfirm"));

            $userNameIn = trim($_SESSION['resetUser']);

            $userNameIn = mysqli_real_escape_string($con,$userNameIn);

            if ($password=="")
                $mess = $mess . "Please enter a valid password.<br/>";
            else
                if ($password != $passwordConfirm)
                    $mess = $mess . "Password does not match.<br/>";

            if ($mess == "") {
                $sql = "UPDATE `Aegis_Employee` SET `Password`='". sha1($password) ."'WHERE sha1(`Email`) = '".$userNameIn."'";
                $result = mysqli_query($con, $sql) or die("Error in the consult.." . mysqli_error($con)); //send the query to the database or quit if cannot connect

                $sql = "SELECT `Email` FROM `Aegis_Employee` WHERE sha1(`Email`) = '".$userNameIn."'";
                $result = mysqli_query($con, $sql) or die("Error in the consult.." . mysqli_error($con)); //send the query to the database or quit if cannot connect
                $row = $result->fetch_assoc();

                $_SESSION['username'] = $row["Email"];
                header("Location: index.php");
            }
        }

        $mess = "<h3>" . $mess . "</h3>";

        ?>

        <form method = "post" action = "reset.php">
            <?php
            $count = 0;
            //check if the username and password exists in the database
            $sql = "Call SP_COUNT_Aegis_EmployeeHashed('".$_GET["user"]."', '". $_GET["reset"]."',@count);select @count as c";
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
            if ($count == 1)
            {
                print "
                    <br>
                    <p id='msg'></p>
                    <br>
                    <label>New Password:</label>
                    <input type = 'password' name = 'pass' id = 'pass' value = '' onkeyup='checkPass()'>
                    <br/>
                    <br>
                    <label>Confirm New Password:</label>
                    <input type = 'password' name = 'passConfirm' id = 'passConfirm' value = '' onkeyup='checkPass()'>
                    <br/>
                    <br>
                    <input type = 'submit' value = 'Change Password' style = 'margin-left: 60px;' name = 'SubButton' id='btn' disabled>
                    <br>
                    <br>";
            }
            else
            {
                $mess = "<h3><br>Link expired<br><br></h3>";
            }

            print $mess;
            ?>
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