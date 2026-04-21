<?php
// Paramètres de connexion à la base de données (À MODIFIER AVEC TES INFOS O2SWITCH)
$host = "localhost";
$dbname = "monsite_users"; 
$user = "user123";
$pass = "motdepasse";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->execute([$username, $password]);

        echo "Inscription réussie ! <a href='index.html'>Retour à l'accueil</a>";
    }
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>
