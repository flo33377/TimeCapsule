<?php

/* Fichier fetch en JS pour updater la BDD en cas de like d'un memory */

require __DIR__ . "/mainFunctions.php";
require __DIR__ . "/main.php";

if (in_array($_POST['memoryId'], $_SESSION['LikedMemory'])) {
    // Si souvenir déjà liké => on ne fait rien
    exit;
} else { 
    likesMemory($_POST); // fonction qui update la BDD

    $_SESSION['LikedMemory'][] = $_POST['memoryId']; // on ajoute l'id de la publi qui vient d'être likée pour disabled le fait qu'elle puisse être liké de nouveau
};


?>

