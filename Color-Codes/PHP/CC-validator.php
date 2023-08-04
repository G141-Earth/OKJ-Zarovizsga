<?php

/**
 * 
 */
class ColorValid
{

	private $tagok = NULL;
	private $tipus = NULL;
	public $helyesseg = false;

	public function __construct($sor, $keveres)
	{
		$this->tagok = explode("-", $sor);
		$this->tipus = strtoupper($keveres);
		$this->helyesseg = $this->ellenor();
	}

	private function ellenor()
	{
		$hossz = $this->tipus == "HEXA" ? 6 : strlen($this->tipus);

		if ($this->tipus == "RGB" or $this->tipus == "RYB" and count($this->tagok) == $hossz)
		{
			if(!(isset($this->tagok[0]) and is_numeric($this->tagok[0]) and (empty($this->tagok[0]) or $this->tagok[0] < 256))) { return false; }
			if(!(isset($this->tagok[1]) and is_numeric($this->tagok[1]) and (empty($this->tagok[1]) or $this->tagok[1] < 256))) { return false; }
			if(!(isset($this->tagok[2]) and is_numeric($this->tagok[2]) and (empty($this->tagok[2]) or $this->tagok[2] < 256))) { return false; }
			return true;
		}
		if ($this->tipus == "HSL" or $this->tipus == "HSV" and count($this->tagok) == $hossz)
		{
			if(!(isset($this->tagok[0]) and is_numeric($this->tagok[0]) and (empty($this->tagok[0]) or $this->tagok[0] < 360))) { return false; }
			if(!(isset($this->tagok[1]) and is_numeric($this->tagok[1]) and (empty($this->tagok[1]) or $this->tagok[1] < 360))) { return false; }
			if(!(isset($this->tagok[2]) and is_numeric($this->tagok[2]) and (empty($this->tagok[2]) or $this->tagok[2] < 360))) { return false; }
			return true;
		}
		if ($this->tipus == "CMYK" and count($this->tagok) == $hossz)
		{
			if(!(isset($this->tagok[0]) and is_numeric($this->tagok[0]) and (empty($this->tagok[0]) or $this->tagok[0] < 101))) { return false; }
			if(!(isset($this->tagok[1]) and is_numeric($this->tagok[1]) and (empty($this->tagok[1]) or $this->tagok[1] < 101))) { return false; }
			if(!(isset($this->tagok[2]) and is_numeric($this->tagok[2]) and (empty($this->tagok[2]) or $this->tagok[2] < 101))) { return false; }
			if(!(isset($this->tagok[3]) and is_numeric($this->tagok[3]) and (empty($this->tagok[3]) or $this->tagok[3] < 101))) { return false; }
			return true;
		}
		if ($this->tipus == "HEXA" and strlen($this->tagok[0]) == $hossz)
		{
			$correct = true;
			$arr = array("0","1","2","3","4","5","6","7","8","9","A","B","C","D","E","F");
			for ($i = 0; $i < strlen($this->tipus) and $correct; $i++)
			{
				$correct = in_array(strtoupper($this->tagok[0][$i]), $arr);
			}
			return $correct;
		}
		return false;
		
	}
}


?>


<?php


class adatbazis
	{
		
		private $servername = "localhost";
		private $username = "root";
		private $password = "";
		private $dbname = "cc-ab";
		private $conn = NULL;
		private $sql = NULL;
		private $row = NULL;
		private $result = NULL;
	
		public function __construct()
		{
			$this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
			if ($this->conn->connect_error) { die("Kapcsolodási hiba: " . $this->conn->connect_error); }
		}

		public function __destruct(){$this->conn->close();}

		public function userAdd($fnev, $tjelszo, $email)
		{
			//EMAIL
			if (!filter_var($email, FILTER_VALIDATE_EMAIL))
			{
				echo("<div class='container-fluid' style='padding: 1rem 3rem 0 3rem'><div class='row'><div class='col-md-12'><div class='alert alert-danger' style='margin: 0'>Nem megfelelő az e-mail cím!</div></div></div></div>");
				return;
			}
			
			$db_connection = mysqli_connect($this->servername, $this->username, $this->password, $this->dbname);
			$username = mysqli_real_escape_string($db_connection, $fnev);

			$this->sql = "INSERT INTO user(fnev, jelszo, email) VALUES ('$fnev','$tjelszo','$email')";
			$this->result = $this->conn->query($this->sql);
			$szoveg = $this->result ? "Sikeres regisztráció" : "Sikertelen regisztráció";
			$tipus = $this->result ? "alert-success" : "alert-danger";
			echo("<div class='container-fluid' style='padding: 1rem 3rem 0 3rem'><div class='row'><div class='col-md-12'><div class='alert ".$tipus."' style='margin: 0'>".$szoveg."</div></div></div></div>");
		}

		public function bejelentkezes($fnev, $jelszo)
		{
			$this->sql = "SELECT user.jelszo, user.email, jogosultsag.nev, user.aktiv FROM user JOIN jogosultsag ON user.jog = jogosultsag.id WHERE LOWER(user.fnev) = LOWER('$fnev')";
			$this->result = $this->conn->query($this->sql);
			if ($this->result->num_rows == 1)
				{
					$this->row = mysqli_fetch_array($this->result);
						if ($this->row["aktiv"] < 1) {
							echo("<script>alert('Inaktív a felhasználó!');</script>");
							unset($_SESSION["login_perm"]);
							unset($_SESSION["login_email"]);
							$_SESSION["login"] = "LOGOUT";
						}
						else if (password_verify($jelszo, $this->row["jelszo"])) {
							$_SESSION["login_perm"] = $this->row["nev"];
							//$_SESSION["login_email"] = "xxx@xxx.xxx";
							$_SESSION["login_email"] = $this->row["email"];
							$_SESSION["login"] = "LOGGED";
						}
						else
						{
							echo("<script>alert('Sikertelen bejelentkezés!');</script>");
							unset($_SESSION["login_perm"]);
							unset($_SESSION["login_email"]);
							unset($_SESSION["login"]);
							$_SESSION["login"] = "LOGOUT";
						}

				}
				else
				{
					echo("<script>alert('Hiba történt! Próbálja újra később.');</script>");
				}
		}
	}
?>