
// fonction qui templatiser le HTML à implémenter à la banner mais en prenant en compte le texte choisi
function createBannerStructureHTML(text) {
    return `<div class="banner-content">
    ${text}
    <div class="progress-bar"></div>
    </div>`;
}

// va chercher le template de banner
let notificationBalise = document.getElementById('banner_infos');

// set les variables de base
let bannerType = null;
let bannerMessage = null;
let bannerText = null;

// si template banner existe, récup les dataset
if(notificationBalise) {
    bannerType = notificationBalise.dataset.bannertype ?? null;
    bannerMessage = notificationBalise.dataset.bannermessage ?? null;
}

// on créé un objet qui contient la correspondance entre les codes (keys, sous forme d'objet) 
// et le contenu (valeur)
// icone affiché avant texte + colorClass doit correspondre à une class CSS
const messages = {
    ChangeName: {
        text: "Le changement de nom a bien été effectué",
        icon: "✅",
        colorClass: "success-banner"
    },
    ChangeColorLogo: {
        text: "Le design a bien été modifié",
        icon: "🎨",
        colorClass: "success-banner"
    },
    MemoryCreated: {
        text: "Le souvenir a bien été enregistré",
        icon: "📝",
        colorClass: "success-banner"
    },
    ErrorUpload: {
        text: "Erreur lors du téléchargement",
        icon: "❌",
        colorClass: "error-banner"
    },
    UnknownEvent: {
        text: "L'évènement ciblé n'existe pas.",
        icon: "😕",
        colorClass: "error-banner"
    }
};


// si le dataset est != de null et qu'il correspond à une key de messages, 
// bannerText prend la valeur associée
if (bannerMessage && messages[bannerMessage]) {
    const { text, icon, colorClass } = messages[bannerMessage];

    // on l'injecte les données dans la structure
    notificationBalise.innerHTML = `
        <div class="banner-content">
            <span class="banner-icon">${icon}</span>
            ${text}
            <div class="progress-bar"></div>
        </div>
    `;

    // On affiche la banner
    displayNotification(notificationBalise, colorClass, 'invisible_banner');
}


// fonction qui affiche les banners
function displayNotification(banner, classNameToAdd, classNameToRemove) {
    notificationBalise.classList.remove(classNameToRemove);
    notificationBalise.classList.add(classNameToAdd);

    banner.classList.add('show');
    banner.style.opacity = '1';
    banner.style.transform = 'translateX(-50%) translateY(-30px)';
    banner.style.bottom = '40px';

    setTimeout(() => { // fait glisser la banner vers le bas pour qu'elle ne soit plus visible
        banner.style.opacity = '0';
        banner.style.transform = 'translateX(-50%) translateY(100px)';
        banner.style.bottom = '-100px';
    }, 5000);

    setTimeout(() => { // la fait disparaitre complètement du DOM en retirant la class +
        // en mettant celle qui fait display: none
        banner.classList.remove(classNameToAdd);
        banner.classList.add(classNameToRemove);
    }, 5500);
}



