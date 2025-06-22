<?php

/* Fichier qui le changement de contenu de la page et les actions de l'utilisateur */

session_start();


/* ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
*/

include_once(__DIR__ . "/users-mainFunctions.php"); 
// fichier avec les fonctions

// Constantes
    // base_url = lien vers la HP basé sur le serveur utilisé 
define("BASE_URL", ($_SERVER["SERVER_PORT"] === "5000") ? "http://localhost:5000/" : "https://www.fneto-prod.fr/timecapsule/");

    // general login url = page de connexion/inscription
define("GENERAL_LOGIN_URL", __DIR__ . "/../../src/content/users-content/login.php");

    // profile url = p. profil de l'utilisateur connecté
define("PROFILE_URL", __DIR__ . "/../../src/content/users-content/user-profile.php");


// Variables de pages
$method = $_SERVER['REQUEST_METHOD'];
    // set des param par défaut
$page = "display_login_page"; // Valeur par défaut
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
    case "display_login_page": // selon si co ou pas, affiche p. profil ou formulaires
        if(isset($_SESSION['user_email']) && $_SESSION['user_email'] !== null) {
            // si connecté, affiche la page user
            $content = PROFILE_URL;
            $lists = getEventsByUserId($_SESSION['user_id']) ?? null;
        } else {
            // sinon, affiche les form de connexion/inscription
            $content = GENERAL_LOGIN_URL;
        };
        break;

    case "post_create_user": // création de compte utilisateur
        // va checker si email déjà en BDD
        $isRegistered = isRegistered($_POST['create_account_email']);

        if($isRegistered == true) { // si email déjà enregistré en base, message d'erreur
            $content = GENERAL_LOGIN_URL;
            $existingEmail = $_POST['create_account_email'];
            $attemptEmail = $_POST['create_account_email'];
        } else { // sinon créé le compte et log in le user
            createnewUser($_POST);
            $userInfos = getUserInfosFromEmail($_POST['create_account_email']);

            if($userInfos !== false) { // si user trouvé (création = success)
                $content = PROFILE_URL;
                $_SESSION['user_email'] = $userInfos['user_email'] ?? null;
                $_SESSION['user_id'] = $userInfos['user_id'] ?? null;
                $_SESSION['nbr_events'] = 0;
                if($_SERVER["SERVER_PORT"] === "5000") {
                    header("Location: " . "/users");
                    exit;
                } else {
                    header("Location: " . "/timecapsule/users");
                    exit;
                };
            } else { // si user pas trouvé (création échouée)
                $content = GENERAL_LOGIN_URL;
                $_SESSION['bannerMessage'] = 'ErrorCreationUser';
            };
        };
        break;
    
    case "attempt_connexion_user": // tentative de connexion à un compte utilisateur
        // va checker si email bien enregistré en base
        $isRegistered = isRegistered($_POST['connect_email']);
        if(!$isRegistered) { // l'email n'est pas en BDD => message d'erreur
            $content = GENERAL_LOGIN_URL;
            $_SESSION['bannerMessage'] = 'UnkonwnEmailUser';
        } else { // l'email est en BDD
            // va vérifier correspondance entre mdp associé en BDD et celui entré
            $attemptSuccess = successfullConnexionUserAccount($_POST);
            if($attemptSuccess) { // si le mot de passe est le bon => log in le user
                $content = PROFILE_URL;
                $user = getUserInfosFromEmail($_POST['connect_email']);
                $_SESSION['user_email'] = $user['user_email'];
                $_SESSION['user_id'] = $user['user_id'];
                $eventsAssociated = getEventsByUserId($_SESSION['user_id']) ?? null;
                $_SESSION['nbr_events'] = count($eventsAssociated);
                if($_SERVER["SERVER_PORT"] === "5000") {
                    header("Location: " . "/users");
                    exit;
                } else {
                    header("Location: " . "/timecapsule/users");
                    exit;
                };
            } else { // Si le mdp n'est pas le bon => message d'erreur
                $content = GENERAL_LOGIN_URL;
                $attemptEmail = $_POST['connect_email'];
                $statusPassword = false;
            }
        }
        break;

    case "disconnect": // deconnexion du compte user
        $content = GENERAL_LOGIN_URL;
        // suppr les valeurs de session
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
