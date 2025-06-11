<?php
// pour générer des notifs :
// créer en PHP : $_SESSION['bannerMessage'] = smthg 
// rajouter dans le JS entrée tableau dont la clé == $_SESSION['bannerMessage']
$bannerMessage = $_SESSION['bannerMessage'] ?? null;

unset($_SESSION['bannerMessage'], $_SESSION['bannerType']);
?>

<div id="banner_infos" class="invisible_banner"

<?php if(isset($bannerMessage) && $bannerMessage != null) : ?>
data-bannermessage='<?= $bannerMessage ?>' 
<?php endif ?>

></div>





