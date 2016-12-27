<html>
<body>


<?php
//Kümmert sich um das Erstellen eines neuen Posts, fängt leere Angaben ab

if (array_key_exists('markdownhead', $_POST)) { 
	
	
	$required = array('markdownhead', 'markdowntext');

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
	

	$datum = date("d.m.Y H:i\h"); 
	$markdownhead= $_POST["markdownhead"]; 
	$markdowntext= $_POST["markdowntext"]; 
	
	$datumtitel = date("Y-m-d-H:i:s");
	$relative_path = '../posts/'.$datumtitel.'.md';
	$handle = fopen($relative_path, 'w+') or die("Konnte Datei nicht öffnen");
	
	
    // schreiben des Inhaltes 
	fwrite ( $handle, $markdownhead );
	fwrite ( $handle, "\n");
	fwrite ( $handle, $datum );
	fwrite ( $handle, "\n" );
    fwrite ( $handle, $markdowntext );
	
	
    // Datei schliessen
    fclose ( $handle );
	header('Location: ../index.php');
	exit;  
	
	}	
   
}

  
	
?>

</body>
</html>