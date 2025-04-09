<?php

require __DIR__ . "/mainFunctions.php";
require __DIR__ . "/main.php";

if (in_array($_POST['memoryId'], $_SESSION['LikedMemory'])) {
    // Si déjà liké => on ne fait rien
    exit;
} else { 
    likesMemory($_POST);

    $_SESSION['LikedMemory'][] = $_POST['memoryId']; // on ajoute l'id de la publi qui vient d'être likée
};


?>

