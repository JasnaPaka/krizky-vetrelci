<?php 
	get_header();
	$uploadDir = wp_upload_dir();
	$objekty = kv_object_seznam();
?>

<div id="page" class="katalog index">
<div class="inner">
<div class="padding">

<h2>Katalog děl</h2>

</div>
</div>

<hr />

<div class="inner">

<?php if (count($objekty) == 0) { ?>

<p>Nebylo nalezeno žádné dílo.</p>

<?php 

} else {
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

<div class="post postitem">
	<a href="/katalog/dilo/<?php echo $objekt->id ?>/" title="Zobrazení informací o díle">
		<img src="<?php echo $img ?>" alt="Ukázka díla" class="katalog-dilo-obr" />
	</a>
	
	<div class="padding">
		<h3><a href="/katalog/dilo/<?php echo $objekt->id ?>/" title="Zobrazení informací o díle"><?php echo $objekt->nazev ?></a></h3>
		<p><span class="post-label">Kategorie:</span> <?php echo $objekt->katnazev ?></p>
		<p><span class="post-label"><?php if (count($objekt->autori) > 1) { echo "Autoři"; } else { echo "Autor"; } ?>:</span>
			<?php if (count($objekt->autori) == 0) { ?>
				nejsou známi
			<?php } else {
				$isFirst = true; 
				foreach ($objekt->autori as $autor) {
					if (!$isFirst) {
						echo ", ";	
					}
					
					echo '<a href="/katalog/autor/'.$autor->id.'/">'.trim($autor->titul_pred." ".$autor->jmeno." ".$autor->prijmeni." ".$autor->titul_za)."</a>";
					
					$isFirst = false;
				}
			} ?>
		</a>
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

<hr />

<div class="padding">
<div class="inner">
<div class="katalog-strankovani">

<?php
	if (count($objekty) > 0) {
		$page = (int) $_GET["stranka"];
		$countPages = kv_object_pages_count();
		
		// První
		if ($page > 0) {
			echo '<a href="/katalog/" class="strankovani-prvni">První</a>';		
		}		
	
		// Předchozí
		if ($page-1 >= 0) {
			echo '<a href="/katalog/?stranka='.($page-1).'" class="strankovani-predchozi">Předchozí</a>';		
		}
	
		// před aktuální stránkou
		if ($page-2 >= 0) {
			echo '<a href="/katalog/?stranka='.($page-2).'" class="strankovani-polozka">'.($page-1)."</a>";		
		}
		if ($page-1 >= 0) {
			echo '<a href="/katalog/?stranka='.($page-1).'" class="strankovani-polozka">'.($page)."</a>";		
		}
		
		// aktuální
		echo '<span class="strankovani-polozka-akt">'.($page+1).'</span>';
		
		// po aktuálním
		if ($page <= $countPages) {
			echo '<a href="/katalog/?stranka='.($page+1).'" class="strankovani-polozka">'.($page+2)."</a>";		
		}
		if ($page+1 <= $countPages) {
			echo '<a href="/katalog/?stranka='.($page+2).'" class="strankovani-polozka">'.($page+3)."</a>";		
		}
		
		// další
		if ($page <= $countPages) {
			echo '<a href="/katalog/?stranka='.($page+1).'" class="strankovani-dalsi">Další</a>';		
		}	
		
		// Poslední
		if ($page <= $countPages) {
			echo '<a href="/katalog/?stranka='.($countPages+1).'" class="strankovani-posledni">Poslední</a>';		
		}	
		
	}

			

?>

</div>
</div>
</div>


<div class="clear"></div>

</div>

</div>
	

<?php get_footer(); ?>