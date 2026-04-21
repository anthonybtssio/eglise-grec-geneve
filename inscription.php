<?php
// --- CONFIGURATION O2SWITCH ---
$host = "localhost";
$dbname = "aoas";   // <--- Ton vrai nom de base de données (sur o2switch, le préfixe est OBLIGATOIRE pour PHP)
$user = "root";  // <--- Ton vrai utilisateur MySQL
$pass = "";            // <--- Ton vrai mot de passe MySQL

try {
    // Connexion sécurisée avec UTF-8
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Nettoyage des données pour plus de sécurité
        $prenom = htmlspecialchars($_POST['prenom']);
        $nom = htmlspecialchars($_POST['nom']);
        $email = htmlspecialchars($_POST['email']);
        $telephone = htmlspecialchars($_POST['telephone']);

        // Insertion (l'id s'ajoute tout seul grâce à l'Auto-Increment)
        $sql = "INSERT INTO users (prenom, nom, email, telephone) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$prenom, $nom, $email, $telephone]);

        // Message de succès avec redirection automatique
        echo "
        <!DOCTYPE html>
        <html lang='fr'>
        <head>
            <meta charset='UTF-8'>
            <meta http-equiv='refresh' content='5;url=index.html'>
            <title>Succès</title>
            <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css' rel='stylesheet'>
            <style>
                body { background: #f8f9fa; display: flex; align-items: center; justify-content: center; height: 100vh; font-family: sans-serif; }
                .success-card { background: white; padding: 40px; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); text-align: center; }
            </style>
        </head>
        <body>
            <div class='success-card'>
                <h1 class='text-success'>Inscription réussie !</h1>
                <p class='lead'>Merci $prenom $nom, vos informations ont été bien enregistrées.</p>
                <p class='text-muted'>Vous allez être redirigé vers l'accueil dans 5 secondes...</p>
                <a href='index.html' class='btn btn-primary rounded-pill px-4'>Retour immédiat</a>
            </div>
        </body>
        </html>";
    }
} catch (PDOException $e) {
    echo "<div style='color:red; padding:20px; border:1px solid red; font-family:sans-serif;'>";
    echo "<h3>Erreur de connexion / Base de données</h3>";
    echo "<p>Détails : " . $e->getMessage() . "</p>";
    echo "<p>Vérifiez que le nom de la base est bien <strong>$dbname</strong> et que vos identifiants sont corrects.</p>";
    echo "</div>";
}
?>