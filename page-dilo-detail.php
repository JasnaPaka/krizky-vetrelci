<?php 
    get_header();
    $objekt = kv_object_info();
    $uploadDir = wp_upload_dir();
    if (is_ssl()) {
        $uploadDir = str_replace("http://", "https://", $uploadDir);
    }

    $oc = kv_object_controller();
    $controller = $oc;

    $pois = $oc->getPoisForObject();

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
			<a href="/katalog/stitek/<?php printf ($tag->id) ?>/" class="kat-tag2"><?php printf ($tag->nazev) ?></a>
			<?php } ?>
	    </div>
	    <?php } ?>
    	

      <h2><?php printf($objekt->nazev) ?></h2>         

    </div>

	<?php include "page-dilo-detail-hlavicka.php" ?>
	
	<div class="padding">
		<div class="buttonsGreen">		
			<?php if (is_user_logged_in() && current_user_can('edit_posts')) { ?>
				<a class="buttonGreen" href="/wp-admin/admin.php?page=object&action=view&id=<?php printf($objekt->id) ?>">UPRAVIT</a>
                <?php
                    if (!$objekt->potreba_foto) {
                        printf ('<a class="buttonGreen" href="/wp-admin/admin.php?page=object&action=newphoto&id=%s">POTŘEBA PŘEFOTIT</a>', $objekt->id);
                    } else {
						printf ('<a class="buttonGreen" href="/wp-admin/admin.php?page=object&action=nonewphoto&id=%s">JIŽ NENÍ POTŘEBA PŘEFOTIT</a>', $objekt->id);
					}
                ?>
            <?php } else { ?>
	        	<a class="buttonGreen" href='mailto:krizkyavetrelci@email.cz?subject=<?php printf(addslashes($objekt->nazev)) ?> (<?php print($objekt->id); ?>): Doplnění informací'>DOPLNIT INFORMACE</a>
	        <?php } ?>
	     </div>
	     
	 	<?php if ($objekt->zruseno) { ?>
	 		<div id="objekt-zrusen">
                Dílo bylo odstraněno, zakryto, zničeno nebo zmizelo neznámo kam.
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

					if (strlen($fotografiePrim->rok) > 0) {
					    $popis.= ", rok: ".$fotografiePrim->rok;
                    }
					
					if (!$fotografiePrim->soukroma)  {
						$popis.= ", &copy; CC-BY-SA 4.0";
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

							if (strlen($photo->rok) > 0) {
								$popis.= ", rok: ".$photo->rok;
							}
							
							if (!$photo->soukroma)  {
								$popis.= ", &copy; CC-BY-SA 4.0";
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
			 		<?php print(stripslashes($objekt->popis)) ?>
			 	</div>
			 	<div id="obsah">
			 		<?php
			 			if ($objekt->zpracovano) { 
			 				print(stripslashes($objekt->obsah));
						}
			 		?>
			 	</div>
			 <?php } ?>
		 </div>

		<?php if (sizeof ($oc->getCollectionsForObject()) > 0) { ?>
			<div id="soubory">
				<hr />
				<h3>Soubory děl</h3>
				<p>Dílo je součástí následujících souborů děl:
				<?php
					$prvni = true;
					foreach ($oc->getCollectionsForObject() as $collection) {
						if (!$prvni) {
							print (", ");
						}
						printf ('<a href="/katalog/soubor/%d/">%s</a>', $collection->id, $collection->nazev);
						$prvni = false;
					}
				?>
				</p>
			</div>
		<?php } ?>
                 
		<?php if (sizeof($pois) > 0) { ?>

		 <div id="body">
			<hr />
			<h3>Související místa</h3>

			<p><ul>
				<?php
				foreach ($pois as $poi) {
					print ("<li>");
					printf ('<a href="https://maps.google.cz/maps?q=%s,%s">%s</a>', $poi->latitude, $poi->longitude, $poi->nazev);
					if (strlen($poi->popis) > 2) {
						print (' &ndash; '.$poi->popis);
					}
					print ("</li>");
				}
				?>
			</ul></p>
		 </div>

		<?php } ?>

		<?php
		if (strlen($objekt->prezdivka) > 2) {
			printf("<div id=\"prezdivky\"><hr /><h3>Přezdívky díla</h3><p>%s</p></div>",$objekt->prezdivka);
		}
		?>

		 <?php if (isset($zdroje) && count($zdroje) > 0) { ?>
		 
		 <div id="zdroje">
			<hr />
		 	<h3>Literatura a prameny</h3>
		 	<p><ul>
		 	<?php
		 		foreach ($zdroje as $zdroj) {
		 			printf("<li>");

                    if (strlen($zdroj->typ) > 0 && strlen($zdroj->nazev) < 2) {
					    $sc = $oc->getSourceType($zdroj->typ);
					    printf('<a href="%s">%s</a>', strlen($zdroj->url) > 2 ? $zdroj->url : sprintf($sc->getUrl(), $zdroj->identifikator),
                            sprintf($sc->getDescription(), $objekt->nazev));
					} else if (strlen($zdroj->url) > 0) {
		 				print('<a href="'.$zdroj->url.'">'.$zdroj->nazev.'</a>');
					} else {
						printf($zdroj->nazev);
					}
					
					if (strlen($zdroj->typ) > 0 && $oc->getIsKniha($zdroj->typ)) {
						printf(' ISBN: '.$zdroj->identifikator.'. Zjistit dostupnost v: <a 
							href="http://aleph.svkpk.cz/F/?func=find-d&find_code=ISN&request='.str_replace("-","",$zdroj->identifikator).'">
							Studijní a vědecká knihovna Plzeňskeho kraje</a>');
					}
					
					printf("</li>");
				}
		 	?>
		 	</ul>
		 	</p>
		 </div>
		 
		 <?php }
		    include "page-trvaly-odkaz.php";
		 ?>
	     
	</div>
   </div>
</div>

<?php } ?>

<?php get_footer(); ?>