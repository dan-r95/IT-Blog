<html>
<body>


<?php

//Kümmert sich um das Ändern eines Posts, übernimmt den alten Namen und schreibt das alte datum und neuen titel/textarea hinein.


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
	
	$filename= $_POST["oldfilename"]; 
	$markdownhead= $_POST["markdownhead"]; 
	$markdowntext= $_POST["markdowntext"]; 
	
	$datumtitel = date("Y-m-d-H:i:s");
	$relative_path = '../posts/'.$filename;
	$content= file_get_contents($relative_path);
	$arr = explode("\n", $content);
	$date_to_save= $arr[1];
	$handle = fopen($relative_path, 'r+') or die("Konnte Datei nicht öffnen");
	
    // schreiben des Inhaltes 
	fwrite ( $handle, $markdownhead );
	fwrite ( $handle, "\n");
	fwrite ( $handle, $date_to_save );
	fwrite ( $handle, "\n" );
    fwrite ( $handle, $markdowntext );
	

    // Datei schlie?en
    fclose ( $handle );
	header('Location: ../index.php');
	exit;  
	
	}
   
}

  
	
?>

</body>
</html>