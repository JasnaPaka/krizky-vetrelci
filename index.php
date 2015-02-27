<?php get_header(); ?>

  <div id="page" class="index bleft">

   	<div class="inner contentheight">         


    <div class="postsIndex">
	    <div class="padding">
		<h2>O projektu</h2>     

   	
    
		<p id="o-projektu">
			<img src="<?php bloginfo('template_url'); ?>-child-krizkyavetrelci/images/medvedi-nahled.jpg" alt="Medvědi" id="o-projektu-logo" /> 
			Projekt Křížky a vetřelci mapuje drobné umění na území města Plzeň. Zaměřuje se jak na umění z doby normalizace,
			tak na sakrální památky jako jsou křížky či kapličky. Bez povšimnutí však nezůstávají ani pomníky a pamětní desky.
			Křížky a vetřelci jsou otevřeným projektem, do kterého se může zapojit každý. Víte o díle, které nám chybí v
			katalogu? Nebo o něm něco víte? <a href="mailto:krizkyavetrelci@seznam.cz">Napište nám</a> nebo se 
			<a href="https://www.facebook.com/groups/krizkyavetrelci/">zapojte na Facebooku</a>.
		</p>
		
		<div id="o-projektu-button">
			<a href="/o-projektu/" class="button">Více o projektu</a>
		</div>  
		
		<h2>Mapa</h2>
		
		<p id="titulka-mapa">
		Aktuálně je zmapováno umístění <strong><?php echo kv_ObjektPocet() ?> děl</strong>.
		</p>
		
		<p id="titulka-mapa-img"><a href="/mapa/" title="Přejít na mapu">
			<img src="<?php bloginfo('template_url'); ?>-child-krizkyavetrelci/images/kv-mapa.jpg" alt="Mapa" /> 
		</a></p>
		
		<div id="titulka-mapa-button">
			<a href="/mapa/" class="button">Přejít na mapu</a>
		</div>
    
    </div>
	</div>
	
      <div id="actualprojects" class="contentheight">

        <h2>Náhodné dílo</h2>

		<?php 
			$uploadDir = wp_upload_dir();
			$obj = kv_random_object();
			
			echo '<a href="/katalog/dilo/'.$obj->id.'/"><h3>'.$obj->nazev.'</h3></a>';
			
			if ($obj->img_512 != null) {
				echo '<a href="/katalog/dilo/'.$obj->id.'/">
					<img src="'.$uploadDir['baseurl'].$obj->img_512.'" alt="Ukázka díla" id="titulka-random-img" /></a>';				
			} else {
				echo '<a href="/katalog/dilo/'.$obj->id.'/">
					<img src="'.get_template_directory_uri().'-child-krizkyavetrelci/images/foto-neni-512.png" alt="Ukázka díla" id="titulka-random-img" /></a>';	
			}
		?>
		
		<br /><br /><br /><br />
		<h2>Poslední přidané</h2>
		
		<?php
			$uploadDir = wp_upload_dir();
			$obj = kv_last_object();
			
			echo '<a href="/katalog/dilo/'.$obj->id.'/"><h3>'.$obj->nazev.'</h3></a>';
			
			if ($obj->img_512 != null) {
				echo '<a href="/katalog/dilo/'.$obj->id.'/">
					<img src="'.$uploadDir['baseurl'].$obj->img_512.'" alt="Ukázka díla" id="titulka-random-img" /></a>';				
			} else {
				echo '<a href="/katalog/dilo/'.$obj->id.'/">
					<img src="'.get_template_directory_uri().'-child-krizkyavetrelci/images/foto-neni-512.png" alt="Ukázka díla" id="titulka-random-img" /></a>';	
			}			
		?>

      </div>      
    </div>

  </div> 


<?php get_footer(); ?>