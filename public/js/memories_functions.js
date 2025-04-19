
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


/* New memory - Function displaying nuancier or selected based on the input */

/*
let backgChoiceRadio = document.getElementsByName('backg_value');

if(backgChoiceRadio) {
    let backgOptionChosen;
    let memoryCreationColorBlock = document.getElementById('memory_color_content');
    let memoryCreationPaternBlock = document.getElementById('memory_patern_content');

        // commun part
    function memoryBackgDisplay(radioOptionsBackg) {
    //va chercher le choix du radio

    for (i = 0; i < radioOptionsBackg.length; i++) {
        if (radioOptionsBackg[i].checked) {
        backgOptionChosen = radioOptionsBackg[i].value;
        break;
        }
    }

    // part for the nuancier preview system
    if (backgOptionChosen == 'color') {
        memoryCreationColorBlock.style.display = 'flex';
        memoryCreationPaternBlock.style.display = 'none';
    } else {
        memoryCreationPaternBlock.style.display = 'flex';
        memoryCreationPaternBlock.style.height = 'fit-content';
        memoryCreationColorBlock.style.display = 'none';
    }
    };

    let ChoiceFormatPreviewPolaroid = document.getElementById('backg_color');
    ChoiceFormatPreviewPolaroid.addEventListener('change', () => {
    memoryBackgDisplay(backgChoiceRadio);
    });

    let ChoiceFormatPreviewNotes = document.getElementById('backg_patern');
    ChoiceFormatPreviewNotes.addEventListener('change', () => {
    memoryBackgDisplay(backgChoiceRadio);
    });

    // part for the memory preview system
    let refreshPreviewMemoryBtn = document.getElementById('memory_preview_btn_refresh');
    let backgMemoryPreview = document.getElementById('memory_preview_container');
    let colorChosen = document.getElementById('color_memory');
    let paternChosen = document.getElementById('patern_memory');

    refreshPreviewMemoryBtn.addEventListener('click', () => {
    if(backgOptionChosen == 'color') {
        backgMemoryPreview.style.backgroundColor = colorChosen.value;
        backgMemoryPreview.style.backgroundImage = '';
    } else {
        backgMemoryPreview.style.backgroundColor = '';
        backgMemoryPreview.style.backgroundImage = paternChosen.value;
    }}
)

};

*/

/* Preview Memory function */

/*
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

*/


/* Preview Memory function */

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

        // Mise à jour de la décoration
        let backgMemoryPreview = document.getElementById('memory_preview_container');
        let backgOptionChosen = memoryBackgDisplay(backgChoiceRadio);

        memoryBackgDisplay(backgChoiceRadio);
        if(backgOptionChosen == 'color') {
            console.log("dans boucle couleur");
            let colorChosen = document.getElementById('color_memory');
            console.log(colorChosen.value);
            backgMemoryPreview.style.backgroundColor = colorChosen.value;
            backgMemoryPreview.style.backgroundImage = '';
        } else {
            console.log("dans boucle patern");
            let paternChosen = document.getElementById('patern_memory');
            backgMemoryPreview.style.backgroundColor = '';
            backgMemoryPreview.style.backgroundImage = `url('${paternChosen.value}')`;
        }}
);
}







