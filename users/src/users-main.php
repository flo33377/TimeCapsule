<?php

/* Fichier qui le changement de contenu de la page et les actions de l'utilisateur */

session_start();
require __DIR__ . '/../../vendor/autoload.php';


/* ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL); */


include_once(__DIR__ . "/users-mainFunctions.php"); 
// fichier avec les fonctions

// Constantes
    // base_url = lien vers la HP basé sur le serveur utilisé 
define("BASE_URL", ($_SERVER["SERVER_PORT"] === "5000") ? "http://localhost:5000/" : "https://www.fneto-prod.fr/timecapsule/");

    // general login url = page de connexion/inscription
define("GENERAL_LOGIN_URL", __DIR__ . "/../../src/content/users-content/login.php");

    // reset pwd start = formulaire de réinitialisation de mot de passe
define("RESET_PWD_START", __DIR__ . "/../../src/content/users-content/pwd_reset_start.php");

    // reset pwd sent = formulaire de réinitialisation de mot de passe
define("RESET_PWD_SENT", __DIR__ . "/../../src/content/users-content/pwd_reset_sent.php");

    // profile url = p. profil de l'utilisateur connecté
define("PROFILE_URL", __DIR__ . "/../../src/content/users-content/user-profile.php");

    // reset pwd form = formulaire de reset de pwd accessible depuis l'email avec le lien
define("RESET_PWD_FORM", __DIR__ . "/../../src/content/users-content/pwd_change_form.php");


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
            if (isset($_POST['post_pwd_reset'])) $page = "post_pwd_reset_start"; // input caché post_pwd_reset
            if (isset($_POST['post_pwd_reset_email'])) $page = "post_pwd_reset_email"; // input caché post_pwd_reset_email
        }
        break;

    case "GET":
        if (!empty($_GET["disconnect"]) && $_GET['disconnect'] == true) $page = "disconnect"; // déconnexion du compte user
        if (!empty($_GET['password_reset']) && $_GET['password_reset'] == true && (!isset($_GET['email']))) $page = "go_form_pwd_reset"; // renvoi mdp par email
        if (!empty($_GET['pwd_reset_email']) && !empty($_GET['token'])) $page = "form_new_pwd";
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
        /* session_unset(); */
        if($_SERVER["SERVER_PORT"] === "5000") {
            header("Location: " . "/users");
            exit;
        } else {
            header("Location: " . "/timecapsule/users");
            exit;
        };
        break;

    case "go_form_pwd_reset" : // affichage du form password reset
        $content = RESET_PWD_START;
        break;
    
    case "post_pwd_reset_start" : // demande d'envoi de lien reset mdp par email
        $isRegistered = isRegistered($_POST['reset_pwd_email']);
        if (filter_var($_POST['reset_pwd_email'], FILTER_VALIDATE_EMAIL) && $isRegistered) { // la donnée saisie est bien un email et il est en BDD
            $token = generateAndSaveResetToken($_POST['reset_pwd_email']);
            $email = $_POST['reset_pwd_email'];
            if($_SERVER["SERVER_PORT"] === "5000") {
                $link = 'http://localhost:5000/users/?pwd_reset_email=' . $_POST['reset_pwd_email'] . '&token=' . $token;
            } else {
                $link = 'https://fneto-prod.fr/timecapsule/users/?pwd_reset_email=' . $_POST['reset_pwd_email'] . '&token=' . $token;
            }

            if (sendResetEmail($email, $link)) {
                /* echo "E-mail envoyé !"; // débug */
            } else {
                /* echo "Échec de l envoi."; // débug */
            }
        };
        $content = RESET_PWD_SENT;

        break;

    case "form_new_pwd" : // affiche le form pour changer son mot de passe
        $content = RESET_PWD_FORM;
        $email = $_GET['pwd_reset_email'];
        break;

    case "post_pwd_reset_email" : // form envoyé pour changer le mdp depuis lien email
        $content = GENERAL_LOGIN_URL;
        if(empty($_POST['token_associated'])) { // si le token est vide ou null
            $_SESSION['bannerMessage'] = 'ErrorTokenResetPassword';
        } else {
            $tokenStatus = isTokenOk($_POST);
            if($tokenStatus == 'invalid') {
                $_SESSION['bannerMessage'] = 'ErrorTokenResetPassword';
            } elseif($tokenStatus == 'expired') {
                $_SESSION['bannerMessage'] = 'ExpiredTokenResetPassword';
            } elseif($tokenStatus == 'valid') {
                changePasswordFromEmail($_POST);
                $_SESSION['bannerMessage'] = 'ResetPasswordSuccess';
            }
        }
        // checker avant fonction que token n'est pas égal à null ou vide
        break;
}
