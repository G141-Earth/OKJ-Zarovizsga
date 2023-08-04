<?php
session_start();
include('../PHP/CC-helper.php');
if (isset($_POST["action"]) and $_POST["action"]=="cmd_logout")
{
	unset($_SESSION["login_perm"]);
	unset($_SESSION["login_email"]);
	$_SESSION["login"] = "LOGOUT";
}
$m = new menuKez();
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
<body onload="fullLoad()">
	<div class="container p-5">
		<div class="row">
			<div class="col-md-3">
				<article class="CC-minta">
				</article>
			</div>
			<div class="col-md-3">
				<article class="CC-minta"></article>
			</div>
			<div class="col-md-3">
				<article class="CC-minta"></article>
			</div>
			<div class="col-md-3">
				<article class="CC-minta"></article>
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<article class="CC-minta">
				</article>
			</div>
			<div class="col-md-3">
				<article class="CC-minta"></article>
			</div>
			<div class="col-md-3">
				<article class="CC-minta"></article>
			</div>
			<div class="col-md-3">
				<article class="CC-minta"></article>
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<article class="CC-minta">
				</article>
			</div>
			<div class="col-md-3">
				<article class="CC-minta"></article>
			</div>
			<div class="col-md-3">
				<article class="CC-minta"></article>
			</div>
			<div class="col-md-3">
				<article class="CC-minta"></article>
			</div>
		</div>
	</div>
</body>
</html>
<script type="text/javascript" src="../JS/script.js"></script>
<script type="text/javascript">
	function fullLoad() {
		var n = document.getElementsByClassName('CC-minta');
		for (var i = 0; i < n.length; i++) {
			var t = [Math.floor(Math.random()*256), Math.floor(Math.random()*256), Math.floor(Math.random()*256)];
			n[i].innerHTML = "<div style='background-color: rgb("+t.slice()+")'></div><div><hr><a href='http://localhost/color-codes/Content/color.php?tipus=RGB&code="+t[0]+"-"+t[1]+"-"+t[2]+"'>"+RGB2HEXA(t)+"</a><hr></div>";
		}
	}
</script>