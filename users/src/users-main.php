<?php

session_start();

/* 
//fonction de débug - need fichier debug_log.txt
function debug_log($message) {
    $file = __DIR__ . '/debug_log.txt'; // Le fichier log sera dans le même dossier que ton script
    $date = date('Y-m-d H:i:s');
    $log = "[$date] $message\n";
    file_put_contents($file, $log, FILE_APPEND);
}

// Utilisation du logger
debug_log("SESSION: " . print_r($_SESSION, true));
debug_log("POST: " . print_r($_POST, true));
debug_log("GET: " . print_r($_GET, true));
debug_log("-----------");

// fin du debogger */



ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

include_once(__DIR__ . "/users-mainFunctions.php");

// Constantes
    // base_url = lien vers la HP basé sur le serveur utilisé 
define("BASE_URL", ($_SERVER["SERVER_PORT"] === "5000") ? "http://localhost:5000/" : "https://www.fneto-prod.fr/timecapsule/");
    // general login url = page de connexion/inscription
define("GENERAL_LOGIN_URL", __DIR__ . "/../../src/content/users-content/login.php");
    // profile url = p. profil de l'utilisateur connecté
define("PROFILE_URL", __DIR__ . "/../../src/content/users-content/user-profile.php");


// Variables de pages
$method = $_SERVER['REQUEST_METHOD'];
    // bellow, set all parameters by default
$page = "login_page"; // Valeur par défaut
$content = GENERAL_LOGIN_URL; // Par défaut, afficher la page de connexion

// Routes
// Savoir sur quelle page on va en cas de POST ou GET
switch ($method) {
    case "POST":
        if (!empty($_POST)) {
            if (isset($_POST["post_create_account"])) $page = "post_create_user"; // basé sur l'input caché post_create_account
            if (isset($_POST['post_connect_account'])) $page = "attempt_connexion_user"; // input caché post_connect_account
        }
        break;

    case "GET":
        if (!empty($_GET["disconnect"]) && $_GET['disconnect'] == true) $page = "disconnect"; // déconnexion du compte user
        break;
}

// Pages
// Logique à appliquer selon la page
switch ($page) {
    case "login_page": // afficher toutes les listes
        if(isset($_SESSION['user_email']) && $_SESSION['user_email'] !== null) {
            $content = PROFILE_URL;
        } else {
            $content = GENERAL_LOGIN_URL;
        };
        break;

    case "post_create_user": // création de compte utilisateur
        $isRegistered = isRegistered($_POST['create_account_email']);

        if($isRegistered == true) { // si email déjà enregistré en base, message d'erreur
            $content = GENERAL_LOGIN_URL;
            $existingEmail = $_POST['create_account_email'];
            $attemptEmail = $_POST['create_account_email'];
        } else { // sinon log in le user
            createnewUser($_POST);
            $userInfos = getUserInfosFromEmail($_POST['create_account_email']);

            if($userInfos !== false) { // si user trouvé (création = success)
                $content = PROFILE_URL;
                $_SESSION['user_email'] = $userInfos['user_email'] ?? null;
                $_SESSION['user_id'] = $userInfos['user_id'] ?? null;
            } else { // si user pas trouvé (création échouée)
                $content = GENERAL_LOGIN_URL;
                $_SESSION['bannerMessage'] = 'ErrorCreationUser';
            };
        };
        break;
    
    case "attempt_connexion_user": // tentative de connexion à un compte utilisateur
        $isRegistered = isRegistered($_POST['connect_email']);
        if(!$isRegistered) { // l'email n'est pas en BDD
            $content = GENERAL_LOGIN_URL;
            $_SESSION['bannerMessage'] = 'UnkonwnEmailUser';
        } else { // l'email est en BDD
            $attemptSuccess = successfullConnexionUserAccount($_POST);
            if($attemptSuccess) { // mot de passe OK
                $content = PROFILE_URL;
                $user = getUserInfosFromEmail($_POST['connect_email']);
                $_SESSION['user_email'] = $user['user_email'];
                $_SESSION['user_id'] = $user['user_id'];
            } else { // mot de passe NOK
                $content = GENERAL_LOGIN_URL;
                $attemptEmail = $_POST['connect_email'];
                $statusPassword = false;
            }
        }
        break;

    case "disconnect": // deconnexion du compte user
        $content = GENERAL_LOGIN_URL;
        unset($_SESSION['user_email']);
        unset($_SESSION['user_id']);
        if($_SERVER["SERVER_PORT"] === "5000") {
            header("Location: " . "/users");
            exit;
        } else {
            header("Location: " . "/timecapsule/users");
            exit;
        };
        break;
}
