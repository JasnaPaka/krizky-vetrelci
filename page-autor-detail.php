<?php 
	get_header();
	$uploadDir = wp_upload_dir();
	
	$autor = kv_author_info();
	$objekty = kv_author_objects();
?>

<?php if (!isset($autor->id) || $autor->deleted) { ?>
	
	<div id="page" class="static">
	
	  <div class="inner">
	
	    <div class="padding">
	
			<h2>Autor nebyl nalezen</h2>
			
			<p>Vámi hledaný autor nebyl bohužel v katalogu nalezen.</p>
		</div>
	   </div>
	</div>	
	
<?php } else { ?>

<div id="page" class="katalog author index">

  <div class="inner">

    <div class="padding">

      <h2><?php echo trim($autor->titul_pred." ".$autor->jmeno." ".$autor->prijmeni." ".$autor->titul_za) ?></h2>         

    </div>
    
<?php if (count($objekty) == 0) { ?>

<p>Nebylo nalezeno žádné dílo.</p>

<?php 

} else {
	
?>	

<div id="obsah-container">
		 
		 	<?php if ($autor->zpracovano) { ?>
			 	<div id="obsah-perex">
			 		<?php echo stripslashes($autor->popis) ?>
			 	</div>
			 	<div id="obsah">
			 		<?php
			 			if ($autor->zpracovano) { 
			 				echo stripslashes($autor->obsah);
						}
			 		?>
			 	</div>
			 <?php } ?>
		 </div>

<h3>Přehled děl</h3>
	
<p>Celkový počet děl: <?php echo $autor->pocet ?></p>
	
<?php	
	$objCount = 0;
	foreach ($objekty as $objekt) {
		$objCount++;
		
		if ($objekt->img_512 != null) {
			$img = $uploadDir['baseurl'].$objekt->img_512;
		} else {
			$img = get_template_directory_uri()."-child-krizkyavetrelci/images/foto-neni-340.png";
		}
		
		if ($objCount % 3 == 1) echo '<div>';
?>

<div class="post postitem postitemauthor">
	<a href="/katalog/dilo/<?php echo $objekt->id ?>/" title="Zobrazení informací o díle">
		<img src="<?php echo $img ?>" alt="Ukázka díla" class="katalog-dilo-obr" />
	</a>
	
	<div class="padding">
		<h3><a href="/katalog/dilo/<?php echo $objekt->id ?>/" title="Zobrazení informací o díle"><?php echo $objekt->nazev ?></a></h3>
	</div>
</div>

<?php
		if ($objCount % 3 == 0) echo '</div>';

	}
?>	

<div class="clear"></div>	    
    
<?php		
} 
?>    
    
   </div>
</div>

<?php } ?>

<?php get_footer(); ?>