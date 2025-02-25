<h1>Bienvenue sur Time Capsule !</h1>
<br>
<h2>Accédez au feed d'un évènement existant :</h2>

<div class="listing_lists">
    <?php foreach ($lists as $list) : ?>
        <a class="list_available" href="./?list=<?= $list['list_name'] ?>">
            <p>> <?= $list['list_name'] ?></p>
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

        <div><p class="form_category bold">Général</p></div>

        <div class="form_field">
            <label for='new_list_title' class="label_new_list">
                <p>Nom de l'évènement :</p>
            </label>
            <input type="text" id="new_list_title" name="new_list_title" required />
            <input type='hidden' id='post_create_list' name='post_create_list' required />
        </div>
        <div class="form_field">
            <label for='new_list_password' class="label_new_list">
                <p>Mot de passe pour y accéder :<br><span class="italic"> (optionnel)</span></p>
            </label>
            <input type="password" id="new_list_password" name="new_list_password" />
        </div>

        <div><p class="form_category bold">Design</p></div>

        <div class="form_field">
            <label for='logo_event'><p>Image d'en-tête (logo par exemple) :</p>
            <span class="italic">Il est conseillé d'utiliser une image sans fond, format png.<br>
            Si vous ne téléchargez pas d'image, une image standard sera utilisée.</span></label>
            <input type='file' id='logo_event' name='logo_event' accept="image/png, image/jpeg, image/jpg, image/heic, image/heif">
        </div>

        <div>
            <label for='main_color'><p>Couleur principale :</p></label>
            <select id='main_color' name='main_color' required>
                <option value='black' selected >Noir</option>
                <option value='greenyellow'>Vert</option>
                <option value='aquamarine'>Bleu marin</option>
                <option value='midnightblue'>Bleu minuit</option>
                <option value='red'>Rouge</option>
                <option value='yellow'>Jaune</option>
                <option value='slateblue'>Violet</option>
                <option value='sienna'>Chocolat</option>
                <option value='hotpink'>Rose</option>
            </select>
        </div>

        <div>
            <label for='secondary_color'><p>Couleur secondaire :</p></label>
            <select id='secondary_color' name='secondary_color' required>
                <option value='black' selected >Blanc</option>
                <option value='black' >Noir</option>
                <option value='greenyellow'>Vert</option>
                <option value='aquamarine'>Bleu marin</option>
                <option value='midnightblue'>Bleu minuit</option>
                <option value='red'>Rouge</option>
                <option value='yellow'>Jaune</option>
                <option value='slateblue'>Violet</option>
                <option value='sienna'>Chocolat</option>
                <option value='hotpink'>Rose</option>
            </select>
        </div>

        <div>
            <label for='font_color'><p>Couleur des textes :</p></label>
            <select id='font_color' name='font_color' required>
                <option value='black' >Blanc</option>
                <option value='black' selected >Noir</option>
                <option value='greenyellow'>Vert</option>
                <option value='aquamarine'>Bleu marin</option>
                <option value='midnightblue'>Bleu minuit</option>
                <option value='red'>Rouge</option>
                <option value='yellow'>Jaune</option>
                <option value='slateblue'>Violet</option>
                <option value='sienna'>Chocolat</option>
                <option value='hotpink'>Rose</option>
            </select>
        </div>

        <div id="modal_submit_button_bloc">
            <input id="modal_submit_button" class="cta" type="submit" value="Créer votre feed" />
        </div>
    </form>


    <div id='preview_bloc'>
        <p class="title_popup bold">Prévisualiser votre rendu</p>
        <input type='button' class="button" id='preview_button_refresh' value='Actualiser'>

                <div class='polaroid' id='container_memory_preview'>
                    <img class='memory_photo' id='photo_memory_preview' src='https://fneto-prod.fr/slovenia/img/muffin-profile.png' alt='Preview memory'>
                    <div class='text_memory'>
                        <h2 id="title_memory_preview">Titre test</h2>
                        <h3 id="notes_memory_preview" style="display: none">Notes test</h3>
                        <div class="memory_preview_flex">
                            <h4>Par&#x202F;</h4>
                            <h4 id="author_memory_preview">Autheur</h4>
                            <h4>&#x202F;-&#x202F;</h4>
                            <h4 id="date_memory_preview">date</h4>
                        </div>

                    </div>

                </div>

    </dialog>
