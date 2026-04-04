<?php
session_start();
$pass = "admin123"; 
$json = "photos.json";
$dir = "uploads/";

if (!file_exists($dir)) { mkdir($dir, 0755, true); }

// Déconnexion
if (isset($_GET['logout'])) { session_destroy(); header("Location: admin.php"); exit(); }

// Connexion
if (isset($_POST['p']) && $_POST['p'] === $pass) { $_SESSION['a'] = 1; }

// Ajouter un fichier
if (isset($_SESSION['a']) && isset($_FILES['f'])) {
    $ext = strtolower(pathinfo($_FILES['f']['name'], PATHINFO_EXTENSION));
    $n = time() . "_" . preg_replace("/[^a-zA-Z0-9.]/", "_", basename($_FILES['f']['name']));
    if (move_uploaded_file($_FILES['f']['tmp_name'], $dir.$n)) {
        $p = file_exists($json) ? json_decode(file_get_contents($json), 1) : [];
        $type = in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']) ? 'img' : 'doc';
        array_unshift($p, [
            "id" => time(), 
            "u" => $dir.$n, 
            "d" => htmlspecialchars($_POST['d']), 
            "t" => $type, 
            "ext" => $ext,
            "date" => date("d/m/Y")
        ]);
        file_put_contents($json, json_encode($p));
        $msg = "✅ Fichier ajouté avec succès !";
    }
}

// Supprimer
if (isset($_SESSION['a']) && isset($_GET['del'])) {
    $p = json_decode(file_get_contents($json), 1);
    foreach($p as $k=>$v) {
        if($v['id'] == $_GET['del']) {
            if(file_exists($v['u'])) unlink($v['u']);
            unset($p[$k]);
        }
    }
    file_put_contents($json, json_encode(array_values($p)));
    header("Location: admin.php"); exit();
}

$p = file_exists($json) ? json_decode(file_get_contents($json), 1) : [];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Administration - Église Antiochienne</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body { background: #f8f9fa; font-family: 'Segoe UI', sans-serif; }
        .admin-container { max-width: 1000px; margin: 50px auto; }
        .card { border: none; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
        .btn-primary { background: #0044cc; border: none; }
        .table img { width: 60px; height: 60px; object-fit: cover; border-radius: 8px; }
        .badge-doc { background: #ff4757; }
        .badge-img { background: #2ed573; }
    </style>
</head>
<body>

<div class="container admin-container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-church text-primary me-2"></i> Administration</h2>
        <?php if(isset($_SESSION['a'])): ?>
            <div>
                <a href="index.html" class="btn btn-outline-secondary me-2">Voir le site</a>
                <a href="?logout=1" class="btn btn-danger">Déconnexion</a>
            </div>
        <?php endif; ?>
    </div>

    <?php if(!isset($_SESSION['a'])): ?>
        <div class="card p-5 mx-auto" style="max-width: 400px;">
            <h4 class="text-center mb-4">Connexion</h4>
            <form method="POST">
                <input type="password" name="p" class="form-control mb-3" placeholder="Mot de passe" autofocus required>
                <button class="btn btn-primary w-100">Se connecter</button>
            </form>
        </div>
    <?php else: ?>
        
        <?php if(isset($msg)) echo "<div class='alert alert-success alert-dismissible fade show'>$msg<button type='button' class='btn-close' data-bs-dismiss='alert'></button></div>"; ?>

        <div class="card p-4 mb-4">
            <h5><i class="fas fa-upload me-2"></i> Ajouter une Photo ou un Document</h5>
            <p class="text-muted small">Les photos iront dans "Galerie", les autres fichiers (PDF, Word...) dans "Documents".</p>
            <form method="POST" enctype="multipart/form-data" class="row g-3">
                <div class="col-md-4">
                    <input type="file" name="f" class="form-control" required>
                </div>
                <div class="col-md-5">
                    <input type="text" name="d" class="form-control" placeholder="Description (ex: Messe de Pâques 2024)" required>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-success w-100"><i class="fas fa-plus me-1"></i> Envoyer</button>
                </div>
            </form>
        </div>

        <div class="card p-4">
            <h5><i class="fas fa-list me-2"></i> Gestion des fichiers en ligne</h5>
            <div class="table-responsive mt-3">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Type</th>
                            <th>Aperçu</th>
                            <th>Description / Nom</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($p)): ?>
                            <tr><td colspan="5" class="text-center py-4">Aucun fichier en ligne.</td></tr>
                        <?php endif; ?>
                        <?php foreach($p as $v): ?>
                        <tr>
                            <td>
                                <span class="badge <?= $v['t']=='img' ? 'badge-img' : 'badge-doc' ?>">
                                    <?= strtoupper($v['ext']) ?>
                                </span>
                            </td>
                            <td>
                                <?php if($v['t'] == 'img'): ?>
                                    <img src="<?= $v['u'] ?>" alt="">
                                <?php else: ?>
                                    <i class="fas fa-file-pdf fa-2x text-danger"></i>
                                <?php endif; ?>
                            </td>
                            <td>
                                <strong><?= $v['d'] ?></strong><br>
                                <small class="text-muted"><?= basename($v['u']) ?></small>
                            </td>
                            <td><?= $v['date'] ?? '-' ?></td>
                            <td>
                                <a href="?del=<?= $v['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Supprimer définitivement ce fichier ?')">
                                    <i class="fas fa-trash"></i> Supprimer
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
