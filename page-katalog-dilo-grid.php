<p><span class="post-label">Kategorie:</span> 
        <a href="/katalog/kategorie/<?php printf($objekt->kategorie) ?>/" title="<?php print ($KV["zobrazeni_informaci"]) ?>"><?php printf($objekt->katnazev) ?></a></p>
<p><span class="post-label"><?php if (count($objekt->autori) > 1) { printf("Autoři"); } else { printf("Autor"); } ?>:</span>
        <?php if (count($objekt->autori) == 0) { ?>
        <?php printf('<a href="/katalog/kategorie/'.$objekt->kategorie.'/bez-autora/">není znám</a>'); ?>
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