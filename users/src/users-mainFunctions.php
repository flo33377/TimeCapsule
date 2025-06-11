<?php



function connect(): PDO {
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

function createnewUser(array $data) {
    $SQLCreateNewUser = "INSERT INTO timecapsule_users (user_email, user_password)
    VALUES (:user_email, :user_password)";
    $CreateNewUserStatement = connect()->prepare($SQLCreateNewUser);
    $CreateNewUserStatement->execute([
        'user_email' => $data['create_account_email'],
        'user_password' => $data['create_account_password']
    ]);
}

function getUserInfosFromEmail(string $email) {
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

function changeNameEvent(int $id, string $newName) {
    $SQLChangeNameEvent = 'UPDATE timecapsule_list SET event_name = ? WHERE event_id = ?';
    $changeNameEventStatement = connect()->prepare($SQLChangeNameEvent);
    $changeNameEventStatement->execute([$newName, $id]);
}

