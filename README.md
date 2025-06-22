# 🕰️ Timecapsule

Bienvenue sur **Timecapsule**, un projet personnel qui permet de créer et partager des souvenirs liés à un événement (anniversaire, voyage, pot de départ, etc.).
Chaque capsule temporelle peut être créée et personnalisée par un utilisateur (après création d'un compte personnel), puis est accessible via un lien unique, protégeable par mot de passe.
Les capsules permettent de stocker et de partager les souvenirs à la manière d'un feed de réseau social, avec des options de personnalisation et la possibilité de "liker" ses souvenirs préférés. 

---

## ✨ Fonctionnalités

- Création de compte utilisateur (email + mot de passe) et connexion à son profil utilisateur
- Création de Landing Page pour un événement (ex. anniversaire, voyage, etc.), dont l'UI est personnalisable
- Partage facilité (Web Share API ou copy/paste pré-complété)
- Lecture publique via un lien et protegeable par mot de passe
- Modification post-création de l'UI de la LP et suppresion (uniquement pour son auteur)
- Ajout de souvenirs (image + texte + multiples options de design)
- Possibilité de liker des souvenirs en AJAX sans rechargement de la page

- Affichage responsive, animations, transitions, feedback utilisateur (bandeaux de notification) 

---

## 🧰 Technologies utilisées

- **Frontend** : HTML, CSS, JavaScript
- **Backend** : PHP (avec PDO)
- **Base de données** : SQLite

---

## 📦 Structure du projet

timecapsule/
├── img/                         # Images statiques (logo, icônes...)
│
├── public/                      # Fichiers accessibles publiquement (JS & CSS)
│   ├── js/                      # Scripts JavaScript
│   └── css/                     # Feuilles de style CSS
│
├── src/
│   ├── db/                      # Base de données SQLite (non incluse - ignorée par Git)
│   ├── api/                     # Fonctions PHP spécifiques (ex. affichage formulaire)
│   ├── content/                 # Contenu des différentes pages
│   │   ├── logo_events/         # Logos uploadés pour les événements
│   │   ├── memory_img/          # Images uploadées pour les souvenirs
│   │   ├── modules/             # Modules d'interface réutilisables (sous-header, dialogues...)
│   │   ├── notifications/       # Système de notification entre PHP et JS
│   │   └── users-content/       # Composants visuels des pages utilisateur
│   ├── main.php                 # Routeur PHP (navigation entre les pages)
│   └── mainFunctions.php        # Fonctions PHP générales (connexion DB, requêtes, etc.)
│
├── users/                       # Scripts/fonctions liés à l’espace utilisateur
│
├── index.php                    # Point d’entrée principal du site
├── .gitignore
└── README.md


## 🚀 Tester le projet

Vous pouvez découvrir une version en ligne de **Timecapsule** ici :

🔗 [https://fneto-prod.fr/timecapsule](https://fneto-prod.fr/timecapsule)

> ⚠️ La DB et les tables ne se créant pas via un script automatisé, l'installation locale n'est pas conseillé en l'état, mais je peux fournir sur demande un export SQL.

---

## 🛠️ Installation locale (non conseillée, prise de contact nécessaire)

Ce projet utilise une base de données SQLite **non incluse** dans le dépôt (voir `.gitignore`).

### Prérequis :
- Serveur local PHP (ex : XAMPP, MAMP, WAMP)
- PHP 7.4+ avec extension `PDO_SQLITE` activée

### Étapes :
1. Cloner le dépôt : git clone https://github.com/flo33377/timecapsule.git
2. Placer le projet dans htdocs (ou équivalent)
3. Créer une base SQLite db_timecapsule.db dans src/db/
4. Ajouter manuellement les tables nécessaires (export sur demande)
5. Lancer index.php dans un navigateur depuis localhost

---

## 🎓 A propos de ce projet
Aspirant développeur web, ce projet a été développé par passion et volonté de mettre en application ce que j'apprends au fil de l'eau.
Il met en avant mes compétences en :

- Développement back et front complet
- Gestion de la base de données et des requêtes
- Expérience utilisateur et design responsive
- Sécurisation de données utilisateurs (authentification, base non publique)

📧 Me contacter : florianneto95@gmail.com
