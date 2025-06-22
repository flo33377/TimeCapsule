/* Fonctions qui permet d'afficher les modales de la page */

// Ouvre la 1ère modale de la page

let getDialogBox = document.getElementById('dialog1');
let showModaleButton = document.getElementById('showModaleButton');
let closeModaleButton = document.getElementById('close_popup');

if(showModaleButton) {
showModaleButton.addEventListener('click', () => {
    getDialogBox.showModal();
    //getDialogBox.style.top = `${(window.innerHeight - getDialogBox.offsetHeight) / 2}px`;
    getDialogBox.style.left = `${(window.innerWidth - getDialogBox.offsetWidth) / 2}px`
})

closeModaleButton.addEventListener('click', () =>
    getDialogBox.close()
)

getDialogBox.addEventListener('click', (event) => {
    if (event.target === getDialogBox) {
        getDialogBox.close();
    }
});
};

// Si 2e modale sur la page, ouvre la 2e modale
// Meilleure solution à trouver

let getDialogBox2 = document.getElementById('dialog2');
let showModaleButton2 = document.getElementById('showModaleButton2');
let closeModaleButton2 = document.getElementById('close_popup2');

if (getDialogBox2) {
showModaleButton2.addEventListener('click', () => {
    getDialogBox2.showModal();
    getDialogBox2.style.top = `${(window.innerHeight - getDialogBox2.offsetHeight) / 2}px`;
    getDialogBox2.style.left = `${(window.innerWidth - getDialogBox2.offsetWidth) / 2}px`
})

closeModaleButton2.addEventListener('click', () =>
    getDialogBox2.close()
)

getDialogBox2.addEventListener('click', (event) => {
    if (event.target === getDialogBox2) {
        getDialogBox2.close();
    }
});
};

