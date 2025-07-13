
// Fonctions liées aux couleurs


/* Fonction qui calcule si couleur est trop claire pour utiliser icone blanche dans les nav buttons */

function isLightColor(hexColor) {
    // Supprime le # si présent
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


/* Preview event fonction - avertissement de couleur trop claire => picto en blanc */

let warningMainColorNotLightHTML = `<p id='warning_main_color_light'>
Attention : la couleur principale sélectionnée étant claire, les icones de navigation 
seront en noir.<br>(cf. Prévisualisation)</p>`;

let newEventMainColorPicker = document.getElementById('main_color');

if (newEventMainColorPicker) { // gestion des erreurs
    newEventWarningBloc = document.getElementById('new_event_main_color_comment');
    newEventMainColorPicker.addEventListener('change', () => {
        // en cas de changement de couleur
        let currentMainColor = newEventMainColorPicker.value;
        let warningMessageDisplayed = document.getElementById('warning_main_color_light');
        if(isLightColor(currentMainColor)) {
            // check si la couleur est claire, si oui affiche le message
            if(!warningMessageDisplayed) {
                newEventWarningBloc.innerHTML = warningMainColorNotLightHTML;
            };
        } else {
            // sinon l'enlève s'il est déjà affiché 
            if(warningMessageDisplayed) {
                warningMessageDisplayed.remove();
            }
        };
    })
}


/* Color Picker via librairy Pickr */

// fonction de mise en place des color pickers
function initPickrs(scope = document) {
    const pickrElements = scope.querySelectorAll('.pickr-container:not([data-pickr-initialized])');
    // on ne sélectionne que ceux qui n'ont pas data-pickr-initialized à true, car on les set et
    // à la fin on les passe à true => pour ne pas reset une 2e fois un pickr si on fait tourner
    // la fonction une 2e fois dans la page
  
    pickrElements.forEach(el => {
      const colorId = el.dataset.colorId; // récup data-color-id
      const input = document.getElementById(colorId); // id de l'input = data-color-id
      const defaultColor = input?.value || '#000000'; // s'il a une valeur dans le HTML, on la prend, sinon par défaut

      const pickr = Pickr.create({
        el: el,
        theme: 'nano',
        default: defaultColor,
        components: {
          preview: true, // affiche une preview
          opacity: false, // pas de possib de choix d'opacité
          hue: true,
          interaction: {
            hex: true,
            input: true,
            save: true
          }
        }
      });
  
      pickr.on('save', (color) => {
        const hex = color.toHEXA().toString();
        if (input) input.value = hex; // quand clique "save", passe la couleur dans le HTML
      });
  
      el.dataset.pickrInitialized = 'true'; // indique que pickr déjà initialisé
    });
  }
  
  // Initialisation à la fin du chargement de la page
  document.addEventListener('DOMContentLoaded', () => {
    initPickrs();
  });

  // Si génération d'un color picker dynamiquement après chargement page => lancer initPickers()
  
