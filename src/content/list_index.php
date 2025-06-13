<?php include_once(__DIR__ . "/modules/colors_functions.php") ?>
<script>
  const allLists = <?php echo json_encode($lists); ?>;
</script>

<?php //echo '<pre>';
//print_r($_SESSION);
//echo '<pre>'; ?>

<h1>Bienvenue sur Time Capsule !</h1>
<br>

<h2>Commencez par créer votre évènement :</h2>

<button class="cta" id='showModaleButton'>Créer un évènement</button>

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


<!-- creation list modal -->
<?php include_once(__DIR__ . "/modules/dialog_event_creation.php") ?>

