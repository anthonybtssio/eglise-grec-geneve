<?php
session_start();
$pass = "admin123"; 
$json_photos = "photos.json";
$json_events = "events.json";
$dir = "uploads/";

if (!file_exists($dir)) { mkdir($dir, 0755, true); }

// Déconnexion
if (isset($_GET['logout'])) { session_destroy(); header("Location: admin.php"); exit(); }

// Connexion
if (isset($_POST['p']) && $_POST['p'] === $pass) { $_SESSION['a'] = 1; }

// --- ACTIONS DOCUMENTS ---
if (isset($_SESSION['a']) && isset($_FILES['f']) && !isset($_POST['add_event'])) {
    $ext = strtolower(pathinfo($_FILES['f']['name'], PATHINFO_EXTENSION));
    $n = time() . "_" . preg_replace("/[^a-zA-Z0-9.]/", "_", basename($_FILES['f']['name']));
    if (move_uploaded_file($_FILES['f']['tmp_name'], $dir.$n)) {
        $p = file_exists($json_photos) ? json_decode(file_get_contents($json_photos), 1) : [];
        $type = in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']) ? 'img' : 'doc';
        array_unshift($p, [
            "id" => time(), 
            "u" => $dir.$n, 
            "d" => htmlspecialchars($_POST['d']), 
            "t" => $type, 
            "ext" => $ext,
            "date" => date("d/m/Y")
        ]);
        file_put_contents($json_photos, json_encode($p));
        $msg = "✅ Fichier ajouté avec succès !";
    }
}

if (isset($_SESSION['a']) && isset($_GET['del_doc'])) {
    $p = json_decode(file_get_contents($json_photos), 1);
    foreach($p as $k=>$v) {
        if($v['id'] == $_GET['del_doc']) {
            if(file_exists($v['u'])) unlink($v['u']);
            unset($p[$k]);
        }
    }
    file_put_contents($json_photos, json_encode(array_values($p)));
    header("Location: admin.php#docs"); exit();
}

// --- ACTIONS ÉVÉNEMENTS ---
if (isset($_SESSION['a']) && isset($_POST['add_event'])) {
    $events = file_exists($json_events) ? json_decode(file_get_contents($json_events), 1) : [];
    $img_url = "";
    
    if(!empty($_FILES['e_img']['name'])) {
        $n = "event_" . time() . "_" . basename($_FILES['e_img']['name']);
        if(move_uploaded_file($_FILES['e_img']['tmp_name'], $dir.$n)) $img_url = $dir.$n;
    }

    array_unshift($events, [
        "id" => time(),
        "title" => htmlspecialchars($_POST['e_title']),
        "date" => $_POST['e_date'],
        "description" => htmlspecialchars($_POST['e_desc']),
        "image" => $img_url,
        "link" => htmlspecialchars($_POST['e_link'])
    ]);
    file_put_contents($json_events, json_encode($events));
    $msg = "✅ Événement ajouté !";
}

if (isset($_SESSION['a']) && isset($_GET['del_event'])) {
    $events = json_decode(file_get_contents($json_events), 1);
    foreach($events as $k=>$v) {
        if($v['id'] == $_GET['del_event']) {
            if(!empty($v['image']) && file_exists($v['image'])) unlink($v['image']);
            unset($events[$k]);
        }
    }
    file_put_contents($json_events, json_encode(array_values($events)));
    header("Location: admin.php#events"); exit();
}

