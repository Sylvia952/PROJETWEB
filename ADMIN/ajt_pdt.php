<?php
include "../config.php";  // config.php à la racine
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['connex_id'])) {
    header('Location: ../index.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (
        isset($_POST['categorie'], $_POST['nom'], $_POST['dtp']) &&
        !empty($_POST['categorie']) && !empty($_POST['nom']) &&
        !empty($_POST['dtp'])
    ) {
        $categorie = trim($_POST['categorie']);
        $nom = trim($_POST['nom']);
        $dtp = trim($_POST['dtp']);

        try {
            $stmt = $pdo->prepare("INSERT INTO produits (categorie, nom, dtp) VALUES (?, ?, ?)");

            if ($stmt->execute([$categorie, $nom, $dtp])) {
                $id_produit = $pdo->lastInsertId();

                // REDIRECTION CORRIGÉE : vers DASHBOARD/produits.php
                header("Location: ../DASHBOARD/produits.php?id_produit=" . $id_produit);
                exit();
            } else {
                $error = "Erreur lors de l'insertion.";
            }
        } catch (PDOException $e) {
            $error = "Erreur: " . $e->getMessage();
        }
    } else {
        $error = "Tous les champs doivent être remplis.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ajouter un produit</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container {
            max-width: 600px;
        }
    </style>
</head>
<body>

<div  class="bg-primary">
    <h2 class="text-center">Ajouter un Produit</h2>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST" class="mt-4">
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

        <div class="d-flex justify-content-between">
            <a href="../DASHBOARD/produits.php" class="btn btn-secondary">Retour à la liste</a>
            <button type="submit" class="btn btn-primary">Ajouter Produit</button>
        </div>
    </form>
</div>

<!-- Ajouter les scripts de Bootstrap -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>