<?php

function connect(): PDO
{
    $dbpath = __DIR__ . "/db/dev_db_timecapsule.db";
    try {
        $mysqlClient = new PDO("sqlite:{$dbpath}");
    } catch (Exception $e) {
        echo 'Erreur : ' . $e->getMessage();
    }

    return $mysqlClient;
}


function createNewList(array $data): bool
{
    $mysqlClient = connect();

    // récup date + calcul prochaines périodes + set password si absent
    $currentDateTS = strtotime(date('d/m/Y'));
    if ($data['periodicity'] == 'weekly') {
        $nextResetTS0 = strtotime('next Monday');
        $nextResetTS1 = strtotime('+7 days', $nextResetTS0);
        $nextResetTS2 = strtotime('+7 days', $nextResetTS1);
        $nextResetTS3 = strtotime('+7 days', $nextResetTS2);
        $nextResetTS4 = strtotime('+7 days', $nextResetTS3);
        $nextResetTS5 = strtotime('+7 days', $nextResetTS4);
    } else {
        $nextResetTS0 = strtotime('first day of next month');
        $nextResetTS1 = strtotime('first day of next month', $nextResetTS0);
        $nextResetTS2 = strtotime('first day of next month', $nextResetTS1);
        $nextResetTS3 = strtotime('first day of next month', $nextResetTS2);
        $nextResetTS4 = strtotime('first day of next month', $nextResetTS3);
        $nextResetTS5 = strtotime('first day of next month', $nextResetTS4);
    }
 
    // SQL request and send
    $SQLSendNewList = "INSERT INTO successfactory_list (list_name, list_password, periodicity, creation_date, 
        next_reset_period0, 'next_reset_period1', 'next_reset_period2', 'next_reset_period3', 'next_reset_period4', 
        'next_reset_period5', current_score)
            VALUES (:list_name, :list_password, :periodicity, :creation_date, 
        :next_reset_period0, :next_reset_period1, :next_reset_period2, :next_reset_period3, :next_reset_period4, 
        :next_reset_period5, :current_score)";
    $SendNewListStatement = $mysqlClient->prepare($SQLSendNewList);
    $SendNewListStatement->execute([
        'list_name' => $data['new_list_title'],
        'list_password' => $data['new_list_password'] ?? null,
        'periodicity' => $data['periodicity'],
        'creation_date' => date('d/m/Y'),
        'next_reset_period0' => $nextResetTS0,
        'next_reset_period1' => $nextResetTS1,
        'next_reset_period2' => $nextResetTS2,
        'next_reset_period3' => $nextResetTS3,
        'next_reset_period4' => $nextResetTS4,
        'next_reset_period5' => $nextResetTS5,
        'current_score' => 0
    ]);

    return true;
}

function getAllLists(): array
{
    // Get existing lists to display it on HP
    $SQLGetAllLists = 'SELECT * FROM timecapsule_list';
    $allListsStatement = connect()->prepare($SQLGetAllLists);
    $allListsStatement->execute();

    return $allListsStatement->fetchAll();
}

function getListByName(string $name)
{
    $SQLGetListInfos = 'SELECT * FROM successfactory_list WHERE list_name = ?';
    $checkPasswordStatement = connect()->prepare($SQLGetListInfos);
    $checkPasswordStatement->execute([$name]);

    return $checkPasswordStatement->fetch();
}

function deleteList(float $id)
{
    $SQLDeleteList = 'DELETE FROM successfactory_list WHERE list_id = ?';
    $deleteListStatement = connect()->prepare($SQLDeleteList);
    $deleteListStatement->execute([$id]);
}

function changeNameList(int $id, string $newName)
{
    $SQLChangeNameList = 'UPDATE successfactory_list SET list_name = ? WHERE list_id = ?';
    $changeNameListStatement = connect()->prepare($SQLChangeNameList);
    $changeNameListStatement->execute([$newName, $id]);
}

function getObjectivesByListId(int $id): array
{
    $SQLGetObjectivesById = 'SELECT * FROM successfactory_obj WHERE obj_list_id = ?';
    $getObjectivesStatement = connect()->prepare($SQLGetObjectivesById);
    $getObjectivesStatement->execute([$id]);

    return $getObjectivesStatement->fetchAll();
}


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
        obj_name, periodicity_obj,/* next_reset_obj,*/ current_score_obj, max_score_obj, tag_obj)
        VALUES (:obj_list_id, :obj_list_name, :obj_name, :periodicity_obj,/*:next_reset_obj,*/ 
        :current_score_obj, :max_score_obj, :tag_obj)";
    $SendNewObjStatement = $mysqlClient->prepare($SQLSendNewObjective);
    $SendNewObjStatement->execute([
        'obj_list_id' => $_SESSION['list_id'],
        'obj_list_name' => $_GET['list'],
        'obj_name' => $_POST['new_obj_title'],
        'periodicity_obj' => $_POST['periodicity'],
        // 'next_reset_obj' => NULL,
        'current_score_obj' => 0,
        'max_score_obj' => $maxScore,
        'tag_obj' => $_POST['new_obj_tag']
    ]);

    return true;
}

// Ajouter un système de like par session id ?

