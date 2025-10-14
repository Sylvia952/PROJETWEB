<?php
include "config.php";

if (isset($_POST['id'])) {
    $id_employe = $_POST['id'];
 
    try {
        $stmt = $pdo->prepare("DELETE FROM employes WHERE id = ?");
        $stmt->execute([$id_employe]);

        if ($stmt->rowCount() > 0) {
            $message = "Employé supprimé avec succès !";
            $type = "success";
        } else {
            $message = "⚠️ Aucun employé trouvé avec cet ID.";
            $type = "warning";
        }
        
    } catch(PDOException $e) {
        $message = "❌ Erreur lors de la suppression : " . $e->getMessage();
        $type = "danger";
    }
    
} else {
    $message = "❌ ID du produit manquant.";
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
        <a href="employes.php" class="btn btn-primary">Retour à la liste</a>
        
        <script>
            setTimeout(function() {
                window.location.href = 'employes.php';
            }, 2000);
        </script>
    </div>
</body>
</html>