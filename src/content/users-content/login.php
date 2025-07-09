
<!-- page content -->

<?php 
//echo '<pre>';
//print_r($_SESSION);
//echo '<pre>'; 
//$_SESSION=[];
?>


<?php // si arrivée avec la donnée de session 'open_signup',
// set une variable pour ouvrir sur le form d'inscription
// sinon ouvre par défaut sur le form de login
$defaultForm = 'login';
if (isset($_SESSION['open_signup'])) {
    $defaultForm = 'signup';
    unset($_SESSION['open_signup']); // on nettoie pour ne pas la garder
} else {
    $defaultForm = 'login';
}
?>


<div id="content_bloc">

<div id='connect_register_radio_bloc'>
    <input type='radio' id='connect_radio' name='connect_register_toggle' value='connect' 
    <?= $defaultForm === 'login' ? 'checked' : '' ?> >
    <label for='connect_radio'>Connexion</label>
    <input type='radio' id='register_radio' name='connect_register_toggle' value='register'
    <?= $defaultForm === 'signup' ? 'checked' : '' ?> >
    <label for='register_radio'>Inscription</label>
</div>

<!-- Connexion -->

<div id="connect_bloc">
    <h1>Connexion</h1>

    <form action="#" method="POST" enctype="form-data" id="form_login">
    <input type='hidden' id='post_connect_account' name='post_connect_account' required />

    <?php if(isset($existingEmail) && $existingEmail !== null) : 
        // si tentative création de compte avec email déjà en BDD ?>
        <p id="existing_email">Cet email est déjà utilisé.<br>Veuillez vous connecter.</p>
    <?php endif ?>

    <div class="field_login">
        <label for='connect_email'><p>Email</p></label>
        <input type='email' id='connect_email' name='connect_email' required
        <?php if(isset($attemptEmail) && $attemptEmail !== null) : 
            // si tentative création de compte avec email déjà enregistré en base, le pré-rempli dans l'itf de connexion ?>
            value="<?= $attemptEmail ?>"
        <?php endif ?>
        >
    </div>

    <div class="field_login">
        <label for='connect_password'><p>Mot de passe</p></label>
        <input type='password' id='connect_password' name='connect_password' required>
    </div>
    <?php if(isset($statusPassword) && $statusPassword == false) : 
        // si tentative de connexion avec mauvais mot de passe ?>
        <p id="wrong_password">Le mot de passe entré est incorrect.</p>
    <?php endif ?>

    <div id="connect_confirm">
        <input id='submit_connect_button' class="main_cta" type="submit" value="Me connecter" />
    </div>

    </form>

    <a id="forgotten_password" href='./users/?password_reset=true'>Mot de passe oublié ?<br>
    (Bientôt disponible)</a>

</div>

<!-- Inscription -->

<div id="register_bloc" style="display: none;">
    <h1>Inscription</h1>

    <?php if(isset($defaultForm) && $defaultForm == 'signup') : 
        // si a tenté de créer un event sans être connecté ?>
        <p id="signup_needed">Vous devez être connecté pour créer un évènement</p>
    <?php endif ?>

    <form action="#" method="POST" enctype="form-data" id="form_register">
    <input type='hidden' id='post_create_account' name='post_create_account' required />

    <div class="field_register">
        <label for='create_account_email'><p>Email</p></label>
        <input type='email' id='create_account_email' name='create_account_email' required>
    </div>

    <div class="field_register">
        <label for='account_password'><p>Mot de passe</p></label>
        <input type='password' id='account_password' name='account_password' required>
    </div>

    <div class="field_register">
        <label for='account_password_validation'><p>Confirmer votre mot de passe</p></label>
        <input type='password' id='account_password_validation' name='account_password_validation' required>
    </div>

    <p id="status_password_conformity"></p>

    <div id="create_account_confirm">
        <input id='submit_register_button' disabled class="main_cta" type="submit" value="Créer mon compte" />
    </div>

    </form>

    <p class="subscription_notes">Aucun email commercial ne vous sera adressé.<br>
    Il vous permettra néanmoins de retrouver votre mot de passe si vous en faites la demande.</p>
</div>

</div>



