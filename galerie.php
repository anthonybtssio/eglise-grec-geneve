<?php
session_start();
$pass = "Eglise2024!"; 
$json = "photos.json";
$dir = "uploads/";

if (!file_exists($dir)) { mkdir($dir, 0755, true); }

// Déconnexion
if (isset($_GET['logout'])) { session_destroy(); header("Location: galerie.php"); exit(); }

// Connexion
if (isset($_POST['p']) && $_POST['p'] === $pass) { $_SESSION['a'] = 1; }

// Ajouter un fichier (Photo ou Document)
if (isset($_SESSION['a']) && isset($_FILES['f'])) {
    $ext = strtolower(pathinfo($_FILES['f']['name'], PATHINFO_EXTENSION));
    $n = time() . "_" . basename($_FILES['f']['name']);
    if (move_uploaded_file($_FILES['f']['tmp_name'], $dir.$n)) {
        $p = file_exists($json) ? json_decode(file_get_contents($json), 1) : [];
        $type = in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']) ? 'img' : 'doc';
        array_unshift($p, ["id"=>time(), "u"=>$dir.$n, "d"=>htmlspecialchars($_POST['d']), "t"=>$type, "ext"=>$ext]);
        file_put_contents($json, json_encode($p));
    }
}

// Supprimer
if (isset($_SESSION['a']) && isset($_GET['del'])) {
    $p = json_decode(file_get_contents($json), 1);
    foreach($p as $k=>$v) if($v['id']==$_GET['del']) { if(file_exists($v['u'])) unlink($v['u']); unset($p[$k]); }
    file_put_contents($json, json_encode(array_values($p)));
    header("Location: galerie.php"); exit();
}

$p = file_exists($json) ? json_decode(file_get_contents($json), 1) : [];
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
        .img-g { width:100%; height:250px; object-fit:cover; border-radius:10px; cursor:pointer; transition: 0.3s; }
        .img-g:hover { transform: scale(1.02); }
        .doc-box { width:100%; height:250px; display:flex; align-items:center; justify-content:center; background:#f8f9fa; border:2px dashed #ccc; border-radius:10px; text-decoration:none; flex-direction:column; color: #333; }
        .admin-section { background:#e9ecef; padding:20px; border-radius:15px; margin-bottom:30px; border: 1px solid #ddd; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <div class="container">
        <a class="navbar-brand" href="index.html">Antiochian Orthodox</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="index.html">Accueil</a></li>
                <li class="nav-item"><a class="nav-link active" href="galerie.php">Galerie</a></li>
                <li class="nav-item"><a class="nav-link" href="evenement.html">Événements</a></li>
                <?php if(!isset($_SESSION['a'])): ?>
                    <li class="nav-item"><a class="nav-link btn btn-outline-light btn-sm ms-lg-3 px-3" href="?admin">Connexion Admin</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link btn btn-danger btn-sm ms-lg-3 px-3 text-white" href="?logout=1">Déconnexion</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<main class="container py-5">
    <h1 class="text-center mb-5">📸 Galerie & Documents</h1>

    <!-- FORMULAIRE DE CONNEXION -->
    <?php if(isset($_GET['admin']) && !isset($_SESSION['a'])): ?>
        <div class="card mx-auto shadow-sm p-4 mb-5" style="max-width:350px;">
            <h4 class="text-center mb-3">Accès réservé</h4>
            <form method="POST">
                <input type="password" name="p" class="form-control mb-3" placeholder="Mot de passe" autofocus>
                <button class="btn btn-primary w-100">Se connecter</button>
            </form>
        </div>
    <?php endif; ?>

    <!-- INTERFACE D'AJOUT (Visible uniquement si connecté) -->
    <?php if(isset($_SESSION['a'])): ?>
        <div class="admin-section shadow-sm">
            <h4>➕ Ajouter une photo ou une pièce jointe</h4>
            <form method="POST" enctype="multipart/form-data" class="row g-3">
                <div class="col-md-4">
                    <label class="small fw-bold">Fichier (Image ou PDF)</label>
                    <input type="file" name="f" class="form-control" required>
                </div>
                <div class="col-md-5">
                    <label class="small fw-bold">Description</label>
                    <input type="text" name="d" class="form-control" placeholder="Ex: Photo de la fête du 15 août">
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button class="btn btn-success w-100">Mettre en ligne</button>
                </div>
            </form>
        </div>
    <?php endif; ?>

    <!-- AFFICHAGE DES PHOTOS ET DOCUMENTS -->
    <div class="row g-4">
        <?php foreach($p as $v): ?>
            <div class="col-md-4 col-sm-6">
                <div class="card h-100 border-0 shadow-sm">
                    <?php if($v['t'] == 'img'): ?>
                        <img src="<?=$v['u']?>" class="img-g" onclick="window.open(this.src)">
                    <?php else: ?>
                        <a href="<?=$v['u']?>" target="_blank" class="doc-box">
                            <i class="fas fa-file-pdf fa-4x text-danger mb-2"></i>
                            <span class="fw-bold">Document <?=strtoupper($v['ext'])?></span>
                        </a>
                    <?php endif; ?>
                    <div class="card-body">
                        <p class="card-text fw-bold"><?= $v['d'] ?: "Sans description" ?></p>
                        <?php if(isset($_SESSION['a'])): ?>
                            <a href="?del=<?=$v['id']?>" class="btn btn-sm btn-outline-danger mt-2" onclick="return confirm('Supprimer ce fichier ?')">🗑 Supprimer</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        <?php if(empty($p)) echo "<p class='text-center text-muted py-5'>Aucune photo ou document pour le moment.</p>"; ?>
    </div>
</main>

<footer class="text-center py-5 border-top mt-5">
    <p class="text-muted">&copy; 2024 Église Antiochian Orthodox Geneva</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
