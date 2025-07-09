
<!-- page content -->

<?php 
//echo '<pre>';
//print_r($_SESSION);
//echo '<pre>'; 
//$_SESSION=[];
?>

<div id="content_bloc">

    <h1>Choisir un nouveau mot de passe</h1>

    <form action="<?= BASE_URL ?>users" method="POST" enctype="form-data" id="pwd_reset_email">
    <input type='hidden' id='post_pwd_reset_email' name='post_pwd_reset_email' required />
    <input type='hidden' id='email_associated' name='email_associated' value="<?= $_GET['pwd_reset_email'] ?>" required /> <!-- email de la demande de reset -->
    <input type='hidden' id='token_associated' name='token_associated' value="<?= $_GET['token'] ?>" required /> <!-- token de la demande de reset -->

    <div class="field_login">
        <label for='new_pwd_email'><p>Nouveau mot de passe</p></label>
        <input type='password' id='account_password' name='new_pwd_email' required>
    </div>

    <div class="field_login">
        <label for='new_pwd_email'><p>Confirmez ce mot de passe</p></label>
        <input type='password' id='account_password_validation' name='new_pwd_email' required>
    </div>

    <p id="status_password_conformity"></p>

    <div id="reset_pwd_confirm">
        <input id='submit_register_button' class="main_cta" type="submit" value="Continuer" />
    </div>


    </form>


</div>



