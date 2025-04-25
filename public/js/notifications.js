
// va chercher le template de banner
let notificationBalise = document.getElementById('banner_infos');

// set les variables de base
let bannerType = null;
let bannerMessage = null;
let bannerText = null;

// si template banner existe, récup les data set
if(notificationBalise) {
    bannerType = notificationBalise.dataset.bannertype ?? null;
    bannerMessage = notificationBalise.dataset.bannermessage ?? null;
}

// fonction qui affiche les banners
function displayNotification(banner, classNameToAdd, classNameToRemove) {
    notificationBalise.classList.remove(classNameToRemove);
    notificationBalise.classList.add(classNameToAdd);

    banner.classList.add('show');
    banner.style.opacity = '1';
    banner.style.transform = 'translateX(-50%) translateY(-30px)';
    banner.style.bottom = '40px';

    setTimeout(() => {
        banner.style.opacity = '0';
        banner.style.transform = 'translateX(-50%) translateY(100px)';
        banner.style.bottom = '-100px';
    }, 5000);

    setTimeout(() => {
        banner.classList.remove(classNameToAdd);
        banner.classList.add(classNameToRemove);
    }, 5500);
}

// switch sur ce que contient bannerMessage
switch(bannerMessage) {
    case 'ChangeName' :
        bannerText = "Le changement de nom a bien été effectué";
        notificationBalise.innerHTML = `
            <div class="banner-content">
            ${bannerText}
            <div class="progress-bar"></div>
            </div>
            `;
        displayNotification(notificationBalise, bannerType, 'invisible_banner');
        // ne pas changer les param + contenu BannerType doit avoir une équivalence dans le CSS
        break;
    
    case 'ChangeColorLogo' :
        bannerText = "Le design a bien été modifié";
        notificationBalise.innerHTML = `
            <div class="banner-content">
            ${bannerText}
            <div class="progress-bar"></div>
            </div>
            `;
        displayNotification(notificationBalise, bannerType, 'invisible_banner');
        break;
    
    default :
        bannerText = null;
}



