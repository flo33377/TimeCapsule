<?php

/* Fichier contenant les fonctions propres à la partie users du site (connexion, inscription, etc.) */

require '../vendor/autoload.php'; // connexion SDK
require '../config_brevo.php'; // connexion SDK
require '../src/content/emails_content/emails_content.php'; // contenu des emails à envoyer


function connect(): PDO { // connexion à la base de données
    $dbpath = __DIR__ . "/../../src/db/db_timecapsule.db";
    try {
        $mysqlClient = new PDO("sqlite:{$dbpath}");
    } catch (Exception $e) {
        echo 'Erreur : ' . $e->getMessage();
    }

    return $mysqlClient;
}


function isRegistered(string $email): bool { // renvoie true si email déjà utilisé en BDD
    $SQLGetExistingUser = 'SELECT 1 FROM timecapsule_users WHERE user_email = ? LIMIT 1';
    $getExistingUserStatement = connect()->prepare($SQLGetExistingUser);
    $getExistingUserStatement->execute([$email]);

    $userFound = $getExistingUserStatement->fetch();

    return $userFound !== false;
    // retourne true si userFound est diff de false (donc contient qlq chose)
    // sinon $userFound = false (car vide) donc false = false (pas diff) => donc renvoie false
}

function createnewUser(array $data) { // création d'un nouveau compte utilisateur
    $SQLCreateNewUser = "INSERT INTO timecapsule_users (user_email, user_password)
    VALUES (:user_email, :user_password)";
    $CreateNewUserStatement = connect()->prepare($SQLCreateNewUser);
    $CreateNewUserStatement->execute([
        'user_email' => $data['create_account_email'],
        'user_password' => $data['account_password']
    ]);
}

function getUserInfosFromEmail(string $email) { // return infos liées à l'user à partir de son email (en argument)
    $SQLGetUserInfos = 'SELECT * FROM timecapsule_users WHERE user_email = ?';
    $getUserInfosStatement = connect()->prepare($SQLGetUserInfos);
    $getUserInfosStatement->execute([$email]);

    return $getUserInfosStatement->fetch(PDO::FETCH_ASSOC);
    // Attention : si vide, le fetch renvoie false, pas null
    // PDO::FETCH_ASSOC permet de ne recevoir que les données, car sinon envoie les données
    // en doublon : 1 fois avec clé à indice (1, 2, etc.) et une fois avec les noms
    // des colonnes (user_email, user_password, etc.), allège tableau et empêche risque
    // d'erreur de boucle forEach par ex
}

function successfullConnexionUserAccount(array $data) : bool { // renvoie true seulement si compte en BDD et mdp OK
    // Argument = $_POST['connect_email'] (email saisi) + $_POST['connect_password'] (mot de passe saisi)
    $userAccountTargeted = getUserInfosFromEmail($data['connect_email']);
    if(!$userAccountTargeted) {
        return false; // si email introuvable en BDD
    } else {
        if($userAccountTargeted['user_password'] == $data['connect_password']) {
            return true; // si mdp conforme
        } else {
            return false; // si mauvais mdp saisi
        }
    }
}

function getEventsByUserId(int $id) : array { // return events dont l'utilisateur est propriétaire (argument : id du user)
    $SQLGetEventsByUser = 'SELECT * FROM timecapsule_list WHERE user_admin_id = ? LIMIT 5';
    $getEventsByUserStatement = connect()->prepare($SQLGetEventsByUser);
    $getEventsByUserStatement->execute([$id]);

    return $getEventsByUserStatement->fetchAll();
}


function generateAndSaveResetToken(string $email) : string { // génère et envoi en BDD token de reset de mot de passe + date d'expiration et retourne le token (argument : email du user)
    $token = bin2hex(random_bytes(32));
    $expire = date("Y-m-d H:i:s", strtotime('+1 hour'));

    $SQLSaveTokenInfos = "UPDATE timecapsule_users 
    SET reset_token = :reset_token, expiration_token = :expiration_token 
    WHERE user_email = :user_email";
    $saveTokenInfosStatement = connect()->prepare($SQLSaveTokenInfos);
    $saveTokenInfosStatement->execute([
        'reset_token' => $token,
        'expiration_token' => $expire,
        'user_email' => $email
    ]);

    return $token;
}


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendResetEmail($userEmail, $resetLink) {
    $mail = new PHPMailer(true);
    $contentEmail = returnHTMLEmailResetPassword($resetLink);
    
/* $mail->SMTPDebug = 2;
$mail->Debugoutput = 'html'; */

    try {
        // Paramètres serveur
        $mail->isSMTP();
        $mail->Host = 'smtp-relay.brevo.com';
        $mail->SMTPAuth = true;
        $mail->Username = BREVO_API_KEY_PUBLIC;
        $mail->Password = BREVO_API_KEY_PRIVATE;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Expéditeur et destinataire
        $mail->setFrom('contact@fneto-prod.fr', 'TimeCapsule');
        $mail->addAddress($userEmail); // Email du destinataire

        // Contenu
        $mail->isHTML(true);
        $mail->Subject = 'Réinitialisation de votre mot de passe';
        $mail->CharSet = 'UTF-8';
        $mail->Body    = $contentEmail;

        $mail->send();
        return true;
    } catch (Exception $e) {
        /* // Log ou debug ici si besoin
        echo "Erreur d'envoi du mail : " . $mail->ErrorInfo; */
        return false;
    }
}


function isTokenOk(array $data): string { // renvoie true si le token de pwd reset est ok et toujours valide, sinon renvoi raison du problème
    // argument = array contenant email_associated et token
    $SQLGetTokenFromUserEmail = 'SELECT reset_token, expiration_token FROM timecapsule_users WHERE user_email = ? LIMIT 1';
    $getTokenFromUserEmailStatement = connect()->prepare($SQLGetTokenFromUserEmail);
    $getTokenFromUserEmailStatement->execute([$data['email_associated']]);

    $userFound = $getTokenFromUserEmailStatement->fetch();

    $getTokenFromUserEmailStatement->closeCursor(); // Referme le PDO pour ne pas bloquer la fonction clearResetToken

    if (!$userFound) {
        return 'invalid'; // si le user n'existe pas
    }

    if ($data['token_associated'] !== $userFound['reset_token']) {
        return 'invalid'; // si le token ne correspond pas
    }

    $now = new DateTime();
    $expiration = new DateTime($userFound['expiration_token']);

    if ($now > $expiration) {
        clearResetToken($data['email_associated']); // token expiré => va nullifier le token
        return 'expired'; // si le token a expiré
    }

    // sinon renvoie true
    return 'valid';
}


function clearResetToken(string $email): void { // nullifie le token de reset de pwd et sa date d'expiration (argument : email du compte user)
    $SQL = 'UPDATE timecapsule_users 
            SET reset_token = NULL, expiration_token = NULL 
            WHERE user_email = :email';

    $stmt = connect()->prepare($SQL);
    $stmt->execute(['email' => $email]);
}


function changePasswordFromEmail(array $data) { // changement de mot de passe utilisé + nullifie le token
    // argument = array contenant new_pwd_email et email_associated
    $SQL = "UPDATE timecapsule_users 
    SET user_password = :user_password, reset_token = NULL, expiration_token = NULL 
    WHERE user_email = :user_email";
    $Statement = connect()->prepare($SQL);
    $Statement->execute([
        'user_password' => $data['new_pwd_email'],
        'user_email' => $data['email_associated']
    ]);
}

