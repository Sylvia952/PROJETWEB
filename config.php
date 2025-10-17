<?php
// === Détection de l'environnement ===
if ($_SERVER['HTTP_HOST'] === 'localhost' || $_SERVER['HTTP_HOST'] === '127.0.0.1') {
    // Connexion locale
    $servername = "127.0.0.1";
    $dbname     = "coldmanager_db";
    $username   = "root";
    $password   = "";
} else {
    // Connexion en ligne (hébergement InfinityFree)
    $servername = "sql311.infinityfree.com";
    $dbname     = "if0_40190078_coldmanagement";
    $username   = "if0_40190078";
    $password   = "Qi9pIcuDhQsO42";
}

try {
    // Création de la connexion PDO
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    

} catch(PDOException $e) {
    echo "❌ Erreur : " . $e->getMessage();
}
?>
