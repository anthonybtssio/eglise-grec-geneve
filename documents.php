<?php
$json = "photos.json";
$p = file_exists($json) ? json_decode(file_get_contents($json), 1) : [];
$docs = array_filter($p, function($v) { return $v['t'] === 'doc'; });
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Documents - Église Antiochian Orthodox Geneva</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        .doc-card { border: none; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); transition: 0.3s; height: 100%; }
        .doc-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
        .doc-icon { height: 120px; display: flex; align-items: center; justify-content: center; background: #f8f9fa; border-top-left-radius: 15px; border-top-right-radius: 15px; }
        .btn-download { border-radius: 10px; font-weight: bold; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark sticky-top">
    <div class="container">
        <a class="navbar-brand" href="index.php">Antiochian Orthodox</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarMenu">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">Accueil</a></li>
                <li class="nav-item"><a class="nav-link" href="horaire.html">Horaire</a></li>
                <li class="nav-item"><a class="nav-link" href="localisation.html">Localisation</a></li>
                <li class="nav-item"><a class="nav-link" href="evenement.php">Événements</a></li>
                <li class="nav-item"><a class="nav-link active" href="documents.php">Documents</a></li>
                <li class="nav-item"><a class="nav-link" href="contact.html">Contact</a></li>
            </ul>
        </div>
    </div>
</nav>

<main class="container py-5">
    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold">📄 Documents & Téléchargements</h1>
        <p class="text-muted">Retrouvez ici tous les documents administratifs et paroissiaux.</p>
    </div>

    <div class="row g-4">
        <?php foreach($docs as $v): ?>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="card doc-card text-center">
                    <div class="doc-icon">
                        <?php 
                        $icon = "fa-file-alt";
                        if($v['ext'] == 'pdf') $icon = "fa-file-pdf text-danger";
                        if(in_array($v['ext'], ['doc', 'docx'])) $icon = "fa-file-word text-primary";
                        if(in_array($v['ext'], ['xls', 'xlsx'])) $icon = "fa-file-excel text-success";
                        ?>
                        <i class="fas <?= $icon ?> fa-4x"></i>
                    </div>
                    <div class="card-body">
                        <h6 class="card-title fw-bold text-dark"><?= $v['d'] ?></h6>
                        <p class="text-muted small">Type: <?= strtoupper($v['ext']) ?> | <?= $v['date'] ?? '' ?></p>
                        <a href="<?= $v['u'] ?>" target="_blank" class="btn btn-outline-primary btn-sm btn-download w-100">
                            <i class="fas fa-download me-1"></i> Ouvrir
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

        <?php if(empty($docs)): ?>
            <div class="text-center py-5">
                <i class="fas fa-folder-open fa-4x text-light mb-3"></i>
                <p class="text-muted">Aucun document pour le moment.</p>
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
