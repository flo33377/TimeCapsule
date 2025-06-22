
// Fonctions propres à la partie users du site
// Fichier appelé uniquement sur la partie users


/* Toogle pour passer du form connect au form register */

let toogle_account_mode = document.getElementById('connect_register_radio_bloc');

if (toogle_account_mode) {
    const radios = document.querySelectorAll('#connect_register_radio_bloc input[type="radio"]');

    // Fonction pour afficher le bon formulaire
    function updateFormDisplay() {
        document.getElementById('connect_bloc').style.display = 
            document.getElementById('connect_radio').checked ? 'flex' : 'none';

        document.getElementById('register_bloc').style.display = 
            document.getElementById('register_radio').checked ? 'flex' : 'none';
    }

    // Event sur chaque radio qui déclenche la fonction
    radios.forEach(radio => {
        radio.addEventListener('change', updateFormDisplay);
    });

    // Appel initial de la fonction au chargement de la page
    updateFormDisplay();
}


/* Inscription - Check que les deux mots de passes rentrées sont les mêmes */

let status_password_conformity = document.getElementById('status_password_conformity');
let send_form_button = document.getElementById('submit_register_button');
non_conform_message = 'Les deux mots de passe doivent être identiques';

if (status_password_conformity) {
    let first_password_field = document.getElementById('create_account_password');
    let second_password_field = document.getElementById('create_account_password_validation');
    
    function checkPasswordMatch() {
        if(first_password_field.value !== second_password_field.value) {
            status_password_conformity.textContent = non_conform_message;
            send_form_button.disabled = true;
        } else {
            status_password_conformity.textContent = '';
            send_form_button.disabled = false;
        }
    }
    
    first_password_field.addEventListener('input', checkPasswordMatch);
    second_password_field.addEventListener('input', checkPasswordMatch);
}


