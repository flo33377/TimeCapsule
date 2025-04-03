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
        'event_logo' => $data['new_event_logo'], // ATTENTION : Need de le passer en URL et de le save
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


function getEventByName(string $name)
{
    $SQLGetEventInfos = 'SELECT * FROM timecapsule_list WHERE list_name = ?';
    $checkPasswordStatement = connect()->prepare($SQLGetEventInfos);
    $checkPasswordStatement->execute([$name]);

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
    $SQLGetMemoriesById = 'SELECT * FROM successfactory_obj WHERE obj_list_id = ?';
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

