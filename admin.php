<?php
session_start();
$pass = "Eglise2024!"; // VOTRE MOT DE PASSE
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
    $n = time() . "_" . basename($_FILES['f']['name']);
    if (move_uploaded_file($_FILES['f']['tmp_name'], $dir.$n)) {
        $p = file_exists($json) ? json_decode(file_get_contents($json), 1) : [];
        $type = in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']) ? 'img' : 'doc';
        array_unshift($p, ["id"=>time(), "u"=>$dir.$n, "d"=>htmlspecialchars($_POST['d']), "t"=>$type, "ext"=>$ext]);
        file_put_contents($json, json_encode($p));
        $msg = "✅ Fichier ajouté avec succès !";
    }
}

// Supprimer
if (isset($_SESSION['a']) && isset($_GET['del'])) {
    $p = json_decode(file_get_contents($json), 1);
    foreach($p as $k=>$v) if($v['id']==$_GET['del']) { if(file_exists($v['u'])) unlink($v['u']); unset($p[$k]); }
    file_put_contents($json, json_encode(array_values($p)));
    header("Location: admin.php"); exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin - Gestion du site</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f4f7f6; padding: 20px; }
        .admin-card { max-width: 800px; margin: auto; background: white; padding: 30px; border-radius: 15px; shadow: 0 4px 6px rgba(0,0,0,0.1); }
    </style>
</head>
<body>

<div class="admin-card shadow-sm">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>⛪ Administration du site</h2>
        <?php if(isset($_SESSION['a'])): ?><a href="?logout=1" class="btn btn-outline-danger btn-sm">Quitter</a><?php endif; ?>
    </div>

    <?php if(!isset($_SESSION['a'])): ?>
        <form method="POST" style="max-width: 300px; margin: auto;">
            <p class="text-center text-muted">Veuillez entrer le mot de passe pour ajouter des photos ou documents.</p>
            <input type="password" name="p" class="form-control mb-3" placeholder="Mot de passe" autofocus>
            <button class="btn btn-primary w-100">Se connecter</button>
        </form>
    <?php else: ?>
        <?php if(isset($msg)) echo "<div class='alert alert-success'>$msg</div>"; ?>
        
        <div class="p-3 mb-4 border rounded bg-light">
            <h5>Ajouter une photo ou un document</h5>
            <form method="POST" enctype="multipart/form-data" class="row g-3">
                <div class="col-md-5"><input type="file" name="f" class="form-control" required></div>
                <div class="col-md-5"><input type="text" name="d" class="form-control" placeholder="Description (ex: Messe du 15 mai)"></div>
                <div class="col-md-2"><button class="btn btn-success w-100">Envoyer</button></div>
            </form>
        </div>

        <h5>Fichiers actuellement sur le site :</h5>
        <div class="table-responsive">
            <table class="table table-hover mt-3">
                <thead><tr><th>Aperçu</th><th>Description</th><th>Action</th></tr></thead>
                <tbody>
                    <?php 
                    $p = file_exists($json) ? json_decode(file_get_contents($json), 1) : [];
                    foreach($p as $v): ?>
                    <tr>
                        <td>
                            <?php if($v['t']=='img'): ?>
                                <img src="<?=$v['u']?>" style="width:50px; height:50px; object-fit:cover; border-radius:4px;">
                            <?php else: ?>
                                <span class="badge bg-danger">PDF / DOC</span>
                            <?php endif; ?>
                        </td>
                        <td class="align-middle"><?=$v['d']?></td>
                        <td class="align-middle">
                            <a href="?del=<?=$v['id']?>" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer ?')">Supprimer</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            <a href="galerie.php" class="btn btn-link text-decoration-none">← Voir la galerie sur le site</a>
        </div>
    <?php endif; ?>
</div>

</body>
</html>
