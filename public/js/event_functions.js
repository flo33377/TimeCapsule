
/* Pagination listing events HP */

if(document.getElementById('eventContainer')) { // error management
    const itemsPerPage = 4; //nbr item par page
    let currentPage = 0; // default setting

    function renderPage(page) { // MàJ les blocs events
    const container = document.getElementById('eventContainer');
    container.innerHTML = ''; // reset avant changement event affichés

    const start = page * itemsPerPage; // index of 1st event to display on this page
    const end = start + itemsPerPage; // index of last event to display
    console.log(allLists);
    const visibleItems = allLists.slice(start, end);

    visibleItems.forEach((item, index) => {
        const div = document.createElement('div');
        div.classList.add('bloc_event_listing', 'slide-in');
        div.style.backgroundColor = item.main_color;
        div.style.backgroundImage = `url('${item.event_logo}')`;
        const delay = index * 0.1;
        div.style.animation= `slideIn 0.5s linear ${delay}s both`;
        div.innerHTML = `
        <a class="list_available" href="./?event=${item.event_id}">
            <div class="label_event">
                <p>${item.event_name}</p>
            </div>
        </a>
        `;
        container.appendChild(div);
    });

    renderPagination(page);
    }

    function renderPagination(current) { // MàJ la pagination
        const totalPages = Math.ceil(allLists.length / itemsPerPage); // nbr total pages
        const controlsNbr = document.getElementById('paginationControls');
        controlsNbr.innerHTML = ''; // reset avant changements
        const controlsArrowLeft = document.getElementById('nav_arrow_left');
        const controlsArrowRight = document.getElementById('nav_arrow_right');
      
        // Déterminer les indices des pages à afficher
        let startPage = Math.max(current - 1, 0); // compare et prend le + grand pour
        // ne pas prendre de nbr négatif
        let endPage = Math.min(startPage + 2, totalPages - 1); // compare et prend le
        // + petit pour ne pas dépasser le nbr max de pages
      
        // Si écart trop petit c'est qu'on est à la fin donc on recule dans la pagination
        // mais s'assure de ne pas passer en négatif
        if (endPage - startPage < 2) {
          startPage = Math.max(endPage - 2, 0);
        }
      
        // génère pour chaque chiffre son num + bouton
        for (let i = startPage; i <= endPage; i++) {
          const btn = document.createElement('button');
          btn.textContent = i + 1;
          if (i === current) {
            btn.disabled = true;
            btn.classList.add('active_pagination');
          }
      
          btn.addEventListener('click', () => { // met un event dessus pour changement page
            currentPage = i;
            renderPage(currentPage);
          });
      
          controlsNbr.appendChild(btn); // ajout le num, btn et event dans le DOM
        }

        if(current === 0) {
            controlsArrowLeft.style.display = "none";
        } else {
            controlsArrowLeft.style.display = 'flex';
            controlsArrowLeft.addEventListener('click', () =>
                renderPage(current - 1));
        }

        const lastPage = (Math.ceil(allLists.length / itemsPerPage)) - 1; // num de la dernière page
        // comme index commence à 0 et que length commence à 1 on retire -1

        if(current == lastPage) {
            controlsArrowRight.style.display = "none";
        } else {
            controlsArrowRight.style.display = 'flex';
            controlsArrowRight.addEventListener('click', () =>
                renderPage(current + 1));
        }

      }
      
    renderPage(currentPage); // lancement par défaut à l'exécution de la page

};


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

let warningMainColorNotLightHTML = `<p id='warning_main_color_light'>
Attention : la couleur principale sélectionnée étant claire, les icones de navigation 
seront en noir.<br>(cf. Prévisualisation)</p>`;

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
        const passwordEvent = shareBtn.dataset.password;

        if (navigator.share) {
            shareBtn.addEventListener('click', async (e) => {
                // async permet d'utiliser await dans la fonction et d'indiquer qu'on est sur une manip 
                // qui va débuter puis se terminer (ex : appel API, partage via navigator.share)
                // await permet de détecter le moment où terminé et d'effectuer une action si besoin à la fin
                e.preventDefault();
                try {
                    if(passwordEvent) {
                        await navigator.share({
                            title: document.title,
                            text: `J'ai créé un site pour l'événement : ${eventName}. 
                            Viens-y déposer tes photos toi aussi ! Voici le mot de passe pour y accéder : ${passwordEvent}`,
                            url: window.location.href
                        });    
                    } else {
                        await navigator.share({
                            title: document.title,
                            text: `J'ai créé un site pour l'événement : ${eventName}. Viens-y déposer tes photos toi aussi !`,
                            url: window.location.href
                        });
                    }
                    // avec await, on mettrait ici l'action à effectuer après partage ok (console.log)
                } catch (err) {
                    if(err.name != 'AbortError') {
                    console.error("Erreur lors du partage :", err);
                    // Fallback si l'utilisateur annule ou si l'API échoue
                    window.location.href = fallbackUrl;
                }}
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


/* Fonction qui renvoie vers la page de login avec form d'inscription ouvert */

registerRedirectionButton = document.getElementById('register_redirection')
if(registerRedirectionButton) {
registerRedirectionButton.addEventListener('click', async (e) => {
    e.preventDefault(); // évite un éventuel comportement par défaut du lien
    try {
        await fetch('./src/api/focus_register_login_page.php');
        window.location.href = './users/'; // redirige vers la page de login
    } catch (error) {
        console.error("Erreur lors de la redirection :", error);
    }
});
};

