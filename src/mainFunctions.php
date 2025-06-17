<?php



function connect(): PDO {
    $dbpath = __DIR__ . "/db/db_timecapsule.db";
    try {
        $mysqlClient = new PDO("sqlite:{$dbpath}");
    } catch (Exception $e) {
        echo 'Erreur : ' . $e->getMessage();
    }

    return $mysqlClient;
}


function createNewEvent(array $data): bool {

    $TransferPathLogo = __DIR__ . '/content/logo_events/';
    if ($_SERVER["SERVER_PORT"] === "5000") { // vaut true si en local
        $publicPath = __DIR__ . '/content/logo_events/';
    } else {
        $publicPath = 'https://fneto-prod.fr/timecapsule-admin/src/content/logo_events/';
    };

    $urlLogo = '';

    if ($_FILES["new_event_logo"]["tmp_name"] !== "") {
        // vérifier si ce bout de code fonctionne (ne peut marcher qu'avec BDD prod) 
        // --> remplace les caractères spéciaux pour ne pas créer de conflit de génération d'URL (cas de Chloë)
        $searchEncodedCharacters  = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'à', 'á', 'â', 'ã', 'ä', 'å', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ð', 'ò', 'ó', 'ô', 'õ', 'ö', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', "'", '"');
        $replaceEncodedCharacters = array('A', 'A', 'A', 'A', 'A', 'A', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 'a', 'a', 'a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', '', '');
        $eventNameEncoded = str_replace($searchEncodedCharacters, $replaceEncodedCharacters, $_POST['new_event_title']);
        // fin du bout de code à tester
        $depositoryUrlLogo = $TransferPathLogo . date("F-j-Y_H-i-s") . $eventNameEncoded . "." . strtolower(pathinfo($_FILES['new_event_logo']['name'], PATHINFO_EXTENSION));
        move_uploaded_file($_FILES['new_event_logo']['tmp_name'], $depositoryUrlLogo);

        $urlLogo = $publicPath . date("F-j-Y_H-i-s") . $eventNameEncoded . "." . strtolower(pathinfo($_FILES['new_event_logo']['name'], PATHINFO_EXTENSION));
    } else {
        $urlLogo = "https://fneto-prod.fr/timecapsule/img/timecapsule-logo.png";
    }

    $mysqlClient = connect();
 
    // SQL request and send
    $SQLCreateNewEvent = "INSERT INTO timecapsule_list 
    (event_name, event_password, creation_date, event_logo, main_color, secondary_color, 
    font_color, user_admin_id)
    VALUES (:event_name, :event_password, :creation_date, :event_logo, :main_color, 
    :secondary_color, :font_color, :user_admin_id)";
    $CreateNewEventStatement = $mysqlClient->prepare($SQLCreateNewEvent);
    $CreateNewEventStatement->execute([
        'event_name' => $data['new_event_title'],
        'event_password' => $data['new_event_password'] ?? null,
        'creation_date' => date('d/m/Y'),
        'event_logo' => $urlLogo,
        'main_color' => $data['main_color'],
        'secondary_color' => $data['secondary_color'],
        'font_color' => $data['font_color'],
        'user_admin_id' => $data['user_id']
    ]);

    return true;
}


function getAllEvents(): array {
    // Get existing lists to display it on HP
    $SQLGetAllEvents = 'SELECT event_id, event_name, event_logo, main_color, secondary_color, font_color FROM timecapsule_list';
    $getAllEventsStatement = connect()->prepare($SQLGetAllEvents);
    $getAllEventsStatement->execute();

    return $getAllEventsStatement->fetchAll();
}


function getEventById(int $id) {
    $SQLGetEventInfos = 'SELECT * FROM timecapsule_list WHERE event_id = ?';
    $checkPasswordStatement = connect()->prepare($SQLGetEventInfos);
    $checkPasswordStatement->execute([$id]);

    return $checkPasswordStatement->fetch();
}

