<?php
	//Functions file
	//Runs operations that work with forms and user accounts.
	//Created: 9/9/2015
	//Author: Chris Antolin
	
	//tests if the entry is empty or not and returns a boolean
	function emptyTest($nameStr)
	{
		if($nameStr == '')// if empty
		{
			return false;
		}
		
		else //contains characters
		{
			return true;
		}
	}
	
	//sanitizes and validates emails
	function emailCheck($email)
	{
		$email = filter_var($email, FILTER_SANITIZE_EMAIL); //removes illegal characters from email input
		
		//validate the email
		if(!filter_var($email, FILTER_VALIDATE_EMAIL) === false) 
		{
			//email is good so it clears
			return true;
		}
		
		else
		{
			return false;
		}
	}
	
	//tests the password's strength (10 characters needed)
	//also tests if there are both numbers and letters in the password
	function pwdCheck($password)
	{
		//test the strength
		if(strlen($password) < 10)
		{
			return false;
		}
		
		//test if the password has both letters and numbers
		//has to go through the entire string
		//utilize two booleans
		$alpha = false;
		$numbers = false;
		//turn the string into an array
		$string = str_split($password);
		//use a loop to check each letter
		for($i = 0; $i < strlen($password); $i++)
		{
			//use preg_match (reg-expressions) to search through a string
			//not as fast as strpos, but easier to work with
			if(preg_match("/[A-Za-z]/", $string[$i]))
			{
				$alpha = true; // this will become from if at least one character is in the string
			}
			
		}
		
		//check if there are any numbers
		//same scenario, but we need to change our reg-ex a little
		for($i = 0; $i < strlen($password); $i++)
		{
			if(preg_match("/[0-9]/", $string[$i]))
			{
				$numbers = true; // this will become from if at least one character is in the string
			}
			
		}
		
		if($alpha == false || $numbers == false) //if either are false, the password is bad
		{
			return false;
		}
		
		else
		{
			return true; //our password is good
		}
		
		
	}
	
	//checks if two strings match
	//used to make sure our confirm fields match their respective parents
	function matchStrings($stringA, $stringB)
	{
		if($stringA == $stringB) //if they match
		{
			return true;
		}
		
		else  //they don't match
		{
			return false;
		}
	}

	//function mailSender
	function mailOut($email, $code, $pwd)
	{
		$sub = "Account Activation";
		
		$body = "
		Thank you for registering! 
		Your account has been created, but you are not done yet! Please activate your account!
		
		----------------------
		Your login Credentials:
		Email: $email
		Password: $pwd
		----------------------
		
		
		Click this link to activate your account!
		http://corsair.cs.iupui.edu:20711/lab2/login.php?email=$code";
	
		if(mail($email, $sub, $body) == true)
		{
			print "Email successfully sent!";
		}
		
		else
		{
			print "Email failed to send!";
		}
	}
	
	
	//this area handles any input type function	
	//handles the department list selection that is made on the form
	function departmentList()
	{
		$allOptions = '<option value = "CSCI" selected = "selected">Computer Science</option>
		<option value = "CGT">Computer Graphics Technology</option>
		<option value = "ECE">Engineering</option>
		<option value = "MATH">Mathematics</option>
		<option value = "CIT">Computer Informational Technology</option>';
		
		return $allOptions; 
	}
	
	//function that makes our code
	function codeMaker($size)
	{
		//initialize our array for 
		$alphaNum = array("a","b","c","d","e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z", "0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
		
		//initialize string
		$msgStr = "";
		//we want to go as long as the requested size
		for($i = 0; $i < $size; $i++)
		{
			//pick a random number between 0 and 35
			$rand = mt_rand(0, 35);
			
			$msgStr = $msgStr . $alphaNum[$rand];
		}
		
		return $msgStr;		
	}
	
	//code checker
	//checks if code is in the correct size (50 characters in this scenario)
	function codeCheck($code)
	{
		if(strlen($code) == 50)
		{
			return true;
		}
		
		else
		{
			return false;
		}
	}
	
	function greetName($name)
	{
		$nameOut = "";
		if($name == "admin@gmail.com")
		{
			$nameOut = "Administrator";
		}
		
		else
		{
			$nameOut = "Member";
		}
		
		return $nameOut;
	}

	function phoneCheck($phone, $size)
	{
		//make sure size of phone is 10 characters
		if(strlen($phone) == 10)
		{
			$phoneclear = true;			
			$string = str_split($phone);
			//use a loop to check for letters in phone
			for($i = 0; $i < strlen($phone); $i++)
			{
				//use preg_match (reg-expressions) to search through a string
				//not as fast as strpos, but easier to work with
				if(preg_match("/[A-Za-z]/", $string[$i]))
				{
					$phoneclear = false; //if an alpha character exists, the phone field is bad
				}
				
			}
			
			return $phoneclear;
		}
		
		else
		{
			return false;
		}
	}
	
	//adds rows to table
	function addClients($size)
	{
		for ($i = 0; $i < $size;$i++) //can utilize one session variable to work with
		//may by retired after database end is connected - at which point, remove from list
		{
			//add them to table
			echo"<tr>";
			echo "<td>" . $_SESSION['Fname'][$i] . "</td>";
			echo "<td>" . $_SESSION['Lname'][$i] . "</td>";
			echo "<td>" . $_SESSION['phone'][$i] . "</td>";
			echo "<td>" . $_SESSION['contact'][$i]. "</td>";
			echo "<td>" . $_SESSION['cPhone'][$i] . "</td>";
			echo "<td>" . $_SESSION['email'][$i] . "</td>";
			echo "<td>" . $_SESSION['website'][$i]. "</td>";
			echo "<td>" . $_SESSION['notes'][$i]. "</td>";			
			echo"</tr>";
			
			
		}
	}
	
	//adds rows to table
	function addOrders($size)
	{
		for ($i = 0; $i < $size;$i++) //can utilize one session variable to work with
		//may by retired after database end is connected - at which point, remove from list
		{
			//add them to table
			echo"<tr>";
			echo "<td>" . "2" . $_SESSION['ion'][$i] . "</td>";
			echo "<td>" . $_SESSION['ordertype'][$i] . "</td>";
			echo "<td>" . $_SESSION['add'][$i] . "</td>";
			echo "<td>" . $_SESSION['d_acc'][$i]. "</td>";
			echo "<td>" . $_SESSION['d_due'][$i] . "</td>";
			echo "<td>" . "$" .  $_SESSION['fee'][$i] . "</td>";			
			echo"</tr>";
			
			
		}
	}
	
	
	function formatPhone($phone)
	{
		$area = substr($phone, 0,3);
		
		$first = substr($phone,3,3);
		
		$last = substr($phone,6);
		
		$newPhone = "(" . $area . ") " . $first . "-" . $last;
		
		return $newPhone;
	}

	function statesList()
	{
		$states = array('AL'=>"Alabama",
		'AK'=>"Alaska",
		'AZ'=>"Arizona",
		'AR'=>"Arkansas",
		'CA'=>"California",
		'CO'=>"Colorado",
		'CT'=>"Connecticut",
		'DE'=>"Delaware",
		'DC'=>"District Of Columbia",
		'FL'=>"Florida",
		'GA'=>"Georgia",
		'HI'=>"Hawaii",
		'ID'=>"Idaho",
		'IL'=>"Illinois",
		'IN'=>"Indiana",
		'IA'=>"Iowa",
		'KS'=>"Kansas",
		'KY'=>"Kentucky",
		'LA'=>"Louisiana",
		'ME'=>"Maine",
		'MD'=>"Maryland",
		'MA'=>"Massachusetts",
		'MI'=>"Michigan",
		'MN'=>"Minnesota",
		'MS'=>"Mississippi",
		'MO'=>"Missouri",
		'MT'=>"Montana",
		'NE'=>"Nebraska",
		'NV'=>"Nevada",
		'NH'=>"New Hampshire",
		'NJ'=>"New Jersey",
		'NM'=>"New Mexico",
		'NY'=>"New York",
		'NC'=>"North Carolina",
		'ND'=>"North Dakota",
		'OH'=>"Ohio",
		'OK'=>"Oklahoma",
		'OR'=>"Oregon",
		'PA'=>"Pennsylvania",
		'RI'=>"Rhode Island",
		'SC'=>"South Carolina",
		'SD'=>"South Dakota",
		'TN'=>"Tennessee",
		'TX'=>"Texas",
		'UT'=>"Utah",
		'VT'=>"Vermont",
		'VA'=>"Virginia",
		'WA'=>"Washington",
		'WV'=>"West Virginia",
		'WI'=>"Wisconsin",
		'WY'=>"Wyoming");
		return $states;
	}
?>