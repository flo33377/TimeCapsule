<?php

/* fonctions liées aux couleurs/décoration de l'évènement et des memories :
- Impression de select avec des couleurs ou des paterns selon le besoin ;
- Impression de select avec les options de personnalisation des memories
- Fonction permettant de savoir si couleur clair => icones passent en noir plutôt que blanc (par défaut)
*/

        // fonction qui imprime les select à partir d'un tableau commun

$colors = [ // clé = nom à afficher & valeur = terme côté code
    'Noir' => 'black',
    'Blanc' => 'white',
    'Gris' => 'LightSlateGray',
    "Coquille d'oeuf" => 'bisque',
    'Bleu ciel' => 'deepskyblue',
    'Bleu marin' => 'aquamarine',
    'Bleu minuit' => 'midnightblue',
    'Vert doux' => 'lightgreen',
    'Vert vif' => 'greenyellow',
    'Rouge' => 'red',
    'Jaune' => 'yellow',
    'Violet' => 'slateblue',
    'Chocolat' => 'sienna',
    'Rose' => 'hotpink',
    'Marron vif' => 'brown',
    'Fuchsia' => 'fuchsia',
    'Or' => 'goldenrod',
    'Teal' => 'teal'
];

$paterns = [
    'Vague' => 'https://fneto-prod.fr/timecapsule/img/paterns/motif-vague.jpeg',
    'Chiens' => 'https://fneto-prod.fr/timecapsule/img/paterns/motif-chien.jpeg',
    'Coeurs' => 'https://fneto-prod.fr/timecapsule/img/paterns/motif-coeur.jpeg',
    'Fleurs' => 'https://fneto-prod.fr/timecapsule/img/paterns/motif-fleur.jpeg',
    'Couleurs de Pouffsouffle' => 'https://fneto-prod.fr/timecapsule/img/paterns/yellowblack.jpg',
    'Déco Pouffsouffle' => 'https://fneto-prod.fr/timecapsule/img/paterns/hufflepuffpatern.jpg',
    'Ciel étoilé' => 'https://fneto-prod.fr/timecapsule/img/paterns/skynight.jpg',
    'Motif parchemin' => 'https://fneto-prod.fr/timecapsule/img/paterns/oldparchmentpatern.jpg'
];

// Param : présence de "transparent" ou non, couleurs ou non, patern ou non, présence d'une valeur par défaut ou non
// + tableau couleur, tableau patern, valeur par défaut
function generateSelectDesigns(bool $displayTransparent, bool $displayColors, bool $displayPaterns, bool $defaultValueSelected, array $colors, array $paterns, $selectedColor = null) {
    // Partie transparent
    if($displayTransparent) {
        if($selectedColor == 'transparent') {
            echo "<option value='transparent' selected>Pas de couleur de fond</option>";
        } else {
            echo "<option value='transparent'>Pas de couleur de fond</option>";
        }
    }
    // Partie couleur
    if($displayColors) {
        if ($defaultValueSelected) {
            foreach ($colors as $name => $value) { // indique la clé correspond à name et la valeur à value
                $selected = ($selectedColor === $value) ? 'selected' : '';
                echo '<option value="' . htmlspecialchars($value) . '" ' . $selected . '>' . htmlspecialchars($name) . '</option>';
            }
        } else {
            foreach ($colors as $name => $value) {
                echo '<option value="' . htmlspecialchars($value) . '">' . htmlspecialchars($name) . '</option>';
            }
        }
    }

    // Partie motifs
    if ($displayPaterns) {
        foreach ($paterns as $name => $url) {
            echo '<option value="' . htmlspecialchars($url) . '">' . htmlspecialchars($name) . '</option>';
        }
    }
}

        // fonction qui génère les selects des déco

$decorations = [
    'Stickers étoile' => 'starsticker',
    'Scotch' => 'scotch',
    'Punaise' => 'pin'
];

function generateSelectDecorations ($decorations) {
    echo "<option value='none' selected>Aucune décoration supplémentaire</option>";
    foreach ($decorations as $name => $value) {
        echo '<option value="' . htmlspecialchars($value) . '">' . htmlspecialchars($name) . '</option>';
    }
}


        // fonction qui indique sur la couleur est claire ou non (pour passer les icones en noir)

function isLightColor($hexColor) {
    // enlève le # si présent
    $hexColor = ltrim($hexColor, '#');

    // Si la couleur est en format court (#fff)
    if (strlen($hexColor) === 3) {
        $hexColor = $hexColor[0].$hexColor[0] . $hexColor[1].$hexColor[1] . $hexColor[2].$hexColor[2];
    }

    // Convertir en valeurs R, G, B
    $r = hexdec(substr($hexColor, 0, 2));
    $g = hexdec(substr($hexColor, 2, 2));
    $b = hexdec(substr($hexColor, 4, 2));

    // Calcul de luminance
    $luminance = (0.299 * $r + 0.587 * $g + 0.114 * $b);

    // Retourne true si couleur claire
    return $luminance > 186;
}



?>

