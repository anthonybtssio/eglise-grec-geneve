<?php
$json = "photos.json";
$p = file_exists($json) ? json_decode(file_get_contents($json), 1) : [];
$imgs = array_filter($p, function($v) { return $v['t'] === 'img'; });
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Galerie - Église Antiochian Orthodox Geneva</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        .gallery-img { width: 100%; height: 280px; object-fit: cover; border-radius: 12px; transition: 0.3s; cursor: pointer; }
        .gallery-img:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.15); }
        .card { border: none; background: transparent; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark sticky-top">
    <div class="container">
        <a class="navbar-brand" href="index.html">Antiochian Orthodox</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarMenu">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="index.html">Accueil</a></li>
                <li class="nav-item"><a class="nav-link" href="horaire.html">Horaire</a></li>
                <li class="nav-item"><a class="nav-link" href="localisation.html">Localisation</a></li>
                <li class="nav-item"><a class="nav-link" href="evenement.html">Événements</a></li>
                <li class="nav-item"><a class="nav-link active" href="galerie.php">Galerie</a></li>
                <li class="nav-item"><a class="nav-link" href="documents.php">Documents</a></li>
                <li class="nav-item"><a class="nav-link" href="contact.html">Contact</a></li>
            </ul>
        </div>
    </div>
</nav>

<main class="container py-5">
    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold">📸 Galerie Photos</h1>
        <p class="text-muted">Retrouvez les moments forts de notre paroisse en images.</p>
    </div>

    <div class="row g-4">
        <?php foreach($imgs as $v): ?>
            <div class="col-md-4 col-sm-6">
                <div class="card h-100">
                    <img src="<?= $v['u'] ?>" class="gallery-img" alt="<?= $v['d'] ?>" onclick="window.open(this.src)">
                    <div class="card-body px-0">
                        <p class="card-text fw-bold text-center"><?= $v['d'] ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        
        <?php if(empty($imgs)): ?>
            <div class="text-center py-5">
                <i class="fas fa-images fa-4x text-light mb-3"></i>
                <p class="text-muted">Aucune photo pour le moment.</p>
            </div>
        <?php endif; ?>
    </div>
</main>

<footer class="text-center py-5 border-top mt-5 bg-dark text-white">
    <div class="container">
        <p>&copy; 2025 Église Antiochian Orthodox Geneva Switzerland</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
