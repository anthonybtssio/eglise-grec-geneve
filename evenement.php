<?php
$json = "events.json";
$events = file_exists($json) ? json_decode(file_get_contents($json), 1) : [];
// Trier par date (plus récent au plus vieux ou selon la date de l'événement)
usort($events, function($a, $b) { return strtotime($a['date']) - strtotime($b['date']); });
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Événements - Église Antiochian Orthodox Geneva Switzerland</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">Antiochian Orthodox <span class="d-none d-sm-inline">Geneva</span></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarMenu">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Accueil</a></li>
                    <li class="nav-item"><a class="nav-link" href="horaire.html">Horaire</a></li>
                    <li class="nav-item"><a class="nav-link" href="localisation.html">Localisation</a></li>
                    <li class="nav-item"><a class="nav-link active" href="evenement.php">Événements</a></li>
                    <li class="nav-item"><a class="nav-link" href="documents.php">Documents</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact.html">Contact</a></li>
                    <li class="nav-item"><a class="nav-link" href="apropos.html">À propos</a></li>
                    <li class="nav-item"><a class="nav-link" href="InscrivezVous.html">Inscription</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenu principal -->
    <main class="container py-5">
        <h1 class="text-center section-title mb-5">📅 Événements à venir</h1>
        
        <div class="row justify-content-center g-4">
            <?php if(empty($events)): ?>
                <div class="text-center py-5">
                    <p class="text-muted lead">Aucun événement prévu pour le moment. Revenez bientôt !</p>
                </div>
            <?php endif; ?>

            <?php foreach($events as $e): ?>
                <div class="col-12 col-lg-8">
                    <div class="card event-card shadow-sm border-0 rounded-4 overflow-hidden">
                        <?php if(!empty($e['image'])): ?>
                            <img src="<?= $e['image'] ?>" class="card-img-top" style="max-height: 400px; object-fit: cover;" alt="<?= $e['title'] ?>">
                        <?php endif; ?>
                        <div class="card-body text-center p-4 p-md-5">
                            <h2 class="card-title fw-bold mb-3"><?= $e['title'] ?></h2>
                            <h6 class="text-primary mb-4">
                                <i class="far fa-calendar-alt me-2"></i>
                                <?php 
                                    setlocale(LC_TIME, 'fr_FR.UTF-8', 'fra');
                                    echo date("d F Y", strtotime($e['date'])); 
                                ?>
                            </h6>
                            <p class="card-text lead mb-4"><?= nl2br($e['description']) ?></p>
                            
                            <?php if(!empty($e['link'])): ?>
                                <a href="<?= $e['link'] ?>" target="_blank" class="btn btn-primary btn-lg px-5 rounded-pill">S'inscrire à l'événement</a>
                            <?php else: ?>
                                <a href="InscrivezVous.html" class="btn btn-outline-primary btn-lg px-5 rounded-pill">Plus d'infos</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
