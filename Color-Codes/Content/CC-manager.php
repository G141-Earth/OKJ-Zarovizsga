<?php

class feluletKez
{
	
	private $servername = "localhost";
	private $username = "root";
	private $password = "";
	private $dbname = "cc-ab";
	private $conn = NULL;
	private $sql = NULL;
	private $row = NULL;
	private $result = NULL;
	private $azonosito = NULL;
	private $nemLetezik = true;
	
	public function __construct($azon)
	{
		$this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
		$this->azonosito = $azon;
		if ($this->conn->connect_error) { die("Kapcsolodási hiba: " . $this->conn->connect_error); }
		$this->sql = "SELECT user.email FROM user WHERE user.email = '$azon'";
		$this->result = $this->conn->query($this->sql);
		$this->nemLetezik = $this->result->num_rows == 0;
	}

	public function __destruct(){$this->conn->close();}

	public function listaAdmin()
	{
		if ($this->nemLetezik)
			{
				$this->alert();
				return;
			}
		$array = array();
		$this->sql = "SELECT * FROM jogosultsag";
		$this->result = $this->conn->query($this->sql);
		if ($this->result->num_rows > 0)
		{
			while($this->row = $this->result->fetch_assoc())
			{
				$array[$this->row['id']] = $this->row['nev'];
			}
		}

		$this->sql = "SELECT user.fnev, user.szin, user.aktiv, user.jog FROM user JOIN jogosultsag ON user.jog = jogosultsag.id WHERE user.email != '$this->azonosito'";
		$this->result = $this->conn->query($this->sql);
		if ($this->result->num_rows > 0)
		{
			echo("<h1>Felhasználók</h1>");
			echo("<div class='row'>");
			while($this->row = $this->result->fetch_assoc())
			{
				$keret = $this->row["aktiv"] > 0 ? "#00FF00" : "#FF0000";
				echo "<div class='col-md-3'>";
				echo("<div class='CC-kompozicio CC-chromo'>");
				echo("<div style='background-color:#".$this->row["szin"]."; border-color: ".$keret." '></div>");
				echo("<form method='POST' class='user'>");
				echo("<input type='hidden' name='status' value='".($this->row["aktiv"] > 0 ? 0 : 1)."'>");
				echo("<input type='hidden' name='nev' value='".$this->row["fnev"]."'>");
				echo("<input type='hidden' name='action' value='act_aktivitas'>");
				echo("<input type='submit' value='".$this->row["fnev"]."'></form>");
				//SELECT FORM

				echo("<form method='POST' class='perm'>");
				echo("<input type='hidden' name='nev' value='".$this->row["fnev"]."'>");
				echo("<input type='hidden' name='action' value='act_jogosul'>");
				echo("<select name='jog'>");
				foreach ($array as $key => $value)
				{
						echo "{$key} => {$value} ";
						echo ("<option value='".$key."' ".($key == $this->row["jog"] ? "selected" : "").">".$value."</option>");
				}
				echo ("</select><input type='submit' value='módosítás'></form>");
				echo ("</div></div>");
			}
			echo("</div>");
		}
	}

