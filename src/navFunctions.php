<?php

function isMobile() {
    return preg_match('/(android|iphone|ipad|ipod|webos|blackberry|iemobile|opera mini)/i', $_SERVER['HTTP_USER_AGENT']);
}



?>