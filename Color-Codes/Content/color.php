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
	<style type="text/css">
	</style>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<?php
	include('../PHP/CC-validator.php');
	//$tovabb = false;
	$val = new ColorValid($_GET["code"], strtoupper($_GET["tipus"]));
	if (!$val->helyesseg) { header("Location: index.php"); }
	session_start();
	include('../PHP/CC-helper.php');
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
						$m->colorOldalMenu(true);
						//$tovabb = true;
					}
					else {$m->colorOldalMenu();}
				}
				else { $m->colorOldalMenu(); }
			}
		} 
		else if ("LOGOUT" == $_SESSION["login"]) { $m->colorOldalMenu(); }
		else { $m->colorOldalMenu(); }
	}
	else { $m->colorOldalMenu(); }
?>
<body onload="fullLoad()">
	<div class="container-fluid p-5 text-center" id="CC-idezet">
		<div class="row">
			<div class="col-md-12">
				<blockquote cite="">
					<q>A szó csak más szavakkal való összefüggésében válik egyértelművé, hasonlóképpen az egyes szinek is csak más szinekkel való összefüggésében nyerik el egyértelmű kifejezőerejüket és pontos jelentésüket.</q>
					<br><div class="author">Johannes Itten</div>
				</blockquote>
			</div>
		</div>
	</div>
	<hr>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<svg id="CC-color" class="CC-kompozicio" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 viewBox="0 0 10 2" style="enable-background:new 0 0 10 2;" xml:space="preserve">
					<g id="Layer" class="border">
						<rect x="0" width="10" height="2"/>
					</g>
				</svg>
			</div>
		</div>
		<!--<div style="width: 100%; height: 240px; background-color: pink;"></div>-->
	</div>
	<div class="container p-3">
		<div class="row">
			<h1 id="CC-Keveres">Keverés</h1>
			<div class="col-md-6">
				<article class="pick">
					<h2>RGB</h2>
					<div class="CC-sor-RGB border"></div>
					<div class="CC-sor-RGB border"></div>
					<div class="CC-sor-RGB border"></div>
					<div class="text-right"><span onclick="formWindow('RGB', true)">Módosítás</span></div>
				</article>
			</div>
			<div class="col-md-6">
				<article class="pick">
					<h2>RYB</h2>
					<div class="CC-sor-RYB border"></div>
					<div class="CC-sor-RYB border"></div>
					<div class="CC-sor-RYB border"></div>
					<div class="text-right"><span onclick="formWindow('RYB', true)">Módosítás</span></div>
				</article>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<article class="pick">
					<h2>HSL</h2>
					<div class="CC-sor-HSL border"></div>
					<div class="CC-sor-HSL border"></div>
					<div class="CC-sor-HSL border"></div>
					<div class="text-right"><span onclick="formWindow('HSL', true)">Módosítás</span></div>
				</article>
			</div>
			<div class="col-md-6">
				<article class="pick">
					<h2>HSV</h2>
					<div class="CC-sor-HSV border"></div>
					<div class="CC-sor-HSV border"></div>
					<div class="CC-sor-HSV border"></div>
					<div class="text-right"><span onclick="formWindow('HSV', true)">Módosítás</span></div>
				</article>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<article class="pick">
					<h2>CMYK</h2>
					<div class="CC-sor-CMYK border"></div>
					<div class="CC-sor-CMYK border"></div>
					<div class="CC-sor-CMYK border"></div>
					<div class="CC-sor-CMYK border"></div>
					<div class="text-right"><span onclick="formWindow('CMYK', true)">Módosítás</span></div>		
				</article>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<article class="pick">
					<h2>HEXA</h2>
					<div class="text-right"><span onclick="formWindow('HEXA', true)">Módosítás</span></div>
				</article>
			</div>
		</div>
	</div>
	<hr>
	<div class="container p-3">
		<div class="row">
			<h1 id="CC-Kontrasztok">Kontrasztok</h1>
			<div class="col-md-4">
				<h2>I. Önmagában való</h2>
				<p>Az önmagában való kontraszt, intenzív, vibráló hatású tisztaszíneket használ. Talán a legegyserűbb színkontraszt, minden színt a maga világossági fokában hasnálunk fel - viszont az intenzítás érdekében a színek nem lehetnek szürkések. A tiszaszínek saturáltságot a maximumra kell fokozni, hogy elérhessék a kivánt eredményt.</p>
			</div>
			<div class="col-md-4">
				<svg class="CC-kompozicio" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 viewBox="0 0 5 5" style="enable-background:new 0 0 5 5;" xml:space="preserve">
					<g>
						<rect x="0" y="0" width="1" height="1"/>
						<rect x="1" y="0" width="1" height="1"/>
						<rect x="2" y="0" width="1" height="1"/>
						<rect x="3" y="0" width="1" height="1"/>
						<rect x="4" y="0" width="1" height="1"/>
						<rect x="0" y="1" width="1" height="1"/>
						<rect x="1" y="1" width="1" height="1"/>
						<rect x="2" y="1" width="1" height="1"/>
						<rect x="3" y="1" width="1" height="1"/>
						<rect x="4" y="1" width="1" height="1"/>
						<rect x="0" y="2" width="1" height="1"/>
						<rect x="1" y="2" width="1" height="1"/>
						<rect x="2" y="2" width="1" height="1"/>
						<rect x="3" y="2" width="1" height="1"/>
						<rect x="4" y="2" width="1" height="1"/>
						<rect x="0" y="3" width="1" height="1"/>
						<rect x="1" y="3" width="1" height="1"/>
						<rect x="2" y="3" width="1" height="1"/>
						<rect x="3" y="3" width="1" height="1"/>
						<rect x="4" y="3" width="1" height="1"/>
						<rect x="0" y="4" width="1" height="1"/>
						<rect x="1" y="4" width="1" height="1"/>
						<rect x="2" y="4" width="1" height="1"/>
						<rect x="3" y="4" width="1" height="1"/>
						<rect x="4" y="4" width="1" height="1"/>
					</g>
				</svg>
			</div>
			<div class="col-md-4">
				<h3>Színek</h3>
				<ul class="CC-paletta">
				</ul>
			</div>
		</div>
	</div>
	<div class="container p-3">
		<div class="row">
			<div class="col-md-4">
				<h2>II. Fény-Árnyék</h2>
				<p>A fény-árnyék kontraszt egy adott szín különböző tónusfókozatait mutathatja meg, vagy komponálható más színekkel is azonos világosságban - ilyenkor érdemes elkwrülni más kontrasztokat, amik megváltoztathatják a kompozció hatását.</p>
			</div>
			<div class="col-md-4">
				<svg class="CC-kompozicio" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 viewBox="0 0 10 10" style="enable-background:new 0 0 10 10;" xml:space="preserve">
					<g>
						<rect x="0" y="0" width="10" height="1"/>
						<rect x="0" y="1" width="10" height="1"/>
						<rect x="0" y="2" width="10" height="1"/>
						<rect x="0" y="3" width="10" height="1"/>
						<rect x="0" y="4" width="10" height="1"/>
						<rect x="0" y="5" width="10" height="1"/>
						<rect x="0" y="6" width="10" height="1"/>
						<rect x="0" y="7" width="10" height="1"/>
						<rect x="0" y="8" width="10" height="1"/>
						<rect x="0" y="9" width="10" height="1"/>
					</g>
				</svg>
			</div>
			<div class="col-md-4">
				<h3>Színek</h3>
				<ul class="CC-paletta">
				</ul>
			</div>
		</div>
	</div>
	<div class="container p-3">
		<div class="row">
			<div class="col-md-4">
				<h2>III. Hideg-Meleg</h2>
				<p>Ez a kontraszt a színek kölcsön hatásátát hívatott reprezentálni, a színek karakterét megváltoztatja az őket körülvevő színek. Többféle képen hathatnak, az egyik ilyen hatás a hideg-meleg. A hideg-meleg kontraszt feladata megmutatni, hogy a szín melegebbnek vagy éppenséggel hidegebbnk látszik egy másik szín környezetében.</p>
			</div>
			<div class="col-md-4">
				<svg class="CC-kompozicio" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 viewBox="0 0 7 7" style="enable-background:new 0 0 7 7;" xml:space="preserve">
					<g>
						<rect x="0" y="0" width="7" height="1"/>
						<rect x="0" y="1" width="7" height="1"/>
						<rect x="0" y="2" width="7" height="1"/>
						<rect x="0" y="3" width="7" height="1"/>
						<rect x="0" y="4" width="7" height="1"/>
						<rect x="0" y="5" width="7" height="1"/>
						<rect x="0" y="6" width="7" height="1"/>
					</g>
				</svg>
			</div>
			<div class="col-md-4">
				<h3>Színek</h3>
				<ul class="CC-paletta">
				</ul>
			</div>
		</div>
	</div>
	<div class="container p-3">
		<div class="row">
			<div class="col-md-4">
				<h2>IV. Komplementer</h2>
				<p>A színek harmóniája megköveteli a komplementer törvényt, azt hogy a színek keverékéből egy semleges szürke jöjjön létre. A szín komplementere megkapható, ha az összes értéket kivonjuk a maximális értékből. A kettő külömbözete adja ki a komplementert. Akkor csináltuk jól, ha a komplementer és az eredeti szín keveréke középszürke.</p>
			</div>
			<div class="col-md-4">
				<svg class="CC-kompozicio" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 viewBox="0 0 7 7" style="enable-background:new 0 0 7 7;" xml:space="preserve">
					<g>
						<rect x="0" y="0" width="1" height="1"/>
						<rect x="1" y="0" width="1" height="1"/>
						<rect x="2" y="0" width="1" height="1"/>
						<rect x="3" y="0" width="1" height="1"/>
						<rect x="4" y="0" width="1" height="1"/>
						<rect x="5" y="0" width="1" height="1"/>
						<rect x="6" y="0" width="1" height="1"/>
						<rect x="0" y="1" width="1" height="1"/>
						<rect x="1" y="1" width="1" height="1"/>
						<rect x="2" y="1" width="1" height="1"/>
						<rect x="3" y="1" width="1" height="1"/>
						<rect x="4" y="1" width="1" height="1"/>
						<rect x="5" y="1" width="1" height="1"/>
						<rect x="6" y="1" width="1" height="1"/>
						<rect x="0" y="2" width="1" height="1"/>
						<rect x="1" y="2" width="1" height="1"/>
						<rect x="2" y="2" width="1" height="1"/>
						<rect x="3" y="2" width="1" height="1"/>
						<rect x="4" y="2" width="1" height="1"/>
						<rect x="5" y="2" width="1" height="1"/>
						<rect x="6" y="2" width="1" height="1"/>
						<rect x="0" y="3" width="1" height="1"/>
						<rect x="1" y="3" width="1" height="1"/>
						<rect x="2" y="3" width="1" height="1"/>
						<rect x="3" y="3" width="1" height="1"/>
						<rect x="4" y="3" width="1" height="1"/>
						<rect x="5" y="3" width="1" height="1"/>
						<rect x="6" y="3" width="1" height="1"/>
						<rect x="0" y="4" width="1" height="1"/>
						<rect x="1" y="4" width="1" height="1"/>
						<rect x="2" y="4" width="1" height="1"/>
						<rect x="3" y="4" width="1" height="1"/>
						<rect x="4" y="4" width="1" height="1"/>
						<rect x="5" y="4" width="1" height="1"/>
						<rect x="6" y="4" width="1" height="1"/>
						<rect x="0" y="5" width="1" height="1"/>
						<rect x="1" y="5" width="1" height="1"/>
						<rect x="2" y="5" width="1" height="1"/>
						<rect x="3" y="5" width="1" height="1"/>
						<rect x="4" y="5" width="1" height="1"/>
						<rect x="5" y="5" width="1" height="1"/>
						<rect x="6" y="5" width="1" height="1"/>
						<rect x="0" y="6" width="1" height="1"/>
						<rect x="1" y="6" width="1" height="1"/>
						<rect x="2" y="6" width="1" height="1"/>
						<rect x="3" y="6" width="1" height="1"/>
						<rect x="4" y="6" width="1" height="1"/>
						<rect x="5" y="6" width="1" height="1"/>
						<rect x="6" y="6" width="1" height="1"/>
					</g>
				</svg>
			</div>
			<div class="col-md-4">
				<h3>Színek</h3>
				<ul class="CC-paletta">
				</ul>
			</div>
		</div>
	</div>
	<div class="container p-3">
		<div class="row">
			<div class="col-md-4">
				<h2>V. Szimultán</h2>
				<p>A szimultán módon létre jövő színek, nem ténylegesen jönnek létre, a szem hívja életre őket, hogy megalkossa a harmónikusságot a színek között. Emiatt egyes színek halványabbnak, míg más színek intenzívebbnek tetszenek a szem számára.</p>
			</div>
			<div class="col-md-4">
				<svg class="CC-kompozicio" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 viewBox="0 0 9 9" style="enable-background:new 0 0 9 9;" xml:space="preserve">
					<g>
						<rect x="0" y="0" width="1" height="1"/>
						<rect x="1" y="0" width="1" height="1"/>
						<rect x="2" y="0" width="1" height="1"/>
						<rect x="3" y="0" width="1" height="1"/>
						<rect x="4" y="0" width="1" height="1"/>
						<rect x="5" y="0" width="1" height="1"/>
						<rect x="6" y="0" width="1" height="1"/>
						<rect x="7" y="0" width="1" height="1"/>
						<rect x="8" y="0" width="1" height="1"/>
						<rect x="0" y="1" width="1" height="1"/>
						<rect x="1" y="1" width="1" height="1"/>
						<rect x="2" y="1" width="1" height="1"/>
						<rect x="3" y="1" width="1" height="1"/>
						<rect x="4" y="1" width="1" height="1"/>
						<rect x="5" y="1" width="1" height="1"/>
						<rect x="6" y="1" width="1" height="1"/>
						<rect x="7" y="1" width="1" height="1"/>
						<rect x="8" y="1" width="1" height="1"/>
						<rect x="0" y="2" width="1" height="1"/>
						<rect x="1" y="2" width="1" height="1"/>
						<rect x="2" y="2" width="1" height="1"/>
						<rect x="3" y="2" width="1" height="1"/>
						<rect x="4" y="2" width="1" height="1"/>
						<rect x="5" y="2" width="1" height="1"/>
						<rect x="6" y="2" width="1" height="1"/>
						<rect x="7" y="2" width="1" height="1"/>
						<rect x="8" y="2" width="1" height="1"/>
						<rect x="0" y="3" width="1" height="1"/>
						<rect x="1" y="3" width="1" height="1"/>
						<rect x="2" y="3" width="1" height="1"/>
						<rect x="3" y="3" width="1" height="1"/>
						<rect x="4" y="3" width="1" height="1"/>
						<rect x="5" y="3" width="1" height="1"/>
						<rect x="6" y="3" width="1" height="1"/>
						<rect x="7" y="3" width="1" height="1"/>
						<rect x="8" y="3" width="1" height="1"/>
						<rect x="0" y="4" width="1" height="1"/>
						<rect x="1" y="4" width="1" height="1"/>
						<rect x="2" y="4" width="1" height="1"/>
						<rect x="3" y="4" width="1" height="1"/>
						<rect x="4" y="4" width="1" height="1"/>
						<rect x="5" y="4" width="1" height="1"/>
						<rect x="6" y="4" width="1" height="1"/>
						<rect x="7" y="4" width="1" height="1"/>
						<rect x="8" y="4" width="1" height="1"/>
						<rect x="0" y="5" width="1" height="1"/>
						<rect x="1" y="5" width="1" height="1"/>
						<rect x="2" y="5" width="1" height="1"/>
						<rect x="3" y="5" width="1" height="1"/>
						<rect x="4" y="5" width="1" height="1"/>
						<rect x="5" y="5" width="1" height="1"/>
						<rect x="6" y="5" width="1" height="1"/>
						<rect x="7" y="5" width="1" height="1"/>
						<rect x="8" y="5" width="1" height="1"/>
						<rect x="0" y="6" width="1" height="1"/>
						<rect x="1" y="6" width="1" height="1"/>
						<rect x="2" y="6" width="1" height="1"/>
						<rect x="3" y="6" width="1" height="1"/>
						<rect x="4" y="6" width="1" height="1"/>
						<rect x="5" y="6" width="1" height="1"/>
						<rect x="6" y="6" width="1" height="1"/>
						<rect x="7" y="6" width="1" height="1"/>
						<rect x="8" y="6" width="1" height="1"/>
						<rect x="0" y="7" width="1" height="1"/>
						<rect x="1" y="7" width="1" height="1"/>
						<rect x="2" y="7" width="1" height="1"/>
						<rect x="3" y="7" width="1" height="1"/>
						<rect x="4" y="7" width="1" height="1"/>
						<rect x="5" y="7" width="1" height="1"/>
						<rect x="6" y="7" width="1" height="1"/>
						<rect x="7" y="7" width="1" height="1"/>
						<rect x="8" y="7" width="1" height="1"/>
						<rect x="0" y="8" width="1" height="1"/>
						<rect x="1" y="8" width="1" height="1"/>
						<rect x="2" y="8" width="1" height="1"/>
						<rect x="3" y="8" width="1" height="1"/>
						<rect x="4" y="8" width="1" height="1"/>
						<rect x="5" y="8" width="1" height="1"/>
						<rect x="6" y="8" width="1" height="1"/>
						<rect x="7" y="8" width="1" height="1"/>
						<rect x="8" y="8" width="1" height="1"/>
					</g>
				</svg>
			</div>
			<div class="col-md-4">
				<h3>Színek</h3>
				<ul class="CC-paletta">
				</ul>
			</div>
		</div>
	</div>
	<div class="container p-3">
		<div class="row">
			<div class="col-md-4">
				<h2>VI. Minőségi</h2>
				<p>A minőségi kontraszt egy tiszta színnel és egy szürke színnel kialakítható. A szürke szín mindig egy <i>befolyésoló</i> szín. Mivel a tiszta színeket nagyon erősen megtöri, befolyásolja, a kontrszt a szürke ezen tuljdonságát hangsúlyozza.</p>
			</div>
			<div class="col-md-4">
				<svg class="CC-kompozicio" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 viewBox="0 0 5 5" style="enable-background:new 0 0 5 5;" xml:space="preserve">
					<g>
						<rect x="0" y="0" width="1" height="1"/>
						<rect x="1" y="0" width="1" height="1"/>
						<rect x="2" y="0" width="1" height="1"/>
						<rect x="3" y="0" width="1" height="1"/>
						<rect x="4" y="0" width="1" height="1"/>
						<rect x="0" y="1" width="1" height="1"/>
						<rect x="1" y="1" width="1" height="1"/>
						<rect x="2" y="1" width="1" height="1"/>
						<rect x="3" y="1" width="1" height="1"/>
						<rect x="4" y="1" width="1" height="1"/>
						<rect x="0" y="2" width="1" height="1"/>
						<rect x="1" y="2" width="1" height="1"/>
						<rect x="2" y="2" width="1" height="1"/>
						<rect x="3" y="2" width="1" height="1"/>
						<rect x="4" y="2" width="1" height="1"/>
						<rect x="0" y="3" width="1" height="1"/>
						<rect x="1" y="3" width="1" height="1"/>
						<rect x="2" y="3" width="1" height="1"/>
						<rect x="3" y="3" width="1" height="1"/>
						<rect x="4" y="3" width="1" height="1"/>
						<rect x="0" y="4" width="1" height="1"/>
						<rect x="1" y="4" width="1" height="1"/>
						<rect x="2" y="4" width="1" height="1"/>
						<rect x="3" y="4" width="1" height="1"/>
						<rect x="4" y="4" width="1" height="1"/>
					</g>
				</svg>
			</div>
			<div class="col-md-4">
				<h3>Színek</h3>
				<ul class="CC-paletta">
				</ul>
			</div>
		</div>
	</div>
	<hr>
	<div class="container p-3">
		<div class="row">
			<div class="col-md-4">
				<h2>Javaslat</h2>
				<p>A szürke színekkel sok hatás érhető el. Az első szín, mindig fekete vagy fehér, egy javaslat, melyik színnel érdemes használni, mint például betű szín. A második megpróbál visszaadni a tényleges világossági fokát a színnek. A többi pedig az absztrakt hatást próbálja elérni vagy mellőzni.</p>
				<p>Az absztrakt hatás egy tényleges szín (nem szürke) és szürke kölcsönhatásából születik meg, minél inkább eltér az említett második színtől a szürke, annál erősebb ez az összkép.</p>
			</div>
			<div class="col-md-4">
				<svg class="CC-kompozicio" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 viewBox="0 0 9 9" style="enable-background:new 0 0 9 9;" xml:space="preserve">
					<g>
						<rect x="0" y="0" width="1" height="1"/>
						<rect x="1" y="0" width="1" height="1"/>
						<rect x="2" y="0" width="1" height="1"/>
						<rect x="3" y="0" width="1" height="1"/>
						<rect x="4" y="0" width="1" height="1"/>
						<rect x="5" y="0" width="1" height="1"/>
						<rect x="6" y="0" width="1" height="1"/>
						<rect x="7" y="0" width="1" height="1"/>
						<rect x="8" y="0" width="1" height="1"/>
						<rect x="0" y="1" width="1" height="1"/>
						<rect x="1" y="1" width="1" height="1"/>
						<rect x="2" y="1" width="1" height="1"/>
						<rect x="3" y="1" width="1" height="1"/>
						<rect x="4" y="1" width="1" height="1"/>
						<rect x="5" y="1" width="1" height="1"/>
						<rect x="6" y="1" width="1" height="1"/>
						<rect x="7" y="1" width="1" height="1"/>
						<rect x="8" y="1" width="1" height="1"/>
						<rect x="0" y="2" width="1" height="1"/>
						<rect x="1" y="2" width="1" height="1"/>
						<rect x="2" y="2" width="1" height="1"/>
						<rect x="3" y="2" width="1" height="1"/>
						<rect x="4" y="2" width="1" height="1"/>
						<rect x="5" y="2" width="1" height="1"/>
						<rect x="6" y="2" width="1" height="1"/>
						<rect x="7" y="2" width="1" height="1"/>
						<rect x="8" y="2" width="1" height="1"/>
						<rect x="0" y="3" width="1" height="1"/>
						<rect x="1" y="3" width="1" height="1"/>
						<rect x="2" y="3" width="1" height="1"/>
						<rect x="3" y="3" width="1" height="1"/>
						<rect x="4" y="3" width="1" height="1"/>
						<rect x="5" y="3" width="1" height="1"/>
						<rect x="6" y="3" width="1" height="1"/>
						<rect x="7" y="3" width="1" height="1"/>
						<rect x="8" y="3" width="1" height="1"/>
						<rect x="0" y="4" width="1" height="1"/>
						<rect x="1" y="4" width="1" height="1"/>
						<rect x="2" y="4" width="1" height="1"/>
						<rect x="3" y="4" width="1" height="1"/>
						<rect x="4" y="4" width="1" height="1"/>
						<rect x="5" y="4" width="1" height="1"/>
						<rect x="6" y="4" width="1" height="1"/>
						<rect x="7" y="4" width="1" height="1"/>
						<rect x="8" y="4" width="1" height="1"/>
						<rect x="0" y="5" width="1" height="1"/>
						<rect x="1" y="5" width="1" height="1"/>
						<rect x="2" y="5" width="1" height="1"/>
						<rect x="3" y="5" width="1" height="1"/>
						<rect x="4" y="5" width="1" height="1"/>
						<rect x="5" y="5" width="1" height="1"/>
						<rect x="6" y="5" width="1" height="1"/>
						<rect x="7" y="5" width="1" height="1"/>
						<rect x="8" y="5" width="1" height="1"/>
						<rect x="0" y="6" width="1" height="1"/>
						<rect x="1" y="6" width="1" height="1"/>
						<rect x="2" y="6" width="1" height="1"/>
						<rect x="3" y="6" width="1" height="1"/>
						<rect x="4" y="6" width="1" height="1"/>
						<rect x="5" y="6" width="1" height="1"/>
						<rect x="6" y="6" width="1" height="1"/>
						<rect x="7" y="6" width="1" height="1"/>
						<rect x="8" y="6" width="1" height="1"/>
						<rect x="0" y="7" width="1" height="1"/>
						<rect x="1" y="7" width="1" height="1"/>
						<rect x="2" y="7" width="1" height="1"/>
						<rect x="3" y="7" width="1" height="1"/>
						<rect x="4" y="7" width="1" height="1"/>
						<rect x="5" y="7" width="1" height="1"/>
						<rect x="6" y="7" width="1" height="1"/>
						<rect x="7" y="7" width="1" height="1"/>
						<rect x="8" y="7" width="1" height="1"/>
						<rect x="0" y="8" width="1" height="1"/>
						<rect x="1" y="8" width="1" height="1"/>
						<rect x="2" y="8" width="1" height="1"/>
						<rect x="3" y="8" width="1" height="1"/>
						<rect x="4" y="8" width="1" height="1"/>
						<rect x="5" y="8" width="1" height="1"/>
						<rect x="6" y="8" width="1" height="1"/>
						<rect x="7" y="8" width="1" height="1"/>
						<rect x="8" y="8" width="1" height="1"/>
					</g>
				</svg>
			</div>
			<div class="col-md-4">
				<h3>Színek</h3>
				<ul class="CC-paletta">
				</ul>
			</div>
		</div>
	</div>
	<form id="CC-Collection" style="display: none;">
		<hr>
		<div class="container p-3">
			<div class="row">
				<h2>COLOR-COLLECTION</h2>
			</div>
		</div>
	</form>

	<div class="CC-dock border" onclick="winCollection()">
	</div>

	<div id="CC-form">
		<nav class="container-fluid p-3 dark text-white"></nav>
		<div class="container-fluid p-3">
			<form method="GET" id="CC-form-RGB" class="full-form">
				<label>Red</label>
				<input type="number" min="0" max="255" value="0" onchange="formChange('RGB',this.value, 1)">
				<input type="range" min="0" max="255" value="0" onchange="formChange('RGB',this.value, 0)">
				<label>Green</label>
				<input type="number" min="0" max="255" value="0" onchange="formChange('RGB',this.value, 3)">
				<input type="range" min="0" max="255" value="0" onchange="formChange('RGB',this.value, 2)">
				<label>Blue</label>
				<input type="number" min="0" max="255" value="0" onchange="formChange('RGB',this.value, 5)">
				<input type="range" min="0" max="255" value="0" onchange="formChange('RGB',this.value, 4)">
				<input type="hidden" name="code" value="">
				<input type="hidden" name="tipus" value="">
				<input type="submit" onclick="valtozas(0);" value="változtatás">
			</form>

			<form method="GET" id="CC-form-RYB" class="full-form">
				<label>Red</label>
				<input type="number" min="0" max="255" value="0"onchange="formChange('RYB',this.value, 1)">
				<input type="range" min="0" max="255" value="0" onchange="formChange('RYB',this.value, 0)">
				<label>Yellow</label>
				<input type="number" min="0" max="255" value="0" onchange="formChange('RYB',this.value, 3)">
				<input type="range" min="0" max="255" value="0" onchange="formChange('RYB',this.value, 2)">
				<label>Blue</label>
				<input type="number" min="0" max="255" value="0" onchange="formChange('RYB',this.value, 5)">
				<input type="range" min="0" max="255" value="0" onchange="formChange('RYB',this.value, 4)">
				<input type="hidden" name="code" value="">
				<input type="hidden" name="tipus" value="">
				<input type="submit" value="változtatás">
			</form>

			<form method="GET" id="CC-form-HSL" class="full-form">
				<label>Hue</label>
				<input type="number"onchange="formChange('HSL',this.value, 1)">
				<input type="range" min="0" max="359" value="0" onchange="formChange('HSL',this.value, 0)">
				<label>Saturation</label>
				<input type="number" onchange="formChange('HSL',this.value, 3)">
				<input type="range" min="0" max="100" value="0" onchange="formChange('HSL',this.value, 2)">
				<label>Lightness</label>
				<input type="number" onchange="formChange('HSL',this.value, 5)">
				<input type="range" min="0" max="100" value="0" onchange="formChange('HSL',this.value, 4)">
				<input type="hidden" name="code" value="">
				<input type="hidden" name="tipus" value="">
				<input type="submit" value="változtatás">
			</form>

			<form method="GET" id="CC-form-HSV" class="full-form">
				<label>Hue</label>
				<input type="number"onchange="formChange('HSV',this.value, 1)">
				<input type="range" min="0" max="359" value="0" onchange="formChange('HSV',this.value, 0)">
				<label>Saturation</label>
				<input type="number" onchange="formChange('HSV',this.value, 3)">
				<input type="range" min="0" max="100" value="0" onchange="formChange('HSV',this.value, 2)">
				<label>Value</label>
				<input type="number" onchange="formChange('HSV',this.value, 5)">
				<input type="range" min="0" max="100" value="0" onchange="formChange('HSV',this.value, 4)">
				<input type="hidden" name="code" value="">
				<input type="hidden" name="tipus" value="">
				<input type="submit" value="változtatás">
			</form>

			<form method="GET" id="CC-form-CMYK" class="full-form">
				<label>Cyan</label>
				<input type="number"onchange="formChange('CMYK',this.value, 1)">
				<input type="range" min="0" max="100" value="0" onchange="formChange('CMYK',this.value, 0)">
				<label>Magenta</label>
				<input type="number" onchange="formChange('CMYK',this.value, 3)">
				<input type="range" min="0" max="100" value="0" onchange="formChange('CMYK',this.value, 2)">
				<label>Yellow</label>
				<input type="number" onchange="formChange('CMYK',this.value, 5)">
				<input type="range" min="0" max="100" value="0" onchange="formChange('CMYK',this.value, 4)">
				<label>Key</label>
				<input type="number" onchange="formChange('CMYK',this.value, 7)">
				<input type="range" min="0" max="100" value="0" onchange="formChange('CMYK',this.value, 6)">
				<input type="hidden" name="code" value="">
				<input type="hidden" name="tipus" value="">
				<input type="submit" value="változtatás">
			</form>

			<form method="GET" id="CC-form-HEXA" class="full-form">
				<label>Hexadecimal</label>
				<input type="text" onchange="if(hexaVal(this.value)){formChange('HEXA', this.value, 0);}">
				<input type="hidden" name="code" value="">
				<input type="hidden" name="tipus" value="">
				<input type="submit" value="változtatás">
			</form>
		</div>
	</div>
	
