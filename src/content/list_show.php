
<!-- navigation bar & admin modale -->

<?php include_once(__DIR__ . "/modules/sub_header.php") ?>

<!-- page content -->

<!-- Password check -->
<?php if (!empty($event["event_password"]) && (!isset($_SESSION['auth']) || $_SESSION['auth'] != $event["event_id"])) : ?>
    <div id="password_bloc">
        <h2>L'accès à cet évènement est protégé.<br>Merci de saisir le mot de passe :</h2>
        <form action='#' method='POST'>
            <input type='password' id='password' name='password' required />
            <input type='hidden' id='targetEvent' name='targetEvent' value="<?= $event["event_id"] ?>" required />
            <input type='hidden' id='password_proposition' name='password_proposition' required />
            <input type='hidden' id='post_authenticate' name='post_authenticate' required />
            <div id="modal_submit_button_bloc"><input type="submit" class="cta" value="Continuer"></div>
        </form>
    </div>


<?php else : ?>
<!-- Memories -->

<div class='memories_global'>

<?php include_once(__DIR__ . '/modules/memories_display_mecanism.php'); ?>

</div>


<?php //echo '<pre>';
//print_r($_SESSION);
//echo '<pre>'; ?>


<!-- Nav buttons -->

<?php // gère l'API de partage RS du lien VS l'envoi vers la page dédiée
$isMobile = isMobile();
$shareLink = './?event=' . $_SESSION['event_id'] . '&share=true';
?>

<div id='nav_buttons'>
<a 
    <?= $isMobile ? 'id="shareBtn" data-href="' . htmlspecialchars($shareLink) . '" data-name="' . $event["event_name"] . '"' : 'href="' . htmlspecialchars($shareLink) . '"'
    //si sur mobile, met l'ID ShareBtn pour déclencher API Share en JS et ajoute le lien desktop en data pour éventuel fallback en JS si API non-fonctionnelle
    // sinon met direct le lien en href 
    ?>
    <?php if(isset($_GET['event']) && $_GET['event'] != null && isset($_SESSION['main_color']) && $_SESSION['main_color'] != null) : ?>
        style="background-color: <?= $_SESSION['main_color'] ?>;"
    <?php endif ?>
>
    <img src="https://fneto-prod.fr/timecapsule/img/share_icon.png" class="nav_icon margin_left" alt="Bouton de partage"
    <?php if(isset($event['main_color']) && $event['main_color'] != null && isLightColor($event['main_color'])) : ?>
        style="filter: invert(0);"
    <?php endif ?>
    >
</a>

    <a href="./?event=<?= $_SESSION['event_id'] ?>&create_mode=true"
    <?php if(isset($_GET['event']) && $_GET['event'] != null && isset($_SESSION['main_color']) && $_SESSION['main_color'] != null) : ?>
        style="background-color: <?= $_SESSION['main_color'] ?>"
    <?php endif ?>
    >
    
    <img src="https://fneto-prod.fr/timecapsule/img/add_icon.png" class="nav_icon" alt="Bouton d'ajout d'un souvenir"
    <?php if(isset($event['main_color']) && $event['main_color'] != null && isLightColor($event['main_color'])) : ?>
        style="filter: invert(0);"
    <?php endif ?>
    >
    </a>
</div>

<?php endif ?>

