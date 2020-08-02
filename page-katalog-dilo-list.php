<h4><?php if (count($objekt->autori) > 1) { printf("Autoři"); } else { printf("Autor"); } ?>:</h4>
<p><?php if (count($objekt->autori) == 0) { ?>
		<?php printf('<a href="/katalog/kategorie/'.$objekt->kategorie.'/bez-autora/">není znám</a>'); ?>
<?php } else {
    $isFirst = true; 
    foreach ($objekt->autori as $autor) {
        if (!$isFirst) {
            printf(", ");	
        }

        printf('<a href="/katalog/autor/'.$autor->id.'/">'.trim($autor->jmeno." ".$autor->prijmeni)."</a>");
        $isFirst = false;
    }
} ?>
</p>