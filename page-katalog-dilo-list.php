<h4><?php if (count($objekt->autori) > 1) { printf("Autoři"); } else { printf("Autor"); } ?>:</h4>
<p><?php if (count($objekt->autori) == 0) { ?>
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
</p>