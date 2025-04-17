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

    
    <?php if (empty($event["event_password"]) || (isset($_SESSION['auth']) && $_SESSION['auth'] == $event["event_id"])) : ?>
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

<?php include_once(__DIR__ . "/admin_modale.php") ?>


