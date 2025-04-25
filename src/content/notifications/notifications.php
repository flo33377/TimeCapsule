<?php
$bannerMessage = $_SESSION['bannerMessage'] ?? null;
$bannerType = $_SESSION['bannerType'] ?? null;

unset($_SESSION['bannerMessage'], $_SESSION['bannerType']);
?>

<div id="banner_infos" class="invisible_banner"

<?php if(isset($bannerType) && $bannerType != null) : ?>
data-bannertype='<?= $bannerType ?>' 
<?php endif ?>

<?php if(isset($bannerMessage) && $bannerMessage != null) : ?>
data-bannermessage='<?= $bannerMessage ?>' 
<?php endif ?>

></div>





