<?php

class forms
{
	public function form_login()
	{
		?>
		<form method="POST" class="container p-5 full-form" id="bejelentkezes">
			<label>Felhasználónév:</label>
			<input type="text" name="input_username">
			<label>Jelszó:</label>
			<input type="password" name="input_pwd">
			<input type='hidden' name='action' value='cmd_login'>
			<input type="submit" value="Belépés">
		</form>
		<?php		
	}
	public function form_logout()
	{
		?>
		<form method='POST'>
			<input type='hidden' name='action' value='cmd_logout'>
			<input type='submit' value='Kijelentkezés'>
		</form>	
		<?php		
	}

	public function form_logoutString()
	{
		return "<form method='POST'><input type='hidden' name='action' value='cmd_logout'><input type='submit' value='Kijelentkezés'></form>";		
	}
}

class menuKez
{
	function foOldalMenu($in=false)
	{
		$array = array();
		$array["Főoldal"] = "index.php";
		$array[$in ? "Statisztika*" : "Bejelentkezés"] = $in ? "#" : "bejelentkezes.php";
		$array[$in ? "Profil" : "Regisztráció"] = $in ? "bejelentkezes.php" : "regisztracio.php";
		$array[$in ? "Kijelentkezés" : "Statisztika*"] = $in ? "Kijelentkezés" : "#";

		echo ("<div class='container-fluid p-0'>");
		echo ("<nav id='CC-menu' class='text-white black'>");
		echo ("<ul><li>");
		echo ("<div class='p-3' id='CC-menu-header'><span>COLOR-CODE</span></div>");
		echo ("<ul class='text-center'>");
		foreach ($array as $key => $value)
				{
					if ($value == "Kijelentkezés" and $value == "Kijelentkezés")
					{
						$f = new forms();
						echo ("<li class='p-3'>".$f->form_logoutString()."</li>");
					}
					else
					{
						echo ("<li class='p-3'><a href='".$value."'>".$key."</a></li>");
					}
				}
		echo ("</ul></li><ul></nav>");
		echo ("<div style='height: 3.5rem;'></div></div>");
	}

	function colorOldalMenu($in=false)
	{
		$array = array();
		$array["Főoldal"] = "index.php";
		$array["Keverés"] = "#CC-Keveres";
		$array["Kontrasztok"] = "#CC-Kontrasztok";
		$array[$in ? "Profil" : "Bejelentkezés"] = "bejelentkezes.php";

		echo ("<div class='container-fluid p-0'>");
		echo ("<nav id='CC-menu' class='text-white black'>");
		echo ("<ul><li>");
		echo ("<div class='p-3' id='CC-menu-header'><span>COLOR-CODE</span></div>");
		echo ("<ul class='text-center'>");
		foreach ($array as $key => $value)
				{
					echo ("<li class='p-3'><a href='".$value."'>".$key."</a></li>");
				}
		echo ("</ul></li><ul></nav>");
		echo ("<div style='height: 3.5rem;'></div></div>");


	}
}

?>