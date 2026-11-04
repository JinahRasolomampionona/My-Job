# My-Job — plateforme de recrutement

My-Job met en relation des **recruteurs** et des **candidats** à Madagascar.
Application Laravel 11 (Blade, Bootstrap 5, Vite) avec gestion des rôles par `spatie/laravel-permission`.

## Les trois espaces

| Rôle | Ce qu'il peut faire |
|------|--------------------|
| **Visiteur** | Voir les offres validées, rechercher par poste / entreprise / ville, s'inscrire et se connecter (fenêtres modales). |
| **Candidat** | Créer son profil, ses formations et ses expériences ; consulter les offres ; **postuler** ; suivre ses candidatures et ses notifications. |
| **Recruteur** | Publier, modifier et supprimer ses offres ; voir les candidatures reçues ; consulter les profils validés. |
| **Administrateur** | Valider ou refuser les offres et les profils ; gérer les recruteurs et les candidats ; tableau de bord des statistiques. |

**Cycle de vie** : une offre (ou un profil) est créée *en attente* → l'administrateur la *valide* ou la *refuse* → elle devient visible (offre pour les candidats, profil pour les recruteurs). Toute modification la remet *en attente*.

## Installation

```bash
composer install
npm install
cp .env.example .env          # puis renseigner la base de données et l'email
php artisan key:generate
php artisan migrate
php artisan db:seed           # crée les rôles + un compte admin (admin@myjob.mg / password, à changer !)
npm run build                 # ou "npm run dev" pendant le développement
```

