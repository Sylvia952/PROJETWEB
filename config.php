<?php
$servername="127.0.0.1";
$dbname="coldmanager_db";
$username="root";
$password="";

$pdo= new PDO("mysql:host=127.0.0.1;dbname=coldmanager_db",$username,$password);

require_once 'config.php';

try {

    $stmt = $pdo->query("SELECT COUNT(*) as total FROM employe");
    $result = $stmt->fetch();
    

} catch(PDOException $e) {
    echo "❌ Erreur : " . $e->getMessage();
}
?>