<?php include_once(__DIR__ . "/src/main.php") ?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" href="./public/css/design-system.css">
  <link rel="stylesheet" href="./public/css/custom-pages.css">

  <script src="./public/js/event_functions.js" defer></script>
  <script src="./public/js/memories_functions.js" defer></script>
  <script src="./public/js/modales.js" defer></script>
  <script src="./public/js/notifications.js" defer></script>

  <link rel="apple-touch-icon" sizes="180x180" href="https://fneto-prod.fr/timecapsule/img/favicon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="https://fneto-prod.fr/timecapsule/img/favicon.png">
  <link rel="icon" type="image/png" sizes="16x16" href="https://fneto-prod.fr/timecapsule/img/favicon.png">

  <title
  <?php if(isset($_GET['event']) && $_GET['event'] != null && isset($event["event_name"]) && $event["event_name"] != null) : ?>
    ><?= $event["event_name"] ?> - Time Capsule
    <?php else : ?>
  >Time Capsule
<?php endif ?>
</title>
</head>

<body>

  <?php if(isset($_GET['event']) && $_GET['event'] != null && isset($_SESSION['main_color']) && $_SESSION['main_color'] != null) : ?>
    <header style="background-color: <?= $_SESSION['main_color'] ?>" >
  <?php else : ?>
    <header>
  <?php endif ?>

    <a href='<?= BASE_URL ?>'>
      
      <?php if(isset($_GET['event']) && $_GET['event'] != null && isset($_SESSION['event_logo']) && $_SESSION['event_logo'] != null) : ?>
        <img src='<?= $_SESSION['event_logo'] ?>' alt='logo évènement'>
      <?php else : ?>
      <img src='https://fneto-prod.fr/timecapsule/img/timecapsule-logo.png' alt='logo Time Capsule'>
    <?php endif ?>
  </a>
  </header>

  <main id='content'
  <?php if(isset($_GET['event']) && $_GET['event'] != null && isset($_SESSION['secondary_color']) && $_SESSION['secondary_color'] != null) : ?>
    style="background-color: <?= $_SESSION['secondary_color'] ?>"
  <?php endif ?>
  >
    <?php include($content) ?>

    <?php include_once(__DIR__ . "/src/content/notifications/notifications.php") ?>

  </main>

</body>

</html>