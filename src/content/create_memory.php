
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

<?php else : // sinon affiche le form de création de memory pour cet event ?>


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
    <label for='author'><p>Auteur</p></label>
    <input type='text' id='author' name='author' required>
</div>

<div class="field_new_memory">
    <label for='photo_memory'><p>Photo</p></label>
    <input type='file' id='photo_memory' name='photo_memory' accept="image/png, image/jpeg, image/jpg, image/heic, image/heif" required>
</div>

<div class="field_new_memory">
    <?php $defaultDate = date('Y-m-d\TH:i'); ?>
    <label for="memory_date">Date du souvenir :</label>
    <input type="datetime-local" id="memory_date" name="memory_date" required value="<?= htmlspecialchars($defaultDate) ?>" max="<?= htmlspecialchars($defaultDate) ?>">
</div>


<div class="radio_selection_block">
    <div id='background_selection'>
        <input type='radio' id='backg_color' name='backg_value' value='color' checked>
        <label for='backg_color'>Couleur de fond</label>
        <input type='radio' id='backg_patern' name='backg_value' value='patern'>
        <label for='backg_patern'>Motif de fond</label>
    </div>

    <div class="custom-color-picker" id="memory_color_content">
        <label for="color_memory">Couleur du polaroid :</label>
        <div>
            <input type="color" name='color_memory' id='color_memory' class='form_field real-color-input' value="#ffe4c4">
            <div class="color-circle" style="background-color: #ffe4c4" ></div>
        </div>
    </div>

    <div id="memory_patern_content" class="field_new_memory" style="display: none;">
        <label for="patern_memory"><p>Motif du polaroid :</p></label>
        <select id='patern_memory' name='patern_memory' required>
        <?php generateSelectDesigns(false, false, true, true, $colors, $paterns, "https://fneto-prod.fr/timecapsule/img/paterns/motif-vague.jpeg") ?>
        </select>
        <div class="nuancier_new_memory" id="nuancier_decoration" style="background-image: url('https://fneto-prod.fr/timecapsule/img/paterns/motif-vague.jpeg')"></div>
    </div>

</div>



<div class="toggle_trigger" onclick="toggleDetails('new_memory_options_field', this)">
    <p><span class="chevron">&#9654;</span> <span class="underline">Voir plus d'options de personnalisation</span></p>
</div>

<div class="new_memory_options_field" id="new_memory_options_field">
    <div class="color_content" id="new_memory_font_color">
        <div class="color_choosing">
            <label for='text_memory_color'><p>Couleur des textes :</p></label>
        </div>
        <div class="custom-color-picker">
            <input type="color" id='text_memory_color' name='text_memory_color' class='form_field real-color-input' value="#041009" required>
            <div class="color-circle" style="background-color: #041009;"></div>
        </div>
    </div>

        <div id="memory_backg_font_content" class="field_new_memory">
        <label for="backg_font_memory"><p>Couleur derrière les textes :</p></label>
        <select id='backg_font_memory' name='backg_font_memory' required>
        <?php generateSelectDesigns(true, true, false, true, $colors, $paterns, "transparent") ?>
        </select>
    </div>

    <div id="memory_decoration_content" class="field_new_memory">
        <label for="decoration_memory"><p>Décoration supplémentaire :</p></label>
        <select id='decoration_memory' name='decoration_memory' required>
        <?php generateSelectDecorations ($decorations) ?>
        </select>
    </div>

</div>

<!-- bloc de preview du souvenir -->

<div id="preview_memory_buttons">
    <input type='button' class="button cta cta_modal" id='memory_preview_btn_refresh' value='Prévisualiser'>
    <input id='submit_button' class="main_cta" type="submit" value="Enregistrer" />
</div>

</form>

<div id='create_memory_preview_bloc'>


    <div class='memory_container' id='memory_preview_container' style="rotate: 1deg">

            <img class='memory_photo' id='photo_memory_preview' src='https://fneto-prod.fr/slovenia/img/muffin-profile.png' alt='Preview memory'>
            <div class='text_memory' id='text_memory_preview'>
                <h2 id="title_memory_preview">Titre test</h2>
                <div class="memory_preview_flex">
                    <h4>Par&#x202F;</h4>
                    <h4 id="author_memory_preview">Auteur</h4>
                </div>
            </div>
        </div>



<?php endif ?>
