
/* preview color create new memory */

let decorationChoice = document.getElementById('patern_memory');

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

// function to display optionnal fields

function toggleDetails(fieldId, triggerEl) {
    const content = document.getElementById(fieldId);
  
    if (content.classList.contains('visible')) {
      // Lancer le fade-out
      content.classList.remove('visible');
      content.classList.add('fading-out');
      triggerEl?.classList.remove('active');
  
      // Après la transition, cacher le contenu
      content.addEventListener('transitionend', function handler() {
        //transitionned = seulement quand anim terminée (timeout quand terminée)
        content.classList.remove('fading-out');
        content.style.display = 'none';
        content.removeEventListener('transitionend', handler);
      });
    } else {
      // Affiche le bloc d'abord, puis applique la classe visible pour lancer la transition
      content.style.display = 'flex';
      requestAnimationFrame(() => {
        content.classList.add('visible');
      });
      triggerEl?.classList.add('active');
    }
  }  


/* Preview Memory function */

let pinHTML = '<img src="https://fneto-prod.fr/timecapsule/img/pin.png" class="pin_memory" alt="Epingle">';
let starStickerHTML = '<img src="https://fneto-prod.fr/timecapsule/img/starsticker.png" class="starsticker_memory" alt="Sticker étoile">';
let scotchHTML = '<img src="https://fneto-prod.fr/timecapsule/img/scotchtape.png" class="scotch_memory_left" alt="Scotch">'+
'<img src="https://fneto-prod.fr/timecapsule/img/scotchtape.png" class="scotch_memory_right" alt="Scotch">'

let previewMemoryPhoto = document.getElementById('photo_memory_preview');

if (previewMemoryPhoto) { // on est sur la page create memory
    let playRefreshPreviewMemory = document.getElementById('memory_preview_btn_refresh');
    let backgChoiceRadio = document.getElementsByName('backg_value');
    let memoryCreationColorBlock = document.getElementById('memory_color_content');
    let memoryCreationPaternBlock = document.getElementById('memory_patern_content');

    // fonction qui va chercher l'état du radio
    function getSelectedBackgOption(radioOptionsBackg) {
        for (i = 0; i < radioOptionsBackg.length; i++) {
            if (radioOptionsBackg[i].checked) {
            return backgOptionChosen = radioOptionsBackg[i].value; //renvoie la valur sélectionnée
            break;
            }
        }
        return null; //renvoie null par défaut si radio vide 
    }

    // fonction afficher le bloc couleur ou patern
    function memoryBackgDisplay(radioOptionsBackg) {
        let selectedOption = getSelectedBackgOption(radioOptionsBackg);
    
        if (selectedOption === 'color') {
            memoryCreationColorBlock.style.display = 'flex';
            memoryCreationPaternBlock.style.display = 'none';
        } else {
            memoryCreationPaternBlock.style.display = 'flex';
            memoryCreationPaternBlock.style.height = 'fit-content';
            memoryCreationColorBlock.style.display = 'none';
        }
    
        return selectedOption; // permet de réutiliser la valeur ailleurs
    }
    
    // event déclencheur sur le radio color
    let ChoiceFormatPreviewPolaroid = document.getElementById('backg_color');
    ChoiceFormatPreviewPolaroid.addEventListener('change', () => {
    memoryBackgDisplay(backgChoiceRadio);
    });
    
    // event déclencheur sur le radio patern
    let ChoiceFormatPreviewNotes = document.getElementById('backg_patern');
    ChoiceFormatPreviewNotes.addEventListener('change', () => {
    memoryBackgDisplay(backgChoiceRadio);
    });
    // fin de la fonction pour afficher le bloc couleur ou patern


    // partie refresh de la preview memory
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

        // Mise à jour de la couleur de fond
        let containerMemoryPreview = document.getElementById('memory_preview_container');
        let backgOptionChosen = memoryBackgDisplay(backgChoiceRadio);

        memoryBackgDisplay(backgChoiceRadio);
        if(backgOptionChosen == 'color') {
            let colorChosen = document.getElementById('color_memory');
            containerMemoryPreview.style.backgroundColor = colorChosen.value;
            containerMemoryPreview.style.backgroundImage = '';
        } else {
            let paternChosen = document.getElementById('patern_memory');
            containerMemoryPreview.style.backgroundColor = '';
            containerMemoryPreview.style.backgroundImage = `url('${paternChosen.value}')`;
        }
    
        // Mise à jour de la couleur et fond des textes
        let blocTexteMemoryPreview = document.getElementById('text_memory_preview');
        let colorFontMemoryPreview = document.getElementById('text_memory_color');
        let colorBackgFontMemoryPreview = document.getElementById('backg_font_memory');
        blocTexteMemoryPreview.style.backgroundColor = colorBackgFontMemoryPreview.value;
        blocTexteMemoryPreview.style.color = colorFontMemoryPreview.value;
    
        // Mise à jour de la déco additionnelle
        decorationChosenMemory = document.getElementById('decoration_memory').value;

        document.querySelectorAll('.pin_memory, .starsticker_memory, .scotch_memory_left, .scotch_memory_right')
    .forEach(el => el.remove());

        if (decorationChosenMemory === 'pin') {
            const pin = document.createElement('img');
            pin.src = "https://fneto-prod.fr/timecapsule/img/pin.png";
            pin.alt = "Epingle";
            pin.className = "pin_memory";
        
            // Insertion AVANT le conteneur
            containerMemoryPreview.parentNode.insertBefore(pin, containerMemoryPreview);
        }
        
        else if (decorationChosenMemory === 'starsticker') {
            const sticker = document.createElement('img');
            sticker.src = "https://fneto-prod.fr/timecapsule/img/starsticker.png";
            sticker.alt = "Sticker étoile";
            sticker.className = "starsticker_memory";
        
            // Insertion EN PREMIER dans le conteneur
            containerMemoryPreview.insertBefore(sticker, containerMemoryPreview.firstChild);
        }
        
        else if (decorationChosenMemory === 'scotch') {
            const left = document.createElement('img');
            left.src = "https://fneto-prod.fr/timecapsule/img/scotchtape.png";
            left.alt = "Scotch";
            left.className = "scotch_memory_left";
        
            const right = document.createElement('img');
            right.src = "https://fneto-prod.fr/timecapsule/img/scotchtape.png";
            right.alt = "Scotch";
            right.className = "scotch_memory_right";
        
            // Insertion EN PREMIER dans le conteneur
            containerMemoryPreview.insertBefore(right, containerMemoryPreview.firstChild); // right en premier car l’ordre compte
            containerMemoryPreview.insertBefore(left, containerMemoryPreview.firstChild);  // left sera donc tout premier
        }
    }
);
}







