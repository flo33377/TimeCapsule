<?php

session_start();

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

include_once(__DIR__ . "/mainFunctions.php");

// Constantes
    // base_url = lien vers la HP basé sur le serveur utilisé 
define("BASE_URL", ($_SERVER["SERVER_PORT"] === "5000") ? "http://localhost:5000/" : "https://www.fneto-prod.fr/timecapsule/");
    // list_index_url = fichier qui affiche listing listes
define("LIST_INDEX_URL", __DIR__ . "/content/list_index.php");
    // FOCUS_EVENT_url = fichier qui demande mdp ou affiche content list si pas de mdp ou mdp ok
define("FOCUS_EVENT_URL", __DIR__ . "/content/list_show.php");


// Variables de pages
$method = $_SERVER['REQUEST_METHOD'];
    // bellow, set all parameters by default
$page = "get_all_events"; // Valeur par défaut
$content = LIST_INDEX_URL; // Par défaut, afficher la liste des listes
$list = null; // créé la variable en prévision
$lists = null; // créé la variable en prévision

// Routes
// Savoir sur quelle page on va en cas de POST ou GET
switch ($method) {
    case "POST":
        if (!empty($_POST)) {
            if (isset($_POST["post_create_event"])) $page = "post_create_event"; // basé sur l'input caché post_create_event
            if (isset($_POST["post_authenticate"])) $page = "post_authenticate"; // basé sur le champ caché sous le mdp
            if (isset($_POST["post_erase_event"])) $page = "post_erase_event"; // basé sur l'input caché suppr liste
            if (isset($_POST["post_change_info_event"])) $page = "post_change_info_event"; // basé sur l'input caché change nom liste
        }
        break;

    case "GET":
        if (!empty($_GET["list"])) $page = "get_show_event"; // le get est généré sous forme de param d'URL
        break;
}

// Pages
// Logique à appliquer selon la page
switch ($page) {
    case "get_all_events": // afficher toutes les listes
        $lists = getAllEvents();
        $content = LIST_INDEX_URL;
        break;

    case "post_create_event": // création de liste
        createNewEvent($_POST);
        $lists = getAllEvents(); // execute la requête SQL et return les listes
        $content = LIST_INDEX_URL;
        break;

    case "post_authenticate": // vérifier authentifcation
        $userPswd = $_POST["password"] ?? null;
        $targetList = $_POST["targetList"] ?? null;

        if ($userPswd && $targetList) {
            $content = FOCUS_EVENT_URL;
            $list = getEventByName($targetList);

            if ($list && isset($list["list_password"]) && $userPswd === $list["list_password"]) {
                $_SESSION["auth"] = $targetList;
                header("Location: " . "/timecapsule/?list=$targetList");
            }
        }
        break;

    case "get_show_event": // afficher une liste et enregistre list_id dans SESSION
        $content = FOCUS_EVENT_URL;
        $listName = $_GET["list"] ?? null;
        if ($listName) $list = getEventByName($listName);
        $_SESSION['list_id'] = $list['list_id'] ?? null;
        $_SESSION['periodicity'] = $list['periodicity'] ?? null;
        $objectivesList = getMemoriesByEventId($list['list_id']); // get all obj
        break;
    
    case "post_erase_event": // supprime une liste
        // ATTENTION /!\: ajouter la verif par mot de passe pour ça /!\
        $content = LIST_INDEX_URL;
        if ($_SESSION['list_id']) deleteEvent($_SESSION['list_id']);
        $lists = getAllEvents();
        break;
    
    case "post_change_info_event": // change le nom d'une liste
        // ATTENTION /!\: Modifier pour ne pas update que le nom /!\
        $content = FOCUS_EVENT_URL;
        $targetList = $_POST['new_name_list'];
        if ($_SESSION['list_id']) changeNameEvent($_SESSION['list_id'], $_POST['new_name_list']);
        $_SESSION["auth"] = $targetList;
        header("Location: " . "/timecapsule/?list=$targetList");
        break;

}
