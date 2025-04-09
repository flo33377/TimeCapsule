
<!-- navigation bar -->

<nav id='nav_bar'>
    <div>
        <a class="back_button cta nav_left" href="<?= BASE_URL ?>">
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
    <?php if (empty($event["event_password"]) || $_SESSION['auth'] == $event["event_id"]) : ?>
        <a class='param_button' id='showModaleButton'>
            <img src="https://fneto-prod.fr/ambition-hub/img/parameter_icon.png" 
            alt="Bouton d'accès aux paramètres" >
        </a>
    <?php endif ?>
    </div>
</nav>

<!-- administration modal -->
<!-- A retravailler pour time capsule -->

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

            <div class="form_field">
            <label for='new_event_logo'><p>Image d'en-tête (logo par exemple) :</p>
            <span class="italic smaller">Il est conseillé d'utiliser une image sans fond, format png.
            Si vous ne téléchargez pas d'image, une image standard sera utilisée.</span></label>
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

            <div id="modal_submit_button_bloc">
            <input id="modal_submit_button" class="admin_cta" type="submit" value="Modifier" />
            </div>
        </form>

        <input type='button' class="button" id='preview_event_btn_refresh' value='Checker le rendu'>

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
<!-- Memories -->

<div class='memories_global'>

    <?php foreach ($memoriesData as $listingMemories) : ?>
        <?php if (!$listingMemories['cancel'] == 'true' ) : ?>
            <div class='memory_container' style='<?= $listingMemories['memory_decoration'] ?>'>
                <img class='memory_photo' src='<?= $listingMemories['url_photo'] ?>' alt='Photo souvenir n°<?= $listingMemories['memory_id'] ?>'>
                <div class='text_memory'>
                    <h2><?= $listingMemories['memory_text'] ?></h2>
                    <h4>Par <?= $listingMemories['memory_author'] ?></h4>
                </div>
                <div class="likes_bloc">
                    <div class="liking_function_bloc">
                        <input type='checkbox' class="like-checkbox" data-nbrlikes='<?= $listingMemories['memory_likes_count'] ?>' 
                        name='box_memory_<?= $listingMemories['memory_id'] ?>' id='<?= $listingMemories['memory_id'] ?>' data-id='<?= $listingMemories['memory_id'] ?>'
                        <?php if(in_array($listingMemories['memory_id'], $_SESSION['LikedMemory'])) : echo('disabled checked'); endif ?>
                        >
                        <label for='<?= $listingMemories['memory_id'] ?>' class="liking_icon">
                            <img src="https://fneto-prod.fr/timecapsule/img/heart_icon_empty.png" class="heart_icon" alt="liking_icon">
                        </label>
                    </div>
                    <div>
                        <p><span class="nbr_likes"><?= $listingMemories['memory_likes_count'] ?></span> likes</p>
                    </div>
                </div>
            </div>
        <?php endif ?>
    <?php endforeach ?>

</div>


<?php //echo '<pre>';
//print_r($_SESSION);
//echo '<pre>'; ?>


<!-- Nav buttons -->
<div id='nav_buttons'>
    <a class="objective_adding_button" href="./?event=<?= $_SESSION['event_id'] ?>&create_mode=true"
    <?php if(isset($_GET['event']) && $_GET['event'] != null && isset($_SESSION['main_color']) && $_SESSION['main_color'] != null) : ?>
        style="background-color: <?= $_SESSION['main_color'] ?>"
    <?php endif ?>
        >
        <p>+</p>
    </a>
</div>

<?php endif ?>

