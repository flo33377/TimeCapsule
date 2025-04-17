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

if (decorationChoice) {
    decorationChoice.addEventListener('change', () => {
        let nuancierDecoration = document.getElementById('nuancier_decoration');
        let nuancierDecoValue = decorationChoice.value;

        // Si la valeur est une URL (donc un motif)
        if (nuancierDecoValue.includes('fneto-prod.fr')) {
            nuancierDecoration.style.backgroundImage = `url('${nuancierDecoValue}')`;
            nuancierDecoration.style.backgroundColor = "";
        } else {
            // Sinon on considère que c’est une couleur
            nuancierDecoration.style.backgroundColor = nuancierDecoValue;
            nuancierDecoration.style.backgroundImage = "";
        }
    });
}


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
        // Aperçu de la photo
        const [photo] = document.getElementById("photo_memory").files;
        if (photo) {
            previewMemoryPhoto.src = URL.createObjectURL(photo);
        }

        // Mise à jour du titre
        let newMemoryValueTitle = document.getElementById('title').value;
        document.getElementById('title_memory_preview').innerHTML = newMemoryValueTitle;

        // Mise à jour de l’auteur
        let newMemoryValueAuthor = document.getElementById('author').value;
        document.getElementById('author_memory_preview').innerHTML = newMemoryValueAuthor;

        // Mise à jour de la décoration
        let newMemoryPreviewDecoration = document.getElementById('color').value;
        let previewContainer = document.getElementById('memory_preview_container');

        if (newMemoryPreviewDecoration.includes('fneto-prod.fr')) {
            // C’est une image de fond
            previewContainer.style.backgroundImage = `url('${newMemoryPreviewDecoration}')`;
            previewContainer.style.backgroundColor = "";
        } else {
            // C’est une couleur CSS
            previewContainer.style.backgroundColor = newMemoryPreviewDecoration;
            previewContainer.style.backgroundImage = "";
        }
    });
}


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


/* Sharing function for nav button */

document.addEventListener('DOMContentLoaded', () => {
    const shareBtn = document.getElementById('shareBtn');
    if (shareBtn) {
        const fallbackUrl = shareBtn.dataset.href;
        const eventName = shareBtn.dataset.name;

        if (navigator.share) {
            shareBtn.addEventListener('click', async (e) => {
                // async permet d'utiliser await dans la fonction et d'indiquer qu'on est sur une manip 
                // qui va débuter puis se terminer (ex : appel API, partage via navigator.share)
                // await permet de détecter le moment où terminé et d'effectuer une action si besoin à la fin
                e.preventDefault();
                try {
                    await navigator.share({
                        title: document.title,
                        text: `J'ai créé un site pour l'événement : ${eventName}. Viens-y déposer tes photos toi aussi !`,
                        url: window.location.href
                    });
                    // avec await, on mettrait ici l'action à effectuer après partage ok (console.log)
                } catch (err) {
                    console.error("Erreur lors du partage :", err);
                    // Fallback si l'utilisateur annule ou si l'API échoue
                    window.location.href = fallbackUrl;
                }
            });
        } else {
            // Si Web Share API non disponible
            shareBtn.addEventListener('click', (e) => {
                e.preventDefault();
                window.location.href = fallbackUrl;
            });
        }
    }
});


/* COPY FUNCTION FOR SHARING TEXT*/

document.addEventListener('DOMContentLoaded', () => {
    const copyBtn = document.getElementById('CopyTextShareBtn');
    const textArea = document.getElementById('sharingTextArea');
    const messageConfirmCopyOK = document.getElementById('copyMessage');

    copyBtn.addEventListener('click', async () => {
        try {
            await navigator.clipboard.writeText(textArea.value);

            // Slide in (depuis le bas)
            messageConfirmCopyOK.style.opacity = '1';
            messageConfirmCopyOK.style.transform = 'translateX(-50%) translateY(-30px)';
            messageConfirmCopyOK.style.bottom = '40px';

            // Slide out après 3 secondes
            setTimeout(() => {
                messageConfirmCopyOK.style.opacity = '0';
                messageConfirmCopyOK.style.transform = 'translateX(-50%) translateY(100px)';
                messageConfirmCopyOK.style.bottom = '-100px';
            }, 2000);
        } catch (err) {
            console.error('Erreur lors de la copie :', err);
            alert("La copie a échoué.");
        }
    });
});







