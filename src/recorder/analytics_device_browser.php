<?php

session_start();
include_once(__DIR__ . "/analytics_recorder_functions.php");

// Domaines autorisés (avec et sans www)
$allowedHosts = ['fneto-prod.fr', 'www.fneto-prod.fr', 'localhost:5000'];

// Vérifie l'origine si elle existe
if (isset($_SERVER['HTTP_ORIGIN'])) {
    $parsedOrigin = parse_url($_SERVER['HTTP_ORIGIN']);
    $originHost = $parsedOrigin['host'] ?? '';
    $originPort = isset($parsedOrigin['port']) ? ':' . $parsedOrigin['port'] : '';
    $originFull = $originHost . $originPort;

    if (!in_array($originFull, $allowedHosts, true)) {
        echo "⛔ Accès interdit depuis une origine non autorisée. ⛔";
        exit;
    }

    // Origine autorisée → on envoie les bons headers CORS
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header("Access-Control-Allow-Methods: POST, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type");
} else {
    // Aucun header Origin → probablement un fetch interne, donc autorisé
    // Pas besoin d'envoyer de headers CORS dans ce cas
}

// Gestion de la requête OPTIONS (préflight)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit;
}


// Récupère les données envoyées ou les set par défaut
$device = $_POST['device'] ?? 'desktop';
$browser = $_POST['browser'] ?? 'other_browser';

$allowedDevices = ['desktop', 'mobile', 'tablet'];
$allowedBrowsers = ['chrome', 'firefox', 'safari', 'edge', 'other_browser'];

// check la correspondance avec les colonnes en BDD ou les set par défaut
if (!in_array($device, $allowedDevices)) $device = 'desktop';
if (!in_array($browser, $allowedBrowsers)) $browser = 'other_browser';

$currentDate = (new DateTime())->format('Y-m-d');

// Vérifie que la ligne du jour existe
if (!isCurrentDateRecorded($currentDate)) {
    addCurrentDateInDB($currentDate);
}

// N'update les données que si c'est un nouveau visiteur
$currentDate = (new DateTime())->format('Y-m-d');

if(!isset($_SESSION['timecapsule_device_browser_last_record']) || (isset($_SESSION['timecapsule_device_browser_last_record']) && ($_SESSION['timecapsule_device_browser_last_record'] != $currentDate))) {
    // Mets à jour les colonnes correspondantes
    $SQL = "UPDATE timecapsule_analytics
            SET $device = $device + 1,
                $browser = $browser + 1
            WHERE date_recorded = :date_recorded";

    $Statement = connectAnalytics()->prepare($SQL);
    $Statement->execute(['date_recorded' => $currentDate]);

    $_SESSION['timecapsule_device_browser_last_record'] = $currentDate;
}

?>
