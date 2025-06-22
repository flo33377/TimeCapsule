<?php // sub-header affichant le bouton retour + si user = propriétaire de l'event sur lequel il est, l'accès à l'admin modale ?>

<nav id='nav_bar'>
    <div>
        <a class="back_button cta nav_left" 
        <?php if((isset($_GET['create_mode']) && $_GET['create_mode'] = true) || (isset($_GET['share']) && $_GET['share'] = true)) : ?>
            href="<?= BASE_URL ?>?event=<?= $_SESSION['event_id'] ?>">
        <?php else : ?> href="<?= BASE_URL ?>">
        <?php endif ?>
            <p> < </p>
        </a>
    </div>

    <?php if(isset($_GET['event']) && $_GET['event'] != null && isset($_SESSION['font_color']) && $_SESSION['font_color'] != null) : ?>
        <h1 style="color: <?= $_SESSION['font_color'] ?>" >
    <?php else : ?>
        <h1>
    <?php endif ?>
    <?= $event["event_name"] ?>
        </h1>

    
    <?php // n'affiche btn admin modale que si connecté et proprio event + mdp déjà saisi OU event sans mdp 
    if(isset($_SESSION['user_id']) && $_SESSION['user_id'] == $event['user_admin_id'] && 
    ((isset($_SESSION['auth']) && $_SESSION['auth'] == $event["event_id"]) || empty($event["event_password"]))) : ?>
        <div class="nav_right cta">
            <a class='param_button' id='showModaleButton'>
                <img src="https://fneto-prod.fr/ambition-hub/img/parameter_icon.png" 
                alt="Bouton d'accès aux paramètres" >
            </a>
        </div>
    <?php else : ?>
        <div>
        </div>
    <?php endif ?>

</nav>

<?php if(isset($_SESSION['user_id']) && $_SESSION['user_id'] == $event['user_admin_id'] && 
(isset($_SESSION['auth']) && $_SESSION['auth'] == $event["event_id"]) || empty($event["event_password"])) {
include_once(__DIR__ . "/admin_modale.php");
}; ?>


