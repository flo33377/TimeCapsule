<!-- met en place SESSION['open_signup'] = true
 qui permet d'ouvrir auto le form d'inscription plutôt que de login sur la page login
 /!\ need de l'appeler en JS et de faire une redir dans le JS vers la page de login 

<?php
session_start();
$_SESSION['open_signup'] = true;
http_response_code(200); // facultatif, juste pour dire "tout va bien"

?>
