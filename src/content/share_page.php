<!-- navigation bar & admin modale -->

<?php include_once(__DIR__ . "/modules/sub_header.php") ?>

<!-- page content -->

<!-- Password check -->
<?php // si liste protégée et mdp pas encore entré et validé, demande le mdp
if (!empty($event["event_password"]) && (!isset($_SESSION['auth']) || $_SESSION['auth'] != $event["event_id"])) : ?>
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


<?php else : // sinon affiche le dispositif de partage ?>

<div>
<?php if(isset($_GET['event']) && $_GET['event'] != null && isset($_SESSION['font_color']) && $_SESSION['font_color'] != null) : ?>
    <p style="color: <?= $_SESSION['font_color'] ?>" >
<?php else : ?>
    <p>
<?php endif ?>
Copie-colle le message aux participants de l'évènement.<br>
Tu peux modifier le message avant de l'envoyer.
</p></div>

<div><input type='button' class="button cta" id='CopyTextShareBtn' value='Copier le message'></div>

<div id="sharingTextDiv">
    <textarea id="sharingTextArea"><?php include_once(__DIR__ . "/modules/share_module.php") ?></textarea>
</div>

<!-- message de confirmation -->
<div id="copyMessage">
    Le texte a bien été copié !
</div>

<?php endif ?>




