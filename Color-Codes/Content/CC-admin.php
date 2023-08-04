<?php
include('CC-manager.php');
$ui = new feluletKez($_SESSION["login_email"]);
if (isset($_POST["action"]) and $_POST["action"]=="act_aktivitas")
{
	if (isset($_POST["nev"]) and !empty($_POST["nev"]) and
		isset($_POST["status"]) and is_numeric($_POST["status"]))
	{
		$ui->aktivitasValtas($_POST["nev"], $_POST["status"]);
	}
}
if (isset($_POST["action"]) and $_POST["action"]=="act_jogosul")
{
	if (isset($_POST["nev"]) and !empty($_POST["nev"]) and
		isset($_POST["jog"]) and is_numeric($_POST["jog"]))
	{
		$ui->jogValtas($_POST["nev"], $_POST["jog"]);
	}
}

if (isset($_POST["action"]) and $_POST["action"]=="act_szinezes")
{
	if (isset($_POST["hexa"]) and !empty($_POST["hexa"]))
	{
		$ui->szinValtas($_POST["hexa"]);
	}
}

if (isset($_POST["action"]) and $_POST["action"]=="act_jelszoCsere")
{
	if (isset($_POST["jelszo"]) and !empty($_POST["jelszo"]))
	{
		$ui->jelszoValtas(password_hash($_POST['jelszo'], PASSWORD_DEFAULT));
	}
}

if (isset($_POST["action"]) and $_POST["action"]=="act_torolLista")
{
	if (isset($_POST["szin"]) and !empty($_POST["szin"]) and isset($_POST["datum"]) and !empty($_POST["datum"]))
	{
		$val = new ColorValid($_POST["szin"], "HEXA");
		if ($val->helyesseg)
		{
			$ui->szinTorol($_POST["szin"], $_SESSION["login_email"], $_POST["datum"]);
		}
	}
}

if (isset($_POST["action"]) and $_POST["action"]=="act_addLista")
{
	if (isset($_POST["szin"]) and !empty($_POST["szin"]))
	{
		$val = new ColorValid($_POST["szin"], "HEXA");
		if ($val->helyesseg)
		{
			$ui->szinFelvetel($_POST["szin"]);
		}
	}
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
	<div class="container-fluid p-5">
		<?php
		$ui->Adataim();
		?>
	</div>
	<hr>
	<div class="container-fluid p-5">
		<?php
		$ui->szinLista();
		?>
	</div>
	<hr>
	<div class="container-fluid p-5">
		<?php
		$ui->listaAdmin();
		?>
	</div>
</body>
</html>
<script type="text/javascript" src="../JS/script.js"></script>