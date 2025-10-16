<?php

/* Fichier qui contient le mécanisme de déclenchement des enregistrements de données analytics */

    // ENVIRONNEMENT //

// dépendances
include_once(__DIR__ . "/analytics_recorder_functions.php");


    // SECURITE //

/* Système de blocage en cas d'intervalles de requêtes trop rapides */

$rateLimitInSeconds = 3; //nbr de sec mini entre chaque requête pour ne pas être bloqué

$clientIP = $_SERVER['REMOTE_ADDR'];
$currentTime = time();

if(isset($_SESSION['last_request_time'])) {
    $elapsed = $currentTime - $_SESSION['last_request_time']; // timing depuis dernière requête
    if($elapsed < $rateLimitInSeconds) { // si inf à rateLimitInSecond => bloque l'accès
        echo "⛔ Vous avez effectué trop de requêtes, veuillez patienter quelques secondes. ⛔";
        exit;
    }
}

$_SESSION['last_request_time'] = $currentTime; 


/* Système de blocage si la requête d'accès ne provient pas de mon site */

$allowedHost = 'www.fneto-prod.fr';
$allowedLocal = 'localhost:5000';

if (isset($_SERVER['HTTP_ORIGIN'])) {
    $origin = parse_url($_SERVER['HTTP_ORIGIN'], PHP_URL_HOST) . 
              (isset(parse_url($_SERVER['HTTP_ORIGIN'])['port']) ? ':' . parse_url($_SERVER['HTTP_ORIGIN'])['port'] : '');
    // construit $origin en extrayant le NDD (+ le port s'il est présent -> cas du local) du header Origin
    if ($origin !== $allowedHost && $origin !== $allowedLocal) { // s'il ne correspond à aucune origine autorisé, on bloque
        echo "⛔ Accès interdit depuis une origine non autorisée. ⛔";
        exit;
    }
}


    // MECANISME //

/* Récupère la date actuelle */
$currentDate = (new DateTime())->format('Y-m-d');
// créé un objet DateTime mais ne donne à currentDate que le format attendu en BDD


/* Check si déjà entrée en BDD pour la date courante */
$isCurrentDateRecorded = isCurrentDateRecorded($currentDate);

/* MàJ de la BDD */
if(!$isCurrentDateRecorded){
    // si date n'existe pas encore, ajoute une entrée
    addCurrentDateInDB($currentDate);
    // et indique en session qu'il est venu aujourd'hui
    $_SESSION['visited_today'] = true;
    $_SESSION['last_visit_date'] = $currentDate;

} else {
    // pars du principe que ce n'est pas un nouveau visiteur
    $newVisitor = false;

    if(!hasAlreadyVisitedToday($currentDate)) { // check s'il est bien déjà venu
        // si c'est bien un nouveau, config sa session et passe newVisitor à true
        $_SESSION['visited_today'] = true;
        $_SESSION['last_visit_date'] = $currentDate;
        $newVisitor = true;
    };

    // récup les données du jour
    $previousStats = getCurrentDateInfos($currentDate);

    // puis renvoie données mises à jour
    $impressions = $previousStats['impressions'] + 1;
    $uniqueVisitors = $previousStats['unique_visitors'];
    if($newVisitor) {
        $uniqueVisitors++; // si new visiteur, incrémente nbr visiteurs
    };
    updateDB($currentDate, $impressions, $uniqueVisitors);
}


?>