<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Mein wunderschöner Blog</title>
	<link rel="icon" href="css/blog.ico" type="image/vnd.microsoft.icon">
	
	<!--Kalender-Style -->
	<link href="lib/calendar/calendar.css" type="text/css" rel="stylesheet" />
	
	<link rel="stylesheet" href="lib/calendar/calendar.css">
	<link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
	
	<!--Import Google Icon Font-->
      <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <!--Import materialize.css-->
      <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>

      <!--Let browser know website is optimized for mobile-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	
	<!-- Quellen:
	Framework: http://materializecss.com/
	SimpleMDE: https://simplemde.com/
	Markdown Parser: https://github.com/michelf/php-markdown
	Upload Script: http://www.w3schools.com/php/php_file_upload.asp
	Calendar: https://github.com/yscoder/Calendar
	-->
    
	<!-- style for font -->
	<link href="css/textstyle.css" type="text/css" rel="stylesheet">
	
	<style>
		.picture {
			display: inline-block;
			margin-left: auto;
			margin-right: auto;
			height: 30px; 
		}

		#row{
			text-align:center;
		}
	</style>
		
	<?php
	
	require_once 'lib/php-markdown-lib/Michelf/Markdown.inc.php';
	use \Michelf\Markdown;
	?>
	
	<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
	<!-- collapse, for materialize css-->
	<script type="text/javascript">
		$( document ).ready(function(){
			$(".button-collapse").sideNav();
			$(".dropdown-button").dropdown();
			$('.parallax').parallax();
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
	<!--Quelle Bild: http://www.imbuemedia.com/img/s7/v155/p1939629921-6.jpg -->
	
	  <div class="parallax-container">
      <div class="parallax"><img src="lib/p1939629921-6.jpg"></div>
	  </div>
	  
	 <div class="row">
      
	  <?php/*
		ini_set('display_errors', 'On');
		error_reporting(E_ALL | E_STRICT);*/ ?>

			
			<div class="col s12 l7 m7">
				<h3 class="valign"> <span class="red-text text-lighten-1">Blog-Einträge</span> </h3>
				
				
				<?PHP
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
				}
				rsort($files); 
				
			$i= count($files);
			
			 //Nur 2 Posts ausgeben und dann mit Buttons durchlaufen
			  $twoposts = 0;
			  $twonext = 2;
			  // berechne next post
			  if (array_key_exists('next', $_POST)) {
				if ($_POST['nextval'] >= $i) {
				  $twoposts = $i-1;
				  $twonext = $i;
				} else {
				  $twoposts = $_POST['nextval'];
				  $twonext = $_POST['nextval']+2;
				}
				$twonext = $twoposts+2;
			  }
			  //// berechne previous post
			  if (array_key_exists('prev', $_POST)) {
				if ($_POST['prevval'] <= 0) {
				  $twoposts = 0;
				  $twonext = 2;
				} else {
				  $twoposts = $_POST['prevval'];
				  $twonext = $_POST['prevval']+2;
				}
			  }
			  #gerade /ungerade anzahl berechnen
			  if (bcmod($twonext,2)== 0) {
				if ($twonext > $i) {
				  $twonext = $_POST['nextval'] + 1;
				}
				}

			  for ($a = $twoposts; $a < $twonext; $a++) {
				
				$post= $files[$a];
				$posts="posts/".$post;
				$postMD = file_get_contents($posts);
				$arr = explode("\n", $postMD);
				$headline = $arr[0];
				$date =$arr[1];
				
				$lines = explode("\n", $postMD);
				$lines = array_slice($lines, 2,6);	//kürzen auf 4 Zeilen
				$postMD = implode("\n",$lines);
				$postTransf = Markdown::defaultTransform($postMD);
				$postTransf =  str_replace('<img', '<img width="70%"', $postTransf);
				$postTransf =  nl2br($postTransf);
				
				
				echo '
				<div class="card blue-grey darken-1">
					<div class="card-content white-text">
					  <span class="card-title">'.$headline.'</span>  
					  <br><b>'.$date.'</b>
					  <p>'.$postTransf.'</p>  
					</div>
					<div class="card-action">
					   <form action="fullpost.php" method="post" enctype="multipart/form-data">
					   <input type="hidden" name="fullpost" value="'.$post.'">
					   <button class="btn waves-effect waves-light" type="submit" name="action">Weiterlesen
					   </button></form>
					</div>
				</div>'; 
				}
				?>
				
				
				<?php
              if ($twoposts > 0) {
              echo "
              <div class='prev'>
                <form method='post' action='index.php' enctype='multipart/form-data'>
                  <input type='hidden' name='prevval' value="; echo $twoposts - 2; echo ">
                  <button class='waves-effect waves-light btn' type='submit' name='prev'><i class='material-icons right'>skip_previous</i>Vorherige</button>	
                </form>
              </div>";
              }
              if ($_POST['nextval']+2 < $i) {
              echo "
              <div class='next'>
                <form method='post' action='index.php' enctype='multipart/form-data'>
                  <input type='hidden' name='nextval' value="; echo $twoposts + 2; echo ">
				  <button class='waves-effect waves-light btn' type='submit' name='next'><i class='material-icons right'>skip_next</i>Naechste </button>
                </form>
              </div>";
             }
              ?>
			</div>
				
				
		<div class="col s1 l1 m1">
		.
		</div>
		
		  <div class="col s12 l4 l4"> <!--offset-s6 id="demo"-->
			<h3>Kalender</h3>
			<div id="ca"></div>
			
			 <div class="card">
				<div class="card-image">
				  <img src="lib/p1939629921-6.jpg">
				  <span class="card-title">Herzlich Willkommen</span>
				</div>
				<div class="card-content">
				  <p>Erstellt von s72795, Ressourcen siehe Quelltext(index.php) und /lib</p>
				</div>
				<div class="card-action">
				  <a href="picupload.php">Meine Bilder</a>
				</div>
			  </div>
			
			
			<h4> Die 10 letzten Posts </h4>
				<?php 
				include 'php/recentposts.php';
					
				
				?>
			</div>
      </div>

 
	
	
	<!-- Kalendar depend -->
	<script src="jquery.js"></script>
	<script src="lib/calendar/calendar.js"></script>
	
	
	<script>
		$('#ca').calendar({
			width: 320,
			height: 320,
			format: 'dd/mm/yyy',
			// startWeek: 0,
			// selectedRang: [new Date(), null],
			weekArray: ['So','Mo','Di','Mi','Do','Fr','Sa'],
			data: [
		{
		  date: '2015/12/24',
		  value: 'Christmas Eve'
		},
		{
		  date: '2015/12/25',
		  value: 'Merry Christmas'
		},
		{
		  date: '2016/01/01',
		  value: 'Happy New Year'
		}
		{
		  date: '1995/04/18',
		  value: 'Happy Birthday, Daniel!'
		}
	  ],
			onSelected: function (view, date, data) {
				console.log('view:' + view)
				console.log('date:' + date)
				console.log('data:' + (data || 'None'));
			}
		});

		
	</script>
	
	
	<!-- simple MDE -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
	<script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
	<script>
	new SimpleMDE({
			element: document.getElementById("demo2"),
			spellChecker: false,
			autosave: {
				enabled: true,
				unique_id: "demo2",
			},
		});
	</script>
	
  </body>
  
</html>