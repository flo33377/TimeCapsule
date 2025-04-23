/* Système de preview color dans les color pickers */

document.addEventListener('DOMContentLoaded', () => {
    const colorPickers = document.querySelectorAll('.custom-color-picker');

    colorPickers.forEach(picker => {
        const input = picker.querySelector('.real-color-input');
        const circle = picker.querySelector('.color-circle');

        // Init couleur par défaut
        circle.style.backgroundColor = input.value;

        // Clique sur le cercle => déclenche l’input
        circle.addEventListener('click', () => input.click());

        // Mise à jour de la couleur du cercle quand l’utilisateur choisit une nouvelle couleur
        input.addEventListener('input', () => {
            circle.style.backgroundColor = input.value;
        });
    });
});

// Fonction qui calcule si couleur est trop claire pour utiliser icone blanche
// cf. nav buttons

function isLightColor(hexColor) {
    // Supprimer le # si présent
    hexColor = hexColor.replace(/^#/, '');

    // Si format court (#fff), l'étendre à 6 caractères
    if (hexColor.length === 3) {
        hexColor = hexColor.split('').map(c => c + c).join('');
    }

    // Convertir les composants hexadécimaux en décimal
    const r = parseInt(hexColor.substring(0, 2), 16);
    const g = parseInt(hexColor.substring(2, 4), 16);
    const b = parseInt(hexColor.substring(4, 6), 16);

    // Calcul de luminance
    const luminance = (0.299 * r + 0.587 * g + 0.114 * b);

    // Retourne true si la couleur est claire
    return luminance > 186;
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
    let newEventNavButtons = document.getElementsByClassName('preview_btn_each');
    let newEventPreviewMainColor = newEventValueMainColor.value;
    document.getElementById('preview_header').style.backgroundColor = newEventPreviewMainColor;
    for(let i = 0; i < newEventNavButtons.length; i++) {
        newEventNavButtons[i]. style.backgroundColor = newEventPreviewMainColor;
        const picto = newEventNavButtons[i].querySelector('img');
        if(picto) {
        picto.style.filter = isLightColor(newEventPreviewMainColor) ? 'invert(0)' : 'invert(1)';
        }
    }

    let newEventValueSecondaryColor = document.getElementById('secondary_color');
    let newEventPreviewSecondaryColor = newEventValueSecondaryColor.value;
    document.getElementById('preview_whole').style.backgroundColor = newEventPreviewSecondaryColor;

    let newEventValueFontColor = document.getElementById('font_color');
    let newEventPreviewFontColor = newEventValueFontColor.value;
    document.getElementById('preview_title').style.color = newEventPreviewFontColor;

    });

};

// Preview event fonction - avertissement de couleur trop claire => picto en blanc

let warningMainColorNotLightHTML = "<p id='warning_main_color_light'>Attention : la couleur principale " +
"sélectionnée étant claire, les icones de navigation seront en noir.<br>(cf. Prévisualisation)</p>";

let newEventMainColorPicker = document.getElementById('main_color');

if (newEventMainColorPicker) {
    newEventWarningBloc = document.getElementById('new_event_main_color_comment');
    newEventMainColorPicker.addEventListener('change', () => {
        let currentMainColor = newEventMainColorPicker.value;
        let warningMessageDisplayed = document.getElementById('warning_main_color_light');
        if(isLightColor(currentMainColor)) {
            if(!warningMessageDisplayed) {
                newEventWarningBloc.innerHTML = warningMainColorNotLightHTML;
            };
        } else {
            if(warningMessageDisplayed) {
                warningMessageDisplayed.remove();
            }
        };
    })
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

    if(copyBtn) {
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
}});


