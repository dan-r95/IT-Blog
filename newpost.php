<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Mein wunderschöner Blog</title>
	<link rel="icon" href="blog.ico" type="image/vnd.microsoft.icon">
	
	
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
		return confirm('Den Post löschen?');
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
		<li><a href="newpost.php">Neuer Post</a></li>
		<li><a href="picupload.php">Post bearbeiten</a></li>
		<li class="divider"></li>
		<li><a href="picupload.php">Bilder hochladen</a></li>
	</ul>
	<ul id="dropdown" class="dropdown-content">
		<li><a href="newpost.php">Neuer Post</a></li>
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
		<div class="col l8 m8 s12">
		<h3>Erstelle einen neuen Post</h3>
	  
		<form action="php/editor.php" method="post" enctype="multipart/form-data"> 
			<label class="mdl-textfield__label" for="markdhead">Ueberschrift</label>		
			<input class="mdl-textfield__input" name="markdownhead" id="markdhead">
			<textarea id="markdown" name="markdowntext"></textarea>
			<button class="btn waves-effect waves-light" type="submit" name="action" >Erstellen	<!-- onclick="Materialize.toast('Post erstellt', 4000)" -->
				<i class="material-icons right">send</i>
			</button>
			<a class="waves-effect waves-light btn" onclick="location.href='index.php';"><i class="material-icons left">delete</i>Verwerfen</a>
		</form>
		</div>
		
		<div class="col l4 m4 s12">
			<h4> Die 10 letzten Posts </h4>
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
				
				} 
					
					
					$index=10;
					if((count($files))<10){
						$index=count($files);
					} 
					
					for ($i=0; $i<$index-1;$i++){
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
									<form action="editpost.php" method="post" enctype="multipart/form-data">
										<input type="hidden" name="filename" value="'.$files[$i].'">
										<button class="btn waves-effect waves-light" type="submit" name="editpost">Editieren
										</button>
										<button class="btn waves-effect waves-light" type="submit" name="deletepost" onclick="return checkDelete()">Loeschen
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
	<!-- <link rel="stylesheet" href="lib/NextStepWebs-simplemde-markdown-editor-00e0f69/src/css/simplemde.min.css"> -->
	<script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
	<script>
	new SimpleMDE({
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