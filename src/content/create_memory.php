
<!-- navigation bar -->

<nav id='nav_bar'>
    <div>
        <a class="back_button cta nav_left" href="<?= BASE_URL ?>?event=<?= $_SESSION['event_id'] ?>">
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

    <div class="nav_right">
    <?php if (empty($event["event_password"]) || (isset($_SESSION['auth']) && $_SESSION['auth'] == $event["event_id"])) : ?>
        <a class='param_button' id='showModaleButton'>
            <img src="https://fneto-prod.fr/ambition-hub/img/parameter_icon.png" 
            alt="Bouton d'accès aux paramètres" >
        </a>
    <?php endif ?>
    </div>
</nav>

<!-- administration modal -->
<!-- A retravailler pour time capsule -->

<?php if (empty($event["event_password"]) || (isset($_SESSION['auth']) && $_SESSION['auth'] == $event["event_id"])) : ?>
<dialog id='dialog1'>

    <button class="close_popup" id="close_popup">X</button>
    <p class="title_popup bold">Gérer mon évènement</p>

    <details><summary
    <?php if(isset($_GET['event']) && $_GET['event'] != null && isset($_SESSION['secondary_color']) && $_SESSION['secondary_color'] != null) : ?>
    style="background-color: <?= $_SESSION['secondary_color'] ?>; color: <?= $_SESSION['font_color'] ?>"
    <?php endif ?>
        >Supprimer l'évènement</summary>
        <p class="italic">Attention : cette action est irréversible</p>
        <form action="<?= BASE_URL ?>" method="POST">
            <input type='hidden' id='post_erase_event' name='post_erase_event' required />
            <div id="modal_submit_button_bloc">
            <input id="modal_submit_button" class="admin_cta erase_button" type="submit" value="Oui, je veux supprimer ma liste" />
            </div>
        </form>
    </details>

        <details><summary
        <?php if(isset($_GET['event']) && $_GET['event'] != null && isset($_SESSION['secondary_color']) && $_SESSION['secondary_color'] != null) : ?>
        style="background-color: <?= $_SESSION['secondary_color'] ?>; color: <?= $_SESSION['font_color'] ?>"
        <?php endif ?>
            >Modifier le nom de mon évènement</summary>
        <form action="<?= BASE_URL ?>" method="POST">
            <input type='hidden' id='post_change_name_event' name='post_change_name_event' required />
            <input type='text' id='new_name_event' class="text_field"
            name='new_name_event' placeholder="Nouveau nom de l'évènement" required />
            <div id="modal_submit_button_bloc">
            <input id="modal_submit_button" class="admin_cta" type="submit" value="Modifier" />
            </div>
        </form>
    </details>

    <details><summary
        <?php if(isset($_GET['event']) && $_GET['event'] != null && isset($_SESSION['secondary_color']) && $_SESSION['secondary_color'] != null) : ?>
        style="background-color: <?= $_SESSION['secondary_color'] ?>; color: <?= $_SESSION['font_color'] ?>"
        <?php endif ?>
            >Modifier le logo ou les couleurs du site</summary>

        <form action="<?= BASE_URL ?>" method="POST" enctype="multipart/form-data">
            <input type='hidden' id='post_change_logo_colors' name='post_change_logo_colors' required />
            <input type='hidden' id='post_event_name' name='post_event_name' value=<?= $event['event_name'] ?> required />

            <div class="form_field_file">
                <div>
                    <label for='new_event_logo'><p>Image d'en-tête (logo par exemple) :</p>
                    <span class="italic smaller">Il est conseillé d'utiliser une image sans fond, format png.
                    Si vous ne téléchargez pas d'image, une image standard sera utilisée.</span></label>
                </div>
                <input type='file' id='new_event_logo' name='new_event_logo' accept="image/png, image/jpeg, image/jpg, image/heic, image/heif">
            </div>

        <div id="color_module">

            <div class="color_content">
                <div class="color_choosing">
                    <label for='main_color'><p>Couleur principale :</p></label>
                    <select id='main_color' name='main_color' class='form_field' required>
                        <option value='black' <?php if($event['main_color'] == "black") : echo('selected'); endif ?>>Noir</option>
                        <option value='greenyellow' <?php if($event['main_color'] == "greenyellow") : echo('selected'); endif ?>>Vert</option>
                        <option value='aquamarine' <?php if($event['main_color'] == "aquamarine") : echo('selected'); endif ?>>Bleu marin</option>
                        <option value='midnightblue' <?php if($event['main_color'] == "midnigthblue") : echo('selected'); endif ?>>Bleu minuit</option>
                        <option value='red' <?php if($event['main_color'] == "red") : echo('selected'); endif ?>>Rouge</option>
                        <option value='yellow' <?php if($event['main_color'] == "yellow") : echo('selected'); endif ?>>Jaune</option>
                        <option value='slateblue' <?php if($event['main_color'] == "slateblue") : echo('selected'); endif ?>>Violet</option>
                        <option value='sienna' <?php if($event['main_color'] == "sienna") : echo('selected'); endif ?>>Chocolat</option>
                        <option value='hotpink' <?php if($event['main_color'] == "hotpink") : echo('selected'); endif ?>>Rose</option>
                    </select>
                </div>
                <div class="nuancier" id="nuancier_main_color" style="background-color:<?= $event['main_color'] ?>"></div>
            </div>

            <div class="color_content">
                <div class="color_choosing">
                    <label for='secondary_color'><p>Couleur secondaire :</p></label>
                    <select id='secondary_color' name='secondary_color' class='form_field' required>
                        <option value='white' <?php if($event['secondary_color'] == "black") : echo('selected'); endif ?>>Blanc</option>
                        <option value='black' <?php if($event['secondary_color'] == "black") : echo('selected'); endif ?>>Noir</option>
                        <option value='greenyellow' <?php if($event['secondary_color'] == "greenyellow") : echo('selected'); endif ?>>Vert</option>
                        <option value='aquamarine' <?php if($event['secondary_color'] == "aquamarine") : echo('selected'); endif ?>>Bleu marin</option>
                        <option value='midnightblue' <?php if($event['secondary_color'] == "midnigthblue") : echo('selected'); endif ?>>Bleu minuit</option>
                        <option value='red' <?php if($event['secondary_color'] == "red") : echo('selected'); endif ?>>Rouge</option>
                        <option value='yellow' <?php if($event['secondary_color'] == "yellow") : echo('selected'); endif ?>>Jaune</option>
                        <option value='slateblue' <?php if($event['secondary_color'] == "slateblue") : echo('selected'); endif ?>>Violet</option>
                        <option value='sienna' <?php if($event['secondary_color'] == "sienna") : echo('selected'); endif ?>>Chocolat</option>
                        <option value='hotpink' <?php if($event['secondary_color'] == "hotpink") : echo('selected'); endif ?>>Rose</option>
                    </select>
                </div>
                <div class="nuancier" id="nuancier_secondary_color" style="background-color:<?= $event['secondary_color'] ?>"></div>
            </div>

            <div class="color_content">
                <div class="color_choosing">
                    <label for='font_color'><p>Couleur des textes :</p></label>
                    <select id='font_color' name='font_color' class='form_field' required>
                    <option value='white' <?php if($event['font_color'] == "black") : echo('selected'); endif ?>>Blanc</option>
                        <option value='black' <?php if($event['font_color'] == "black") : echo('selected'); endif ?>>Noir</option>
                        <option value='greenyellow' <?php if($event['font_color'] == "greenyellow") : echo('selected'); endif ?>>Vert</option>
                        <option value='aquamarine' <?php if($event['font_color'] == "aquamarine") : echo('selected'); endif ?>>Bleu marin</option>
                        <option value='midnightblue' <?php if($event['font_color'] == "midnigthblue") : echo('selected'); endif ?>>Bleu minuit</option>
                        <option value='red' <?php if($event['font_color'] == "red") : echo('selected'); endif ?>>Rouge</option>
                        <option value='yellow' <?php if($event['font_color'] == "yellow") : echo('selected'); endif ?>>Jaune</option>
                        <option value='slateblue' <?php if($event['font_color'] == "slateblue") : echo('selected'); endif ?>>Violet</option>
                        <option value='sienna' <?php if($event['font_color'] == "sienna") : echo('selected'); endif ?>>Chocolat</option>
                        <option value='hotpink' <?php if($event['font_color'] == "hotpink") : echo('selected'); endif ?>>Rose</option>
                    </select>
                </div>
                <div class="nuancier" id="nuancier_font_color" style="background-color:<?= $event['font_color'] ?>"></div>
            </div>
        </div>

        <div id="modal_submit_button_bloc">
            <input type='button' class="button cta cta_modal" id='preview_event_btn_refresh' value='Prévisualiser le rendu'>
            <input id="modal_submit_button" class="main_cta" type="submit" value="Modifier" />
            </div>
        </form>

    <div id='preview_module'>

        <div id='preview_whole' style="background-color: <?= $event['secondary_color'] ?>">
            <div id='preview_header' style="background-color: <?= $event['main_color'] ?>">
                <img src="<?= $event['event_logo'] ?>" 
                id="preview_logo" alt="Exemple logo">
            </div>

            <div>
                <p id="preview_title" style="color: <?= $event['font_color'] ?>"><?= $event['event_name'] ?></p>
            </div>

            <div id="preview_content_memory">
                <div id="memory_container" style="rotate: 1deg">
                    <img src="https://fneto-prod.fr/timecapsule/img/photo_template.jpg" alt="Exemple photo">
                    <p>Une super soirée passée avec toi !</p>
                    <p>Par Mélanie</p>
                </div>
            </div>

            <div id="preview_adding_button" style="background-color: <?= $event['main_color'] ?>">
                <p id="preview_adding_btn_text" style="color: white">+</p>
            </div>
        </div>
    </details>

    </dialog>
