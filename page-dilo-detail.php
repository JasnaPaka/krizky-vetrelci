<?php 
	get_header();
	$objekt = kv_object_info();
	$uploadDir = wp_upload_dir();
	
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

      <h2><?php echo $objekt->nazev ?></h2>         

    </div>

	<div class="topMenu">
		<div>
			<h1>Kategorie</h1>
			<h2><?php echo $kategorie->nazev ?></h2>
			<div class="space"></div>
			<h1>Přezdívka</h1>
			<h2>
				<?php
					if (strlen($objekt->prezdivka) > 2) {
						echo $objekt->prezdivka;	
					} else {
						echo "<em>(není uvedena)</em>";	
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
							echo ", ";	
						}
						echo '<a href="/katalog/autor/'.$autor->id.'/">'.trim($autor->titul_pred." ".$autor->jmeno." ".$autor->prijmeni." ".$autor->titul_za)."</a>";
						
						$isFirst = false;	
					}
					
					if (count($autori) == 0) {
						echo "(nejsou uvedeni)";	
					}
				?>
			</h2>
			<div class="space"></div>
			<h1>Přístupnost</h1>
			<h2>
				<?php
					if (strlen($objekt->pristupnost) > 2) {
						echo $objekt->pristupnost;	
					} else {
						echo "<em>(není uvedena)</em>";	
					}
				?>
			</h2>
		</div>
		<div>
			<h1>Rok vzniku</h1>
			<h2>
				<?php
					if (strlen($objekt->rok_vzniku) > 2) {
						echo $objekt->rok_vzniku;	
					} else {
						echo "<em>(není uveden)</em>";	
					}
				?>
			</h2>
			<div class="space"></div>
			<h1>GPS</h1>
			<h2><?php echo round($objekt->latitude, 6).",".round($objekt->longitude, 6) ?></h2>
		</div>
		<div>
			<h1>Materiál</h1>
			<h2>
				<?php
					if (strlen($objekt->material) > 2) {
						echo $objekt->material;	
					} else {
						echo "<em>(není uveden)</em>";	
					}
				?>			
			</h2>
			<div class="space"></div>
			<h1>Památková ochrana</h1>
			<h2>
				<?php
					if (strlen($objekt->pamatkova_ochrana) > 2) {
						echo '<a href="http://monumnet.npu.cz/pamfond/list.php?CiRejst='.$objekt->pamatkova_ochrana.'">'.$objekt->pamatkova_ochrana.'</a>';	
					} else {
						echo "ne";	
					}
				?>			
			</h2>
		</div>
	</div>
	
	<div class="padding">
		<div class="buttonsGreen">		
			<?php if (is_user_logged_in() && current_user_can('edit_posts')) { ?>
				<a class="buttonGreen" href="/wp-admin/admin.php?page=object&action=view&id=<?php echo $objekt->id ?>">UPRAVIT</a>
	        <?php } else { ?>
	        	<a class="buttonGreen" href='mailto:krizkyavetrelci@email.cz?subject=<?php echo addslashes($objekt->nazev) ?>: Doplnění informací'>DOPLNIT INFORMACE</a>
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
		     		
		     	
		     		<a href="<?php echo $uploadDir['baseurl'].$fotografiePrim->img_large ?>" alt="Pro zvětšení klepněte"
		     			data-lightbox-gallery="lightbox[gallery-<?php echo $objekt->id ?>]" title="<?php echo $popis ?>" 
		     			rel="lightbox[gallery-<?php echo $objekt->id ?>]">
		     			<img src="<?php echo $uploadDir['baseurl'].$fotografiePrim->img_512 ?>" alt="Fotografie díla" />
					</a>
				<?php 
					}
				 
					if ($fotografiePrim != null && strlen($popis) > 0) {
				?>	
					<div id="photo-description"><?php echo $popis ?></div>
				<?php		
					}
					
					if (count($fotografieOst) > 0) {	
						echo '<div id="photo-small">';
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
		     		<a href="<?php echo $uploadDir['baseurl'].$photo->img_large ?>" alt="Pro zvětšení klepněte"
		     			data-lightbox-gallery="lightbox[gallery-<?php echo $objekt->id ?>]" title="<?php echo $popis ?>" 
		     			rel="lightbox[gallery-<?php echo $objekt->id ?>]" class="photo-preview">
		     			
		     			<?php if ($photo->img_100 == null) { ?>
		     				<img src="<?php bloginfo('template_url') ?>-child-krizkyavetrelci/images/foto-neni-100.png" alt="Fotografie díla" />
		     			<?php } else  { ?>
		     				<img src="<?php echo $uploadDir['baseurl'].$photo->img_100 ?>" alt="Fotografie není dostupná" />
		     			<?php } ?>
					</a>						
				<?php													
						}
						echo '</div>';
				}
					
				?>
		     </div>
		     <div id="map-box">
				<?php echo $objekt->mapa ?>
		     </div>

		 </div>
		 
		 <div class="clear"></div>		 
		 
		 <div id="obsah-container">
		 
		 	<?php if ($objekt->zpracovano) { ?>
			 	<div id="obsah-perex">
			 		<?php echo stripslashes($objekt->popis) ?>
			 	</div>
			 	<div id="obsah">
			 		<?php
			 			if ($objekt->zpracovano) { 
			 				echo stripslashes($objekt->obsah);
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
		 			echo "<li>"; 
					
		 			if (strlen($zdroj->url) > 0) {
		 				echo '<a href="'.$zdroj->url.'">'.$zdroj->nazev.'</a>';	
					} else {
						echo $zdroj->nazev;	
					}
					
					if (strlen($zdroj->isbn) > 0) {
						echo ' ISBN: '.$zdroj->isbn.'. Zjistit dostupnost v: <a 
							href="http://aleph20.svkpl.cz/F/?func=find-d&find_code=ISN&request='.str_replace("-","",$zdroj->isbn).'">
							Studijní a vědecká knihovna Plzeňskeho kraje</a>';
					}
					
					echo "</li>";
					//echo "<br />";
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