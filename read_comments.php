<?php
	require_once "../config.php";
	
	//loom andmebaasiga ühenduse
	//server, kasutaja, parool, andmebaas
	$conn = new mysqli($server_host, $server_user_name, $server_password, $database);
	//määran suhtlemisel kasutatava koodutabeli
	$conn->set_charset=("utf8");
	
	//valmistame ette andmete saatmise SQL käsu
	$stmt = $conn->prepare("SELECT comment, grade, added FROM vp_daycomment");
	echo $conn->error;
	//seome saadavad andmed muutujatega
	$stmt->bind_result($comment_from_db, $grade_from_db, $added_from_db);
	//täidame käsu
	$stmt->execute();
	//kui saan ühe kirje
	//if($stmt->fetch()){
		//mis selle ühe kirjega teha
	//}	
	//kui tuleb teadmata arv kirjeid
	$comment_html = null;
	while($stmt->fetch()){
		//echo $comment_from_db;
		//<p>kommentaar, hinne päevale: 6, lisatud xxxxxx</p>
		$comment_html .= "<p>" .$comment_from_db .", hinne päevale: " .$grade_from_db;
		$comment_html .= ", lisatud " .$added_from_db .".</p> \n";
	}
	
	
	






?>
<!DOCTYPE html>
<html lang="et">

<head>
	<meta charset="utf-8">
	<title>Martin Ost teeb oma elu esimest veebilehte.</title>
</head>

<body>
	<img src="https://raw.githubusercontent.com/veebiprogrammeerimine2022/Ryhm-2/main/vp_banner_gs.png" alt="Veebiprogrammeerimise 2K22 banner">
	<h1>Martin õpib veebi programmeerima.</h1>
	<p>Kirjutasin lehel oleva koodi õpetaja abiga ning loodan selles osavaks saada ka ise.</p>
	<p>Õppetöö toimus <a href="https://www.tlu.ee" target="_blank">Tallinna Ülikoolis</a> digitehnoloogiate instituudis.</p>
	<p>Minu nimi on Martin Ost ja olen Tallinna Ülikooli 1. kursuse tudeng Informaatika tarkvaraarenduse suunal.</p>
	<a href="https://www.tlu.ee" target="_blank"><img src="pics/tlu_15.jpg" alt="Tallinna Ülikooli sisemuse pilt"></a>
<?php echo $comment_html; ?>
</body>

</html>