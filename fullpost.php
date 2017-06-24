<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Mein wunderschöner Blog</title>
	<link rel="icon" href="css/blog.ico" type="image/vnd.microsoft.icon">
	
	
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
		
	<?php
	error_reporting(E_ALL ^ E_WARNING); 
	require_once 'lib/php-markdown-lib/Michelf/Markdown.inc.php';
	use \Michelf\Markdown;
	?>
	
	<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
	<!-- collapse, for materialize css-->
	<script type="text/javascript">
		$( document ).ready(function(){
			$(".button-collapse").sideNav();
			$(".dropdown-button").dropdown();
			$('.parallax').parallax();
			$('#textarea1').val('New Text');
			$('#textarea1').trigger('autoresize');
		});
				
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
	
	
	  <div class="parallax-container">
      <div class="parallax"><img src="lib/Sonnenaufgang.jpg"></div>
	  </div>
	  
	 <div class="row">
      
			
		<div class="col s12 l7 m7">
			
			<h5> Vollst&auml;ndiger Post </h5>
			
			<?php if (array_key_exists('fullpost', $_POST)) { 
				
				$file= $_POST['fullpost'];
				$posts="posts/".$file;
				$postMD = file_get_contents($posts);
				$arr = explode("\n", $postMD);
				$headline = $arr[0];
				$date =$arr[1];
						
				$lines = explode("\n", $postMD);
				$lines = array_slice($lines, 2);	//cut first 2
				$postMD = implode("\n",$lines);
				$postTransform = Markdown::defaultTransform($postMD);
				$postTransform =  str_replace('<img', '<img width="70%"', $postTransform);  //set the width of images to 100%
				$postTransform =  nl2br($postTransform);
				
				echo '
						<div class="card blue-grey darken-1">
							<div class="card-content white-text">
							  <span class="card-title">'.$headline.'</span>  
							  <br><b>'.$date.'</b>
							  <p>'.$postTransform.'</p>  
							</div>
							
						</div>'; 
				}
						
				
			?>
			<br>
			<!--<div class="col s12 l3 m3"> -->
			<h5> Bisherige Kommentare </h5>
			
			
			<?php
			$dirname = "comments/".$file.'/';
			//$comments=glob("*txt", GLOB_BRACE);
	
				$files = array();
				if ($handle = opendir($dirname)) {  //'.'
					while (false !== ($file = readdir($handle))) {
						if ($file != "." && $file != "..") {
						//$files[filemtime($file)] = $file;
						$files[] = $file;
						}
					}
					closedir($handle);
				}
				rsort($files);
				//var_dump($files);				
				
				foreach($files as $file) {
					
					$comment = file_get_contents($dirname.$file);
					$arr = explode("\n", $comment);
					//$headline = strtok($postMD, "\n");
					$date = $arr[0];
					$name =$arr[1];
					$email =$arr[2];
				
				//var_dump($arr);
				//set the width of images to 100%
				
				$lines = explode("\n", $comment);
				$lines = array_slice($lines, 3);	
				$comment = implode("\n",$lines);
				$comment =  nl2br($comment);	
				
					echo'
					<div class="card-panel grey lighten-2">
						<span class="blue-text text- darken-2"> <b>Name:  '.$name.'    &emsp;Datum:  '.$date.'</b><br></span>
						<span class="blue-text "><i>'.$comment.'</i><br></span>
					</div>';
				
				
				}		
			?>
			
			<br>
			<!--</div>-->
			<h5> Hinterlasse doch einen Kommentar! </h5>
			
			<form class="col s12" action="php/comment.php" method="post" enctype="multipart/form-data">
			  <div class="row">
				<div class="input-field col s6">
				  <input placeholder="Max Mustermann" name="name" id="name" type="text" class="validate">
				  <label for="name">Name</label>
				</div>
				<div class="input-field col s6">
				  <input id="email" placeholder="max.mustermann@mail.net" name="email" type="email" class="validate">
				  <label for="email">Email</label>
				</div>
			  </div>
			  <div class="row">
				<div class="input-field col s12">
				  <textarea id="textarea1" name="textarea1" class="materialize-textarea"></textarea>
				  <label for="textarea1">Kommentar</label>
				</div>
			  </div>
			<input type="hidden" name="postname" value="<?php echo $file= $_POST['fullpost']; ?>" >  <!-- Bekomme den Postnamen übergeben-->
			<button class="btn waves-effect waves-light" type="submit" name="action" onclick="Materialize.toast('Post erstellt', 4000)">Kommentieren	
				<i class="material-icons right">send</i>
			</button>
			</form>
			
			
		</div>
		
		<div class="col s12 l5 m5">
			<h5> Die letzten 10 Posts </h5>
				<?php 
					include 'php/recentposts.php';
				?>
	</div>	

   	
	
  </body>
  
</html>