<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Mein wundersch&ouml;ner Blog</title>
	<link rel="icon" href="css/blog.ico" type="image/vnd.microsoft.icon">
	
	
	<!--Import Google Icon Font-->
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <!--Import materialize.css-->
      <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>

      <!--Let browser know website is optimized for mobile-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	
    
	<!-- style for font -->
	<link href="css/textstyle.css" type="text/css" rel="stylesheet">
	
	<!-- css for picture thumbnails -->
	<link href="css/pictures.css" type="text/css" rel="stylesheet">
	
	<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
	<!-- collapse, for materialize css-->
	<script type="text/javascript">
		$( document ).ready(function(){
			$(".button-collapse").sideNav();
			$(".dropdown-button").dropdown();
			$('.materialboxed').materialbox();
		});
				
	</script>
	
	<script language="JavaScript" type="text/javascript">
		function checkDelete(){
		return confirm('Wirklich loeschen?');
		}
	</script>
	
	
  </head>
  
  <body>
	<!--Import jQuery before materialize.js-->
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="js/materialize.min.js"></script>
	
    
	
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
    <div class="col s12">
		<h4> Neues Bild hochladen </h4>
		<form action="php/upload.php" method="post" enctype="multipart/form-data">
			Datei ausw&aumlhlen (jpg, png, gif)
			<input type="file" name="Bild" id="Bild">
			<input type="submit" value="Hochladen" name="submit">
		</form>
	</div>
	</div>
	<div class="row">
	<div class="col s12 l8">
	<h4 class="center-align">Meine Bilder</h4>
  
	
	<?PHP
	
	
	$dirname = "uploads/";
	$images = glob($dirname."*.{jpg,jpeg,png,gif,jpeg,JPG,JPEG,PNG,GIF,JPEG}", GLOB_BRACE);
	$imagename=glob("*.{jpg,jpeg,png,gif,jpeg,JPG,JPEG,PNG,GIF,JPEG}", GLOB_BRACE);
	
	$max= count($images);
	foreach($images as $image) {
		
			$pic=substr($image, 8);
			
			echo ' <div class="img"> <img class="materialboxed"   data-caption="'. $pic.'"  src="'.$image.'">
					<div class="desc">'.$pic.'</div>';
			
			echo '
					<form action="editpost.php" method="post" enctype="multipart/form-data">
						<input type="hidden" name="picname" value="'.$image.'">
						<button class="btn waves-effect waves-light" type="submit" name="deletepic" onClick="return checkDelete()">Loeschen
						<i class="material-icons right">delete</i>
						</button>
					</form>	 </div>';
		
			
		
	}	
	?>
	</div>
	<div class="col s12 l4">
	<h4 class="center-align">Die letzten 10 Posts</h4>
		<?php 
				// gleich wie recentposts.php nur mit zusätzlichen buttons für löschen und edit
				$dir= './posts/';
				$files = array();
				if ($handle = opendir($dir)) {  //'.'
					while (false !== ($file = readdir($handle))) {
						if ($file != "." && $file != "..") {
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
				
					for ($i=0; $i<$index;$i++){
						$posts="posts/".$files[$i];
						$post= file_get_contents($posts);
						$arr = explode("\n", $post);
					
						$headline = $arr[0];
						$date =$arr[1];
						
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
										<button class="btn waves-effect waves-light" type="submit" name="deletepost"onClick="return checkDelete()">Loeschen
										</button>
									</form>											
									</span>
									</div>';
							
					} 
			?>
	</div>
	</div>
	
	
  </body>
  
</html>