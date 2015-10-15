<?php 
	get_header();
	$uploadDir = wp_upload_dir();
	$objekty = kv_object_seznam();
	$oc = kv_object_controller();
	
	$page = (int) $_GET["stranka"];
	if ($page == null) {
		$page = 0;	
	} 
?>

<div id="page" class="katalog index">
<div class="inner">
<div class="padding">

<div id="searchdatabase">
	<form method="post" action="/katalog/">
        <input name="typ" value="dilo" type="hidden">
        <input id="s" name="s" placeholder="Hledat v dílech..." type="text">
        <input value="Hledat" type="submit">
	</form>
</div>

<h2>
	<?php if ($oc->getIsShowedTag()) { ?>
		Díla se štítkem '<?php printf ($oc->getCurrentTag()->nazev) ?>'
	<?php } else if ($oc->getIsShowedCategory()) { ?>		
		Kategorie děl '<?php printf ($oc->getCurrentCategory()->nazev) ?>'
	<?php } else if ($oc->getSearchValue() == null) { ?>
		Katalog děl
	<?php } else { ?>
		Výsledek hledání v dílech pro "<?php printf($oc->getSearchValue()) ?>"
	<?php }?>
</h2>

<?php if ($page == 0 && count($oc->getAllTags()) > 0 && !$oc->getIsShowedCategory()) { ?>	
	<div id="kat-tags">	
<?php foreach ($oc->getAllTags() as $tag) { ?>

<a href="/katalog/stitek/<?php printf ($tag->id) ?>/" class="kat-tag"><?php printf ($tag->nazev) ?></a>

<?php } ?>
	</div>
	<div class="clear"></div>	
<?php } ?>

</div>

</div>

<hr />

<div class="inner">

<?php if (count($objekty) == 0) { ?>

<p>Nebylo nalezeno žádné dílo.</p>

<?php 

} else {
	if ($oc->getIsShowedTag()) {
		$popis = $oc->getCurrentTag()->popis;
		
		if (strlen(trim($popis)) > 0) {
			printf("<p>%s</p>", $popis);
		}
		printf("<p>Počet děl se štítkem: %d</p><br />", sizeof($objekty));	
	}
	
	$objCount = 0;
	foreach ($objekty as $objekt) {
		$objCount++;
		
		if ($objekt->img_512 != null) {
			$img = $uploadDir['baseurl'].$objekt->img_512;
		} else {
			$img = get_template_directory_uri()."-child-krizkyavetrelci/images/foto-neni-340.png";
		}
		
		if ($objCount % 3 == 1) printf('<div>');
?>

<div class="post postitem">
	<a href="/katalog/dilo/<?php printf($objekt->id) ?>/" title="Zobrazení informací o díle">
		<img src="<?php printf($img) ?>" alt="Ukázka díla" class="katalog-dilo-obr" />
	</a>
	
	<div class="padding">
		<h3><a href="/katalog/dilo/<?php printf($objekt->id) ?>/" title="Zobrazení informací o díle"><?php printf($objekt->nazev) ?></a></h3>
		<p><span class="post-label">Kategorie:</span> 
			<a href="/katalog/kategorie/<?php printf($objekt->kategorie) ?>/" title="Zobrazení děl v kategorii"><?php printf($objekt->katnazev) ?></a></p>
		<p><span class="post-label"><?php if (count($objekt->autori) > 1) { printf("Autoři"); } else { printf("Autor"); } ?>:</span>
			<?php if (count($objekt->autori) == 0) { ?>
				nejsou známi
			<?php } else {
				$isFirst = true; 
				foreach ($objekt->autori as $autor) {
					if (!$isFirst) {
						printf(", ");	
					}
					
					printf('<a href="/katalog/autor/'.$autor->id.'/">'.trim($autor->titul_pred." ".$autor->jmeno." ".$autor->prijmeni." ".$autor->titul_za)."</a>");
					
					$isFirst = false;
				}
			} ?>
		</a>
	</div>
</div>

<?php
		if ($objCount % 3 == 0) printf('</div>');

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
		$countPages = kv_object_pages_count();
		
		
		$subcat = "";
		$category = $oc->getCurrentCategory();
		if ($category != null) {
			$subcat = "kategorie/".$category->id."/";	
		}
		
		if ($countPages > 0) {
			// První
			if ($page > 0) {
				printf('<a href="/katalog/'.$subcat.'" class="strankovani-prvni">První</a>');		
			}		
		
			// Předchozí
			if ($page-1 >= 0) {
				printf('<a href="/katalog/'.$subcat.'?stranka='.($page-1).'" class="strankovani-predchozi">Předchozí</a>');		
			}
		
			// před aktuální stránkou
			if ($page-2 >= 0) {
				printf('<a href="/katalog/'.$subcat.'?stranka='.($page-2).'" class="strankovani-polozka">'.($page-1)."</a>");		
			}
			if ($page-1 >= 0) {
				printf('<a href="/katalog/'.$subcat.'?stranka='.($page-1).'" class="strankovani-polozka">'.($page)."</a>");		
			}
			
			// aktuální
			printf('<span class="strankovani-polozka-akt">'.($page+1).'</span>');
			
			// po aktuálním
			if ($page <= $countPages) {
				printf('<a href="/katalog/'.$subcat.'?stranka='.($page+1).'" class="strankovani-polozka">'.($page+2)."</a>");		
			}
			if ($page+1 <= $countPages) {
				printf('<a href="/katalog/'.$subcat.'?stranka='.($page+2).'" class="strankovani-polozka">'.($page+3)."</a>");		
			}
			
			// další
			if ($page <= $countPages) {
				printf('<a href="/katalog/'.$subcat.'?stranka='.($page+1).'" class="strankovani-dalsi">Další</a>');		
			}	
			
			// Poslední
			if ($page <= $countPages) {
				printf('<a href="/katalog/'.$subcat.'?stranka='.($countPages-1).'" class="strankovani-posledni">Poslední</a>');		
			}
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
