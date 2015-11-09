<?php
session_start();

require_once "util/function.php";
require_once "dbconnect.php";
?>
<!DOCTYPE html>

<!--
    Filename: forgotPassword.php
    Written by: Denver Huynh
    Purpose: Password Recovery Prototype for Aegis Appraisals
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

    <title>Forgotten Password</title>
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
        <h2>To reset your password, enter the email address you use to sign in.</h2>

        <?php
        $mess = "";


        if(isset($_POST['SubButton']))
        {
            $userNameIn = trim($_POST['myUname']);

            $userNameIn = mysqli_real_escape_string($con,$userNameIn);

            //now veriy the username and password
            if (emailcheck($userNameIn)) //if the email is not a valid format, don't need to continue at all
            {
                $count = 0;
                //check if the username and password exists in the database
                $sql = "Call SP_COUNT_Aegis_Email('".$userNameIn."',@count);select @count as c";
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
                    $sql = "SELECT `Password` FROM `Aegis_Employee` WHERE `Email` = '".$userNameIn."'";
                    $result = mysqli_query($con, $sql) or die("Error in the consult.." . mysqli_error($con)); //send the query to the database or quit if cannot connect
                    $row = $result->fetch_assoc();
                    $emailBody = "Click here to reset your password.\nhttp://corsair.cs.iupui.edu:20801/prototype/reset.php?user=".sha1($userNameIn)."&reset=".sha1($row['Password']);
                    if (mail($userNameIn,"Forgotten Password",$emailBody,"Aegis Password Reset")==TRUE)
                    {
                        $mess = "Instructions have been sent to the email address provided.";
                    }
                    else
                    {
                        $mess = "Could not send reset instructions. Please try again.";
                    }
                }
                else
                {
                    $mess = "No account found with that email address.";
                }
            }
            else
            {
                $mess = "Please enter a valid email.";
            }

        }

        $mess = "<h3>" . $mess . "</h3>";

        ?>

        <form method = "post" action = "forgotPassword.php">
            <?php
            if ($mess!="<h3>Instructions have been sent to the email address provided.</h3>")
            {
                print "
                    <br>
                    <label>UserName:</label>
                    <input name = 'myUname' id = 'myUname' value = ''>
                    <br/>
                    <br>
                    <input type = 'submit' value = 'Continue' style = 'margin-left: 60px;' name = 'SubButton'>
                    <br>
                    <br>";
            }
            else
            {
                $mess = "<h3><br>Instructions have been sent to the email address provided.<br><br></h3>";
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