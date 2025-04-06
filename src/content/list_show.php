
<!-- navigation bar -->

<nav id='nav_bar'>
    <div>
        <a class="back_button cta nav_left" href="<?= BASE_URL ?>">< Retour</a>
    </div>

    <h1><?= $event["event_name"] ?></h1>

    <div class="nav_right">
    <?php if (empty($list["list_password"]) || $_SESSION['auth'] == $list["list_name"]) : ?>
        <a class='param_button' id='showModaleButton'>
            <img src="https://fneto-prod.fr/ambition-hub/img/parameter_icon.png" 
            alt="Bouton d'accès aux paramètres" >
        </a>
    <?php endif ?>
    </div>
</nav>

<!-- administration modal -->

<!-- VOIR AVEC JULIEN - Comme visible en clair dans le HTML
 Est-ce que pas risque que quelqu'un essaie de le déclencher alors que ne peut pas le voir
 Est-ce que token crf permet de corriger ça ? -->

<dialog id='dialog1'>

    <button class="close_popup" id="close_popup">X</button>
    <p class="title_popup bold">Gérer ma liste</p>

    <details><summary>Supprimer ma liste</summary>
        <form action="<?= BASE_URL ?>" method="POST">
            <input type='hidden' id='erase_list' name='erase_list' required />
            <div id="modal_submit_button_bloc">
            <input id="modal_submit_button" class="admin_cta erase_button" type="submit" value="Oui, je veux supprimer ma liste" />
            </div>
        </form>
    </details>

        <details><summary>Modifier le nom de ma liste</summary>
        <form action="<?= BASE_URL ?>" method="POST">
            <input type='hidden' id='change_name_list' name='change_name_list' required />
            <input type='text' id='new_name_list' class="text_field"
            name='new_name_list' placeholder="Nouveau nom de ma liste" required />
            <div id="modal_submit_button_bloc">
            <input id="modal_submit_button" class="admin_cta" type="submit" value="Modifier le nom de ma liste" />
            </div>
        </form>
    </details>

    </dialog>

<!-- page content -->

<!-- Password check -->
<?php if (!empty($list["list_password"]) && (!isset($_SESSION['auth']) || $_SESSION['auth'] !== $list["list_name"])) : ?>
    <div id="password_bloc">
        <h2>Cette liste est protégée.<br>Merci de saisir le mot de passe :</h2>
        <form action='#' method='POST'>
            <input type='password' id='password' name='password' required />
            <input type='hidden' id='targetList' name='targetList' value="<?= $list["list_name"] ?>" required />
            <input type='hidden' id='password_proposition' name='password_proposition' required />
            <input type='hidden' id='post_authenticate' name='post_authenticate' required />
            <div id="modal_submit_button_bloc"><input type="submit" class="cta" value="Continuer"></div>
        </form>
    </div>

<?php else : ?>
<!-- Objectives listing -->

<?php if(!empty($objSports)) : ?>
    <div class="sports_tag_bloc">
        <h2 class="tag_title">Objectifs sportifs</h2>
        <div class='objectives_listing'>
            <?php foreach($objSports as $objectives) : ?>
                <div class='objective_item'>
                <input type='checkbox' class="task-checkbox" id='<?= $objectives['obj_id'] ?>' 
                data-id='<?= $objectives['obj_id'] ?>' data-score='<?= $objectives['current_score_obj'] ?>' name='box_<?= $objectives['obj_id'] ?>'>
                <label for='<?= $objectives['obj_id'] ?>'><?= $objectives['obj_name'] ?></label>
                </div>
            <?php endforeach ?>
        </div>
    </div>
<?php endif ?>

<?php if(!empty($objPersoDev)) : ?>
    <div class="perso_dev_tag_bloc">
        <h2 class="tag_title">Objectifs de développement personnel</h2>
        <div class='objectives_listing'>
            <?php foreach($objPersoDev as $objectives) : ?>
                <div class='objective_item'>
                <input type='checkbox' class="task-checkbox" id='<?= $objectives['obj_id'] ?>' 
                data-id='<?= $objectives['obj_id'] ?>' data-score='<?= $objectives['current_score_obj'] ?>' name='box_<?= $objectives['obj_id'] ?>'>
                <label for='<?= $objectives['obj_id'] ?>'><?= $objectives['obj_name'] ?></label>
                </div>
            <?php endforeach ?>
        </div>
    </div>
<?php endif ?>

<?php if(!empty($objCreativity)) : ?>
    <div class="creativity_tag_bloc">
        <h2 class="tag_title">Objectifs créatifs</h2>
        <div class='objectives_listing'>
            <?php foreach($objCreativity as $objectives) : ?>
                <div class='objective_item'>
                <input type='checkbox' class="task-checkbox" id='<?= $objectives['obj_id'] ?>' 
                data-id='<?= $objectives['obj_id'] ?>' data-score='<?= $objectives['current_score_obj'] ?>' name='box_<?= $objectives['obj_id'] ?>'>
                <label for='<?= $objectives['obj_id'] ?>'><?= $objectives['obj_name'] ?></label>
                </div>
            <?php endforeach ?>
        </div>
    </div>
<?php endif ?>


<?php //echo '<pre>';
print_r($_SESSION);
//echo '<pre>'; ?>


<!-- Nav buttons -->
<div id='nav_buttons'>
<div class="objective_adding_button" id='showModaleButton2'><p>+</p></div>
</div>

<!-- Modal add new obj -->
<dialog id='dialog2' class="personal_development_tag">

    <button class="close_popup" id="close_popup2">X</button>
    <p class="title_popup bold">Créer un nouvel objectif</p>

    <form action="#" method="POST">
    <div class="form_new_objective">
        <input type='hidden' id='post_create_objective' name='post_create_objective' required />
        
        <div class="dialog_form"><label for='new_obj_title' class="label_new_obj"><p>Libellé de l'objectif</p></label>
        <input type="text" id="new_obj_title" name="new_obj_title" placeholder="Libellé" class="text_field" required />
        </div>

        <div class="dialog_form">
        <p>Cet objectif :</p>
        <div class="dialog_radio"><input type='radio' id='unique' name='periodicity' value='unique' checked/>
        <label for='unique'>N'est réalisable qu'une fois par période</label>
        </div>
        <div class="dialog_radio"><input type='radio' id='several' name='periodicity' value='several'/>
        <label for='several'>Est réalisable plusieurs fois sur la période</label>
        </div>
        <div class="dialog_radio"><input type='radio' id='infinite' name='periodicity' value='infinite'/>
        <label for='infinite'>Peut être réalisé à l'infini sur la période</label>
        </div>
        </div>

        <div id='several_times'></div>

        <div class="dialog_form">
            <label for='new_obj_tag' class="label_new_obj"><p>Catégorie de l'objectif</p></label>
            <select name="new_obj_tag" id="new_obj_tag">
                <option value="personal_development">Développement personnel</option>
                <option value="sports">Sport et hygiène de vie</option>
                <option value="creativity">Projets perso et créatifs</option>
            </select>
        </div>

        </div>
        <div id="modal_submit_button_bloc">
            <input id="modal_submit_button" class="cta" type="submit" value="Créer l'objectif" />
        </div>
    </form>

</dialog>


<?php endif ?>

