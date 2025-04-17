
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


<h2 id="title_page_new_memory" 
<?php if(isset($_GET['event']) && $_GET['event'] != null && isset($_SESSION['font_color']) && $_SESSION['font_color'] != null) : ?>
    style="color: <?= $_SESSION['font_color'] ?>; background-color: <?= $_SESSION['secondary_color'] ?>; border: 2px solid <?= $_SESSION['font_color'] ?>"
<?php endif ?>
>Enregistrer un nouveau souvenir</h2>

<form action="<?= BASE_URL ?>" method="POST" enctype="multipart/form-data" id="form_new_memory"
<?php if(isset($_GET['event']) && $_GET['event'] != null && $_GET['event'] != null && isset($_SESSION['font_color']) && $_SESSION['font_color'] != null) : ?>
    style="border: 2px solid <?= $_SESSION['font_color'] ?>"
<?php endif ?>
>

<input type='hidden' id='post_create_memory' name='post_create_memory' required />
<input type='hidden' id='event_id' name='event_id' value="<?= $event["event_id"] ?>" required />

<div class="field_new_memory">
    <label for='title'><p>Titre</p></label>
    <input type='text' id='title' name='title' required>
</div>

<div class="field_new_memory">
    <label for='color'><p>Couleur/décoration</p></label>
    <select id='color' name='color' required>
    <?php generateSelectDesigns(true, true, $colors, $paterns, "bisque") ?>
    </select>
</div>

<div class="nuancier_new_memory" id="nuancier_decoration" style="background-color:bisque"></div>


<div class="field_new_memory">
    <label for='author'><p>Auteur</p></label>
    <input type='text' id='author' name='author' required>
</div>

<div class="field_new_memory">
    <label for='photo_memory'><p>Photo</p></label>
    <input type='file' id='photo_memory' name='photo_memory' accept="image/png, image/jpeg, image/jpg, image/heic, image/heif" required>
</div>

<div id="preview_memory_buttons">
    <input type='button' class="button cta cta_modal" id='memory_preview_btn_refresh' value='Prévisualiser'>
    <input id='submit_button' class="main_cta" type="submit" value="Enregistrer" />
</div>

</form>

<div id='create_memory_preview_bloc'>


    <div class='memory_container' id='memory_preview_container' style="rotate: 1deg">
            <img class='memory_photo' id='photo_memory_preview' src='https://fneto-prod.fr/slovenia/img/muffin-profile.png' alt='Preview memory'>
            <div class='text_memory'>
                <h2 id="title_memory_preview">Titre test</h2>
                <div class="memory_preview_flex">
                    <h4>Par&#x202F;</h4>
                    <h4 id="author_memory_preview">Auteur</h4>
                </div>
            </div>
        </div>



        <?php endif ?>
