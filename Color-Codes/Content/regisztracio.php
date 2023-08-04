<?php
include('../PHP/CC-helper.php');
$m = new menuKez();
session_start();
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
				}
				else {$m->foOldalMenu();}
			}
			else { $m->foOldalMenu(); }
		}
	} 
	else if ("LOGOUT" == $_SESSION["login"]) { $m->foOldalMenu(); }
	else { $m->foOldalMenu(); }
}
else { $m->foOldalMenu(); }
?>

<?php
if(isset($_POST["nev"]) and !empty($_POST["nev"]) and isset($_POST["email"]) and !empty($_POST["email"]) and isset($_POST["jelszo"]) and !empty($_POST["jelszo"]))
{
	include('../PHP/CC-validator.php');
	$ab = new adatbazis();
	$ab->userAdd($_POST['nev'], password_hash($_POST['jelszo'], PASSWORD_DEFAULT), $_POST['email']);
}

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
	<form method="POST" class="container p-5 full-form" id="regisztracio">
		<label>Felhasználónév:</label>
		<input type="text" name="nev">
		<label>E-mail:</label>
		<input type="email" name="email">
		<label>Jelszó:</label>
		<input type="password" name="jelszo">
		<input type="submit" value="Regisztráció">
	</form>
</body>
</html>
<script type="text/javascript" src="../JS/script.js"></script>