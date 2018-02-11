<?php 
    get_header();
    $uploadDir = wp_upload_dir();
    $ac = kv_autor_controller();

    $autor = kv_author_info();
    $objekty = kv_author_objects();
    $zdroje = kv_author_sources();
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

	<div class="topMenu">
            <div>
                <h1>Narození</h1>
                <h2>
                    <?php if ($autor->datum_narozeni == null) {
                            printf('<em class="neevidovano">(neuvedeno)</em>');
                    } else {
                            print date("j. n. Y", strtotime($autor->datum_narozeni));
                            if (strlen ($autor->misto_narozeni) > 1) {
                                printf (', %s', $autor->misto_narozeni);
                            }
                    } ?>
                </h2>
            </div>
            <?php if ($autor->datum_umrti != null) { ?>
                <div>
                    <h1>Úmrtí</h1>
                    <h2>
                            <?php
                                    print date("j. n. Y", strtotime($autor->datum_umrti));
                                if (strlen ($autor->misto_umrti) > 1) {
                                    printf (', %s', $autor->misto_umrti);
                                }
                            ?>
                    </h2>
                </div>
            <?php } ?>
            <?php if ($autor->web != null) { ?>
                <div>
                    <h1>Web</h1>
                    <h2>
                        <?php
                            $caption = $autor->web;
                            if (strlen($autor->web) > 40) {
                                    $caption = substr($autor->web, 0, 40)."...";
                            }						
                            printf ('<a href="%s">%s</a>', $autor->web, $caption);
                        ?>
                    </h2>
                </div>
            <?php } ?>
	</div>
	

	<?php if (is_user_logged_in()) { ?>
		<div class="buttonsGreen">			
			<a class="buttonGreen" href="/wp-admin/admin.php?page=author&action=view&id=<?php echo $autor->id ?>">UPRAVIT</a>
		</div>
    <?php } ?>
     
    
<?php if (count($objekty) == 0) { ?>

<div id="dila"> 
<hr />
<h3>Přehled děl</h3>
<p>Nebylo nalezeno žádné dílo.</p>
</div>

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
 
 <?php if (count($zdroje) > 0) { ?>
 
 <div id="zdroje">
 	<hr />
 	<h3>Literatura a prameny</h3>
 	<p><ul>
 	<?php
        foreach ($zdroje as $zdroj) {
            printf("<li>");
            if (strlen($zdroj->typ) > 0 && strlen($zdroj->nazev) < 2) {
                $sc = $ac->getSourceType($zdroj->typ);
                printf('<a href="%s">%s</a>', strlen($zdroj->url) > 2 ? $zdroj->url : sprintf($sc->getUrl(), $zdroj->identifikator),
                    sprintf($sc->getDescription(), trim($autor->jmeno." ".$autor->prijmeni)));
            } else if (strlen($zdroj->url) > 0) {
                print('<a href="'.$zdroj->url.'">'.$zdroj->nazev.'</a>');
            } else {
                printf($zdroj->nazev);
            }

            if (strlen($zdroj->typ) > 0 && $ac->getIsKniha($zdroj->typ)) {
                printf(' ISBN: '.$zdroj->identifikator.'. Zjistit dostupnost v: <a 
                                href="http://aleph20.svkpl.cz/F/?func=find-d&find_code=ISN&request='.str_replace("-","",$zdroj->identifikator).'">
                                Studijní a vědecká knihovna Plzeňskeho kraje</a>');
            }

            printf("</li>");
        }
 	?>
 	</ul>
 	</p>
 </div>
 
 <?php } ?> 
 
<div id="dila"> 
<hr />
<h3>Přehled děl</h3>
	
<p id="pocet-del">Celkový počet děl: <?php echo $autor->pocet ?></p>
	
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
		<h3>
            <a href="/katalog/dilo/<?php echo $objekt->id ?>/" title="Zobrazení informací o díle"><?php echo $objekt->nazev ?></a>
			<?php if ($objekt->zruseno) { ?>
                <span class="katalog-dilo-zruseno">Odstraněno</span>
			<?php } ?>
        </h3>
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
</div>

<?php } ?>

<?php get_footer(); ?>