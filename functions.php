<?php

if (WP_DEBUG && WP_DEBUG_DISPLAY) 
{
   ini_set('error_reporting', E_ALL & ~E_STRICT & ~E_DEPRECATED);
}

function getObjectPluralStr($count) {
    global $KV;
    
    if ($count == 0) {
        return $KV["dilo"][0];
    }
    if ($count < 2) {
        return $KV["dilo"][1];
    }
    if ($count < 5) {
        return $KV["dilo"][2];
    }
    
    return $KV["dilo"][3];
}

function getCountRandomObjects() {
    return 2;
}

// řetězce

$KV["projekt_nazev"] = "Křížky a vetřelci";
$KV["projekt_info"] = 'Projekt Křížky a vetřelci mapuje drobné umění na území města Plzeň. Zaměřuje se jak na umění z doby normalizace,
			tak na sakrální památky jako jsou křížky či kapličky. Bez povšimnutí však nezůstávají ani pomníky a pamětní desky.
			Křížky a vetřelci jsou otevřeným projektem, do kterého se může zapojit každý. Víte o díle, které nám chybí v
			katalogu? Nebo o něm něco víte? <a href="mailto:krizkyavetrelci@email.cz">Napište nám</a> nebo se 
			<a href="https://www.facebook.com/groups/krizkyavetrelci/">zapojte na Facebooku</a>.';

$KV["nahodne_dilo"] = "Náhodná díla";
$KV["posledni_pridane"] = "Poslední přidané";
$KV["dilo"] = array ("děl", "dílo", "díla", "děl");
$KV["ukazka_dila"] = "Ukázka díla";
$KV["hledat_v_dilech"] = "Hledat v dílech...";
$KV["katalog_del"] = "Katalog děl";
$KV["dila_se_stitkem"] = "Díla se štítkem";
$KV["vysledek_hledani_dila"] = "Výsledek hledání v dílech pro";
$KV["dilo_nenalezeno"] = "Nebylo nalezeno žádné dílo.";
$KV["pocet_del_se_stitkem"] = "Počet děl se štítkem";
$KV["zobrazeni_informaci"] = "Zobrazení informací o díle";
$KV["zadne_dilo"] = "V katalogu není žádné dílo.";
$KV["hledame"] = "Zapojte se";


include "functions-strings.php";
