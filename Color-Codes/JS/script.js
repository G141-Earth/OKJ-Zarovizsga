//GLOBÁLIS VÁLTOZOK
var aSzin;
var collection

function RGB2HSL(tombRGB)
	{
		var nums = [Number(tombRGB[0])/256, Number(tombRGB[1])/256, Number(tombRGB[2])/256];
		var max = Math.max(nums[0], nums[1], nums[2]);
		var min = Math.min(nums[0], nums[1], nums[2]);
		var delta = max - min;
		var lightness = (max+min) / 2;
		var saturation = delta == 0 ? 0 : delta/(1-Math.abs(2*lightness-1));
		var hue = -1;
		if (delta == 0) {hue = 0;}
		else if (max == nums[0]) {hue = Math.round(60*((nums[1]-nums[2])/delta%6));}
		else if (max == nums[1]) {hue = Math.round(60*((nums[2]-nums[0])/delta+2));}
		else if (max == nums[2]) {hue = Math.round(60*((nums[0]-nums[1])/delta+4));}
		hue = (hue < 0 ? 360-(hue*-1) : hue);
		return [hue, Math.round(saturation*100), Math.round(lightness*100)];
	}

	function RGB2RYB(tombRGB)
	{
		var iRed = tombRGB[0];
		var iGreen = tombRGB[1];
		var iBlue = tombRGB[2];

		var iWhite = Math.min(iRed, iGreen, iBlue);
		
		iRed   -= iWhite;
		iGreen -= iWhite;
		iBlue  -= iWhite;
		
		var iMaxGreen = Math.max(iRed, iGreen, iBlue);
		
		var iYellow = Math.min(iRed, iGreen);
		
		iRed   -= iYellow;
		iGreen -= iYellow;
		
		if (iBlue > 0 && iGreen > 0)
		{
			iBlue  /= 2;
			iGreen /= 2;
		}

		iYellow += iGreen;
		iBlue   += iGreen;
		
		var iMaxYellow = Math.max(iRed, iYellow, iBlue);
		
		if (iMaxYellow > 0)
		{
			var iN = iMaxGreen / iMaxYellow;
			
			iRed    *= iN;
			iYellow *= iN;
			iBlue   *= iN;
		}
		
		iRed    += iWhite;
		iYellow += iWhite;
		iBlue   += iWhite;
		
		return new Array(Math.floor(iRed), Math.floor(iYellow), Math.floor(iBlue));
	}

	function RYB2RGB(tombRYB)
	{
		var iRed = tombRYB[0];
		var iYellow = tombRYB[1];
		var iBlue = tombRYB[2];

		var iWhite = Math.min(iRed, iYellow, iBlue);
		
		iRed    -= iWhite;
		iYellow -= iWhite;
		iBlue   -= iWhite;

		var iMaxYellow = Math.max(iRed, iYellow, iBlue);

		// Get the green out of the yellow and blue
		var iGreen = Math.min(iYellow, iBlue);
		
		iYellow -= iGreen;
		iBlue   -= iGreen;

		if (iBlue > 0 && iGreen > 0)
		{
			iBlue  *= 2.0;
			iGreen *= 2.0;
		}
		
		// Redistribute the remaining yellow.
		iRed   += iYellow;
		iGreen += iYellow;

		// Normalize to values.
		var iMaxGreen = Math.max(iRed, iGreen, iBlue);
		
		if (iMaxGreen > 0)
		{
			var iN = iMaxYellow / iMaxGreen;
			
			iRed   *= iN;
			iGreen *= iN;
			iBlue  *= iN;
		}
		
		// Add the white back in.
		iRed   += iWhite;
		iGreen += iWhite;
		iBlue  += iWhite;

		// Save the RGB
		return new Array(Math.floor(iRed), Math.floor(iGreen), Math.floor(iBlue));
	}

	function RGB2HSV(tombRGB)
	{
		var nums = [Number(tombRGB[0])/256, Number(tombRGB[1])/256, Number(tombRGB[2])/256];
		var max = Math.max(nums[0], nums[1], nums[2]);
		var min = Math.min(nums[0], nums[1], nums[2]);
		var delta = max - min;
		var value = max;
		var saturation = delta == 0 ? 0 : delta/max;
		var hue = -1;
		if (delta == 0) {hue = 0;}
		else if (max == nums[0]) {hue = Math.round(60*((nums[1]-nums[2])/delta%6));}
		else if (max == nums[1]) {hue = Math.round(60*((nums[2]-nums[0])/delta+2));}
		else if (max == nums[2]) {hue = Math.round(60*((nums[0]-nums[1])/delta+4));}
		hue = (hue < 0 ? 360-(hue*-1) : hue);
		return [hue, Math.round(saturation*100), Math.round(value*100)];
	}

	function HSV2RGB(tombHSV)
	{
		var nums = [Number(tombHSV[0]), Number(tombHSV[1]/100), Number(tombHSV[2]/100)];
		var c = nums[2]*nums[1];
		var x = c * (1-Math.abs((nums[0]/60)%2 -1));
		var m = nums[2] - c;
		var back = [];
		if (nums[0] < 60) {back = [c, x, 0];}
		else if (nums[0] < 120) {back = [x, c, 0];}
		else if (nums[0] < 180) {back = [0, c, x];}
		else if (nums[0] < 240) {back = [0, x, c];}
		else if (nums[0] < 300) {back = [x, 0, c];}
		else {back = [c, 0, x];}
		back = [(back[0]+m)*255, (back[1]+m)*255, (back[2]+m)*255];
		return [Math.round(back[0]), Math.round(back[1]), Math.round(back[2])];
	}

	function CMYK2RGB(tombCMYK)
	{
		var nums = [Number(tombCMYK[0]/100), Number(tombCMYK[1]/100), Number(tombCMYK[2]/100), Number(tombCMYK[3]/100)];
		var back = [255 * (1-nums[0]) * (1-nums[3]), 255 * (1-nums[1]) * (1-nums[3]), 255 * (1-nums[2]) * (1-nums[3])];
		return [Math.round(back[0]), Math.round(back[1]), Math.round(back[2])];
	}

	function RGB2CMYK(tombRGB)
	{
		var nums = [Number(tombRGB[0])/255, Number(tombRGB[1])/255, Number(tombRGB[2])/255];
		var key = 1-Math.max(nums[0], nums[1], nums[2]);
		var cyan = Math.round((1-nums[0]-key)/(1-key)*100);
		var magenta = Math.round((1-nums[1]-key)/(1-key)*100);
		var yellow = Math.round((1-nums[2]-key)/(1-key)*100);
		key = Math.round(key*100);
		return new Array(cyan, magenta, yellow, key);
	}

	function RGB2HEXA(tombRGB)
	{
		var back = "#";
		var hexa = ["0","1","2","3","4","5","6","7","8","9","A","B","C","D","E","F"];
		for (var i = 0; i < tombRGB.length; i++) {
			var elso = Math.floor(tombRGB[i] / 16);
			var masodik = tombRGB[i] - elso*16;
			back += hexa[elso]+hexa[masodik];
		}
		return back;
	}

	function HSL2RGB(tombHSL)
	{
		var nums = [Number(tombHSL[0]), Number(tombHSL[1])/100, Number(tombHSL[2])/100];
		var c = (1 - Math.abs(2*nums[2] - 1)) * nums[1];
		var x = c * ( 1 - Math.abs((nums[0]/60) % 2 - 1));
		var back = [];
		var m = nums[2] - c/2;
		if (nums[0] < 60) {back = [c, x, 0];}
		else if (nums[0] < 120) {back = [x, c, 0];}
		else if (nums[0] < 180) {back = [0, c, x];}
		else if (nums[0] < 240) {back = [0, x, c];}
		else if (nums[0] < 300) {back = [x, 0, c];}
		else if (nums[0] < 360) {back = [c, 0, x];}
		return [Math.round((back[0]+m)*255), Math.round((back[1]+m)*255), Math.round((back[2]+m)*255)];
	}

	function HEXA2RGB(hexa)
	{
		var hexa = hexa.slice(1,7).toUpperCase();
		var rgb = [0,0,0];
		for (var i = 0; i < hexa.length; i++) {
			var temp = i % 2 == 0 ? 16 : 1;
			if (hexa[i] == '0') { temp = 0*temp; }
			if (hexa[i] == '1') { temp = 1*temp; }
			if (hexa[i] == '2') { temp = 2*temp; }
			if (hexa[i] == '3') { temp = 3*temp; }
			if (hexa[i] == '4') { temp = 4*temp; }
			if (hexa[i] == '5') { temp = 5*temp; }
			if (hexa[i] == '6') { temp = 6*temp; }
			if (hexa[i] == '7') { temp = 7*temp; }
			if (hexa[i] == '8') { temp = 8*temp; }
			if (hexa[i] == '9') { temp = 9*temp; }
			if (hexa[i] == 'A') { temp = 10*temp; }
			if (hexa[i] == 'B') { temp = 11*temp; }
			if (hexa[i] == 'C') { temp = 12*temp; }
			if (hexa[i] == 'D') { temp = 13*temp; }
			if (hexa[i] == 'E') { temp = 14*temp; }
			if (hexa[i] == 'F') { temp = 15*temp; }
			rgb[i % 2 == 0 ? i/2 : (i-1)/2] += temp;
			temp = 0;
		}
		return rgb;
	}

	///////////////////////////////////////////////////////////////////////////////

	function loadRGB(red, green, blue)
	{
		var RGB = [red, green, blue];
		var HSL = RGB2HSL(RGB);
		darkStyle(HSL);
		var HSV = RGB2HSV(RGB);
		var RYB = RGB2RYB(RGB);
		var CMYK = RGB2CMYK(RGB);
		var HEXA = RGB2HEXA(RGB);
		document.getElementById('Layer').getElementsByTagName('rect')[0].style.fill="RGB("+RGB.slice()+")";
		filler("RGB", RGB);
		filler("RYB", RYB);
		filler("HSL", HSL);
		filler("HSV", HSV);
		filler("CMYK", CMYK);
		filler("HEXA", HEXA); 
		document.getElementById("CC-form").style.backgroundColor = "RGB("+RGB.slice()+")";
		document.getElementById('Layer').getElementsByTagName('rect')[0].style.fill="RGB("+RGB.slice()+")";
		aSzin = new Array(RGB, RYB, HSL, HSV, CMYK, HEXA);
		collection = new Array();
	}

	function loadRYB(red, yellow, blue)
	{
		var RYB = [red, yellow, blue];
		var RGB = RYB2RGB(RYB);
		var HSL = RGB2HSL(RGB);
		darkStyle(HSL);
		var HSV = RGB2HSV(RGB);
		var CMYK = RGB2CMYK(RGB);
		var HEXA = RGB2HEXA(RGB);
		document.getElementById('Layer').getElementsByTagName('rect')[0].style.fill="RGB("+RGB.slice()+")";
		filler("RGB", RGB);
		filler("RYB", RYB);
		filler("HSL", HSL);
		filler("HSV", HSV);
		filler("CMYK", CMYK);
		filler("HEXA", HEXA); 
		document.getElementById("CC-form").style.backgroundColor = "RGB("+RGB.slice()+")";
		document.getElementById('Layer').getElementsByTagName('rect')[0].style.fill="RGB("+RGB.slice()+")";
		aSzin = new Array(RGB, RYB, HSL, HSV, CMYK, HEXA);
		collection = new Array();
	}

	function loadHSL(hue, saturation, lightness)
	{
		var HSL = [hue, saturation, lightness];
		darkStyle(HSL);
		var RGB = HSL2RGB(HSL);
		var RYB = RGB2RYB(RGB);
		var HSV = RGB2HSV(RGB);
		var CMYK = RGB2CMYK(RGB);
		var HEXA = RGB2HEXA(RGB);
		document.getElementById('Layer').getElementsByTagName('rect')[0].style.fill="RGB("+RGB.slice()+")";
		filler("RGB", RGB);
		filler("RYB", RYB);
		filler("HSL", HSL);
		filler("HSV", HSV);
		filler("CMYK", CMYK);
		filler("HEXA", HEXA);
		document.getElementById("CC-form").style.backgroundColor = "RGB("+RGB.slice()+")";
		document.getElementById('Layer').getElementsByTagName('rect')[0].style.fill="RGB("+RGB.slice()+")";
		aSzin = new Array(RGB, RYB, HSL, HSV, CMYK, HEXA);
		collection = new Array();
	}

	function loadHSV(hue, saturation, valu)
	{
		var HSV = [hue, saturation, valu];
		var RGB = HSV2RGB(HSV);
		var HSL = RGB2HSL(RGB);
		darkStyle(HSL);
		var RYB = RGB2RYB(RGB);
		var HSV = RGB2HSV(RGB);
		var CMYK = RGB2CMYK(RGB);
		var HEXA = RGB2HEXA(RGB);
		document.getElementById('Layer').getElementsByTagName('rect')[0].style.fill="RGB("+RGB.slice()+")";
		filler("RGB", RGB);
		filler("RYB", RYB);
		filler("HSL", HSL);
		filler("HSV", HSV);
		filler("CMYK", CMYK);
		filler("HEXA", HEXA); 
		document.getElementById("CC-form").style.backgroundColor = "RGB("+RGB.slice()+")";
		document.getElementById('Layer').getElementsByTagName('rect')[0].style.fill="RGB("+RGB.slice()+")";
		aSzin = new Array(RGB, RYB, HSL, HSV, CMYK, HEXA);
		collection = new Array();
	}

	function loadCMYK(cyan, magenta, yellow, key)
	{
		var CMYK = [cyan, magenta, yellow, key];
		var RGB = CMYK2RGB(CMYK);
		var HSL = RGB2HSL(RGB);
		darkStyle(HSL);
		var RYB = RGB2RYB(RGB);
		var HSV = RGB2HSV(RGB);
		var HEXA = RGB2HEXA(RGB);
		document.getElementById('Layer').getElementsByTagName('rect')[0].style.fill="RGB("+RGB.slice()+")";
		filler("RGB", RGB);
		filler("RYB", RYB);
		filler("HSL", HSL);
		filler("HSV", HSV);
		filler("CMYK", CMYK);
		filler("HEXA", HEXA); 
		document.getElementById("CC-form").style.backgroundColor = "RGB("+RGB.slice()+")";
		document.getElementById('Layer').getElementsByTagName('rect')[0].style.fill="RGB("+RGB.slice()+")";
		aSzin = new Array(RGB, RYB, HSL, HSV, CMYK, HEXA);
		collection = new Array();
	}

	function loadHEXA(hexa)
	{
		var HEXA = "#"+hexa.toUpperCase();
		var RGB = HEXA2RGB(HEXA);
		var HSL = RGB2HSL(RGB);
		darkStyle(HSL);
		var HSV = RGB2HSV(RGB);
		var RYB = RGB2RYB(RGB);
		var CMYK = RGB2CMYK(RGB);
		
		document.getElementById('Layer').getElementsByTagName('rect')[0].style.fill="RGB("+RGB.slice()+")";
		filler("RGB", RGB);
		filler("RYB", RYB);
		filler("HSL", HSL);
		filler("HSV", HSV);
		filler("CMYK", CMYK);
		filler("HEXA", HEXA); 
		document.getElementById("CC-form").style.backgroundColor = "RGB("+RGB.slice()+")";
		document.getElementById('Layer').getElementsByTagName('rect')[0].style.fill="RGB("+RGB.slice()+")";
		aSzin = new Array(RGB, RYB, HSL, HSV, CMYK, HEXA);
		collection = new Array();
	}

	///////////////////////////////////////////////////////////////////////////////

	function formChange(tipus, ertek, index)
	{
		var inputs = document.getElementById("CC-form-"+tipus).getElementsByTagName("input");
		var labels = document.getElementById("CC-form-"+tipus).getElementsByTagName("label");
		var text = "";
		var temp = [];

		inputs[index].value = ertek;
		for (var i = 0; i < inputs.length-3; i+=2)
		{
			temp[i/2] = inputs[i].value;
			text += inputs[i].value + "-";
		}
		//Változik keveréstől függően
		backgroundSetter(temp, tipus);
		
		//Label írás
		index = index % 2 == 0 ? index : index-1;
		var name = labels[index/2].innerHTML.split(":")[0]
		labels[index/2].innerHTML = name +": "+ (tipus == "HEXA" ? "#" : "") + ertek ;
		inputs[inputs.length-3].value = text.slice(0, text.length-1);
	}

	function darkStyle(tombHSL)
	{
		var hue = tombHSL[0];
		var saturation = tombHSL[1];
		var lightness = 5;
		var temp = [hue+"deg", saturation+"%", lightness+"%"];
		document.getElementsByTagName('style')[0].innerHTML = ".dark{background-color: HSL("+temp.slice()+");}";
	}

	function backgroundSetter(minta, tipus)
	{
		var bg = document.getElementById("CC-form");
		if (tipus == "RGB")
			{
				bg.style.backgroundColor = "RGB("+minta.slice()+")";
			}
		if (tipus == "RYB")
			{
				minta = RYB2RGB(minta);
				bg.style.backgroundColor = "RGB("+minta.slice()+")";
			}
		if (tipus == "HSL")
			{
				bg.style.backgroundColor = "HSL("+minta[0]+"deg "+minta[1]+"% "+minta[2]+"%)";
			}
		if (tipus == "HSV")
			{
				minta = HSV2RGB(minta);
				bg.style.backgroundColor = "RGB("+minta.slice()+")";
			}
		if (tipus == "CMYK")
			{
				minta = CMYK2RGB(minta);
				bg.style.backgroundColor = "RGB("+minta.slice()+")";
			}
		if (tipus == "HEXA")
			{
				bg.style.backgroundColor = "#"+minta;
			}
	}

	function hexaVal(code)
	{
		var helyes = code.length == 6;
		code = code.toUpperCase();
		var betuk = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "A", "B", "C", "D", "E", "F"];
		for (var i = 0; i < code.length && helyes; i++)
		{
			helyes = betuk.includes(code[i]);
		}
		return helyes;
	}

	function formWindow(tipus, status)
	{
		if (status)
		{
			var nav = document.getElementById("CC-form").getElementsByTagName('nav')[0];
			nav.innerHTML = tipus;
			nav.onclick = function() {formWindow(tipus, false)};
		}
		else
		{
			backgroundSetter(aSzin[0], "RGB");
			var index = tipus == "RGB" ? 0 : tipus == "RYB" ? 1 : tipus == "HSL" ? 2 : tipus == "HSV" ? 3 : tipus == "CMYK" ? 4 : tipus == "HEXA" ? 5 : -1;
			filler(tipus, aSzin[index]);
		}
		status = status ? "block" : "none";
		document.getElementById("CC-form").style.display = status;
		document.getElementById("CC-form-"+tipus).style.display = status;
	}

	///////////////////////////////////////////////////////////////////////////////

	function filler(tipus, tomb)
	{
		tipus = tipus.toUpperCase();
		var index = tipus == "RGB" ? 0 : tipus == "RYB" ? 1 : tipus == "HSL" ? 2 : tipus == "HSV" ? 3 : tipus == "CMYK" ? 4 : tipus == "HEXA" ? 5 : -1;
		var objects = document.getElementsByClassName('CC-sor-'+tipus);
		var labels = document.getElementById("CC-form-"+tipus).getElementsByTagName("label");
		var inputs = document.getElementById("CC-form-"+tipus).getElementsByTagName("input");
		var line = "";
		var code = "";
		var noHexa = tipus != "HEXA";

		document.getElementsByTagName('h2')[index].innerHTML = tipus+" <span>"+tomb.slice()+"</span>";
		for (var i = 0; i < inputs.length-3; i+=2)
		{
			if (tipus == "RGB" ^ tipus == "RYB") { line = "<div style='width:"+(tomb[i/2]/255*100)+"%'></div>"; }
			if (tipus == "HSL" ^ tipus == "HSV" && i/2 == 0) { line = "<div style='width:"+(tomb[i/2]/360*100)+"%;background: hsl("+tomb[0]+"deg, 100%, 50%)'></div>"; }
			if (tipus == "HSL" && i/2 == 1) { line = "<div style='width:"+tomb[i/2]+"%;background: linear-gradient(to right, #808080, hsl("+tomb[0]+"deg, 100%, 50%))'></div>"; }
			if (tipus == "HSL" && i/2 == 2) { line = "<div style='width:"+tomb[i/2]+"%;background: linear-gradient(to right, #000000, hsl("+tomb[0]+"deg, 100%, 50%), #FFFFFF)'></div>"; }
			if (tipus == "HSV" && i/2 == 1) { line = "<div style='width:"+tomb[i/2]+"%;background: linear-gradient(to right, #FFFFFF, hsl("+tomb[0]+"deg, 100%, 50%))'></div>"; }
			if (tipus == "HSV" && i/2 == 2) { line = "<div style='width:"+tomb[i/2]+"%;background: linear-gradient(to right, #000000, hsl("+tomb[0]+"deg, 100%, 50%)'></div>"; }
			if (tipus == "CMYK") { line = "<div style='width:"+tomb[i/2]+"%'></div>"; }
			
			if (noHexa) { objects[i/2].innerHTML = line; }
			var name = labels[i/2].innerHTML.split(":")[0];
			labels[i/2].innerHTML = (name)+": "+(noHexa ? tomb[i/2] : tomb);
			inputs[i].value = noHexa ? tomb[i/2] : tomb.slice(1, 7);
			if (noHexa) { inputs[i+1].value = tomb[i/2]; }
		}
		for (var i = 0; i < tomb.length && noHexa; i++) {
			code += tomb[i]+"-";
		}
		code = noHexa ? code.slice(0, code.length-1) : tomb.slice(1, tomb.length);
		inputs[inputs.length-3].value = code;
		inputs[inputs.length-2].value = tipus;
	}

	///////////////////////////////////////////////////////////////////////////////

	function kontrasztKomplementer() {

		var arrays = kontasztSzinek(4);
		var nums = [[4,10,11,12,18], [26,32,33,34,40], [17,23,24,25,31], [30,36,37,38,44], [8,14,15,16,22]];
		kompozicioMegjelenites(arrays, nums, 4);
		szinMegjelenites(arrays, 3);
	}

	function kontrasztHidegMeleg()
	{
		var nums = [[0], [1], [2], [3], [4], [5], [6]];
		var arrays = kontasztSzinek(3);
		kompozicioMegjelenites(arrays, nums, 3);
		szinMegjelenites(arrays, 2);
	}

	function kontrasztFenyArnyek() {
		var arrays = kontasztSzinek(2);
		var nums = [[0], [1], [2], [3], [4], [5], [6], [7], [8], [9]];
		kompozicioMegjelenites(arrays, nums, 2);
		szinMegjelenites(arrays, 1);
	}

	function kontrasztSzimultan(){
		var arrays = kontasztSzinek(5);
		var nums = [[0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,29,30,32,33,35,36,38,39,41,42,44,45,47,48,50,51,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80], [28,37,46], [31,40,49], [34,43,52]];
		kompozicioMegjelenites(arrays, nums, 5);
		szinMegjelenites(arrays, 4);
	}

	function kontrasztMinosegi(){
		var arrays = kontasztSzinek(6);
		var nums = [[12], [7,11,13,17], [2,6,8,10,14,16,18,22], [1,3,5,9,15,19,21,23], [0,4,20,24]];
		kompozicioMegjelenites(arrays, nums, 6);
		szinMegjelenites(arrays, 5);
	}

	function kontrasztOnmagaban(){
		var arrays = kontasztSzinek(1);
		var nums = [[[9,14,17,18,19],4], [[1,2,3,8,13], 0], [[5,6,7,10,15],20], [[11,16,21,22,23], 24]];
		var all = rendezes(arrays[0], arrays[1], nums);
		arrays = all[0];
		nums = all[1]
		kompozicioMegjelenites(arrays, nums, 1);
		szinMegjelenites(arrays, 0);
	}

	function kontrasztSzurkek(){
		var arrays = kontasztSzinek(8);
		var nums = [[0,1,2,3,9,18,20,21,27,29,30], [4,10,11,12,13,14,15,16,19,22,25,28,31,34,36,37,38,39,40,41,42,43,44,46,49,52,55,58,61,64,65,66,67,68,69,70,76], [5,6,7,8,17,23,24,26,32,33,35], [45,47,48,54,56,57,63,72,73,74,75], [77,59,50,51,60,78,79,80,71,62,53]];
		kompozicioMegjelenites(arrays, nums, 7);
		szinMegjelenites(arrays, 6);
	}

	///////////////////////////////////////////////////////////////////////////////

	function CC_mix(szin1, szin2)
	{
		return new Array(Math.round((szin1[0]+szin2[0])/2), Math.round((szin1[1]+szin2[1])/2), Math.round((szin1[2]+szin2[2])/2));
	}

	function lepteto(lepes, kezdet, cel)
	{
		return Math.round(2 * lepes * cel - kezdet) / (lepes+1);
	}

	function betuSzin(tombRGB)
	{
		var lum = Math.round(luminance(tombRGB));
		var black = Math.round((lum <= 55 ? 0 : lum) / 100) > 0;
		return black;
	}

	function kontasztSzinek(id)
	{
		var arrays = [];
		if (id == 1)
		{
			var HSL = szinToleralas();
			var hue = HSL[0];
			var black = [];
			/*
			var lum = Math.round(luminance(HSL2RGB(HSL)));
			lum = lum <= 55 ? 0 : 100;
			lum = 100-Math.round(lum / 100)*100;
			*/

			arrays[0] = [hue, HSL[1], HSL[2]];
			hue = (hue+30)%360;
			arrays[1] = [hue, HSL[1], HSL[2]];
			hue = 360-hue;
			arrays[2] = [hue, HSL[1], HSL[2]];
			hue = Math.abs(hue-30);
			arrays[3] = [hue, HSL[1], HSL[2]];

			arrays[0] = HSL2RGB(arrays[0]);
			arrays[1] = HSL2RGB(arrays[1]);
			arrays[2] = HSL2RGB(arrays[2]);
			arrays[3] = HSL2RGB(arrays[3]);

			for (var i = 0; i < arrays.length; i++)
			{
				black[i] = betuSzin(arrays[i]);
			}
			arrays = [arrays, black];
		}
		if (id == 2)
		{
			var HSL = [aSzin[2][0], aSzin[2][1], aSzin[2][2]];
			HSL[2] = HSL[2] % 10;

			arrays = new Array(10);
			for (var i = 0; i < arrays.length; i++) {
				arrays[i] = [HSL[0], HSL[1], 100-(i*10+  (10-HSL[2]))];
				arrays[i] = HSL2RGB(arrays[i]);
			}
		}
		if (id == 3)
		{
			var HSL = [aSzin[2][0], aSzin[2][1], aSzin[2][2]];
			var hue = HSL[0] - 30;
			hue = hue < 0 ? hue + 360 : hue;

			arrays = new Array(7);
			for (var i = 0; i < arrays.length; i++)
			{
				arrays[i] = [hue, HSL[1], HSL[2]];
				arrays[i] = HSL2RGB(arrays[i]);
				hue = hue + 10 >= 360 ? 360-(hue+10) : hue + 10;
			}
			return arrays;
		}
		if (id == 4)
		{
			arrays[0] = [aSzin[1][0], aSzin[1][1], aSzin[1][2]];
			arrays[4] = [(255-arrays[0][0]) ,(255-arrays[0][1]),(255-arrays[0][2])];
			arrays[2] = CC_mix(arrays[0], arrays[4]);
			arrays[1] = CC_mix(arrays[0], arrays[2]);
			arrays[3] = CC_mix(arrays[4], arrays[2]);

			arrays[0] = RYB2RGB(arrays[0]);
			arrays[1] = RYB2RGB(arrays[1]);
			arrays[2] = RYB2RGB(arrays[2]);
			arrays[3] = RYB2RGB(arrays[3]);
			arrays[4] = RYB2RGB(arrays[4]);
			return arrays;
		}
		if (id == 5)
		{
			var HSL = szinToleralas();
			var lum = Math.round(luminance(HSL2RGB(HSL)));
			arrays[0] = RGB2RYB(HSL2RGB(HSL));
			arrays[4] = [(255-arrays[0][0]) ,(255-arrays[0][1]),(255-arrays[0][2])];
			arrays[2] = RGB2RYB(HSL2RGB(new Array(0,0,lum)));
			arrays[1] = CC_mix(arrays[0], arrays[2]);
			arrays[3] = CC_mix(arrays[4], arrays[2]);

			arrays[0] = RYB2RGB(arrays[0]);
			arrays[1] = RYB2RGB(arrays[1]);
			arrays[2] = RYB2RGB(arrays[2]);
			arrays[3] = RYB2RGB(arrays[3]);
			arrays[4] = RYB2RGB(arrays[4]);
			return arrays;
		}

		if (id == 6)
		{
			var HSL = szinToleralas();
			var lum = Math.round(luminance(HSL2RGB(HSL)));
			arrays[0] = RGB2RYB(HSL2RGB(HSL));
			arrays[4] = RGB2RYB(HSL2RGB(new Array(0,0,lum)));
			arrays[1] = CC_mix(arrays[0], arrays[4]);
			arrays[2] = CC_mix(arrays[1], arrays[4]);
			arrays[3] = CC_mix(arrays[2], arrays[4]);

			arrays[0] = RYB2RGB(arrays[0]);
			arrays[1] = RYB2RGB(arrays[1]);
			arrays[2] = RYB2RGB(arrays[2]);
			arrays[3] = RYB2RGB(arrays[3]);
			arrays[4] = RYB2RGB(arrays[4]);
			return arrays;
		}
		//Nem kontraszt
		if (id == 8)
		{
			var rgb = [aSzin[0][0], aSzin[0][1], aSzin[0][2]];
			var lum = Math.round(luminance(rgb));
			var black = betuSzin(rgb);
			arrays[0] = black ? new Array(0,0,0) : new Array(255,255,255);
			arrays[1] = new Array(aSzin[1][0], aSzin[1][1], aSzin[1][2]);
			arrays[2] = RGB2RYB(HSL2RGB(new Array(0,0,lum)));
			var gray = arrays[2][0] - 64 < 0 ? 255 + arrays[2][0] - 64 : arrays[2][0] - 64 ;
			arrays[3] = [gray, gray, gray];
			gray = gray + 128 > 255 ? gray + 128 - 255 : gray + 128;
			arrays[4] = [gray, gray, gray];

			arrays[0] = RYB2RGB(arrays[0]);
			arrays[1] = RYB2RGB(arrays[1]);
			arrays[2] = RYB2RGB(arrays[2]);
			arrays[3] = RYB2RGB(arrays[3]);
			arrays[4] = RYB2RGB(arrays[4]);
			return arrays;
		}
		return arrays;
	}

	function szinMegjelenites(szinek, index)
	{
		var paletta = document.getElementsByClassName("CC-paletta")[index];
		paletta.innerHTML = "";
		for (var i = 0; i < szinek.length; i++)
		{
			if (i == 6-1 && szinek.length > 6)
				{
					paletta.innerHTML += "<li style='height: auto'><ul></ul><button class='border'>További szín</button></li>";
					paletta = paletta.getElementsByTagName('ul')[0];
				}
			var hexa = RGB2HEXA(szinek[i]).substring(1, 7);
			var url = "http://localhost/color-codes/Content/color.php?tipus=hexa&code="+hexa;
			var font = betuSzin(szinek[i]) ? "#000000" : "#FFFFFF";
			paletta.innerHTML += "<li style='background-color:rgb("+szinek[i].slice()+")' class='border'><a style='color: "+font+"' href='"+url+"'>#"+hexa+"</a></li>";
			//onclick='addCollection(\""+hexa+"\" title='#"+hexa+"')'
		}
	}

	function kompozicioMegjelenites(szinek, szamok, index)
	{
		var kompozicio = document.getElementsByTagName('svg')[index];
		kompozicio = kompozicio.getElementsByTagName('rect');
		for (var i = 0; i < szamok.length; i++) {
			for (var j = 0; j < szamok[i].length; j++) {
				kompozicio[szamok[i][j]].style.fill = "RGB("+szinek[i].slice()+")";
			}
		}
	}

	function loadHistory()
	{
		document.getElementById("history").getElementsByTagName('input')[0].value = aSzin[aSzin.length-1].substring(1, 7);
		//document.forms['CC-history'].submit();
	}

	///////////////////////////////////////////////////////////////////////////////

	function linear(part)
	{
		var part = part/255;
		var back = part <= 0.04045 ? part / 12.92 : Math.pow((( part + 0.055)/1.055),2.4);
		return back;
	}

	function luminance(color)
	{
		var red = new Array(color[0], linear(color[0]), 0.2126);
		var green = new Array(color[1], linear(color[1]), 0.7152);
		var blue = new Array(color[2], linear(color[2]), 0.0722);
		var Y = red[1]*red[2] + green[1]*green[2] + blue[1]*blue[2];
		var L = Y <= 0.008856 ? Y * 903.3 : (Math.pow(Y,(1/3)) * 116 - 16);
		return L;
	}

	function rendezes(szinek, black, indexs)
	{
		var fekete = [];
		var feher = [];
		for (var i = 0; i < black.length; i++)
		{
			if (black[i])
			{
				fekete.push(szinek[i]);
				fekete.push(indexs[i]);
			}
			else
			{
				feher.push(szinek[i]);
				feher.push(indexs[i]);
			}
		}
		var t1 = black[0] ? fekete : feher;
		var arrays = [];
		var nums =[];
		var temp = [];
		for (var i = 0; i < t1.length; i+=2)
		{
			arrays.push(t1[i]);
			nums.push(t1[i+1][0]);
			temp.push(t1[i+1][1]);
			//x.innerHTML += "<div style='background: rgb("+t1[i].slice()+"); width: 100%; height: 50px;'></div>"
		}
		arrays.push(black[0] ? [0,0,0] : [255,255,255]);
		nums.push(temp);
		temp = [];

		var t2 = !black[0] ? fekete : feher;
		for (var i = 0; i < t2.length; i+=2)
		{
			arrays.push(t2[i]);
			nums.push(t2[i+1][0]);
			temp.push(t2[i+1][1]);
		}
		if (temp.length>0)
		{
			arrays.push(!black[0] ? [0,0,0] : [255,255,255]);
			nums.push(temp);
		}
		return [arrays, nums];
	}

	function szinToleralas()
	{
		return [aSzin[2][0], 100, aSzin[2][2]];
	}

	///////////////////////////////////////////////////////////////////////////////

	function addCollection(hc)
	{
		var tovabb = hexaVal(hc);
		if (tovabb && !(collection.includes(hc)))
		{
			collection.push(hc);
			var object = document.getElementById('CC-Collection').getElementsByClassName('row')[0];
			var gomb = object.getElementsByClassName("col-md-12");
			if (gomb.length == 1) {gomb[0].remove();}
			object.innerHTML += "<div class='col-md-4'><input type='hidden' value='"+hc+"' name='collection'><div class='CC-kompozicio CC-chromo' onclick='removeCollection(this)' style='cursor: pointer'><div style='background-color:#"+hc+"'></div><div>#"+hc+"</div></div></div>";
			object.innerHTML+= "<div class='col-md-12'><input type='submit' value='színek mentése'></div>";
			if (collection.length == 1) {document.getElementById('CC-Collection').style.display = 'block'}
		}
	}

	function winCollection()
	{
		document.getElementById('CC-Collection').style.display = document.getElementById('CC-Collection').style.display == 'block' ^ collection.length == 0 ? 'none' : 'block';
	}

	function removeCollection(object)
	{
		var hc = object.getElementsByTagName('div')[1].innerHTML.substring(1, 7);
		var include = collection.includes(hc);
		var target = document.getElementById('CC-Collection').getElementsByClassName('col-md-4');
		for (var i = 0; i < collection.length && include; i++) {
			if (collection[i] == hc && target[i].getElementsByTagName('div')[2].innerHTML.substring(1, 7) == hc)
			{
				collection.splice(i,1);
				target[i].remove();
				if (collection.length == 0) {document.getElementById('CC-Collection').style.display = 'none';}
				return;
			}
		}
	}

	///////////////////////////////////////////////////////////////////////////////

	function szinezes(hc, first)
	{
		if (hexaVal(hc))
		{
			document.getElementsByClassName('CC-chromo')[ first ? 0 : 2].getElementsByTagName('div')[0].style.backgroundColor = "#"+hc;
			document.getElementsByClassName('szin')[ first ? 0 : 1].getElementsByTagName('input')[0].value = hc;
		}
	}

	///-END-///////////////////////////////////////////////////////////////////////

	//loadRGB(Math.floor(Math.random() * 256), Math.floor(Math.random() * 256), Math.floor(Math.random() * 256));
	//kontrasztKomplementer();