</body>
</html>
<script type="text/javascript" src="../JS/script.js"></script>
<script type="text/javascript">
	function fullLoad()
	{
		<?php
		if (strtoupper($_GET["tipus"]) == "RGB")
		{
			$tagok = explode("-", $_GET["code"]);
			echo "var red =".$tagok[0].";";
			echo "var green =".$tagok[1].";";
			echo "var blue =".$tagok[2].";";
			echo "loadRGB(red, green, blue);";
		}
		if (strtoupper($_GET["tipus"]) == "RYB")
		{
			$tagok = explode("-", $_GET["code"]);
			echo "var red =".$tagok[0].";";
			echo "var yellow =".$tagok[1].";";
			echo "var blue =".$tagok[2].";";
			echo "loadRYB(red, yellow, blue);";
		}
		if (strtoupper($_GET["tipus"]) == "HSL")
		{
			$tagok = explode("-", $_GET["code"]);
			echo "var hue =".$tagok[0].";";
			echo "var saturation =".$tagok[1].";";
			echo "var lightness =".$tagok[2].";";
			echo "loadHSL(hue, saturation, lightness);";
		}
		if (strtoupper($_GET["tipus"]) == "HSV")
		{
			$tagok = explode("-", $_GET["code"]);
			echo "var hue =".$tagok[0].";";
			echo "var saturation =".$tagok[1].";";
			echo "var valu =".$tagok[2].";";
			echo "loadHSV(hue, saturation, valu);";
		}
		if (strtoupper($_GET["tipus"]) == "CMYK")
		{
			$tagok = explode("-", $_GET["code"]);
			echo "var cyan =".$tagok[0].";";
			echo "var magenta =".$tagok[1].";";
			echo "var yellow =".$tagok[2].";";
			echo "var key =".$tagok[3].";";
			echo "loadCMYK(cyan, magenta, yellow, key);";
		}
		if (strtoupper($_GET["tipus"]) == "HEXA")
		{
			$tagok = explode("-", $_GET["code"]);
			echo "var hexa ='".$tagok[0]."';";
			echo "loadHEXA(hexa);";
		}
		?>
		//document.onload = formAutoSubmit();
		//loadHistory();
		kontrasztHidegMeleg();
		kontrasztKomplementer();
		kontrasztFenyArnyek();
		kontrasztSzimultan();
		kontrasztMinosegi();
		kontrasztOnmagaban();
		kontrasztSzurkek();
	}
</script>