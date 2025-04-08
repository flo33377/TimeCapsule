
<!-- navigation bar -->

<nav id='nav_bar'>
    <div>
        <a class="back_button cta nav_left" href="<?= BASE_URL ?>/?event=<?= $_SESSION['event_id'] ?>">
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

<h2
<?php if(isset($_GET['event']) && $_GET['event'] != null && $_GET['event'] != null && isset($_SESSION['font_color']) && $_SESSION['font_color'] != null) : ?>
    style="color: <?= $_SESSION['font_color'] ?>"
<?php endif ?>
>Enregistrer un nouveau souvenir</h2>

<?php print_r($_SESSION); ?>

<form action="<?= BASE_URL ?>" method="POST" enctype="multipart/form-data">

<input type='hidden' id='post_create_memory' name='post_create_memory' required />
<input type='hidden' id='event_id' name='event_id' value="<?= $event["event_id"] ?>" required />

<div>
    <label for='title'><p>Titre</p></label>
    <input type='text' id='title' name='title' required>
</div>

<div>
    <label for='date'><p>Date</p></label>
    <input type='date' id='date' name='date' required>
</div>

<div>
    <label for='color'><p>Couleur</p></label>
    <select id='color' name='color' required>
        <option value='background-color: white' selected>Blanc</option>
        <option value='background-color: black'>Noir</option>
        <option value='background-color: greenyellow'>Vert</option>
        <option value='background-color: aquamarine'>Bleu marin</option>
        <option value='background-color: midnightblue'>Bleu minuit</option>
        <option value='background-color: red'>Rouge</option>
        <option value='background-color: yellow'>Jaune</option>
        <option value='background-color: slateblue'>Violet</option>
        <option value='background-color: sienna'>Chocolat</option>
        <option value='background-color: hotpink'>Rose</option>
        <option value='background-image: url("https://www.fneto-prod.fr/slovenia/memories/paterns/motif-vague.jpeg")'>Motif vague</option>
        <option value='background-image: url("https://www.fneto-prod.fr/slovenia/memories/paterns/motif-arbre.jpeg")'>Motif arbres</option>
        <option value='background-image: url("https://www.fneto-prod.fr/slovenia/memories/paterns/motif-chien.jpeg")'>Motif chien</option>
        <option value='background-image: url("https://www.fneto-prod.fr/slovenia/memories/paterns/motif-coeur.jpeg")'>Motif coeurs</option>
        <option value='background-image: url("https://www.fneto-prod.fr/slovenia/memories/paterns/motif-fleur.jpeg")'>Motif fleurs</option>
        <option value='background-image: url("https://www.fneto-prod.fr/slovenia/memories/paterns/motif-plage.jpeg")'>Motif plage</option>
        <option value='background-image: url("https://www.fneto-prod.fr/slovenia/memories/paterns/motif-vivatech.jpeg")'>Motif Viva Tech</option>
    </select>
</div>

<div>
    <label for='author'><p>Auteur</p></label>
    <input type='text' id='author' name='author' required>
</div>

<div>
    <label for='photo_memory'><p>Photo</p></label>
    <input type='file' id='photo_memory' name='photo_memory' accept="image/png, image/jpeg, image/jpg, image/heic, image/heif">
</div>

<div class='submit_button_bloc'>
    <input type='submit' class="submit_button" id='submit_button' value='Enregistrer le souvenir !'>
</div>

</form>


<div id='create_memory_preview_bloc'>
    <input type='button' class="button" id='memory_preview_btn_refresh' value='Actualiser'>


    <div id='memory_container' style="rotate: 1deg">
            <img class='memory_photo' id='photo_memory_preview' src='https://fneto-prod.fr/slovenia/img/muffin-profile.png' alt='Preview memory'>
            <div class='text_memory'>
                <h2 id="title_memory_preview">Titre test</h2>
                <div class="memory_preview_flex">
                    <h4>Par&#x202F;</h4>
                    <h4 id="author_memory_preview">Auteur</h4>
                    <h4>&#x202F;-&#x202F;</h4>
                    <h4 id="date_memory_preview">date</h4>
                </div>
            </div>
        </div>




