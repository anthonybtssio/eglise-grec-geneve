<?php
$json_events = "events.json";
$events = file_exists($json_events) ? json_decode(file_get_contents($json_events), true) : [];
$next_event = null;
$today = date('Y-m-d');

if (!empty($events)) {
    $future_events = array_filter($events, function($e) use ($today) {
        return $e['date'] >= $today;
    });
    
    usort($future_events, function($a, $b) {
        return strtotime($a['date']) - strtotime($b['date']);
    });
    
    if (!empty($future_events)) {
        $next_event = $future_events[0];
    }
}

function format_fr_date($date) {
    $months = [
        'January' => 'janvier', 'February' => 'février', 'March' => 'mars', 'April' => 'avril',
        'May' => 'mai', 'June' => 'juin', 'July' => 'juillet', 'August' => 'août',
        'September' => 'septembre', 'October' => 'octobre', 'November' => 'novembre', 'December' => 'décembre'
    ];
    $date_str = date("d F Y", strtotime($date));
    return strtr($date_str, $months);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Église Antiochian Orthodox Geneva Switzerland - Église orthodoxe grecque Genève Bellevue</title>
    <meta name="description" content="Bienvenue à l'Église Antiochian Orthodox Geneva Switzerland (Église orthodoxe grecque). Située à Bellevue, Genève, notre paroisse accueille la communauté orthodoxe de Suisse. Horaires des messes, événements et localisation.">
    <meta name="keywords" content="Église orthodoxe grecque Genève Bellevue, Antiochian Orthodox Church Geneva Switzerland, Greek Orthodox Church Geneva, Église orthodoxe Suisse, AOAS Genève, Orthodox Church Bellevue">
    
    <!-- Open Graph (pour Facebook/Instagram/WhatsApp) -->
    <meta property="og:title" content="Église Antiochian Orthodox Geneva Switzerland - Bellevue">
    <meta property="og:description" content="Église orthodoxe grecque à Genève (Bellevue). Horaires des messes et vie de la communauté.">
    <meta property="og:image" content="face.jpg">
    <meta property="og:url" content="https://votre-site.ch">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark sticky-top">
    <div class="container">
        <a class="navbar-brand" href="index.php">Antiochian Orthodox <span class="d-none d-sm-inline">Geneva</span></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu" aria-controls="navbarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarMenu">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link active" href="index.php">Accueil</a></li>
                <li class="nav-item"><a class="nav-link" href="horaire.html">Horaire</a></li>
                <li class="nav-item"><a class="nav-link" href="localisation.html">Localisation</a></li>
                <li class="nav-item"><a class="nav-link" href="evenement.php">Événements</a></li>
                <li class="nav-item"><a class="nav-link" href="documents.php">Documents</a></li>
                <li class="nav-item"><a class="nav-link" href="contact.html">Contact</a></li>
                <li class="nav-item"><a class="nav-link" href="apropos.html">À propos</a></li>
                <li class="nav-item"><a class="nav-link" href="InscrivezVous.html">Inscription</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Contenu principal -->
<main>
    <!-- Carousel -->
    <div id="carouselChurch" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselChurch" data-bs-slide-to="0" class="active" aria-current="true"></button>
            <button type="button" data-bs-target="#carouselChurch" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#carouselChurch" data-bs-slide-to="2"></button>
            <button type="button" data-bs-target="#carouselChurch" data-bs-slide-to="3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="IMG_7211.JPG" class="d-block w-100" alt="explication de l'évangile">
            </div>
            <div class="carousel-item">
                <img src="IMG_7225.PNG" class="d-block w-100" alt="Fin de messe">
            </div>
            <div class="carousel-item">
                <img src="IMG_7226.PNG" class="d-block w-100" alt="Intérieur de l'église">
            </div>
            <div class="carousel-item">
                <img src="Resurrection.jpg" class="d-block w-100" alt="Icone de résurrection">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselChurch" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Précédent</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselChurch" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Suivant</span>
        </button>
    </div>

    <!-- Bloc infos rapides -->
    <div class="container my-5 py-5">
        <h2 class="text-center section-title">Bienvenue à l'Église Antiochienne</h2>
        <div class="row g-4 text-center">
            <div class="col-12 col-md-4">
                <div class="info-card">
                    <h4><i class="fas fa-dove mb-3 d-block"></i> Horaires des messes</h4>
                    <p class="mb-0">2ème Dimanche du mois : 10h30<br>4ème Dimanche du mois : 10h30</p>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="info-card">
                    <h4><i class="fas fa-map-marker-alt mb-3 d-block"></i> Localisation</h4>
                    <p class="mb-0">Chemin de la Chênaie 145C,<br>1293 Bellevue, Genève</p>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="info-card">
                    <h4><i class="fas fa-calendar-alt mb-3 d-block"></i> Prochain événement</h4>
                    <?php if ($next_event): ?>
                        <p class="mb-0">
                            <strong><?= $next_event['title'] ?></strong><br>
                            <?= format_fr_date($next_event['date']) ?>
                        </p>
                        <a href="evenement.php" class="btn btn-sm btn-outline-primary mt-2">Détails</a>
                    <?php else: ?>
                        <p class="mb-0">Aucun événement prévu pour le moment.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <!-- Bloc SEO / Présentation -->
    <div class="bg-light py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center">
                    <h2 class="mb-4">Votre Église Orthodoxe à Genève Bellevue</h2>
                    <p class="lead">
                        Bienvenue à la paroisse de l'<strong>Église Antiochian Orthodox Geneva Switzerland</strong>. 
                        Située à Bellevue, notre communauté représente l'<strong>Église orthodoxe grecque</strong> au sein du canton de Genève et de la Suisse.
                    </p>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Footer -->
<footer class="text-center">
    <div class="container">
        <div class="row">
            <div class="col-12 mb-4">
                <h3 class="text-white mb-3">Antiochian Orthodox Geneva Switzerland</h3>
                <div class="social-icons">
                    <a href="https://m.facebook.com/share/p/16q4RCaz4V/?mibextid=wwXIfr&wtsid=rdr_0NXitAsiyx5FxvxpR" target="_blank">
                        <i class="fab fa-facebook"></i>
                    </a>
                    <a href="https://www.instagram.com/antioch_geneve?igsh=ZjM0MW9qY2VpeDNh" target="_blank">
                        <i class="fab fa-instagram"></i>
                    </a>
                </div>
            </div>
            <div class="col-12 mb-4">
                <p class="mb-1">
                    <a href="mentions-legales.html">Mentions légales</a> | 
                    <a href="politique-confidentialite.html">Politique de confidentialité</a>
                </p>
                <p class="small text-white-50">&copy; 2025 Tous droits réservés</p>
            </div>
        </div>
    </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