function deleteEvent(int $id): void {
    $pdo = connect();

    try {
        // Démarre une transaction (plusieurs opérations), 
        //permet de ne pas enregistrer les modifications tant qu'on a pas fait commit()
        $pdo->beginTransaction();

        // 1. Récupérer les souvenirs liés à cet event
        $SQLSelectMemories = 'SELECT url_photo FROM timecapsule_memories WHERE event_id = ?';
        $selectMemoriesStmt = $pdo->prepare($SQLSelectMemories);
        $selectMemoriesStmt->execute([$id]);
        $memories = $selectMemoriesStmt->fetchAll(PDO::FETCH_ASSOC);

        // 2. Supprimer les souvenirs de la base
        $SQLDeleteMemories = 'DELETE FROM timecapsule_memories WHERE event_id = ?';
        $deleteMemoriesStmt = $pdo->prepare($SQLDeleteMemories);
        $deleteMemoriesStmt->execute([$id]);

        // 3. Supprimer l'event
        $SQLDeleteEvent = 'DELETE FROM timecapsule_list WHERE event_id = ?';
        $deleteEventStmt = $pdo->prepare($SQLDeleteEvent);
        $deleteEventStmt->execute([$id]);

        // 4. Envoie l'ensemble des modifs et les sauvegardes si pas de retour d'erreur jusqu'ici
        $pdo->commit();

        
        // Prend le bon path selon local ou non
        if ($_SERVER["SERVER_PORT"] === "5000") { // vaut true si en local
            $pathPrefix = __DIR__ . '/content/memory_img/';
        } else {
            // En prod, on reconstitue le chemin absolu sur le serveur
            $baseUrl = 'https://fneto-prod.fr/timecapsule-admin/'; //racine url publique
            $serverRoot = '/home/fnetopm/www/timecapsule-admin/';
        }

        // 5. Supprimer les fichiers liés (en dehors de la transaction)
        foreach ($memories as $memory) {
            $url = $memory['url_photo']; // url complète avec racine
            if ($_SERVER["SERVER_PORT"] === "5000") {
                // En local : on utilise directement le nom du fichier
                $filename = basename($url);
                $filePath = $pathPrefix . $filename; //
            } else {
                // En prod : on transforme l'URL publique en chemin serveur
                $relativePath = str_replace($baseUrl, '', $url); // Ex: src/content/memory_img/photo.jpg
                $filePath = $serverRoot . $relativePath;         // Ex: /home/fnetopm/www/timecapsule/src/content/memory_img/photo.jpg
            }

            if (file_exists($filePath)) { // si fichier existe bien
                unlink($filePath); // supprime le fichier
            }
        }
    } catch (Exception $e) {
        $pdo->rollBack(); // annule les modifs s'il y a un retour d'erreur
    }
}

function changeNameEvent(int $id, string $newName) {
    $SQLChangeNameEvent = 'UPDATE timecapsule_list SET event_name = ? WHERE event_id = ?';
    $changeNameEventStatement = connect()->prepare($SQLChangeNameEvent);
    $changeNameEventStatement->execute([$newName, $id]);
}

function changeLogoOrColorsEvent(int $id, array $data) {
    if($_FILES["new_event_logo"]["tmp_name"] !== "") { // only if a new logo was uploaded
        $TransferPathMemory = __DIR__ . '/content/logo_events/';
        if ($_SERVER["SERVER_PORT"] === "5000") { // vaut true si en local
            $publicPath = __DIR__ . '/content/logo_events/';
        } else {
            $publicPath = 'https://fneto-prod.fr/timecapsule-admin/src/content/memory_img/';
        };

        $urlMemory = '';

        $searchEncodedCharacters  = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'à', 'á', 'â', 'ã', 'ä', 'å', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ð', 'ò', 'ó', 'ô', 'õ', 'ö', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ');
        $replaceEncodedCharacters = array('A', 'A', 'A', 'A', 'A', 'A', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 'a', 'a', 'a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y');
        $memoryNameEncoded = str_replace($searchEncodedCharacters, $replaceEncodedCharacters, $data['post_event_name']);
        
        $depositoryUrlMemory = $TransferPathMemory . date("F-j-Y_H-i-s") . $memoryNameEncoded . "." . strtolower(pathinfo($_FILES['new_event_logo']['name'], PATHINFO_EXTENSION));
        move_uploaded_file($_FILES['new_event_logo']['tmp_name'], $depositoryUrlMemory);

        $urlMemory = $publicPath . date("F-j-Y_H-i-s") . $memoryNameEncoded . "." . strtolower(pathinfo($_FILES['new_event_logo']['name'], PATHINFO_EXTENSION));

        $SQLChangeLogoAndColorsEvent = 'UPDATE timecapsule_list SET event_logo = ?, main_color = ?, 
        secondary_color = ?, font_color = ? WHERE event_id = ?';
        $changeLogoColorsEventStatement = connect()->prepare($SQLChangeLogoAndColorsEvent);
        $changeLogoColorsEventStatement->execute([$urlMemory, $_POST['main_color'], $_POST['secondary_color'], $_POST['font_color'], $id]);

        return true;
    } else {
        $SQLChangeOnlyColorsEvent = 'UPDATE timecapsule_list SET main_color = ?, 
        secondary_color = ?, font_color = ? WHERE event_id = ?';
        $changeOnlyColorsEventStatement = connect()->prepare($SQLChangeOnlyColorsEvent);
        $changeOnlyColorsEventStatement->execute([$_POST['main_color'], $_POST['secondary_color'], $_POST['font_color'], $id]);
    }
}

