// Open 1st modal of the page

let getDialogBox = document.getElementById('dialog1');
let showModaleButton = document.getElementById('showModaleButton');
let closeModaleButton = document.getElementById('close_popup');

if(showModaleButton) {
showModaleButton.addEventListener('click', () => {
    // avant de placer l'évent, vérifie que l'elem est sur la page pour éviter les erreurs console
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


/* Preview color event */

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

/* preview color create new memory */

let decorationChoice = document.getElementById('color');

if(decorationChoice) {
    decorationChoice.addEventListener('change', () => {
        let nuancierDecoration = document.getElementById('nuancier_decoration');
        let nuancierDecoValue = decorationChoice.value;
        if (nuancierDecoValue.includes('color')) {
            let valueCSSnuancier = nuancierDecoValue.slice(17);
            nuancierDecoration.style.backgroundColor = valueCSSnuancier;
            nuancierDecoration.style.backgroundImage = "";
          } else {
            let valueCSSnuancier = nuancierDecoValue.slice(17);
            nuancierDecoration.style.backgroundImage = valueCSSnuancier;
            nuancierDecoration.style.backgroundColor = "";
          };
    });
};


/* Preview Event function */

let previewLogoEvent = document.getElementById('preview_logo');
let logoAlreadyUploaded = document.getElementById('post_change_logo_colors'); // true only if we're on
    // the change logo/colors admin modal, not the create event page

if (previewLogoEvent) {
    let playRefreshPreviewEvent = document.getElementById('preview_event_btn_refresh');
    playRefreshPreviewEvent.addEventListener('click', () => {
    const [logo] = document.getElementById("new_event_logo").files;
    if (logo) {
        previewLogoEvent.src = URL.createObjectURL(logo);
    } else {
        if(!logoAlreadyUploaded) {
        previewLogoEvent.src = "https://fneto-prod.fr/timecapsule/img/timecapsule-logo.png";
    }};

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


/* Preview Memory function */

let previewMemoryPhoto = document.getElementById('photo_memory_preview');

if (previewMemoryPhoto) {
    let playRefreshPreviewMemory = document.getElementById('memory_preview_btn_refresh');
    playRefreshPreviewMemory.addEventListener('click', () => {
    const [photo] = document.getElementById("photo_memory").files;
    if (photo) {
        previewMemoryPhoto.src = URL.createObjectURL(photo);
    };

    let newMemoryValueTitle = document.getElementById('title');
    let newMemoryPreviewTitle = newMemoryValueTitle.value;
    document.getElementById('title_memory_preview').innerHTML = newMemoryPreviewTitle;

    let newMemoryValueAuthor = document.getElementById('author');
    let newMemoryPreviewAuthor = newMemoryValueAuthor.value;
    document.getElementById('author_memory_preview').innerHTML = newMemoryPreviewAuthor;

    let newMemoryValueDecoration = document.getElementById('color');
    let newMemoryPreviewDecoration = newMemoryValueDecoration.value;
    if (newMemoryPreviewDecoration.includes('color')) {
        let valueDecoration = newMemoryPreviewDecoration.slice(17);
        document.getElementById('memory_container').style.backgroundColor = valueDecoration;
        document.getElementById('memory_container').style.backgroundImage = "";
      } else {
        let valueDecoration = newMemoryPreviewDecoration.slice(17);
        document.getElementById('memory_container').style.backgroundImage = valueDecoration;
        document.getElementById('memory_container').style.backgroundColor = "";
      };

    });

};


/* Fonction de like des memories */

// AJAX request to update DB when checkbox updated

document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".like-checkbox").forEach(checkbox => {
        checkbox.addEventListener("change", function () {
            let memoryId = this.dataset.id; // get from the id
            let currentNbrLikesImport = this.dataset.nbrlikes;

            let newNbrOfLikes = parseInt(currentNbrLikesImport);
            newNbrOfLikes++;

            const formdata = new FormData();
            formdata.append("memoryId", memoryId);
            formdata.append("newNbrOfLikes", newNbrOfLikes);

            fetch("./src/updateLikesNbr.php", {
                method: "POST",
                body: formdata
            })
            .then(response => { let reponse = response.text(); console.log(reponse) })

            // disabled une fois cliquée
            this.disabled = true;

            // update le nombre de likes à +1
            let likesBloc = this.closest(".likes_bloc");
            let spanLikes = likesBloc.querySelector(".nbr_likes");
            if (spanLikes) {
                spanLikes.textContent = newNbrOfLikes;
            };

            // remplace par la nouvelle image
            let imgIcon = this.parentElement.querySelector("img");
            if (imgIcon) {
                imgIcon.src = "https://fneto-prod.fr/timecapsule/img/heart_icon_full.png";
            }

            imgIcon.classList.add("animate-heart");

            // supprimer la classe après timeout
            setTimeout(() => {
                imgIcon.classList.remove("animate-heart");
            }, 400); // ATTENTION : Doit matcher la durée de l'animation CSS

         })
    });
});

document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".like-checkbox").forEach(checkbox => { 
        if(checkbox.checked) {
            // remplace par la nouvelle image
            let imgIcon = checkbox.parentElement.querySelector("img");
            if (imgIcon) {
                imgIcon.src = "https://fneto-prod.fr/timecapsule/img/heart_icon_full.png";
            }
        } 
    })
});