<?php endif ?>

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

<h2
<?php if(isset($_GET['event']) && $_GET['event'] != null && $_GET['event'] != null && isset($_SESSION['font_color']) && $_SESSION['font_color'] != null) : ?>
    style="color: <?= $_SESSION['font_color'] ?>"
<?php endif ?>
>Enregistrer un nouveau souvenir</h2>

<form action="<?= BASE_URL ?>" method="POST" enctype="multipart/form-data" id="form_new_memory">

<input type='hidden' id='post_create_memory' name='post_create_memory' required />
<input type='hidden' id='event_id' name='event_id' value="<?= $event["event_id"] ?>" required />

<div class="field_new_memory">
    <label for='title'><p
    <?php if(isset($_GET['event']) && $_GET['event'] != null && $_GET['event'] != null && isset($_SESSION['font_color']) && $_SESSION['font_color'] != null) : ?>
    style="color: <?= $_SESSION['font_color'] ?>"
    <?php endif ?>
    >Titre</p></label>
    <input type='text' id='title' name='title' required>
</div>

<div>
    <label for='color'><p
    <?php if(isset($_GET['event']) && $_GET['event'] != null && $_GET['event'] != null && isset($_SESSION['font_color']) && $_SESSION['font_color'] != null) : ?>
    style="color: <?= $_SESSION['font_color'] ?>"
    <?php endif ?>
    >Couleur/décoration</p></label>
    <select id='color' name='color' required>
        <option value='background-color: white' selected>Blanc</option>
        <option value='background-color: LightSlateGray	'>Gris</option>
        <option value='background-color: bisque'>Coquille d'oeuf</option>
        <option value='background-color: greenyellow'>Vert vif</option>
        <option value='background-color: lightgreen'>Vert doux</option>
        <option value='background-color: aquamarine'>Bleu marin</option>
        <option value='background-color: midnightblue'>Bleu minuit</option>
        <option value='background-color: red'>Rouge</option>
        <option value='background-color: yellow'>Jaune</option>
        <option value='background-color: slateblue'>Violet</option>
        <option value='background-color: sienna'>Chocolat</option>
        <option value='background-color: hotpink'>Rose</option>
        <option value='background-image: url("https://www.fneto-prod.fr/timecapsule/img/paterns/motif-vague.jpeg")'>Motif vague</option>
        <option value='background-image: url("https://www.fneto-prod.fr/timecapsule/img/paterns/motif-chien.jpeg")'>Motif chien</option>
        <option value='background-image: url("https://www.fneto-prod.fr/timecapsule/img/paterns/motif-coeur.jpeg")'>Motif coeurs</option>
        <option value='background-image: url("https://www.fneto-prod.fr/timecapsule/img/paterns/motif-fleur.jpeg")'>Motif fleurs</option>
        <option value='background-image: url("https://www.fneto-prod.fr/timecapsule/img/paterns/motif-vivatech.jpeg")'>Motifs géométriques</option>
    </select>