function getMemoriesByEventId(int $id): array {
    $SQLGetMemoriesById = 'SELECT * FROM timecapsule_memories WHERE event_id = ? ORDER BY memory_date DESC';
    $getMemoriesStatement = connect()->prepare($SQLGetMemoriesById);
    $getMemoriesStatement->execute([$id]);

    return $getMemoriesStatement->fetchAll();
}


function createNewMemory(array $data): bool {
    $mysqlClient = connect();

    // part about file naming and stocking
    $TransferPathMemory = __DIR__ . '/content/memory_img/';
    if ($_SERVER["SERVER_PORT"] === "5000") { // vaut true si en local
        $publicPath = __DIR__ . '/content/memory_img/';
    } else {
        $publicPath = 'https://fneto-prod.fr/timecapsule-admin/src/content/memory_img/';
    };

    $urlMemory = '';

    if ($_FILES["photo_memory"]["tmp_name"] !== "") {
        // --> remplace les caractères spéciaux pour ne pas créer de conflit de génération d'URL (cas de Chloë)
        $searchEncodedCharacters  = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'à', 'á', 'â', 'ã', 'ä', 'å', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ð', 'ò', 'ó', 'ô', 'õ', 'ö', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', "'", '"');
        $replaceEncodedCharacters = array('A', 'A', 'A', 'A', 'A', 'A', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 'a', 'a', 'a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', '', '');
        $memoryNameEncoded = str_replace($searchEncodedCharacters, $replaceEncodedCharacters, $_POST['title']);
        
        $depositoryUrlMemory = $TransferPathMemory . date("F-j-Y_H-i-s") . $memoryNameEncoded . "." . strtolower(pathinfo($_FILES['photo_memory']['name'], PATHINFO_EXTENSION));
        move_uploaded_file($_FILES['photo_memory']['tmp_name'], $depositoryUrlMemory);

        $urlMemory = $publicPath . date("F-j-Y_H-i-s") . $memoryNameEncoded . "." . strtolower(pathinfo($_FILES['photo_memory']['name'], PATHINFO_EXTENSION));
    } else {
        $urlMemory = null;
    }
    

    // Part to select color or patern
    $decoration = '';
    if($data['backg_value'] == 'color') {
        $decoration = $data['color_memory'];
    } else {
        $decoration = $data['patern_memory'];
    }

    // SQL request and send
    $SQLSendNewMemory = "INSERT INTO timecapsule_memories (event_id, memory_text, 
        url_photo, memory_decoration, memory_text_color, memory_backg_font, 
        memory_additional_deco, memory_author, memory_date, memory_likes_count)
        VALUES (:event_id, :memory_text, :url_photo, :memory_decoration, 
        :memory_text_color, :memory_backg_font, :memory_additional_deco, 
        :memory_author, :memory_date, :memory_likes_count)";
    $sendNewMemoryStatement = $mysqlClient->prepare($SQLSendNewMemory);
    $sendNewMemoryStatement->execute([
        'event_id' => $data['event_id'],
        'memory_text' => $data['title'],
        'url_photo' => $urlMemory,
        'memory_decoration' => $decoration,
        'memory_text_color' => $data['text_memory_color'],
        'memory_backg_font' => $data['backg_font_memory'],
        'memory_additional_deco' => $data['decoration_memory'],
        'memory_author' => $data['author'],
        'memory_date' => $data['memory_date'],
        'memory_likes_count' => '0'
    ]);

    return true;
}

function likesMemory(array $data): bool {

    $SQLIncreaseNbrLikes = "UPDATE timecapsule_memories 
    SET memory_likes_count = :memory_likes_count WHERE memory_id = :memory_id";
    $SendIncreaseLikesNbr = connect()->prepare($SQLIncreaseNbrLikes);
    $SendIncreaseLikesNbr->execute([
        'memory_likes_count' => $data['newNbrOfLikes'],
        'memory_id' => $data['memoryId']
    ]);

    return true;
}

