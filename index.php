<?php 
    get_header(); 

    $uploadDir = wp_upload_dir();
    $PAGE["pocet_del"] = kv_ObjektPocet();
?>

  <div id="page" class="index bleft titulni">

   	<div class="inner contentheight">         


    <div class="postsIndex">
	    <div class="padding">
		<h2>O projektu</h2>     

		<p id="o-projektu">
                    <img src="<?php bloginfo('template_url'); ?>-child-krizkyavetrelci/images/o-projektu-obr.jpg" alt="Obrázek k projektu" id="o-projektu-logo" /> 
                    <?php print ($KV["projekt_info"]); ?>
		</p>
		
		<div id="o-projektu-button">
			<a href="/o-projektu/" class="button">Více o projektu</a>
		</div>  
		
        <?php include "index-zpravy.php" ?>
		
        <?php include "index-content.php" ?>
		
        <div class="clear"></div>
    
    </div>
	</div>
	
      <div id="actualprojects" class="contentheight">

        <h2><?php print($KV["nahodne_dilo"]) ?></h2>

		<?php 
                    if ($PAGE["pocet_del"] == 0) {
                        print ($KV["zadne_dilo"]);
                    } else {
			$objects = array();
			$searches = 1;
			
			$i = 1;
			while ($i <= 3) {		
				$obj = kv_random_object();
				
				// Z každé kategorie pouze jeden náhodný objekt, zkusíme to náhodně 10x, pak končíme (ochrana proti zacyklení)
				$found = false; 
				foreach ($objects as $obEx) {
					if ($obEx->kategorie == $obj->kategorie) {
						$found = true;	
					}
				}
				
				if ($found && $searches < 10) {
					$searches++;
					continue;	
				}
				
				$searches = 0;
								
				$i++;
				$objects[] = $obj;
			}
			
			foreach($objects as $obj) {
				echo '<a href="/katalog/dilo/'.$obj->id.'/"><h3>'.$obj->nazev.'</h3></a>';
				
				if ($obj->img_512 != null) {
					echo '<a href="/katalog/dilo/'.$obj->id.'/">
						<img src="'.$uploadDir['baseurl'].$obj->img_512.'" alt="'.$KV["ukazka_dila"].'" id="titulka-random-img" /></a>';				
				} else {
					echo '<a href="/katalog/dilo/'.$obj->id.'/">
						<img src="'.get_template_directory_uri().'-child-krizkyavetrelci/images/foto-neni-512.png" alt="'.$KV["ukazka_dila"].'" id="titulka-random-img" /></a>';	
				}
				
				echo "<br /><br />";
			}
                    }
		?>
		
		<br /><br /><br /><br />
		<h2><?php print($KV["posledni_pridane"]) ?></h2>
		
		<?php
			$obj = kv_last_object();
                        if ($obj == null) {
                            print ($KV["zadne_dilo"]);
                        } else {
                            echo '<a href="/katalog/dilo/'.$obj->id.'/"><h3>'.$obj->nazev.'</h3></a>';

                            if ($obj->img_512 != null) {
                                    echo '<a href="/katalog/dilo/'.$obj->id.'/">
                                            <img src="'.$uploadDir['baseurl'].$obj->img_512.'" alt="'.$KV["ukazka_dila"].'" id="titulka-random-img" /></a>';				
                            } else {
                                    echo '<a href="/katalog/dilo/'.$obj->id.'/">
                                            <img src="'.get_template_directory_uri().'-child-krizkyavetrelci/images/foto-neni-512.png" alt="'.$KV["ukazka_dila"].'" id="titulka-random-img" /></a>';	
                            }			
                        }
		?>

      </div>      
    </div>

  </div> 


<?php 
    get_footer();