</div>

</div>
    <div class="nuancier_new_memory" id="nuancier_decoration" style="background-color:white"></div>
</div>

<div class="field_new_memory">
    <label for='author'><p
    <?php if(isset($_GET['event']) && $_GET['event'] != null && $_GET['event'] != null && isset($_SESSION['font_color']) && $_SESSION['font_color'] != null) : ?>
    style="color: <?= $_SESSION['font_color'] ?>"
    <?php endif ?>
    >Auteur</p></label>
    <input type='text' id='author' name='author' required>
</div>

<div>
    <label for='photo_memory'><p
    <?php if(isset($_GET['event']) && $_GET['event'] != null && $_GET['event'] != null && isset($_SESSION['font_color']) && $_SESSION['font_color'] != null) : ?>
    style="color: <?= $_SESSION['font_color'] ?>"
    <?php endif ?>
    >Photo</p></label>
    <input type='file' id='photo_memory' name='photo_memory' accept="image/png, image/jpeg, image/jpg, image/heic, image/heif" required>
</div>

<div id="submit_button_bloc">
    <input type='button' class="button cta cta_modal" id='memory_preview_btn_refresh' value='Prévisualiser'>
    <input id='submit_button' class="main_cta" type="submit" value="Enregistrer" />
</div>

</form>

<div id='create_memory_preview_bloc'>


    <div id='memory_container' style="rotate: 1deg">
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
