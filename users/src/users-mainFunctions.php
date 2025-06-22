<?php

/* Fichier contenant les fonctions propres à la partie users du site (connexion, inscription, etc.) */


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
        'user_password' => $data['create_account_password']
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


