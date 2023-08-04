<?php
include('../PHP/CC-helper.php');
$m = new menuKez();
include('../PHP/CC-validator.php');
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Color-Code</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="../img/maat.svg">
	<link rel="stylesheet" href="../CSS/bootstrap4/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="../CSS/index2.css">
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
</body>
</html>
<script type="text/javascript" src="../JS/script.js"></script>

<?php 
session_start();
if (false){
	session_destroy();
}

if (isset($_POST["action"]) and $_POST["action"]=="cmd_logout")
{
	unset($_SESSION["login_perm"]);
	unset($_SESSION["login_email"]);
	$_SESSION["login"] = "LOGOUT";
}
if (isset($_POST["action"]) and $_POST["action"]=="cmd_login")
{
	if (isset($_POST["input_username"]) and
		!empty($_POST["input_username"]) and
		isset($_POST["input_pwd"]) and
		!empty($_POST["input_pwd"]))
	{
		$usercheck = new adatbazis();
		$usercheck->bejelentkezes($_POST["input_username"],$_POST["input_pwd"]);
	}	
}

if (isset($_SESSION["login"]))
{
	if ("LOGGED" == $_SESSION["login"])
	{
		if(isset($_SESSION["login_perm"]))
		{
			if (isset($_SESSION["login_email"]))
			{
				if (filter_var($_SESSION["login_email"], FILTER_VALIDATE_EMAIL))
				{
					$m->foOldalMenu(true);
					if ($_SESSION["login_perm"]=="Admin")
					{
						include("CC-admin.php");			
					}
					else if ($_SESSION["login_perm"]=="User")
					{
						include("CC-user.php");	
					}
				}
				else
				{
					$m->foOldalMenu();
					$forms = new forms(); $forms->form_login();
				}
			}
			else
			{
				$m->foOldalMenu();
				$forms = new forms(); $forms->form_login();
			}
		}
	} 
	else if ("LOGOUT" == $_SESSION["login"])
	{
		$m->foOldalMenu();
		$forms = new forms(); $forms->form_login();
	}
	else 
	{
		$m->foOldalMenu();
		$forms = new forms(); $forms->form_login();
	}
}
else
{
	$m->foOldalMenu();
	$forms = new forms(); $forms->form_login();
}
?>