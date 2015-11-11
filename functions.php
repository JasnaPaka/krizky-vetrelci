<?php

if (WP_DEBUG && WP_DEBUG_DISPLAY) 
{
   ini_set('error_reporting', E_ALL & ~E_STRICT & ~E_DEPRECATED);
}

include "functions-strings.php";

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