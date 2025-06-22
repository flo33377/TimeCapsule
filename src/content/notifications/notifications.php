<?php
// pour générer des notifs :
// créer en PHP : $_SESSION['bannerMessage'] = code d'erreur
// rajouter dans le JS entrée tableau dont la clé == $_SESSION['bannerMessage'] (le code d'erreur)
$bannerMessage = $_SESSION['bannerMessage'] ?? null;

unset($_SESSION['bannerMessage']);
?>

<div id="banner_infos" class="invisible_banner"

<?php if(isset($bannerMessage) && $bannerMessage != null) : ?>
data-bannermessage='<?= $bannerMessage ?>' 
<?php endif ?>

></div>





