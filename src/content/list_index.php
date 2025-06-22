<?php include_once(__DIR__ . "/modules/colors_functions.php") ?>
<script>
  // encodage en json des events pour affichage dynamique en JS 
  const allLists = <?php echo json_encode($lists); ?>;
</script>

<h1>Bienvenue sur Time Capsule !</h1>

<h2>Commencez par créer votre évènement :</h2>

<?php if(isset($_SESSION['user_id']) && $_SESSION['user_id'] !== null
&& isset($_SESSION['nbr_events']) && $_SESSION['nbr_events'] < 5) : 
// user connecté avec moins de 5 events => ouvre la modale de création ?>
  <button class="cta" id='showModaleButton'>Créer un évènement</button>

<?php elseif(isset($_SESSION['user_id']) && $_SESSION['user_id'] !== null
&& isset($_SESSION['nbr_events']) && $_SESSION['nbr_events'] >= 5) : 
// user connecté avec plus de 5 events => renvoi p. profil pour lui dire qu'il ne peut pas créer plus d'event ?>
  <button class="cta" id='max_events_redirection'>Créer un évènement</button>

<?php else : 
// user non connecté => renvoi vers la page de connexion ?>
  <button class="cta" id='register_redirection'>Créer un évènement</button>
<?php endif ?>

<br>

<h2>Ou accédez à un évènement existant :</h2>
<div id="whole_discovery_events_area">
    <img src="https://fneto-prod.fr/timecapsule/img/arrow-slider.png" alt="flèche navigation" id="nav_arrow_left">
    <div id="events_show_area">
        <div id="eventContainer" class="listing_all_lists"></div>
        <div id="paginationControls"></div>
    </div>
    <img src="https://fneto-prod.fr/timecapsule/img/arrow-slider.png" alt="flèche navigation" id="nav_arrow_right">
</div>


<!-- modale de création d'event injectée seulement si possible de créer un event -->
<?php if(isset($_SESSION['user_id']) && $_SESSION['user_id'] !== null ) : ?>
  <?php include_once(__DIR__ . "/modules/dialog_event_creation.php") ?>
<?php endif ?>

