<?php 
// Template des pages de la partie users
// Liaisons fichiers externes + param pages
// + header + système de notification
// contenu généré depuis $content
?>

<?php include_once(__DIR__ . "/src/users-main.php") ?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" href="./../public/css/design-system.css">
  <link rel="stylesheet" href="./../public/css/custom-pages.css">
  <link rel="stylesheet" href="./../public/css/users.css">

  <script src="./../public/js/account_functions.js" defer></script>
  <script src="./../public/js/event_functions.js" defer></script>
  <script src="./../public/js/notifications.js" defer></script>

  <link rel="apple-touch-icon" sizes="180x180" href="https://fneto-prod.fr/timecapsule/img/favicon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="https://fneto-prod.fr/timecapsule/img/favicon.png">
  <link rel="icon" type="image/png" sizes="16x16" href="https://fneto-prod.fr/timecapsule/img/favicon.png">

  <title>Time Capsule</title>
</head>

<body>
    <header>
      <a href='<?= BASE_URL ?>'>
        <img src='https://fneto-prod.fr/timecapsule/img/timecapsule-logo.png' alt='logo Time Capsule'>
      </a>
    </header>

  <main id='content'>

  <!-- Content -->
    <?php include($content) ?>

  <!-- Notification system -->
    <?php include_once(__DIR__ . "/../src/content/notifications/notifications.php") ?>

  </main>

</body>

</html>