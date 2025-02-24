<?php include_once(__DIR__ . "/src/main.php") ?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./public/css/design-system.css">
  <link rel="stylesheet" href="./public/css/custom-pages.css">
  <link rel="apple-touch-icon" sizes="180x180" href="https://fneto-prod.fr/timecapsule/img/favicon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="https://fneto-prod.fr/timecapsule/img/favicon.png">
  <link rel="icon" type="image/png" sizes="16x16" href="https://fneto-prod.fr/timecapsule/img/favicon.png">
  <script src="./public/js/js-mecanisms.js" defer></script>
  <title>Time Capsule</title>
</head>

<body>
  <header>
    <a href='<?= BASE_URL ?>'>
      <img src='https://fneto-prod.fr/timecapsule/img/timecapsule-logo.png' alt='logo Time Capsule'>
    </a>
  </header>

  <main id='content'>
    <?php include($content) ?>
  </main>

</body>

</html>