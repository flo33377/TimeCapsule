<?php // contenu du bloc de texte copiable pour partager son event quand web share API non disponible sur le device du user ?>

Salut 👋, j'ai créé un site pour partager nos souvenirs pour l'événement : <?= $event['event_name'] ?>.
Viens toi-aussi y déposer tes photos ! 📸
Le lien : <?= BASE_URL ?>?event=<?= $event["event_id"] ?>

<?php if(isset($event["event_password"]) && $event["event_password"] != null) : ?>
Voici le mot de passe pour y accéder : <?= $event["event_password"] ?>
<?php endif ?>