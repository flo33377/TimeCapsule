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
    // CREATE_MEMORY_URL = fichier sur lequel est le form pour ajouter memory
define("CREATE_MEMORY_URL", __DIR__ . "/content/create_memory.php");


// Variables de pages
$method = $_SERVER['REQUEST_METHOD'];
    // bellow, set all parameters by default
$page = "get_all_events"; // Valeur par défaut
$content = LIST_INDEX_URL; // Par défaut, afficher la liste des listes
$list = null; // créé la variable en prévision
$lists = null; // créé la variable en prévision

if (!isset($_SESSION['LikedMemory'])) {
    $_SESSION['LikedMemory'] = []; // initialise un tableau vide pour stocker les publis likées
};

// Routes
// Savoir sur quelle page on va en cas de POST ou GET
switch ($method) {
    case "POST":
        if (!empty($_POST)) {
            if (isset($_POST["post_create_event"])) $page = "post_create_event"; // basé sur l'input caché post_create_event
            if (isset($_POST["post_authenticate"])) $page = "post_authenticate"; // basé sur le champ caché sous le mdp
            if (isset($_POST["post_erase_event"])) $page = "post_erase_event"; // basé sur l'input caché suppr liste
            if (isset($_POST["post_change_name_event"])) $page = "post_change_name_event"; // basé sur l'input caché change nom liste
            if (isset($_POST["post_change_logo_colors"])) $page = "post_change_logo_colors"; // basé sur l'input caché change logo colors
            if (isset($_POST["post_create_memory"])) $page = "post_create_memory"; // basé sur l'input caché post_create_memory
        }
        break;

    case "GET":
        if (!empty($_GET["event"]) && !isset($_GET['create_mode'])) $page = "get_show_event"; // le get est généré sous forme de param d'URL
        if (!empty($_GET['create_mode']) && $_GET['create_mode'] == 'true') $page = "go_create_memory"; // basé sur l'input caché create_memory
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

    case "post_authenticate": // vérifier authentification
        $userPswd = $_POST["password"] ?? null;
        $targetEvent = $_POST["targetEvent"] ?? null;

        if ($userPswd && $targetEvent) {
            $content = FOCUS_EVENT_URL;
            $event = getEventById($targetEvent);

            if ($event && isset($event["event_password"]) && $userPswd === $event["event_password"]) {
                $_SESSION["auth"] = $targetEvent;
                if($_SERVER["SERVER_PORT"] === "5000") {
                    header("Location: " . "/?event=$targetEvent");
                } else {
                    header("Location: " . "/timecapsule/?event=$targetEvent");
                };
            }
        }
        break;

    case "get_show_event": // afficher une liste et enregistre event_id dans SESSION
        $content = FOCUS_EVENT_URL;
        $eventId = $_GET["event"] ?? null;
        if ($eventId) $event = getEventById($eventId);
        $_SESSION['event_id'] = $event['event_id'] ?? null;
        $_SESSION['main_color'] = $event['main_color'] ?? null;
        $_SESSION['secondary_color'] = $event['secondary_color'] ?? null;
        $_SESSION['font_color'] = $event['font_color'] ?? null;
        $_SESSION['event_logo'] = $event['event_logo'] ?? null;
        $memoriesData = getMemoriesByEventId($event['event_id']); // get all memories
        break;
    
    case "post_erase_event": // supprime un event
        // ATTENTION /!\: ajouter la verif par mot de passe pour ça /!\
        $content = LIST_INDEX_URL;
        if ($_SESSION['event_id']) deleteEvent($_SESSION['event_id']);
        $lists = getAllEvents();
        break;
    
    case "post_change_name_event": // change le nom d'un event
        // ATTENTION /!\: Modifier pour ne pas update que le nom /!\
        $content = FOCUS_EVENT_URL;
        if ($_SESSION['event_id']) $targetEvent = $_SESSION['event_id'];
        if ($_SESSION['event_id']) changeNameEvent($_SESSION['event_id'], $_POST['new_name_event']);
        $_SESSION["auth"] = $targetEvent;
        if($_SERVER["SERVER_PORT"] === "5000") {
            header("Location: " . "/?event=$targetEvent");
        } else {
            header("Location: " . "/timecapsule/?event=$targetEvent");
        };
        break;

    case "post_change_logo_colors" : // change les couleurs et éventuellement le logo de l'event
        $content = FOCUS_EVENT_URL;
        if ($_SESSION['event_id']) $targetEvent = $_SESSION['event_id'];
        if ($_SESSION['event_id']) changeLogoOrColorsEvent($_SESSION['event_id'], $_POST);
        if($_SERVER["SERVER_PORT"] === "5000") {
            header("Location: " . "/?event=$targetEvent");
        } else {
            header("Location: " . "/timecapsule/?event=$targetEvent");
        };
        break;

    case "go_create_memory": // va sur la page pour créer des memories
        $content = CREATE_MEMORY_URL;
        $eventId = $_GET["event"] ?? null;
        if ($eventId) $event = getEventById($eventId);
        break;

    case "post_create_memory": // créé un memory
        $content = FOCUS_EVENT_URL;
        $eventId = $_SESSION["event_id"] ?? null;
        if ($_SESSION['event_id']) $targetEvent = $_SESSION['event_id'];
        if ($eventId) $event = getEventById($eventId);
        if ($eventId) createNewMemory($_POST);
        $memoriesData = getMemoriesByEventId($event['event_id']); // get all memories
        if($_SERVER["SERVER_PORT"] === "5000") {
            header("Location: " . "/?event=$targetEvent");
        } else {
            header("Location: " . "/timecapsule/?event=$targetEvent");
        };
        break;
}
