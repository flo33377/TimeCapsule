// Open 1st modal of the page

let getDialogBox = document.getElementById('dialog1');
let showModaleButton = document.getElementById('showModaleButton');
let closeModaleButton = document.getElementById('close_popup');

showModaleButton.addEventListener('click', () => {
    getDialogBox.showModal();
    getDialogBox.style.top = `${(window.innerHeight - getDialogBox.offsetHeight) / 2}px`;
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

// If 2nd modal in the page - VOIR AVEC JULIEN S'IL A SOLUTION

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


/* Preview color */

let mainColorChoice = document.getElementById('main_color');

if (mainColorChoice) {
    mainColorChoice.addEventListener('change', () => {
        let nuancierMainColor = document.getElementById("nuancier_main_color");
        nuancierMainColor.style.backgroundColor = mainColorChoice.value;
    });

    let secondaryColorChoice = document.getElementById('secondary_color');
    secondaryColorChoice.addEventListener('change', () => {
        let nuancierSecondaryColor = document.getElementById("nuancier_secondary_color");
        nuancierSecondaryColor.style.backgroundColor = secondaryColorChoice.value;
    });

    let fontColorChoice = document.getElementById('font_color');
    fontColorChoice.addEventListener('change', ( )=> {
        let nuancierFontColor = document.getElementById("nuancier_font_color");
        nuancierFontColor.style.backgroundColor = fontColorChoice.value;
    });
};


/* Preview function */

let previewLogoEvent = document.getElementById('preview_logo');

if (previewLogoEvent) {
    let playRefresh = document.getElementById('preview_button_refresh');
    playRefresh.addEventListener('click', () => {
    const [photo] = document.getElementById("new_event_logo").files;
    if (photo) {
        previewLogoEvent.src = URL.createObjectURL(photo);
    } else {
        previewLogoEvent.src = "https://fneto-prod.fr/timecapsule/img/timecapsule-logo.png";
    };

    let newEventValueTitle = document.getElementById('new_event_title');
    let newEventPreviewTitle = newEventValueTitle.value;
    document.getElementById('preview_title').innerHTML = newEventPreviewTitle;

    let newEventValueMainColor = document.getElementById('main_color');
    let newEventPreviewMainColor = newEventValueMainColor.value;
    document.getElementById('preview_header').style.backgroundColor = newEventPreviewMainColor;
    document.getElementById('preview_adding_button').style.backgroundColor = newEventPreviewMainColor;

    let newEventValueSecondaryColor = document.getElementById('secondary_color');
    let newEventPreviewSecondaryColor = newEventValueSecondaryColor.value;
    document.getElementById('preview_whole').style.backgroundColor = newEventPreviewSecondaryColor;

    let newEventValueFontColor = document.getElementById('font_color');
    let newEventPreviewFontColor = newEventValueFontColor.value;
    document.getElementById('preview_title').style.color = newEventPreviewFontColor;

    });

};
