


<?php

if (isset($_POST['submit'])) 
	{
		require "../config.php";
		require "../common.php";
		$fname ="";
		$lname ="";
		$email ="";
		$age ="";
		$loc ="";
	
		$fname_e ="";
		$lname_e ="";
		$email_e ="";
		$age_e ="";
		$loc_e ="";
	
	
		if (empty($_POST["firstname"])) 
		{
			$fname_e="First name is required";		
		}
		else 
		{
			$fname = $_POST["firstname"];
		}
		if (empty($_POST["lastname"])) 
		{
			?> <script> alert("Last Name is required"); </script> <?php
		}
		else 
		{
			$lname = $_POST["lastname"];
		}
		if (empty($_POST["email"])) 
		{
			?> <script> alert("email is required"); </script> <?php
		}
		else 
		{
			$email = $_POST["email"];
			if (!preg_match("/([w-]+@[w-]+.[w-]+)/",$email)) 
			{
				$email_e = "Invalid email format";
			}
		}
		if (empty($_POST["age"])) 
		{
			?> <script> alert("age is required"); </script> <?php
			
		}
		else 
		{
			$age =$_POST["age"];
		}
		if (empty($_POST["location"])) 
		{
			?> <script> alert("location is required"); </script> <?php
		}
		else 
		{
			$loc = $_POST["location"];
		}
	
	?> <blockquote> ERROR in Server Side . </blockquote> <?php


if(($fname!="") and ($lname!="") and ($email!="") and ($age!="") and ($loc!="") )
	{
		
	try 
	{
        $connection = new PDO($dsn, $username, $password, $options);
  
        $new_user = array(
            "firstname" => $fname,
            "lastname"  => $lname,
            "email"     => $email,
            "age"       => $age,
            "location"  => $loc
		
        );
		

        $sql = sprintf(
                "INSERT INTO %s (%s) values (%s)",
                "users",
                implode(", ", array_keys($new_user)),
                ":" . implode(", :", array_keys($new_user))
        );
        
        $statement = $connection->prepare($sql);
        $statement->execute($new_user);
    }

	catch(PDOException $error) 
	{
        echo $sql . "<br>" . $error->getMessage();
    }
	
	}
    
	}
?>

<?php require "templates/header.php"; ?>
<script>
    function check()
    {
        var fname=document.forms["form"]["firstname"].value;
        var lname=document.forms["form"]["lastname"].value;
        var email=document.forms["form"]["email"].value;
		var age=document.forms["form"]["age"].value;
		var loc=document.forms["form"]["location"].value;
		
        if(fname.value=="")
        {
            alert("Enter a Valied First Name");
            document.forms["form"]["firstname"].focus();
				return false;
        }
        if(fname.length<4)
        {
            alert("Enter a Valied First Name");
            document.forms["form"]["firstname"].focus();
            return false;
        }
        if(lname.value=="")
        {
            alert("Enter a Valied Last Name");
            document.forms["form"]["lastname"].focus();
            return false;
        }
        if(lname.length<4)
        {
            alert("Enter a Valied Last Name");
            document.forms["form"]["lastname"].focus();
            return false;
        }
		
        var email=document.form.email.value;  
        var atposition=email.indexOf("@");  
        var dotposition=email.lastIndexOf(".");     
        if (atposition<1 || dotposition<atposition+2 || dotposition+2>=email.length)
        {  
            alert("Please enter a valid e-mail address "); 
			document.forms["form"]["email"].focus();			
            return false;  
        }  
	    if(age=="" )
		{
			alert("enter age ");
			document.forms["form"]["age"].focus();
			return false;
		}
		if(age.length>2 )
		{
			alert("enter a valid age ");
			document.forms["form"]["age"].focus();
			return false;
		}
		if(loc=="" )
		{
			alert("please enter ur Location ");
			document.forms["form"]["location"].focus();
			return false;
		}
		if(loc.length<3 )
		{
			alert("please enter valied Location ");
			document.forms["form"]["location"].focus();
			return false;
		}
        
    }
</script>

<?php if (isset($_POST['submit']) && $statement) { ?>
    <blockquote><?php echo $_POST['firstname'].$_POST['lastname']; ?> successfully added.</blockquote>
<?php } ?>


<h2>Add a user</h2>

<form name="form" onsubmit="return check()" method="post" >
    <label for="firstname">First Name</label>
    <input type="text" name="firstname" id="firstname">
    <label for="lastname">Last Name</label>
    <input type="text" name="lastname" id="lastname">
    <label for="email">Email Address</label>
    <input type="text" name="email" id="email">
    <label for="age">Age</label>
    <input type="text" name="age" id="age">
    <label for="location">Location</label>
    <input type="text" name="location" id="location">
    <input type="submit" name="submit" value="Submit">
</form>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>