	public function adataim()
	{
		if ($this->nemLetezik)
			{
				$this->alert();
				return;
			}
		$this->sql = "SELECT user.fnev, user.szin, user.aktiv, user.jog, user.email, jogosultsag.nev FROM user JOIN jogosultsag ON user.jog = jogosultsag.id WHERE user.email = '$this->azonosito'";
		$this->result = $this->conn->query($this->sql);
		if ($this->result->num_rows == 1)
		{
				$this->row = $this->result->fetch_assoc();
				echo("<div class='row'>");
					echo "<div class='col-md-3'>";
						echo("<div class='CC-kompozicio CC-chromo'>");
							echo("<div style='background-color:#".$this->row["szin"]."; height: 226px;'></div>");
							echo("<form method='POST' class='szin'>");
								echo("<input type='hidden' name='hexa' value='".$this->row["szin"]."'>");
								echo("<input type='hidden' name='action' value='act_szinezes'>");
								echo("<input type='text' value='".$this->row["szin"]."' onchange='szinezes(this.value, true)'>");
								echo("<input type='submit' value='módosítás'></form>");
						echo("</div></div>");
					echo "<div class='col-md-9'>";
						echo("<div class='CC-kompozicio CC-chromo'>");
							echo("<form method='POST' class='adatok full-form'>");
								echo "<dl>";
								echo "<dt>Felhasználónév:</dt><dd>".$this->row["fnev"]."</dd>";
								echo "<dt>Jogosultság:</dt><dd>".$this->row["nev"]."</dd>";
								echo "<dt>E-mail:</dt><dd>".$this->row["email"]."</dd>";
								echo "</dl><hr>";
								echo("<label>Új jelszó:</label>");
								echo("<input type='password' name='jelszo' value=''>");
								echo("<input type='hidden' name='action' value='act_jelszoCsere'>");
								echo("<input type='submit' value='módosítás'></form>");
						echo("</div></div>");
			echo("</div>");
		}
	}

	public function aktivitasValtas($nev, $status)
	{
		$status = $status > 0 ? 1 : 0;
		$this->sql = "UPDATE user SET aktiv= $status WHERE fnev = '$nev'";
		$this->result = $this->conn->query($this->sql);
		$szoveg = $this->result ? "Sikeres aktivítás módosítás" : "Sikertelen aktivítás módosítás";
		$tipus = $this->result ? "alert-success" : "alert-danger";
		echo("<div class='container-fluid' style='padding: 1rem 3rem 0 3rem'><div class='row'><div class='col-md-12'><div class='alert ".$tipus."' style='margin: 0'>".$szoveg."</div></div></div></div>");
	}

	public function szinHistoryAdd($szin)
	{
		$status = $status > 0 ? 1 : 0;
		$this->sql = "UPDATE user SET aktiv= $status WHERE fnev = '$nev'";
		$this->result = $this->conn->query($this->sql);
		$szoveg = $this->result ? "Sikeres aktivítás módosítás" : "Sikertelen aktivítás módosítás";
		$tipus = $this->result ? "alert-success" : "alert-danger";
		echo("<div class='container-fluid' style='padding: 1rem 3rem 0 3rem'><div class='row'><div class='col-md-12'><div class='alert ".$tipus."' style='margin: 0'>".$szoveg."</div></div></div></div>");
	}

	public function jogValtas($nev, $jog)
	{
		$this->sql = "UPDATE user SET jog= $jog WHERE fnev = '$nev'";
		$this->result = $this->conn->query($this->sql);
		$szoveg = $this->result ? "Sikeres jogosultság módosítás" : "Sikertelen jogosultság módosítás";
		$tipus = $this->result ? "alert-success" : "alert-danger";
		echo("<div class='container-fluid' style='padding: 1rem 3rem 0 3rem'><div class='row'><div class='col-md-12'><div class='alert ".$tipus."' style='margin: 0'>".$szoveg."</div></div></div></div>");
	}

	public function szinValtas($szin)
	{
		$szin = strtoupper($szin);
		$val = new ColorValid($szin, "hexa");
		if ($val->helyesseg)
		{
			$this->sql = "UPDATE user SET szin= '$szin' WHERE email = '$this->azonosito'";
			$this->result = $this->conn->query($this->sql);
			$szoveg = $this->result ? "Sikeres szín módosítás" : "Sikertelen szín módosítás";
		$tipus = $this->result ? "alert-success" : "alert-danger";
		echo("<div class='container-fluid' style='padding: 1rem 3rem 0 3rem'><div class='row'><div class='col-md-12'><div class='alert ".$tipus."' style='margin: 0'>".$szoveg."</div></div></div></div>");
		}
	}

