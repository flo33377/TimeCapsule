
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
                    <h4>Par <?= $listingMemories['memory_author'] ?> - <?= $listingMemories['memory_date'] ?></h4>
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

