<?php
//Skript zum Hochladen von Bildern bestimmter Formate, sowie 2MB Dateigröße als Maximum

$target_dir = "../uploads/";
$target_file = $target_dir . basename($_FILES["Bild"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
	//var_dump($_FILES);
    $check = getimagesize($_FILES["Bild"]["tmp_name"]);
    if($check !== false) {
        echo "Datei ist ein Bild - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "Datei ist kein Bild";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    echo "Datei existiert bereits.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["Bild"]["size"] > 2097152) {
    echo "Datei ist zu gross";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" && $imageFileType != "JPG" 
	&& $imageFileType != "JPEG" && $imageFileType != "PNG" && $imageFileType != "GIF") {
    echo "Nur JPEG, JPG, GIF und PNG sind erlaubt.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Datei wurde nicht hochgeladen.";
// if everything is ok, try to upload file
} 
else {
    if (move_uploaded_file($_FILES["Bild"]["tmp_name"], $target_file)) {
        echo "Die Datei". basename( $_FILES["Bild"]["name"]). " wurde hochgeladen.";
    } else {
        echo "Fehler beim Hochladen.";
    }
}

?>