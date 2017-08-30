<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Mein wunderschöner Blog</title>
	<link rel="icon" href="css/blog.ico" type="image/vnd.microsoft.icon">
	
	<!--Kalender-Einbindung -->
	<link href="lib/calendar/calendar.css" type="text/css" rel="stylesheet" />
	
	<link rel="stylesheet" href="calendar.css">
	<link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
	
	<!--Import Google Icon Font-->
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <!--Import materialize.css-->
      <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>

      <!--Let browser know website is optimized for mobile-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	
    
	<!-- style for font -->
	<link href="css/textstyle.css" type="text/css" rel="stylesheet">
	
	<script language="JavaScript" type="text/javascript">
		function checkDelete(){
		return confirm('Wirklich loeschen?');
		}
	</script>
	
	<?php
		/*ini_set('display_errors', 'On');
		error_reporting(E_ALL | E_STRICT); */?>
	
  </head>
  
  <body>
 <!--Import jQuery before materialize.js-->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script> 
    <script type="text/javascript" src="js/materialize.min.js"></script>
	<!-- collapse, for materialize css-->
	<script type="text/javascript" src="js/init.js"></script>
	
	<!-- Dropdown Structure mobile & pc -->
	<ul id="dropdown_mob" class="dropdown-content">
		<li><a href="editor.php">Neuer Post</a></li>
		<li><a href="picupload.php">Post bearbeiten</a></li>
		<li class="divider"></li>
		<li><a href="picupload.php">Bilder hochladen</a></li>
	</ul>
	<ul id="dropdown" class="dropdown-content">
		<li><a href="editor.php">Neuer Post</a></li>
		<li><a href="picupload.php">Post bearbeiten</a></li>
		<li class="divider"></li>
		<li><a href="picupload.php">Bilder hochladen</a></li>
	</ul>
	
	<div class="navbar-fixed">
	<nav>
		<div class="nav-wrapper">
		  <a href="index.php" class="brand-logo right">Mein Blog</a>
		  <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
		  <ul  class="left hide-on-med-and-down">
			<li><a href="index.php">Home</a></li>
			<!-- Dropdown Trigger -->
			<li><a class="dropdown-button" href="#!" data-activates="dropdown">Admin<i class="material-icons right">arrow_drop_down</i></a></li>
		  </ul>
		  
		  <ul class="side-nav" id="mobile-demo">
			<li class="active"><a href="index.php">Home</a></li>
			<!-- Dropdown Trigger -->
			<li><a class="dropdown-button" href="#!" data-activates="dropdown_mob">Admin<i class="material-icons right">arrow_drop_down</i></a></li>
			
		  </ul>
		</div>
	</nav>
	</div>
	
	<div class="row">
		<div class="col s12 l8 m8">
		<h3>Bearbeite Post:</h3>
		
		
		
		<?php if (array_key_exists('editpost', $_POST)) { 
				
				$file= $_POST['filename'];
				$posts="posts/".$file;
				$postMD = file_get_contents($posts);
				$arr = explode("\n", $postMD);
				$headline = $arr[0];
				$date =$arr[1];
						
				$lines2 = explode("\n", $postMD);
				$lines2 = array_slice($lines2, 2);	//cut first 2
				$postMD = implode("\n",$lines2);
		}	
		if (array_key_exists('deletepost', $_POST)) { 
				
				$file= $_POST['filename'];
				$posts="posts/".$file;
				unlink($posts);
				
				function rrmdir($dir) {
				  if (is_dir($dir)) {
					$objects = scandir($dir);
					foreach ($objects as $object) {
					  if ($object != "." && $object != "..") {
						if (filetype($dir."/".$object) == "dir") 
						   rrmdir($dir."/".$object); 
						else unlink   ($dir."/".$object);
					  }
					}
					reset($objects);
					rmdir($dir);
				  }
				 }
				 
				$dir= "comments/".$file.'/';
				rrmdir($dir); //lösche den ordner mit, indem sich die comments befinden
				header('Location: index.php');
				exit;  
		}	
		if (array_key_exists('deletepic', $_POST)) { 
				
				$file= $_POST['picname'];
				
				//$pic=substr($file, 8);
				unlink($file);
				header('Location: picupload.php');
				exit;  
		}	
						
			?>
		<form action="php/editor-edit.php" method="post" enctype="multipart/form-data"> 
			<label class="mdl-textfield__label" for="markdhead">Ueberschrift</label>		
			<input class="mdl-textfield__input" name="markdownhead" id="markdhead" value="<?php echo $headline; ?>">
			<input type="hidden" name="oldfilename" value="<?php echo $file ?>" >
			<textarea id="markdown" name="markdowntext"> <?php echo $postMD; ?> </textarea>
			<button class="btn waves-effect waves-light" type="submit" name="action" >Erstellen	<!-- onclick="Materialize.toast('Post erstellt', 4000)" -->
				<i class="material-icons right">send</i>
			</button>
			<a class="waves-effect waves-light btn" onclick="location.href='index.php';"><i class="material-icons left">delete</i>Verwerfen</a>
		</form>
	</div>
		
	<div class="col s12 l4 m4 ">
		<h3> Die 10 letzte Posts </h3>
		<?php 
				// gleich wie recentposts.php nur mit zusätzlichen buttons für löschen und edit
				$dir= './posts/';
				$files = array();
				if ($handle = opendir($dir)) {  //'.'
					while (false !== ($file = readdir($handle))) {
						if ($file != "." && $file != "..") {
						//$files[filemtime($file)] = $file;
						$files[] = $file;
						}
					}
					closedir($handle);

				rsort($files);   //sort descending
				//echo var_dump($files);
				} 
					
					
					$index=10;
					if((count($files))<10){
						$index=count($files);
					} 
					
					for ($i=0; $i<$index;$i++){
						$posts="posts/".$files[$i];
						$post= file_get_contents($posts);
						$arr = explode("\n", $post);
					//$headline = strtok($postMD2, "\n");
						$headline = $arr[0];
						$date =$arr[1];
						//echo '<p>'.$headline.'   '.$date.'</p><br>';
						echo '
								<div class="card-panel teal">
								<span class="white-text">
									<h5>'.$headline.'</h5>
									<b>'.$date.'</b>
									<form action="fullpost.php" method="post" enctype="multipart/form-data">
										<input type="hidden" name="fullpost" value="'.$files[$i].'">
										<button class="btn waves-effect waves-light" type="submit" name="action">Mehr
										</button>
									</form>
									<form action="php/editor-edit.php" method="post" enctype="multipart/form-data">
										<input type="hidden" name="filename" value="'.$files[$i].'">
										<button class="btn waves-effect waves-light" type="submit" name="editpost">Editieren
										</button>
										<button class="btn waves-effect waves-light" type="submit" name="deletepost" onClick="return checkDelete()">Loeschen
										</button>
									</form>											
									</span>
									</div>';
							
					} 
			?>
	</div>
	</div>
	<div>
		
	</div>
	
	
	
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
	<script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
	<script>
	var markdown= new SimpleMDE({
			element: document.getElementById("markdown"),
			spellChecker: false,
			autosave: {
				enabled: false,
				unique_id: "markdown",
			},
		});
	</script>
  </body>
  
</html>