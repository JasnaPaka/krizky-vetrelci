<?php 
	get_header();
	$objekt = kv_object_info();
	$uploadDir = wp_upload_dir();
	$oc = kv_object_controller();
	
	$kategorie = $objekt->kategorie;
	$autori = $objekt->autori;
	$zdroje = $objekt->zdroje;
	$fotografiePrim = $objekt->fotografiePrim;
	$fotografieOst = $objekt->fotografieNotPrim;
?>

<?php if (!isset($objekt->nazev) || $objekt->deleted) { ?>
	
	<div id="page" class="static">
	
	  <div class="inner">
	
	    <div class="padding">
	
			<h2>Dílo nebylo nalezeno</h2>
			
			<p>Vámi hledané dílo nebylo bohužel v katalogu nalezeno.</p>
		</div>
	   </div>
	</div>	
	
<?php } else { ?>

<div id="page" class="index podnet">

  <div class="inner">

    <div class="padding">
    
    	<?php if (count($oc->getTagsForObject($objekt->id)) > 0) { ?>	
      	<div id="searchdatabase">
			<?php foreach ($oc->getTagsForObject($objekt->id) as $tag) { ?>
			<a href="/katalog/stitek/<?php printf ($tag->id) ?>/" class="kat-tag"><?php printf ($tag->nazev) ?></a>
			<?php } ?>
	    </div>
	    <?php } ?>
    	

      <h2><?php printf($objekt->nazev) ?></h2>         

    </div>

	<div class="topMenu">
		<div>
			<h1>Kategorie</h1>
			<h2><?php printf('<a href="/katalog/kategorie/%s/" title="Přehled všech děl v kategorii">%s</a>', 
						$kategorie->id, $kategorie->nazev); ?></h2> 
			<div class="space"></div>
			<h1>Přezdívka</h1>
			<h2>
				<?php
					if (strlen($objekt->prezdivka) > 2) {
						printf($objekt->prezdivka);	
					} else {
						printf('<em class="neevidovano">(není uvedena)</em>');
					}
				?>
			</h2>
		</div>
		<div>
			<h1>Autor</h1>
			<h2>
				<?php
					$isFirst = true;
					foreach ($autori as $autor) {
						if (!$isFirst) {
							printf(", ");	
						}
						printf('<a href="/katalog/autor/%s/" title="Informace o autorovi">%s</a>', 
							$autor->id, trim($autor->titul_pred." ".$autor->jmeno." ".$autor->prijmeni." ".$autor->titul_za));
						
						$isFirst = false;	
					}
					
					if (count($autori) == 0) {
						printf('<em class="neevidovano">(nejsou uvedeni)</em>');	
					}
				?>
			</h2>
			<div class="space"></div>
			<h1>Přístupnost</h1>
			<h2>
				<?php
					if (strlen($objekt->pristupnost) > 2) {
						printf($objekt->pristupnost);	
					} else {
						printf('<em class="neevidovano">(není uvedena)</em>');	
					}
				?>
			</h2>
		</div>
		<div>
			<h1>Rok vzniku</h1>
			<h2>
				<?php
					if (strlen($objekt->rok_vzniku) > 2) {
						printf($objekt->rok_vzniku);	
					} else {
						printf('<em class="neevidovano">(není uveden)</em>');
					}
				?>
			</h2>
			<div class="space"></div>
			<h1>GPS</h1>
			<h2><?php printf(round($objekt->latitude, 6).",".round($objekt->longitude, 6)) ?></h2>
		</div>
		<div>
			<h1>Materiál</h1>
			<h2>
				<?php
					if (strlen($objekt->material) > 2) {
						printf($objekt->material);	
					} else {
						printf('<em class="neevidovano">(není uveden)</em>');	
					}
				?>			
			</h2>
			<div class="space"></div>
			<h1>Památková ochrana</h1>
			<h2>
				<?php
					if (strlen($objekt->pamatkova_ochrana) > 2) {
						printf('<a href="http://monumnet.npu.cz/pamfond/list.php?CiRejst='.$objekt->pamatkova_ochrana.'">'.$objekt->pamatkova_ochrana.'</a>');	
					} else {
						printf("ne");	
					}
				?>			
			</h2>
		</div>
	</div>
	
	<div class="padding">
		<div class="buttonsGreen">		
			<?php if (is_user_logged_in() && current_user_can('edit_posts')) { ?>
				<a class="buttonGreen" href="/wp-admin/admin.php?page=object&action=view&id=<?php printf($objekt->id) ?>">UPRAVIT</a>
	        <?php } else { ?>
	        	<a class="buttonGreen" href='mailto:krizkyavetrelci@email.cz?subject=<?php printf(addslashes($objekt->nazev)) ?> (<?php print($objekt->id); ?>): Doplnění informací'>DOPLNIT INFORMACE</a>
	        <?php } ?>
	     </div>
	     
	 	<?php if ($objekt->zruseno) { ?>
	 		<div id="objekt-zrusen">
	 			Dílo se na místě již nenachází. Bylo v minulosti odstraněno nebo zničeno.
	 		</div>
	 	<?php } ?>
	     
	     <div id="picture-map">
		     
		     <div id="picture-box">
		     	<?php if ($fotografiePrim == null || $fotografiePrim->img_512 == null) { ?>
		     		<img src="<?php bloginfo('template_url') ?>-child-krizkyavetrelci/images/foto-neni-512.png" alt="Fotografie není dostupná" 
		     			title="Fotografie není dostupná"  />		     	
		     	<?php } else { 
		     		$popis = $fotografiePrim->popis;
					if (strlen(trim($fotografiePrim->autor)) > 1) {
						$popis.= " Autor/zdroj: ".$fotografiePrim->autor;	
					}
					
					if (!$fotografiePrim->soukroma)  {
						$popis.= ", licence: CC-BY-SA"; 	
					}
					
					$popis = trim ($popis);
		     	
		     	?>
		     		
		     	
		     		<a href="<?php printf($uploadDir['baseurl'].$fotografiePrim->img_large) ?>" alt="Pro zvětšení klepněte"
		     			data-lightbox-gallery="lightbox[gallery-<?php printf($objekt->id) ?>]" title="<?php printf($popis) ?>" 
		     			rel="lightbox[gallery-<?php printf($objekt->id) ?>]">
		     			<img src="<?php printf($uploadDir['baseurl'].$fotografiePrim->img_512) ?>" alt="Fotografie díla" />
					</a>
				<?php 
					}
				 
					if ($fotografiePrim != null && strlen($popis) > 0) {
				?>	
					<div id="photo-description"><?php printf($popis) ?></div>
				<?php		
					}
					
					if (count($fotografieOst) > 0) {	
						printf('<div id="photo-small">');
						foreach ($fotografieOst as $photo) {
							
				     		$popis = $photo->popis;
							if (strlen(trim($photo->autor)) > 1) {
								$popis.= " Autor/zdroj: ".$photo->autor;	
							}
							
							if (!$photo->soukroma)  {
								$popis.= " Licence: CC-BY-SA"; 	
							}
							
							$popis = trim ($popis);
							
				?>							
		     		<a href="<?php printf($uploadDir['baseurl'].$photo->img_large); ?>" alt="Pro zvětšení klepněte"
		     			data-lightbox-gallery="lightbox[gallery-<?php printf($objekt->id) ?>]" title="<?php printf($popis) ?>" 
		     			rel="lightbox[gallery-<?php printf($objekt->id) ?>]" class="photo-preview">
		     			
		     			<?php if ($photo->img_100 == null) { ?>
		     				<img src="<?php bloginfo('template_url') ?>-child-krizkyavetrelci/images/foto-neni-100.png" alt="Fotografie díla" />
		     			<?php } else  { ?>
		     				<img src="<?php printf($uploadDir['baseurl'].$photo->img_100) ?>" alt="Fotografie není dostupná" />
		     			<?php } ?>
					</a>						
				<?php													
						}
						printf('</div>');
				}
					
				?>
		     </div>
		     <div id="map-box">
				<?php printf($objekt->mapa) ?>
		     </div>

		 </div>
		 
		 <div class="clear"></div>		 
		 
		 <div id="obsah-container">
		 
		 	<?php if ($objekt->zpracovano) { ?>
			 	<div id="obsah-perex">
			 		<?php printf(stripslashes($objekt->popis)) ?>
			 	</div>
			 	<div id="obsah">
			 		<?php
			 			if ($objekt->zpracovano) { 
			 				printf(stripslashes($objekt->obsah));
						}
			 		?>
			 	</div>
			 <?php } ?>
		 </div>
		 
		 <?php if ($objekt->zpracovano && count($zdroje) > 0) { ?>
		 
		 <div id="zdroje">
			<hr />
		 	<h3>Literatura a prameny</h3>
		 	<p><ul>
		 	<?php
		 		foreach ($zdroje as $zdroj) {
		 			printf("<li>"); 
					
		 			if (strlen($zdroj->url) > 0) {
		 				printf('<a href="'.$zdroj->url.'">'.$zdroj->nazev.'</a>');	
					} else {
						printf($zdroj->nazev);	
					}
					
					if (strlen($zdroj->isbn) > 0) {
						printf(' ISBN: '.$zdroj->isbn.'. Zjistit dostupnost v: <a 
							href="http://aleph20.svkpl.cz/F/?func=find-d&find_code=ISN&request='.str_replace("-","",$zdroj->isbn).'">
							Studijní a vědecká knihovna Plzeňskeho kraje</a>');
					}
					
					printf("</li>");
				}
		 	?>
		 	</ul>
		 	</p>
		 </div>
		 
		 <?php } ?>
	     
	</div>
   </div>
</div>

<?php } ?>

<?php get_footer(); ?>