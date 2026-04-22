<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title data-i18n="docs-seo-title">Documents Officiels - Église Antiochian Orthodox Geneva Switzerland</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/png" href="logo.png">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="Antioch GVA">
    <link rel="apple-touch-icon" href="logo.png">
    <link rel="apple-touch-startup-image" href="logo.png">
    <link rel="manifest" href="manifest.json">
</head>
<body>
    <div class="utility-bar">
        <div class="container">
            <div class="controls-wrapper">
                <button class="theme-toggle" onclick="toggleTheme()" aria-label="Changer de thème">
                    <i class="fas fa-moon"></i>
                </button>
                <div class="lang-switcher">
                    <button class="lang-btn active-lang" id="btn-fr" onclick="setLang('fr')">FR</button>
                    <button class="lang-btn" id="btn-en" onclick="setLang('en')">EN</button>
                    <button class="lang-btn" id="btn-ar" onclick="setLang('ar')">ع</button>
                </div>
                <button id="btnInstall" class="btn-install-app" data-i18n="install-btn">Appli</button>
            </div>
        </div>
    </div>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="index.html" data-i18n="nav-brand">Antiochian Orthodox <span class="d-none d-sm-inline">Geneva</span></a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarMenu">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.html" data-i18n="nav-home">Accueil</a></li>
                    <li class="nav-item"><a class="nav-link" href="horaire.html" data-i18n="nav-schedule">Horaire</a></li>
                    <li class="nav-item"><a class="nav-link" href="localisation.html" data-i18n="nav-location">Localisation</a></li>
                    <li class="nav-item"><a class="nav-link" href="evenement.html" data-i18n="nav-events">Événements</a></li>
                    <li class="nav-item"><a class="nav-link" href="documents.php" data-i18n="nav-docs">Documents</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact.html" data-i18n="nav-contact">Contact</a></li>
                    <li class="nav-item hide-in-app"><a class="nav-link" href="apropos.html" data-i18n="nav-about">À propos</a></li>
                    <li class="nav-item"><a class="nav-link" href="InscrivezVous.html" data-i18n="nav-register">Inscription</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container py-5">
        <h1 class="text-center section-title" data-i18n="docs-title">Documents de la Paroisse</h1>
        <p class="text-center text-muted mb-5" data-i18n="docs-subtitle">Retrouvez ici tous les documents officiels, statuts et formulaires de notre communauté.</p>

        <div class="row g-4">
            <!-- Grille de documents pour une meilleure réactivité que le tableau -->
            <div class="col-12 col-md-6 col-lg-4">
                <div class="info-card d-flex flex-column align-items-center text-center p-4">
                    <i class="fas fa-file-pdf fa-3x mb-3 text-danger"></i>
                    <h4 class="h5 mb-2" data-i18n="docs-statuts-title">Statuts de la Paroisse</h4>
                    <p class="small text-muted mb-4" data-i18n="docs-statuts-text">Document officiel décrivant l'organisation et le fonctionnement de l'association.</p>
                    <a href="uploads/statuts.pdf" class="btn btn-gold-action w-100 mb-2" download>
                        <i class="fas fa-download me-2"></i> <span data-i18n="docs-download">Télécharger</span>
                    </a>
                    <button class="btn-share w-100" data-i18n="share-btn">Partager <i class="fas fa-share-alt"></i></button>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-4">
                <div class="info-card d-flex flex-column align-items-center text-center p-4">
                    <i class="fas fa-file-pdf fa-3x mb-3 text-danger"></i>
                    <h4 class="h5 mb-2" data-i18n="docs-adhesion-title">Formulaire d'Adhésion</h4>
                    <p class="small text-muted mb-4" data-i18n="docs-adhesion-text">Version papier du formulaire d'inscription à la paroisse.</p>
                    <a href="uploads/adhesion.pdf" class="btn btn-gold-action w-100 mb-2" download>
                        <i class="fas fa-download me-2"></i> <span data-i18n="docs-download">Télécharger</span>
                    </a>
                    <button class="btn-share w-100" data-i18n="share-btn">Partager <i class="fas fa-share-alt"></i></button>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-4">
                <div class="info-card d-flex flex-column align-items-center text-center p-4">
                    <i class="fas fa-file-pdf fa-3x mb-3 text-danger"></i>
                    <h4 class="h5 mb-2" data-i18n="docs-calendrier-title">Calendrier Liturgique</h4>
                    <p class="small text-muted mb-4" data-i18n="docs-calendrier-text">Détail des célébrations et événements pour l'année en cours.</p>
                    <a href="uploads/calendrier.pdf" class="btn btn-gold-action w-100 mb-2" download>
                        <i class="fas fa-download me-2"></i> <span data-i18n="docs-download">Télécharger</span>
                    </a>
                    <button class="btn-share w-100" data-i18n="share-btn">Partager <i class="fas fa-share-alt"></i></button>
                </div>
            </div>
        </div>
    </main>

    <footer class="text-center">
        <div class="container">
            <div class="row">
                <div class="col-12 mb-4">
                    <h3 class="text-white mb-3" data-i18n="footer-title">Antiochian Orthodox Geneva Switzerland</h3>
                    <div class="social-icons">
                        <a href="https://m.facebook.com/share/p/16q4RCaz4V/?mibextid=wwXIfr&wtsid=rdr_0NXitAsiyx5FxvxpR" target="_blank"><i class="fab fa-facebook"></i></a>
                        <a href="https://www.instagram.com/antioch_geneve?igsh=ZjM0MW9qY2VpeDNh" target="_blank"><i class="fab fa-instagram"></i></a>
                        <a href="https://www.tiktok.com/@user1045672728666" target="_blank"><i class="fab fa-tiktok"></i></a>
                    </div>
                </div>
                <div class="col-12 mb-4">
                    <p class="mb-1">
                        <a href="mentions-legales.html" data-i18n="footer-legal">Mentions légales</a> | 
                        <a href="politique-confidentialite.html" data-i18n="footer-privacy">Politique de confidentialité</a>
                    </p>
                    <p class="small text-white-50" data-i18n="footer-copyright">&copy; 2025 Tous droits réservés</p>
                </div>
            </div>
        </div>
    </footer>

    <nav class="app-bottom-nav">
        <a href="index.html" class="tab-item">
            <i class="fas fa-home"></i>
            <span data-i18n="nav-home">Accueil</span>
        </a>
        <a href="horaire.html" class="tab-item">
            <i class="fas fa-clock"></i>
            <span data-i18n="nav-schedule">Horaire</span>
        </a>
        <a href="localisation.html" class="tab-item">
            <i class="fas fa-map-marker-alt"></i>
            <span data-i18n="nav-location">Lieu</span>
        </a>
        <a href="contact.html" class="tab-item">
            <i class="fas fa-envelope"></i>
            <span data-i18n="nav-contact">Contact</span>
        </a>
        <a href="InscrivezVous.html" class="tab-item">
            <i class="fas fa-user-plus"></i>
            <span data-i18n="nav-register">Adhésion</span>
        </a>
    </nav>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>

    <script>
      if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('sw.js');
      }
    </script>
</body>
</html>