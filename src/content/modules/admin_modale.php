<?php include_once(__DIR__ . "/colors_functions.php") ?>

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
            <label for="new_name_event">Nom à donner à l'évènement</label>
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
                    </div>
                    <div class="custom-color-picker">
                    <input type="color" id='main_color' name='main_color' class='form_field real-color-input' 
                    <?php if(isset($event['main_color']) && $event['main_color'] != null) : ?> value="<?= $event['main_color'] ?>"
                    <?php else : ?> value="#041009"
                    <?php endif ?>
                    required>
                    <div class="color-circle" style="background-color: 
                    <?php if(isset($event['main_color']) && $event['main_color'] != null) : ?><?= $event['main_color'] ?>
                    <?php else : ?>#041009
                    <?php endif ?>
                    ;"></div>
                    </div>
                </div>

                <div class="color_content">
                    <div class="color_choosing">
                        <label for='secondary_color'><p>Couleur secondaire :</p></label>
                    </div>
                    <div class="custom-color-picker">
                    <input type="color" id='secondary_color' name='secondary_color' class='form_field real-color-input'
                    <?php if(isset($event['secondary_color']) && $event['secondary_color'] != null) : ?> value="<?= $event['secondary_color'] ?>"
                    <?php else : ?> value="#FFFFFF"
                    <?php endif ?>
                    required>
                    <div class="color-circle" style="background-color: 
                    <?php if(isset($event['secondary_color']) && $event['secondary_color'] != null) : ?><?= $event['secondary_color'] ?>
                    <?php else : ?>#ffffff
                    <?php endif ?>
                    ;"></div>
                    </div>
                </div>

                <div class="color_content">
                    <div class="color_choosing">
                        <label for='font_color'><p>Couleur des textes :</p></label>
                    </div>
                    <div class="custom-color-picker">
                    <input type="color" id='font_color' name='font_color' class='form_field real-color-input' 
                    <?php if(isset($event['font_color']) && $event['font_color'] != null) : ?> value="<?= $event['font_color'] ?>"
                    <?php else : ?> value="#041009"
                    <?php endif ?>
                    required>
                    <div class="color-circle" style="background-color: 
                    <?php if(isset($event['font_color']) && $event['font_color'] != null) : ?><?= $event['font_color'] ?>
                    <?php else : ?>#041009
                    <?php endif ?>
                    ;"></div>
                    </div>
                </div>

                </div>

        <div id="modal_submit_button_bloc" class="preview_double_buttons">
            <input type='button' class="button cta cta_modal" id='preview_event_btn_refresh' value='Prévisualiser le rendu'>
            <input id="modal_submit_button" class="main_cta" type="submit" value="Modifier" />
        </div>
    </form>

    <div id='preview_module'>

        <div id='preview_whole' style="background-color: <?= $event['secondary_color'] ?>">
            <div id='preview_header' style="background-color: <?= $event['main_color'] ?>">
                <img src="<?php if($event['event_logo'] != null) : echo($event['event_logo']);
                else : echo('https://fneto-prod.fr/timecapsule/img/timecapsule-logo.png'); endif ?>" 
                id="preview_logo" alt="Exemple logo">
            </div>

            <div>
                <p id="preview_title" style="color: <?= $event['font_color'] ?>"><?= $event['event_name'] ?></p>
            </div>

            <div id="preview_content_memory">
                <div id="memory_container" style="rotate: 2deg">
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