$docs = file_exists($json_photos) ? json_decode(file_get_contents($json_photos), 1) : [];
$events = file_exists($json_events) ? json_decode(file_get_contents($json_events), 1) : [];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Administration - Église Antiochienne</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body { background: #f4f7f6; font-family: 'Segoe UI', sans-serif; }
        .admin-container { max-width: 1100px; margin: 40px auto; }
        .card { border: none; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); margin-bottom: 30px; }
        .nav-tabs { border: none; margin-bottom: 20px; }
        .nav-tabs .nav-link { border: none; color: #666; font-weight: 600; padding: 12px 25px; border-radius: 10px; margin-right: 10px; }
        .nav-tabs .nav-link.active { background: #0044cc; color: white; }
        .btn-primary { background: #0044cc; border: none; border-radius: 8px; }
        .table img { width: 50px; height: 50px; object-fit: cover; border-radius: 8px; }
    </style>
</head>
<body>

<div class="container admin-container">
    <div class="d-flex justify-content-between align-items-center mb-4 px-3">
        <h2><i class="fas fa-user-shield text-primary me-2"></i> Espace Admin</h2>
        <?php if(isset($_SESSION['a'])): ?>
            <div>
                <a href="index.html" class="btn btn-outline-secondary me-2">Voir le site</a>
                <a href="?logout=1" class="btn btn-danger">Quitter</a>
            </div>
        <?php endif; ?>
    </div>

    <?php if(!isset($_SESSION['a'])): ?>
        <div class="card p-5 mx-auto" style="max-width: 400px;">
            <h4 class="text-center mb-4">Connexion</h4>
            <form method="POST">
                <input type="password" name="p" class="form-control mb-3" placeholder="Mot de passe" autofocus required>
                <button class="btn btn-primary w-100 py-2">Se connecter</button>
            </form>
        </div>
    <?php else: ?>
        
        <?php if(isset($msg)) echo "<div class='alert alert-success alert-dismissible fade show mx-3'>$msg<button type='button' class='btn-close' data-bs-dismiss='alert'></button></div>"; ?>

        <ul class="nav nav-tabs px-3" id="adminTabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="docs-tab" data-bs-toggle="tab" href="#docs" role="tab">📄 Documents & Photos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="events-tab" data-bs-toggle="tab" href="#events" role="tab">📅 Événements</a>
            </li>
        </ul>

        <div class="tab-content">
            <!-- ONGLET DOCUMENTS -->
            <div class="tab-pane fade show active" id="docs" role="tabpanel">
                <div class="card p-4 mx-3">
                    <h5 class="mb-3"><i class="fas fa-plus-circle me-2"></i>Ajouter un Document ou une Image</h5>
                    <form method="POST" enctype="multipart/form-data" class="row g-3">
                        <div class="col-md-4"><input type="file" name="f" class="form-control" required></div>
                        <div class="col-md-5"><input type="text" name="d" class="form-control" placeholder="Description du fichier" required></div>
                        <div class="col-md-3"><button class="btn btn-success w-100">Mettre en ligne</button></div>
                    </form>
                </div>

                <div class="card p-4 mx-3">
                    <h5 class="mb-3">Fichiers actuels</h5>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead><tr><th>Aperçu</th><th>Description</th><th>Type</th><th>Date</th><th>Action</th></tr></thead>
                            <tbody>
                                <?php foreach($docs as $v): ?>
                                <tr>
                                    <td>
                                        <?php if($v['t'] == 'img'): ?>
                                            <img src="<?= $v['u'] ?>">
                                        <?php else: ?>
                                            <i class="fas fa-file-pdf fa-2x text-danger"></i>
                                        <?php endif; ?>
                                    </td>
                                    <td><strong><?= $v['d'] ?></strong></td>
                                    <td><span class="badge bg-light text-dark border"><?= strtoupper($v['ext']) ?></span></td>
                                    <td class="small text-muted"><?= $v['date'] ?? '-' ?></td>
                                    <td><a href="?del_doc=<?= $v['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Supprimer ?')"><i class="fas fa-trash"></i></a></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- ONGLET ÉVÉNEMENTS -->
            <div class="tab-pane fade" id="events" role="tabpanel">
                <div class="card p-4 mx-3">
                    <h5 class="mb-3"><i class="fas fa-calendar-plus me-2"></i>Créer un Événement</h5>
                    <form method="POST" enctype="multipart/form-data" class="row g-3">
                        <input type="hidden" name="add_event" value="1">
                        <div class="col-md-6">
                            <label class="small fw-bold">Titre de l'événement</label>
                            <input type="text" name="e_title" class="form-control" required placeholder="Ex: Déjeuner de Pâques">
                        </div>
                        <div class="col-md-6">
                            <label class="small fw-bold">Date</label>
                            <input type="date" name="e_date" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label class="small fw-bold">Description</label>
                            <textarea name="e_desc" class="form-control" rows="3" required placeholder="Détails de l'événement..."></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="small fw-bold">Image (optionnel)</label>
                            <input type="file" name="e_img" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="small fw-bold">Lien d'inscription (Google Forms, etc.)</label>
                            <input type="url" name="e_link" class="form-control" placeholder="https://...">
                        </div>
                        <div class="col-12 text-end">
                            <button class="btn btn-primary px-5 py-2">Publier l'événement</button>
                        </div>
                    </form>
                </div>

                <div class="card p-4 mx-3">
                    <h5 class="mb-3">Événements publiés</h5>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead><tr><th>Image</th><th>Titre</th><th>Date</th><th>Action</th></tr></thead>
                            <tbody>
                                <?php foreach($events as $e): ?>
                                <tr>
                                    <td><?php if($e['image']): ?><img src="<?= $e['image'] ?>"><?php else: ?>-<?php endif; ?></td>
                                    <td><strong><?= $e['title'] ?></strong></td>
                                    <td><?= date("d/m/Y", strtotime($e['date'])) ?></td>
                                    <td>
                                        <a href="?del_event=<?= $e['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Supprimer cet événement ?')"><i class="fas fa-trash"></i> Supprimer</a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
