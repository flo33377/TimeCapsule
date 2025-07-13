
// Fonctions liées aux évènements (HP + page de chaque event)

/* Pagination du listing des events
Utilisé pour la HP et pour le listing des events propriétaire de la page user */

if(document.getElementById('eventContainer')) { // gestion des erreurs
    const itemsPerPage = 4; //nbr item par page
    let currentPage = 0; // page affichée par défaut

    // Fonction qui MàJ les events affichés
    function renderPage(page) {
    const container = document.getElementById('eventContainer');
    container.innerHTML = ''; // reset initial

    const start = page * itemsPerPage; // index de l'évènement juste avant le 1er à afficher
    const end = start + itemsPerPage; // index du dernier évènement à afficher
    const visibleItems = allLists.slice(start, end);

    visibleItems.forEach((item, index) => {
        const div = document.createElement('div');
        div.classList.add('bloc_event_listing', 'slide-in');
        div.style.backgroundColor = item.main_color;
        div.style.backgroundImage = `url('${item.event_logo}')`;
        const delay = index * 0.1;
        div.style.animation= `slideIn 0.5s linear ${delay}s both`; // décalage du slideIn de chaque évènement
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

    function renderPagination(current) {
        // Fonction qui MàJ la pagination
        const totalPages = Math.ceil(allLists.length / itemsPerPage); // nbr total pages
        const controlsNbr = document.getElementById('paginationControls');
        controlsNbr.innerHTML = ''; // reset initial
        const controlsArrowLeft = document.getElementById('nav_arrow_left');
        const controlsArrowRight = document.getElementById('nav_arrow_right');
      
        // Déterminer les indices des pages à afficher

        let startPage = Math.max(current - 1, 0);
        // compare et prend le + grand pour ne pas prendre de nbr négatif
        let endPage = Math.min(startPage + 2, totalPages - 1);
        // compare et prend le + petit pour ne pas dépasser le nbr max de pages
      
        // Si écart trop petit c'est qu'on est à la fin donc on recule dans la pagination
        // mais s'assure de ne pas passer en négatif
        if (endPage - startPage < 2) {
          startPage = Math.max(endPage - 2, 0);
        }
      
        // génère pour chaque chiffre son num + bouton
        for (let i = startPage; i <= endPage; i++) {
          const btn = document.createElement('button');
          btn.textContent = i + 1; // car index commence à 0
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
            // si ne peut pas reculer, désactive la flèche de gauche
            controlsArrowLeft.style.visibility = "hidden";
            controlsArrowLeft.style.pointerEvents = "none";
        } else {
            // sinon l'affiche
            controlsArrowLeft.style.visibility = 'visible';
            controlsArrowLeft.style.pointerEvents = 'auto';
            controlsArrowLeft.addEventListener('click', () =>
                renderPage(current - 1));
        }

        const lastPage = (Math.ceil(allLists.length / itemsPerPage)) - 1; // num de la dernière page
        // comme index commence à 0 et que length commence à 1 on fait -1

        if(current == lastPage) {
            // si on ne peut pas aller plus loin, désactive la flèche de droite
            controlsArrowRight.style.visibility = "hidden";
            controlsArrowRight.style.pointerEvents = "none";
        } else {
            // sinon l'affiche
            controlsArrowRight.style.visibility = 'visible';
            controlsArrowRight.style.pointerEvents = 'auto';
            controlsArrowRight.addEventListener('click', () =>
                renderPage(current + 1));
        }

      }
      
    renderPage(currentPage); // lancement par défaut à l'exécution de la page

};

// A SUPPR
/* Système de color picker - Affiche couleur selectionnée dans un rond */

document.addEventListener('DOMContentLoaded', () => {
    const colorPickers = document.querySelectorAll('.custom-color-picker');

    colorPickers.forEach(picker => {
        const input = picker.querySelector('.real-color-input');
        const circle = picker.querySelector('.color-circle');

        // Set couleur par défaut
        circle.style.backgroundColor = input.value;

        // Déclenche l'input quand on clique sur le color picker
        circle.addEventListener('click', () => input.click());

        // MàJ de la couleur du cercle en cas de changement de couleur
        input.addEventListener('input', () => {
            circle.style.backgroundColor = input.value;
        });
    });
});


/* Système de preview du design des évènements lors de leur création/modification */

let previewLogoEvent = document.getElementById('preview_logo');

let logoAlreadyUploaded = document.getElementById('post_change_logo_colors'); 
// Ne veut true que si on est sur l'interface de modif d'un event, pas sur la page de création

if (previewLogoEvent) { // gestion des erreurs
    let playRefreshPreviewEvent = document.getElementById('preview_event_btn_refresh');
    // event sur le bouton refresh la preview
    playRefreshPreviewEvent.addEventListener('click', () => {
    const [logo] = document.getElementById("new_event_logo").files;
    if (logo) {
        // si logo upload/nouveau logo upload, utilise un blob
        previewLogoEvent.src = URL.createObjectURL(logo);
    } else {
        // sinon, se sert de celui déjà en BDD ou en set un par défaut
        if(!logoAlreadyUploaded) {
        previewLogoEvent.src = "https://fneto-prod.fr/timecapsule/img/timecapsule-logo.png";
    }};

    let newEventValueMainColor = document.getElementById('main_color');
    let newEventNavButtons = document.getElementsByClassName('preview_btn_each');
    let newEventPreviewMainColor = newEventValueMainColor.value; // récupère la nouvelle couleur principale
    document.getElementById('preview_header').style.backgroundColor = newEventPreviewMainColor; // MàJ le header avec cette couleur
    for(let i = 0; i < newEventNavButtons.length; i++) {
        // MàJ toutes les icones de nav avec la nouvelle couleur
        newEventNavButtons[i]. style.backgroundColor = newEventPreviewMainColor;
        const picto = newEventNavButtons[i].querySelector('img');
        if(picto) {
            // si cette couleur est claire, passe les picto en blanc
            picto.style.filter = isLightColor(newEventPreviewMainColor) ? 'invert(0)' : 'invert(1)';
        }
    }

    let newEventValueSecondaryColor = document.getElementById('secondary_color');
    let newEventPreviewSecondaryColor = newEventValueSecondaryColor.value;
    document.getElementById('preview_whole').style.backgroundColor = newEventPreviewSecondaryColor;
    // récup la couleur secondaire et MàJ le background avec

    let newEventValueFontColor = document.getElementById('font_color');
    let newEventPreviewFontColor = newEventValueFontColor.value;
    document.getElementById('preview_title').style.color = newEventPreviewFontColor;
    // récup la couleur de font et MàJ les textes avec

    });

};


/* Fonction de like des memories - via requête AJAX */

document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".like-checkbox").forEach(checkbox => {
        checkbox.addEventListener("change", function () {
            // Ajoute un event change à chaque checkbox de like
            let memoryId = this.dataset.id; // récup l'id du souvenir
            let currentNbrLikesImport = this.dataset.nbrlikes; // récup le nbr de likes sur le souvenir au chargement de la page

            let newNbrOfLikes = parseInt(currentNbrLikesImport);
            newNbrOfLikes++; // fait +1 sur le nbr de likes

            const formdata = new FormData();
            // fait un form data avec les infos à renvoyer en BDD
            formdata.append("memoryId", memoryId);
            formdata.append("newNbrOfLikes", newNbrOfLikes);

            fetch("./src/updateLikesNbr.php", {
                // déclenche la fonction de MàJ de BDD
                method: "POST",
                body: formdata
            })
            .then(response => { let reponse = response.text(); console.log(reponse) })

            // désactive le multi-like une fois cliquée
            this.disabled = true;

            // update le nombre de likes à +1 dans le texte affiché
            let likesBloc = this.closest(".likes_bloc");
            let spanLikes = likesBloc.querySelector(".nbr_likes");
            if (spanLikes) {
                spanLikes.textContent = newNbrOfLikes;
            };

            // remplace par la nouvelle image (qui veut dire que désactivé)
            let imgIcon = this.parentElement.querySelector("img");
            if (imgIcon) {
                imgIcon.src = "https://fneto-prod.fr/timecapsule/img/heart_icon_full.png";
            }

            imgIcon.classList.add("animate-heart");
            // ajoute la class qui set l'animation

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
            // au chargement, remplace l'icone par celle qui indique que déjà liké
            let imgIcon = checkbox.parentElement.querySelector("img");
            if (imgIcon) {
                imgIcon.src = "https://fneto-prod.fr/timecapsule/img/heart_icon_full.png";
            }
        } 
    })
});


/* Nav button - fonction de partage */

document.addEventListener('DOMContentLoaded', () => {
    const shareBtn = document.getElementById('shareBtn');
    if (shareBtn) {
        // récupère les infos pour le bon fonctionnement
        const fallbackUrl = shareBtn.dataset.href;
        const eventName = shareBtn.dataset.name;
        const passwordEvent = shareBtn.dataset.password;

        if (navigator.share) {
            // si Web Share API est dispo, la déclenche
            shareBtn.addEventListener('click', async (e) => {
                // async permet d'utiliser await dans la fonction et d'indiquer qu'on est sur une manip 
                // qui va débuter puis se terminer (ex : appel API, partage via navigator.share)
                // await permet de détecter le moment où terminé et d'effectuer une action si besoin à la fin
                e.preventDefault();
                try {
                    if(passwordEvent) {
                        await navigator.share({
                            // si event avec mot de passe, texte avec mot de passe
                            title: document.title,
                            text: `J'ai créé un site pour l'événement : ${eventName}. 
                            Viens-y déposer tes photos toi aussi ! Voici le mot de passe pour y accéder : ${passwordEvent}`,
                            url: window.location.href
                        });    
                    } else {
                        await navigator.share({
                            // sinon texte sans mot de passe
                            title: document.title,
                            text: `J'ai créé un site pour l'événement : ${eventName}. Viens-y déposer tes photos toi aussi !`,
                            url: window.location.href
                        });
                    }
                    // avec await, on mettrait ici l'action à effectuer après partage ok (ex : console.log)
                } catch (err) {
                    if(err.name != 'AbortError') {
                    console.error("Erreur lors du partage :", err);
                    // Fallback si l'utilisateur annule ou si l'API échoue
                    window.location.href = fallbackUrl;
                }}
            });
        } else {
            // Si Web Share API non disponible, envoie sur la page de partage
            shareBtn.addEventListener('click', (e) => {
                e.preventDefault();
                window.location.href = fallbackUrl;
            });
        }
    }
});


/* Fonction de copie de texte pour partage sans Web Share API */

document.addEventListener('DOMContentLoaded', () => {
    const copyBtn = document.getElementById('CopyTextShareBtn');
    const textArea = document.getElementById('sharingTextArea');
    const messageConfirmCopyOK = document.getElementById('copyMessage');

    if(copyBtn) {
    copyBtn.addEventListener('click', async () => {
        try {
            // copie le texte dans le presse papier
            await navigator.clipboard.writeText(textArea.value);

            // Affichage de la notif de copie - Slide in (depuis le bas)
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


/* Fonction qui renvoie vers la page de login avec form d'inscription ouvert
Déclenché si qlq'un veut créer event sans être connecté */

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

/* User avec 5 events essaie d'en créer un autre
=> renvoie vers p. profil avec message d'avertissement */

maxEventsReachedRedirectionButton = document.getElementById('max_events_redirection')
if(maxEventsReachedRedirectionButton) {
maxEventsReachedRedirectionButton.addEventListener('click', async (e) => {
    e.preventDefault(); // évite un éventuel comportement par défaut du lien
    try {
        window.location.href = './users/'; // redirige vers la page de login
    } catch (error) {
        console.error("Erreur lors de la redirection :", error);
    }
});
};



