# CLAUDE.md — Église Orthodoxe Antiochienne Genève

## Identité du projet

Site web officiel et PWA de l'**Église Orthodoxe Antiochienne de Genève-Bellevue** (Suisse).
Propriétaire/développeur : **Anthony Abouhable** (`a.abouhable@gmail.com`)
Hébergement : **O2Switch**

---

## Ce que fait l'application

Site institutionnel et communautaire pour la paroisse orthodoxe de Genève :

- Informations sur les **messes** (2e et 4e dimanche du mois, 10h30)
- **Localisation** de l'église avec carte Google Maps intégrée
- **Événements** dynamiques chargés depuis `events.json`
- **Formulaire d'adhésion** traité par `inscription.php`
- **Contact** via Formspree (`f/xdklowyl`) + info prêtre Père Moussa
- **Ressources orthodoxes** externes (Patriarcat, Balamand…)
- **Export iCalendar** (.ics) pour ajouter les messes au calendrier
- **Multilingue** : Français, Anglais, Arabe (RTL)
- **Dark/Light theme** persisté en localStorage
- **PWA installable** sur mobile et bureau

---

## Stack technique

| Couche | Technologie |
|--------|-------------|
| Frontend | HTML5 vanilla + CSS3 + JavaScript vanilla |
| CSS Framework | Bootstrap 5.3.2 (CDN) |
| Icônes | Font Awesome 6.4.2 (CDN) |
| Polices | Google Fonts — Montserrat + Playfair Display |
| PWA | Service Worker (`sw.js`, cache-first) + `manifest.json` |
| Formulaires | Formspree (contact) + PHP (inscription) |
| Backend | PHP 7+ (inscription.php, admin.php, galerie.php…) |
| Données | `events.json` (événements) |
| Pas de build tool | Aucun webpack/vite — tout en vanilla, CDN |

---

## Structure des fichiers

```
/
├── index.html                    # Accueil : carousel 4 images + 3 cartes
├── horaire.html                  # Horaires messes + export .ics
├── localisation.html             # Carte Google Maps + transports
├── evenement.html                # Événements dynamiques (fetch events.json)
├── contact.html                  # Formulaire Formspree + info prêtre
├── InscrivezVous.html            # Formulaire d'adhésion
├── apropos.html                  # Liens ressources orthodoxes externes
├── mentions-legales.html         # Infos légales / éditeur
├── politique-confidentialite.html# RGPD
├── script.js                     # i18n + PWA install + theme toggle + share
├── style.css                     # Design system (variables CSS, dark mode)
├── sw.js                         # Service Worker (network-first, v3)
├── manifest.json                 # Config PWA (nom, icônes, couleurs)
├── events.json                   # Données événements (édité manuellement)
├── inscription.php               # Traitement formulaire adhésion
├── admin.php                     # Panel administrateur
├── documents.php                 # Gestion documents/PDF
├── evenement.php                 # Gestion événements côté serveur
├── galerie.php                   # Galerie photos
└── logo.png + images/            # Assets visuels
```

---

## Design System

### Couleurs (CSS variables dans `:root`)
```css
--primary-color: #050a14      /* Noir profond (light mode) */
--gold-color: #D4AF37         /* Or/doré (couleur liturgique) */
--ivory-bg: #fdfaf5           /* Fond ivoire (light mode) */
--transition-3d: all 0.3s cubic-bezier(0.4, 0, 0.2, 1)
```

### Dark mode
Déclenché par `[data-theme="dark"]` sur `<html>`, persisté en localStorage.

### Mode PWA (`display-mode: standalone`)
- Navbar et footer Bootstrap cachés
- `app-bottom-nav` (barre navigation bas) affiché à la place
- Padding body ajusté pour safe areas

### Typographie
- **Headers** : Playfair Display (serif)
- **Body** : Montserrat (sans-serif)

---

## Fonctionnalités clés à connaître

### i18n (internationalisation)
- 3 langues : `fr` (défaut), `en`, `ar` (RTL)
- Pattern : attribut `data-i18n="clé"` sur chaque élément
- Dictionnaire dans `script.js` → `const i18n = { fr: {}, en: {}, ar: {} }`
- Persistance : `localStorage.setItem('lang', lang)`
- Pour ajouter une traduction : ajouter la clé dans les 3 langues + l'attribut sur l'élément HTML

### Service Worker
- Fichier : `sw.js`, cache name : `antioch-v3`
- Stratégie : **network-first** (essaie le réseau, fallback cache)
- Mise à jour du cache : incrémenter `CACHE_NAME` dans `sw.js`
- Enregistrement répété sur chaque page HTML (pas de script commun)

### Export iCalendar
- Dans `horaire.html`, génère des fichiers `.ics` en JS pur
- Utilise `RRULE:FREQ=MONTHLY;BYDAY=2SU` et `4SU` pour les récurrences
- Créé en `Blob` → téléchargé via `<a>` simulé

### Événements dynamiques
- `events.json` → lu par `fetch()` dans `evenement.html`
- Tri par date côté JS
- Format attendu dans `events.json` : `{ "titre", "date", "description", "image", "lien" }`

### PWA Installation
- `beforeinstallprompt` capturé dans `script.js`
- Bouton "Appli" dans la navbar déclenche `deferredPrompt.prompt()`
- Web Share API disponible (bouton "Partager")

---

## Conventions de code

- **Pas de framework JS** — vanilla only, pas de React/Vue/Angular
- **Pas de build tool** — éditer directement les fichiers, pas de `npm build`
- **CDN uniquement** pour Bootstrap, Font Awesome, Google Fonts
- **HTML répété** : navbar et footer dupliqués sur chaque page (pas de templating)
- **Commentaires** : minimaux, seulement si comportement non-évident
- **PHP** : simple, sans ORM ni framework (scripts directs)

---

## Ce qu'on fait souvent dans ce projet

- Ajouter/modifier du contenu textuel → modifier le HTML + les 3 langues dans `script.js`
- Ajouter un événement → éditer `events.json`
- Modifier les styles → éditer `style.css` via les variables CSS en priorité
- Changer les horaires des messes → `horaire.html` + les fonctions iCalendar
- Mettre à jour le cache PWA → incrémenter `CACHE_NAME` dans `sw.js`
- Améliorer le mode PWA → cibler `@media (display-mode: standalone)` dans CSS
- Ajouter une page → créer HTML, copier navbar/footer des autres pages, ajouter lien dans nav
- Modifier le formulaire d'adhésion → `InscrivezVous.html` + `inscription.php`

---

## Contacts clés dans le contenu

- **Prêtre** : Père Moussa
- **Responsable paroisse** : Georges McKarris
- **Formspree ID** : `f/xdklowyl` (formulaire contact)
- **Adresse église** : Genève-Bellevue, accessible bus V

---

## Points d'attention

- Chaque page enregistre le service worker elle-même → si on ajoute une page, ne pas oublier le bloc SW
- L'arabe utilise `dir="rtl"` → vérifier que les layouts ne cassent pas
- Le logo est `logo.png` utilisé à la fois pour la navbar, le manifest PWA et les apple-touch-icons
- Bootstrap est en CDN — pas de personnalisation du build Bootstrap possible sans changer l'approche
- Les images du carousel sont en chemin relatif — si on réorganise les dossiers, mettre à jour les chemins