	public function jelszoValtas($tjelszo)
	{
		$this->sql = "UPDATE user SET jelszo= '$tjelszo' WHERE email = '$this->azonosito'";
		$this->result = $this->conn->query($this->sql);
		$szoveg = $this->result ? "Sikeres módosítás" : "Sikertelen módosítás";
		$tipus = $this->result ? "alert-success" : "alert-danger";
		echo("<div class='container-fluid' style='padding: 1rem 3rem 0 3rem'><div class='row'><div class='col-md-12'><div class='alert ".$tipus."' style='margin: 0'>".$szoveg."</div></div></div></div>");
	}

	public function szinTorol($szin, $azon, $datum)
	{
		$this->sql = "DELETE FROM wishlist WHERE felhasz_id = (SELECT id FROM user WHERE email = '$this->azonosito') AND datum = '$datum' AND szin = '$szin'";
		$this->result = $this->conn->query($this->sql);
		$szoveg = $this->result ? "Sikeres módosítás" : "Sikertelen módosítás";
		$tipus = $this->result ? "alert-success" : "alert-danger";
		echo("<div class='container-fluid' style='padding: 1rem 3rem 0 3rem'><div class='row'><div class='col-md-12'><div class='alert ".$tipus."' style='margin: 0'>".$szoveg."</div></div></div></div>");
	}

	public function szinFelvetel($szin)
	{
		$szin = strtoupper($szin);
		$this->sql = "SELECT jogosultsag.wlimit, (SELECT COUNT(*) FROM wishlist JOIN user ON wishlist.felhasz_id = user.id WHERE user.email = '$this->azonosito') AS 'all' FROM wishlist JOIN user ON wishlist.felhasz_id = user.id JOIN jogosultsag ON user.jog = jogosultsag.id WHERE user.email = '$this->azonosito' LIMIT 1";
		$this->result = $this->conn->query($this->sql);
		if ($this->result->num_rows == 1)
		{
			$this->row = $this->result->fetch_assoc();
			if ($this->row['all'] < $this->row['wlimit'])
			{
				$this->sql = "INSERT INTO wishlist(felhasz_id, szin) VALUES ((SELECT id FROM user WHERE email = '$this->azonosito'),'$szin')";
				$this->result = $this->conn->query($this->sql);
				$szoveg = $this->result ? "Sikeres módosítás" : "Sikertelen módosítás";
				$tipus = $this->result ? "alert-success" : "alert-danger";
				echo("<div class='container-fluid' style='padding: 1rem 3rem 0 3rem'><div class='row'><div class='col-md-12'><div class='alert ".$tipus."' style='margin: 0'>".$szoveg."</div></div></div></div>");
			}
			else
			{
				echo("<div class='container-fluid' style='padding: 1rem 3rem 0 3rem'><div class='row'><div class='col-md-12'><div class='alert alert-danger' style='margin: 0'>A felhasználó elérte a maximális számot, amit eltárolhat!</div></div></div></div>");
			}
		}
		elseif ($this->result)
		{
			$this->sql = "INSERT INTO wishlist(felhasz_id, szin) VALUES ((SELECT id FROM user WHERE email = '$this->azonosito'),'$szin')";
			$this->result = $this->conn->query($this->sql);
			$szoveg = $this->result ? "Sikeres módosítás" : "Sikertelen módosítás";
			$tipus = $this->result ? "alert-success" : "alert-danger";
			echo("<div class='container-fluid' style='padding: 1rem 3rem 0 3rem'><div class='row'><div class='col-md-12'><div class='alert ".$tipus."' style='margin: 0'>".$szoveg."</div></div></div></div>");
		}
	}
			

	private function alert()
	{
		if ($this->nemLetezik)
		{
			echo("<div class='row'><div class='col-md-12'><div class=' alert alert-danger' style='margin: 0'>Nincs ilyen felhasználó</div></div></div>");
			return;
		}
	}

	public function Szinhistory($szin)
	{
		if ($this->nemLetezik) { return; }
		$this->sql = "INSERT INTO history(felhasz_id, szin) VALUES ((SELECT user.id FROM user WHERE user.email = '$this->azonosito' ),'$szin')";
		$this->result = $this->conn->query($this->sql);
	}

