<script>
  const allLists = <?php echo json_encode($lists); ?>;
</script>

<div id="content_bloc">

<nav>
<a href='<?= BASE_URL ?>' class="back_button cta nav_left"> < </a>
<a href='?disconnect=true' class="login_button my_account_button">Deconnexion</a>
</nav>

<h1>Mon compte</h1>

<h2>Mes évènements :</h2>

<?php if(empty($lists)) : ?>
    <p>Vous n'avez pas encore créé d'évènement.</p>
    <a href='<?= BASE_URL ?>' class="cta" id='showModaleButton'>Créer un évènement</a>
<?php else : ?>
    <div id="whole_discovery_events_area">
        <img src="https://fneto-prod.fr/timecapsule/img/arrow-slider.png" alt="flèche navigation" id="nav_arrow_left">
        <div id="events_show_area">
            <div id="eventContainer" class="listing_all_lists"></div>
            <div id="paginationControls"></div>
        </div>
        <img src="https://fneto-prod.fr/timecapsule/img/arrow-slider.png" alt="flèche navigation" id="nav_arrow_right">
    </div>
<?php endif ?>


<?php 
//echo '<pre>';
//print_r($_SESSION);
//echo '<pre>'; 
?>

</div>


