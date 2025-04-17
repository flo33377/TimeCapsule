<?php

// 2 param : patern ou non, echo selected ou non

$colors = [ // key is the name to display, value is the coding name
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
    'Motif vague' => 'https://fneto-prod.fr/timecapsule/img/paterns/motif-vague.jpeg',
    'Motif chien' => 'https://fneto-prod.fr/timecapsule/img/paterns/motif-chien.jpeg',
    'Motif coeurs' => 'https://fneto-prod.fr/timecapsule/img/paterns/motif-coeur.jpeg',
    'Motif fleurs' => 'https://fneto-prod.fr/timecapsule/img/paterns/motif-fleur.jpeg',
    'Couleurs de Pouffsouffle' => 'https://fneto-prod.fr/timecapsule/img/paterns/yellowblack.jpg',
    'Motifs Pouffsouffle' => 'https://fneto-prod.fr/timecapsule/img/paterns/hufflepuffpatern.jpg',
    'Ciel étoilé' => 'https://fneto-prod.fr/timecapsule/img/paterns/skynight.jpg',
    'Motif parchemin' => 'https://fneto-prod.fr/timecapsule/img/paterns/oldparchmentpatern.jpg'
];


function generateSelectDesigns(bool $displayPaterns, bool $displayColorsWithSelected, array $colors, array $paterns, $selectedColor = null) {
    // Partie couleur
    if ($displayColorsWithSelected) {
        foreach ($colors as $name => $value) { // indique la clé correspond à name et la valeur à value
            $selected = ($selectedColor === $value) ? 'selected' : '';
            echo '<option value="' . htmlspecialchars($value) . '" ' . $selected . '>' . htmlspecialchars($name) . '</option>';
        }
    } else {
        foreach ($colors as $name => $value) {
            echo '<option value="' . htmlspecialchars($value) . '">' . htmlspecialchars($name) . '</option>';
        }
    }

    // Partie motifs
    if ($displayPaterns) {
        foreach ($paterns as $name => $url) {
            echo '<option value="' . htmlspecialchars($url) . '">' . htmlspecialchars($name) . '</option>';
        }
    }
}




?>

