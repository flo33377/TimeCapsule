<?php

/* Fichier contenant les diverses fonctions de navigation (check de device, etc.) */

function isMobile() {
    return preg_match('/(android|iphone|ipad|ipod|webos|blackberry|iemobile|opera mini)/i', $_SERVER['HTTP_USER_AGENT']);
}



?>