Lancement complet (serveur + file d'attente + Vite) :

```bash
composer dev
```

### Configuration des emails

Les emails sont envoyés **en file d'attente** pour que les pages ne ralentissent pas. Il faut donc qu'un *worker* tourne :

```bash
php artisan queue:work        # déjà inclus dans "composer dev"
```

Pour Gmail, dans `.env` :

```
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=votre.adresse@gmail.com
MAIL_PASSWORD=mot-de-passe-d-application-google
MAIL_FROM_ADDRESS="votre.adresse@gmail.com"
APP_URL=http://127.0.0.1:8000   # adresse réelle du site : utilisée pour les liens dans les emails
```

En développement, `MAIL_MAILER=log` écrit les emails dans `storage/logs/laravel.log` au lieu de les envoyer.

### Tests

```bash
php artisan test
```

Les tests utilisent une base SQLite en mémoire : ils ne touchent pas à la base MySQL.

---

## Modifications apportées (dernière version)

### 1. Nouvelle fonctionnalité : gestion des emails et des notifications

Toutes les notifications passent par `app/Notifications/`. Une classe de base (`BaseNotification`) gère la file d'attente, l'email (texte en français) et l'enregistrement en base pour la cloche.

| Événement | Destinataire | Email | Cloche |
|-----------|-------------|:-----:|:------:|
| Inscription | le nouvel inscrit (bienvenue) | ✔ | |
| Inscription | les administrateurs | | ✔ |
| Offre créée ou modifiée | les administrateurs | ✔ | ✔ |
| Offre validée / refusée | le recruteur | ✔ | ✔ |
| Offre validée | tous les candidats (alerte « nouvelle offre ») | | ✔ |
| Profil créé ou modifié | les administrateurs | | ✔ |
| Profil validé / refusé | le candidat | ✔ | ✔ |
| Candidature envoyée | le recruteur | ✔ | ✔ |
| Candidature envoyée | le candidat (confirmation) | ✔ | ✔ |
| Mot de passe oublié | l'utilisateur | ✔ (en français) | |

- **Cloche de notifications** (`components/notification-bell`) dans les trois espaces : compteur de non-lues, liste des dernières notifications, « Tout marquer comme lu ». Elle se rafraîchit **en Ajax toutes les 30 secondes**, sonne et affiche un toast lorsqu'une nouvelle notification arrive.
- **Page « Mes notifications »** (`/notifications`) : historique paginé, lecture (redirige vers la page concernée) et suppression.
- **Candidatures** : nouveau bouton « Postuler » (en Ajax, avec message facultatif), table `candidatures`, page « Mes candidatures » pour le candidat et liste des candidats dans le détail de l'offre pour le recruteur. Un candidat doit avoir un profil validé et ne peut postuler qu'une fois par offre.
- Les anciens Mailables cassés (`ProfilValide`, `ProfilRefuse` pointaient vers une vue inexistante `view.name`, `GmailEmail` avait des adresses en dur) et la route de test `/sendEmail` ont été supprimés et remplacés par ce système.

### 2. Connexion et inscription en Ajax (sans rechargement)

- Les formulaires de connexion, d'inscription et de mot de passe oublié sont envoyés en **Ajax** (`axios`). Les erreurs s'affichent sous chaque champ, avec une animation.
- **Après l'inscription, la page ne se recharge plus** : la fenêtre d'inscription se ferme, celle de connexion s'ouvre avec l'email déjà rempli et un message de succès.
- La connexion redirige directement vers l'espace du rôle (ou vers la page demandée avant la connexion).
- Les URL `/login`, `/register` et `/forgot-password` ouvrent la bonne fenêtre modale sur l'accueil (avant, elles affichaient un fragment HTML sans mise en page).
- La page de réinitialisation du mot de passe était vide (modale jamais affichée) : c'est maintenant une vraie page.

### 3. Corrections de bugs et de sécurité

**Sécurité**
- Aucune page n'était protégée : n'importe qui pouvait ouvrir `/admin`, valider des offres, supprimer des utilisateurs… Les routes sont maintenant groupées par rôle (`auth` + `role:admin|recruteur|candidat`).
- Il était possible de **s'inscrire en tant qu'admin** en modifiant le formulaire : le rôle est limité à `recruteur` ou `candidat`.
- Un recruteur pouvait modifier ou supprimer les offres des autres, et un candidat le profil, les formations ou les expériences des autres : un contrôle de propriétaire a été ajouté.
- **Faille XSS** : la description des offres (éditeur Quill) était affichée sans filtrage. Le HTML est maintenant nettoyé (`app/Support/HtmlSanitizer.php`) à l'enregistrement et à l'affichage.
- Un administrateur ne peut plus être supprimé depuis les listes. La suppression d'un utilisateur supprime aussi ses données liées (profil, formations, expériences, offres, notifications).
- La connexion est limitée à 5 tentatives (protection contre la force brute).
- `phpunit.xml` utilisait la vraie base MySQL : lancer les tests l'aurait vidée. Les tests utilisent désormais SQLite en mémoire.

**Fonctionnement**
- `app.js` plantait sur la plupart des pages (`#title`, `#toggleSidebar` et `#editor` utilisés sans vérifier qu'ils existent). Le reste du script ne s'exécutait donc pas : tooltips, Alpine, etc.
- Bootstrap était chargé deux fois (npm + CDN), ce qui créait des conflits sur les modales et les menus. Il n'est plus chargé qu'une fois.
- L'éditeur Quill synchronisait le mauvais formulaire (le premier de la page, c'est-à-dire la recherche) ; le script en ligne de la page de création faisait une erreur (`Quill` non défini).
- Recherche de l'accueil : le champ s'appelait `localite` alors que le contrôleur attendait `localisation`. La recherche n'affichait que des offres validées, et un champ vide provoquait une erreur.
- Les offres en attente ou refusées étaient visibles publiquement via leur URL.
- La page admin « Validation profils » plantait dès qu'un candidat n'avait pas encore de profil, et il n'y avait **aucun bouton Valider / Refuser** dans l'interface.
- La modification du profil remettait toujours la civilité à « Mr ». Un candidat pouvait aussi créer plusieurs profils.
- L'ajout d'une expérience sans date de fin provoquait une erreur SQL (colonnes NOT NULL). L'année de fin doit maintenant être postérieure à l'année de début.
- Les règles de validation refusaient les accents et les chiffres (« Développeur », « Master 2 », « L'Oréal »…).
- Le badge « urgent » s'affichait sur toutes les offres ; plusieurs liens pointaient vers `offres-details.html` (page inexistante).
- La case « urgent » n'était pas modifiable à l'édition d'une offre, et les offres créées par l'admin n'avaient pas de `user_id` (erreur SQL).
- Les compteurs, notifications et messages des tableaux de bord étaient codés en dur (« 2 », « Jimmy Denis »…). Ils affichent maintenant les vraies données.
- Les boutons « Se déconnecter » des menus ne faisaient rien, et la recherche des barres du haut n'était pas branchée.
- `/dashboard` affichait l'accueil sans données (erreur) : il redirige vers l'espace du rôle.
- `UserFactory` et `DatabaseSeeder` ne renseignaient pas la colonne `role` (erreur SQL).

### 4. Design et animations JavaScript

- Apparition progressive des éléments au défilement (AOS), cartes d'offres qui se soulèvent au survol et badge « urgent » qui pulse.
- Compteurs animés sur les tableaux de bord, cartes de statistiques cliquables.
- Toasts animés pour les messages de succès ou d'erreur, et formulaires qui « tremblent » en cas d'erreur.
- Boutons avec effet ripple et indicateur de chargement pendant les envois Ajax.
- Barre de progression lors des changements de page, en-tête ombré au défilement, bouton « retour en haut ».
- Inscription repensée : choix du rôle par cartes, indicateur de robustesse du mot de passe, bouton afficher / masquer le mot de passe.
- Fenêtres modales animées ; elles se rouvrent automatiquement après une erreur de validation.
- Messages « aucun résultat » illustrés, et animations désactivées si le système demande de réduire les mouvements.

### 5. Organisation du code

- Composants Blade réutilisables : `offer-card`, `stat-card`, `notification-bell`, `flash`, `empty-state`.
- Formulaire d'offre unique (`offers/_form.blade.php`) pour l'admin et le recruteur.
- Layouts candidat et recruteur fusionnés dans une base commune (`Layout/dashboard.blade.php`).
- Tests automatisés : `tests/Feature/MyJobWorkflowTest.php` (sécurité des rôles, notifications, candidatures, XSS, affichage de toutes les pages) et mise à jour des tests d'authentification. **49 tests passent.**

### Nouvelles migrations

- `create_notifications_table` : notifications en base (cloche).
- `create_candidatures_table` : candidatures des candidats aux offres.

```bash
php artisan migrate
```
