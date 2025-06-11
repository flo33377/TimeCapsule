
/* Toogle connect/registration blocs */

let toogle_account_mode = document.getElementById('connect_register_radio_bloc');
if(toogle_account_mode) {
    document.querySelectorAll('#connect_register_radio_bloc input[type="radio"]').forEach(radio => {
        radio.addEventListener('change', () => {
            document.getElementById('connect_bloc').style.display = 
                document.getElementById('connect_radio').checked ? 'flex' : 'none';
            
            document.getElementById('register_bloc').style.display = 
                document.getElementById('register_radio').checked ? 'flex' : 'none';
        });
    });
};

/* Check password conformity */

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


