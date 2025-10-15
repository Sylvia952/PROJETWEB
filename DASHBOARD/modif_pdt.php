<?php
include "../config.php";

// Vérification et récupération de l'ID
if (!isset($_GET['id'])) {  // ← Correction : 'id' au lieu de 'id_produits'
    die("❌ ID du produit manquant.");
}

$id_produit = $_GET['id'];  // ← Correction : variable cohérente

// Récupération du produit
$stmt = $pdo->prepare("SELECT * FROM produits WHERE id = ?");
$stmt->execute([$id_produit]);  // ← Correction : $id_produit
$produit = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$produit) {
    die("Produit non trouvé.");
}

$message = '';

// Traitement du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $categorie = $_POST['categorie'];
    $prix = $_POST['prix'];
    $quantite = $_POST['quantite'];
    $date_ajout = $_POST['date_ajout'];

    try {
        $stmt = $pdo->prepare("UPDATE produits SET nom = ?, categorie = ?, prix = ?, quantite = ?, date_ajout = ? WHERE id = ?");
        $stmt->execute([$nom, $categorie, $prix, $quantite, $date_ajout, $id_produit]);  // ← Correction : $id_produit
        
        $message = '<div class="alert alert-success">✅ Produit modifié avec succès !</div>';
        
        // Recharger les données après modification
        $stmt = $pdo->prepare("SELECT * FROM produits WHERE id = ?");
        $stmt->execute([$id_produit]);  // ← Correction : $id_produit
        $produit = $stmt->fetch(PDO::FETCH_ASSOC);
        
    } catch(PDOException $e) {
        $message = '<div class="alert alert-danger">❌ Erreur : ' . $e->getMessage() . '</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Modifier le Produit</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center">Modifier le Produit</h2>
    
    <?= $message ?>
    
    <form method="POST" class="mt-4">
        
        <div class="form-group">
            <label for="nom">Nom du produit</label>
            <input type="text" class="form-control" name="nom" id="nom" 
                   value="<?= htmlspecialchars($produit['nom']) ?>" required>
        </div>

        <div class="form-group">
            <label for="categorie">Catégorie</label>
            <select class="form-control" name="categorie" id="categorie" required>
                <option value="">-- Choisissez une catégorie --</option>
                <option value="poissons">POISSONS</option>
                <option value="viandes">VIANDES</option>
                <option value="saucisses">SAUCISSES</option>
            </select>
        </div>

        <div class="form-group">
            <label for="nom">Nom</label>
            <input type="text" class="form-control" name="nom" id="nom" placeholder="Nom du produit" required>
        </div>

        <div class="form-group">
            <label for="dtp">Date de Péremption</label>
            <input type="date" class="form-control" name="dtp" id="dtp" required>
        </div>


        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block">Mettre à jour</button>
            <a href="produits.php" class="btn btn-secondary btn-block mt-2">Retour à la liste</a>
        </div>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>