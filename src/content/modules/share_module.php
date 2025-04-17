Salut 👋, j'ai créé un site pour partager nos souvenirs pour l'événement : <?= $event['event_name'] ?>.
Viens toi-aussi y déposer tes photos ! 📸
Le lien : https://timecapsule.fr/?event=<?= $event["event_id"] ?>

<?php if(isset($event["event_password"])) : ?>
Voici le mot de passe pour y accéder : <?= $event["event_password"] ?>
<?php endif ?>