	public function szinLista()
	{
		if ($this->nemLetezik)
		{
			$this->alert();
			return;
		}
		$this->sql = "SELECT wishlist.szin,wishlist.datum, DATE(wishlist.datum) AS 'datum2', jogosultsag.wlimit, (SELECT COUNT(*) FROM wishlist JOIN user ON wishlist.felhasz_id = user.id WHERE user.email = '$this->azonosito') AS 'all' FROM wishlist JOIN user ON wishlist.felhasz_id = user.id JOIN jogosultsag ON user.jog = jogosultsag.id WHERE user.email = '$this->azonosito' ORDER BY wishlist.datum DESC";
		$this->result = $this->conn->query($this->sql);
		$over = false;
		if ($this->result->num_rows >= 0)
		{
			echo("<h1>Szín listám</h1><div class='row'>");
			while($this->row = $this->result->fetch_assoc())
			{
				if (!$over)
				{
					$szoveg = $this->result->num_rows > 0 ? $this->row["all"] == 0 ? "Még nincs színed, amit kezelhetnél." : "Itt kezelheted a színeidet." : "Még nincs színed, amit kezelhetnél.";
					echo("<p>".$szoveg."</p>");
					$this->wlimiter = $this->row["wlimit"] - 1 >= $this->row["all"] and $this->wlimiter;
					if ($this->wlimiter)
					{
						$arr = array("0","1","2","3","4","5","6","7","8","9","A","B","C","D","E","F");
						$hexa = $arr[rand(0,15)].$arr[rand(0,15)].$arr[rand(0,15)].$arr[rand(0,15)].$arr[rand(0,15)].$arr[rand(0,15)];
						echo "<div class='col-md-3'>";
						echo("<div class='CC-kompozicio CC-chromo'>");
						echo("<div style='background-color:#".$hexa.";'></div>");
						echo("<form method='POST' class='szin'>");
						echo("<input type='hidden' name='szin' value='".$hexa."'>");
						echo("<input type='text' value='".$hexa."' onchange='szinezes(this.value, false)'>");
						echo("<input type='hidden' name='action' value='act_addLista'>");
						echo("<input type='submit' value='felvétel'></form>");
						echo ("</div></div>");
					}
					$over = true;
				}
				echo "<div class='col-md-3'>";
				echo("<div class='CC-kompozicio CC-chromo'>");
				echo("<div style='background-color:#".$this->row["szin"].";' title='#".$this->row["szin"]."'></div>");
				echo("<form method='POST' class='perm'>");
				echo("<input type='hidden' name='szin' value='".$this->row["szin"]."'>");
				echo("<input type='hidden' name='datum' value='".$this->row["datum"]."'>");
				echo("<input type='hidden' name='action' value='act_torolLista'>");
				echo("<label style='margin-top: 4px'>".$this->row["datum2"]."</label>");
				echo("<input type='submit' value='törlés'></form>");
				echo ("</div></div>");
				
			}
			if (!$over) {
				echo("<p>Még nincs színed, amit kezelhetnél.</p>");
				$arr = array("0","1","2","3","4","5","6","7","8","9","A","B","C","D","E","F");
				$hexa = $arr[rand(0,15)].$arr[rand(0,15)].$arr[rand(0,15)].$arr[rand(0,15)].$arr[rand(0,15)].$arr[rand(0,15)];
				echo "<div class='col-md-3'>";
				echo("<div class='CC-kompozicio CC-chromo'>");
				echo("<div style='background-color:#".$hexa.";'></div>");
				echo("<form method='POST' class='szin'>");
				echo("<input type='hidden' name='szin' value='".$hexa."'>");
				echo("<input type='text' value='".$hexa."' onchange='szinezes(this.value, false)'>");
				echo("<input type='hidden' name='action' value='act_addLista'>");
				echo("<input type='submit' value='felvétel'></form>");
				echo ("</div></div>");
			}
			echo("</div>");
		}
	}
}