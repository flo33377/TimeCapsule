<?php foreach ($memoriesData as $listingMemories) : ?>


<?php if (!$listingMemories['cancel'] == 'true' ) : 
    // display only if cancel != false ?>

<div class="whole_memory">

    <?php if ($listingMemories['memory_additional_deco'] != null && $listingMemories['memory_additional_deco'] == "pin") : ?>
        <img src="https://fneto-prod.fr/timecapsule/img/pin.png" class="pin_memory" alt="Epingle">
    <?php endif ?>


    <div class='memory_container' style='
        <?php if((str_contains($listingMemories['memory_decoration'], 'fneto-prod.fr'))) {
            // htmlspecialchars permet d'échapper les apostrophes/guillemets par défaut
            echo "background-image: url(\"" . htmlspecialchars($listingMemories['memory_decoration'], ENT_QUOTES) . "\");";
        } else {
            echo "background-color: " . $listingMemories['memory_decoration'];
        } ?>
        ; transform:rotate(<?= round(rand(-2,2)) ?>deg);'>

        <?php if($listingMemories['memory_additional_deco'] != null && $listingMemories['memory_additional_deco'] == "starsticker") : ?>
            <img src="https://fneto-prod.fr/timecapsule/img/starsticker.png" class="starsticker_memory" alt="Sticker étoile">
        <?php elseif ($listingMemories['memory_additional_deco'] != null && $listingMemories['memory_additional_deco'] == "scotch") : ?>
                <img src="https://fneto-prod.fr/timecapsule/img/scotchtape.png" class="scotch_memory_left" alt="Scotch">
                <img src="https://fneto-prod.fr/timecapsule/img/scotchtape.png" class="scotch_memory_right" alt="Scotch">
        <?php endif ?>

        <img class='memory_photo' src='<?= $listingMemories['url_photo'] ?>' alt='Photo souvenir n°<?= $listingMemories['memory_id'] ?>'>


        <div class='text_memory' style="
        <?php if($listingMemories['memory_text_color'] != null) : ?>
            color: <?= $listingMemories['memory_text_color'] ?>;
        <?php endif ?>
        <?php if($listingMemories['memory_backg_font'] != null) : ?>
            background-color: <?= $listingMemories['memory_backg_font'] ?>
        <?php endif ?>
        ">
            <h2><?= $listingMemories['memory_text'] ?></h2>
            <h4>Par <?= $listingMemories['memory_author'] ?></h4>
        </div>


        <div class="likes_bloc">
            <div class="liking_function_bloc nbr_like_bloc">
                <input type='checkbox' class="like-checkbox" data-nbrlikes='<?= $listingMemories['memory_likes_count'] ?>' 
                name='box_memory_<?= $listingMemories['memory_id'] ?>' id='<?= $listingMemories['memory_id'] ?>' data-id='<?= $listingMemories['memory_id'] ?>'
                <?php if(in_array($listingMemories['memory_id'], $_SESSION['LikedMemory'])) : echo('disabled checked'); endif ?>
                >
                <label for='<?= $listingMemories['memory_id'] ?>' class="liking_icon">
                    <img src="https://fneto-prod.fr/timecapsule/img/heart_icon_empty.png" class="heart_icon" alt="liking_icon">
                </label>
            </div>
            <div class="nbr_like_bloc">
                <p><span class="nbr_likes"><?= $listingMemories['memory_likes_count'] ?></span> likes</p>
            </div>
        </div>
    </div>

</div>

<?php endif ?>
<?php endforeach ?>

