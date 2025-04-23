<?php include_once(__DIR__ . "/modules/colors_functions.php") ?>

<h1>Bienvenue sur Time Capsule !</h1>
<br>
<h2>Accédez au feed d'un évènement existant :</h2>

<div class="listing_lists">
    <?php foreach ($lists as $list) : ?>
        <a class="list_available" href="./?event=<?= $list['event_id'] ?>">
            <p>> <?= $list['event_name'] ?></p>
        </a>
    <?php endforeach ?>
</div>

<h2>Ou créez un nouveau feed pour un évènement :</h2>

<button class="cta" id='showModaleButton'>Créer un feed</button>

<!-- creation list modal -->

<dialog id='dialog1' class="">

    <button class="close_popup" id="close_popup">X</button>
    <p class="title_popup bold">Créer un feed pour un nouvel évènement</p>
    <p>Vous pourrez modifier ces informations par la suite.</p>

    <form action="<?= BASE_URL ?>" method="POST" enctype="multipart/form-data">
    <input type='hidden' id='post_create_event' name='post_create_event' required />

        <div><p class="form_category bold">Général</p></div>

        <div class="form_field">
            <label for='new_event_title' class="label_new_list">
                <p>Nom de l'évènement :</p>
            </label>
            <input type="text" id="new_event_title" name="new_event_title" required />
        </div>

        <div class="form_field">
            <label for='new_event_password' class="label_new_list">
                <p>Mot de passe pour y accéder :
                <br><span class="italic smaller"> (optionnel)</span></p>
            </label>
            <input type="password" id="new_event_password" name="new_event_password" />
        </div>

        <div><p class="form_category bold">Design</p></div>

        <div class="form_field_file">
            <div>
                <label for='new_event_logo'><p>Image d'en-tête (logo par exemple) :</p>
                <span class="italic smaller">Il est conseillé d'utiliser une image sans fond, format png.
                Si vous ne téléchargez pas d'image, une image standard sera utilisée.</span></label>
            </div>
            <div class="file_input">
                <input type='file' id='new_event_logo' name='new_event_logo' accept="image/png, image/jpeg, image/jpg, image/heic, image/heif">
            </div>
        </div>

        
        <div id="new_event_main_color_comment" class="new_event_warning_message"></div>

        <div id="color_module">

            <div class="color_content">
                <div class="color_choosing">
                    <label for='main_color'><p>Couleur principale :</p></label>
                </div>
                <div class="custom-color-picker">
                <input type="color" id='main_color' name='main_color' class='form_field real-color-input' value="#041009" required>
                <div class="color-circle"></div>
                </div>
            </div>

            <div class="color_content">
                <div class="color_choosing">
                    <label for='secondary_color'><p>Couleur secondaire :</p></label>
                </div>
                <div class="custom-color-picker">
                    <input type="color" id='secondary_color' name='secondary_color' class='form_field real-color-input' value="#FFFFFF" required>
                <div class="color-circle"></div>
                </div>
            </div>

            <div class="color_content">
                <div class="color_choosing">
                    <label for='font_color'><p>Couleur des textes :</p></label>
                </div>
                <div class="custom-color-picker">
                <input type="color" id='font_color' name='font_color' class='form_field real-color-input' value="#041009" required>
                <div class="color-circle"></div>
                </div>
            </div>

        </div>

        <div id="modal_submit_button_bloc" class="preview_double_buttons">
            <input type='button' class="button cta cta_modal" id='preview_event_btn_refresh' value='Actualiser'>
            <input id="modal_submit_button" class="main_cta" type="submit" value="Créer votre feed" />
        </div>
    </form>

    

    <div id='preview_module'>
        <p class="title_popup bold">Prévisualiser votre rendu</p>

        <div id='preview_whole' style="background-color: white">
            <div id='preview_header' style="background-color: black">
                <img src="https://fneto-prod.fr/timecapsule/img/timecapsule-logo.png" 
                id="preview_logo" alt="Exemple logo">
            </div>

            <div>
                <p id="preview_title">Nom de mon super évènement</p>
            </div>

            <div id="preview_content_memory">
                <div id="memory_container" style="rotate: 2deg">
                    <img src="https://fneto-prod.fr/timecapsule/img/photo_template.jpg" alt="Exemple photo">
                    <p>Une super soirée passée avec toi !</p>
                    <p>Par Mélanie</p>
                </div>
            </div>


            <div id="preview_buttons">
                <div class="preview_btn_each" style="background-color: black;">
                    <img src="https://fneto-prod.fr/timecapsule/img/share_icon.png"
                    style="filter: invert(1);" alt="Bouton 1">
                </div>
                <div class="preview_btn_each" style="background-color: black;">
                    <img src="https://fneto-prod.fr/timecapsule/img/add_icon.png" 
                    style="filter: invert(1);" alt="Bouton 2">
                </div>
            </div>
        </div>


    </dialog>
