<html>
<body>

<?php

//Erstellt zu übergebenem Postnamen einen Kommentar (in einen Ordner) und Dateiname damit er eindeutig ist als Uhrzeit/Datum

if (array_key_exists('textarea1', $_POST) ) { 
	
	$required = array('name', 'email', 'textarea1');

	// Loop over field names, make sure each one exists and is not empty
	$error = false;
	foreach($required as $field) {
		if (empty($_POST[$field])) {
			$error = true;
		 }
	}

	if ($error) {
	  echo "Leere Felder sind nicht gestattet";
	} 
	else {
	
	
	$filename= $_POST["postname"]; 
	$datum = date("d.m.Y H:i\h"); 
	
	$relative_path = '../comments/'.$filename.'/';
	
	if (!file_exists($relative_path)) {
		mkdir($relative_path, 0777, true);
	}
	$datumtitel = date("Y-m-d-H:i:s");
	$handle = fopen($relative_path.$datumtitel.".txt", 'w+') or die("Konnte Datei nicht öffnen");
	
	
	echo $_POST["name"]; 
	echo $_POST["email"]; 
	
    // schreiben des Inhaltes 
	fwrite ( $handle, $datum );
	// Neue Zeile einfuegen, damit Auswertung m?glich wird
	fwrite ( $handle, "\n" );
    fwrite ( $handle, $_POST["name"] );
	fwrite ( $handle, "\n" );
    fwrite ( $handle, $_POST["email"] );
	fwrite ( $handle, "\n" );
	fwrite ( $handle, $_POST["textarea1"] );
	
  
	
    // Datei schliessen
    fclose ( $handle );

	header('Location: ../index.php'); exit;  
    // Datei wird nicht weiter ausgefuehrt
    exit;
	}
}

?>


</body>
</html>