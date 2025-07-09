
<!-- page content -->

<?php 
//echo '<pre>';
//print_r($_SESSION);
//echo '<pre>'; 
//$_SESSION=[];
?>

<div id="content_bloc">

<!-- Formulaire de demande de reset de mot de passe -->

<div id="pwd_reset_start_bloc">
    <h1>Mot de passe oublié ?</h1>

    <p class="informations_notes">Saisissez votre email pour recevoir un lien de réinitialisation de votre mot de passe.</p>

    <form action="#" method="POST" enctype="form-data" id="form_login">
    <input type='hidden' id='post_pwd_reset' name='post_pwd_reset' required />

    <div class="field_login">
        <label for='reset_pwd_email'><p>Email</p></label>
        <input type='email' id='reset_pwd_email' name='reset_pwd_email' required>
    </div>

    <div id="reset_pwd_confirm">
        <input id='submit_reset_pwd_button' class="main_cta" type="submit" value="Continuer" />
    </div>

    </form>

</div>


</div>



