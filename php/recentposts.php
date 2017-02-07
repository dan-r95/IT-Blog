				<?php 
				//Gibt die letzten 10 Posts nach Datum sortiert aus, aber ohne edit und löschen buttons
				
				//$dir= '../posts/';
				$dir=dirname(__DIR__,1).'/posts';
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
						//$posts="../posts/".$files[$i];
						$posts=dirname(__DIR__,1).'/posts/'.$files[$i];
						$post= file_get_contents($posts);
						$arr = explode("\n", $post);
					
						$headline = $arr[0];
						$date =$arr[1];
						//echo '<p>'.$headline.'   '.$date.'</p><br>';
						echo '
								<div class="card-panel teal">
								<span class="white-text">
									<h5>'.$headline.'</h5>
									<b>'.$date.'</b>
									<form action="../fullpost.php" method="post" enctype="multipart/form-data">
										<input type="hidden" name="fullpost" value="'.$files[$i].'">
										<button class="btn waves-effect waves-light" type="submit" name="action">Mehr
										</button>
									</form>									
									</span>
									</div>';
							
					} 
				?>
