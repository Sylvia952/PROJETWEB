<?php
include "../config.php";
session_start();

if (!isset($_SESSION['connex_id'])) {
    header('Location: index.php');
    exit();
}

if (isset($_GET['id'])) {
    $id_produit = $_GET['id'];
 
    try {
        $stmt = $pdo->prepare("DELETE FROM produits WHERE id = ?");
        $stmt->execute([$id_produit]);

        if ($stmt->rowCount() > 0) {
            $message = "Produit supprimé avec succès !";
            $type = "success";
        } else {
            $message = "Aucun produit trouvé avec cet ID.";
            $type = "warning";
        }
        
    } catch(PDOException $e) {
        $message = "Erreur lors de la suppression : " . $e->getMessage();
        $type = "danger";
    }
    
} else {
    $message = "ID du produit manquant.";
    $type = "danger";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suppression</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <div class="alert alert-<?= $type ?>">
            <?= $message ?>
        </div>
        <a href="produits.php" class="btn btn-primary">Retour à la liste</a> 
        
        <script>
            setTimeout(function() {
                window.location.href = 'produits.php'; 
            }, 100);
        </script>
    </div>
</body>
</html>