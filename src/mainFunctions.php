<?php

function connect(): PDO
{
    $dbpath = __DIR__ . "/db/db_timecapsule.db";
    try {
        $mysqlClient = new PDO("sqlite:{$dbpath}");
    } catch (Exception $e) {
        echo 'Erreur : ' . $e->getMessage();
    }

    return $mysqlClient;
}


function createNewEvent(array $data): bool
{

    $TransferPathLogo = __DIR__ . '/content/logo_events/';
    if ($_SERVER["SERVER_PORT"] === "5000") { // vaut true si en local
        $publicPath = __DIR__ . '/content/logo_events/';
    } else {
        $publicPath = 'https://fneto-prod.fr/timecapsule/src/content/logo_events/';
    };

    $urlLogo = '';

    if ($_SERVER["REQUEST_METHOD"] === "POST" && $_FILES["new_event_logo"]["tmp_name"] !== "") {
        // vérifier si ce bout de code fonctionne (ne peut marcher qu'avec BDD prod) 
        // --> remplace les caractères spéciaux pour ne pas créer de conflit de génération d'URL (cas de Chloë)
        $searchEncodedCharacters  = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'à', 'á', 'â', 'ã', 'ä', 'å', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ð', 'ò', 'ó', 'ô', 'õ', 'ö', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ');
        $replaceEncodedCharacters = array('A', 'A', 'A', 'A', 'A', 'A', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 'a', 'a', 'a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y');
        $eventNameEncoded = str_replace($searchEncodedCharacters, $replaceEncodedCharacters, $_POST['new_event_title']);
        // fin du bout de code à tester
        $depositoryUrlLogo = $TransferPathLogo . date("F-j-Y_H-i-s") . $eventNameEncoded . "." . strtolower(pathinfo($_FILES['new_event_logo']['name'], PATHINFO_EXTENSION));
        move_uploaded_file($_FILES['new_event_logo']['tmp_name'], $depositoryUrlLogo);

        $urlLogo = $publicPath . date("F-j-Y_H-i-s") . $eventNameEncoded . "." . strtolower(pathinfo($_FILES['new_event_logo']['name'], PATHINFO_EXTENSION));
    }

    $mysqlClient = connect();
 
    // SQL request and send
    $SQLCreateNewEvent = "INSERT INTO timecapsule_list 
    (event_name, event_password, creation_date, event_logo, main_color, secondary_color, 
    font_color)
    VALUES (:event_name, :event_password, :creation_date, :event_logo, :main_color, 
    :secondary_color, :font_color)";
    $CreateNewEventStatement = $mysqlClient->prepare($SQLCreateNewEvent);
    $CreateNewEventStatement->execute([
        'event_name' => $data['new_event_title'],
        'event_password' => $data['new_event_password'] ?? null,
        'creation_date' => date('d/m/Y'),
        'event_logo' => $urlLogo,
        'main_color' => $data['main_color'],
        'secondary_color' => $data['secondary_color'],
        'font_color' => $data['font_color']
    ]);

    return true;
}


function getAllEvents(): array
{
    // Get existing lists to display it on HP
    $SQLGetAllEvents = 'SELECT * FROM timecapsule_list';
    $getAllEventsStatement = connect()->prepare($SQLGetAllEvents);
    $getAllEventsStatement->execute();

    return $getAllEventsStatement->fetchAll();
}


function getEventById(float $id)
{
    $SQLGetEventInfos = 'SELECT * FROM timecapsule_list WHERE event_id = ?';
    $checkPasswordStatement = connect()->prepare($SQLGetEventInfos);
    $checkPasswordStatement->execute([$id]);

    return $checkPasswordStatement->fetch();
}

function deleteEvent(float $id)
{
    $SQLDeleteEvent = 'DELETE FROM timecapsule_list WHERE list_id = ?';
    $deleteEventStatement = connect()->prepare($SQLDeleteEvent);
    $deleteEventStatement->execute([$id]);
}

function changeNameEvent(int $id, string $newName)
{
    $SQLChangeNameEvent = 'UPDATE timecapsule_list SET list_name = ? WHERE list_id = ?';
    $changeNameEventStatement = connect()->prepare($SQLChangeNameEvent);
    $changeNameEventStatement->execute([$newName, $id]);
}

function getMemoriesByEventId(int $id): array
{
    $SQLGetMemoriesById = 'SELECT * FROM timecapsule_memories WHERE event_id = ?';
    $getMemoriesStatement = connect()->prepare($SQLGetMemoriesById);
    $getMemoriesStatement->execute([$id]);

    return $getMemoriesStatement->fetchAll();
}

/* TEMPORAIREMENT EN COMM CAR VA BCP CHANGER */

/*
function createNewObjective(array $data): bool
{
    $mysqlClient = connect();

    // get the max score based on the periodicity + number field
    switch($_POST['periodicity']){
        case 'unique':
            $maxScore = 1;
            break;
        case 'several':
            $maxScore = $_POST['new_objective_number'] ?? NULL;
            break;
        case 'infinite':
            $maxScore = 99;
            break;
    }

    // SQL request and send
    $SQLSendNewObjective = "INSERT INTO successfactory_obj (obj_list_id, obj_list_name, 
        obj_name, periodicity_obj, current_score_obj, max_score_obj, tag_obj)
        VALUES (:obj_list_id, :obj_list_name, :obj_name, :periodicity_obj, 
        :current_score_obj, :max_score_obj, :tag_obj)";
    $SendNewObjStatement = $mysqlClient->prepare($SQLSendNewObjective);
    $SendNewObjStatement->execute([
        'obj_list_id' => $_SESSION['list_id'],
        'obj_list_name' => $_GET['list'],
        'obj_name' => $_POST['new_obj_title'],
        'periodicity_obj' => $_POST['periodicity'],
        'current_score_obj' => 0,
        'max_score_obj' => $maxScore,
        'tag_obj' => $_POST['new_obj_tag']
    ]);

    return true;
}

*/

// Ajouter un système de like par session id ?

