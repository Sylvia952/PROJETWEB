<?php
include "../config.php"; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (
        isset($_POST['categorie'], $_POST['nom'], $_POST['dtp']) &&
        !empty($_POST['categorie']) && !empty($_POST['nom']) &&
        !empty($_POST['dtp'])
    ) {
        $categorie = trim($_POST['categorie']);
        $nom = trim($_POST['nom']);
        $dtp = trim($_POST['dtp']);

        $stmt = $pdo->prepare("INSERT INTO ajt_pdt (categorie, nom, dtp) VALUES (?, ?, ?)");

        if ($stmt->execute([$categorie, $nom, $dtp])) {

            $id_ajt_pdt = $pdo->lastInsertId();

        
            header("Location: produits.php?id_ajt_pdt=" . $id_ajt_pdt);
            exit();
        } else {
            echo "Erreur lors de l'insertion.";
        }
    } else {
        echo "Tous les champs doivent être remplis.";
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
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center">Ajouter un Produit</h2>

    <form method="POST" class="mt-4">

<div class="form-group">
            <label for="categorie">Categorie</label>
            <input type="text" class="form-control" name="categorie" id="categorie" placeholder="Categorie" required>
        </div>

        <div class="form-group">
            <label for="nom">Nom</label>
            <input type="text" class="form-control" name="nom" id="nom" placeholder="Nom" required>
        </div>

        <div class="form-group">
            <label for="dtp">Date de Péremption</label>
            <input type="date" class="form-control" name="dtp" id="dtp" placeholder="Date de péremption" required>
        </div>


        <button type="submit" class="btn btn-primary btn-block">Ajouter Produit</button>
    </form>
</div>

<!-- Ajouter les scripts de Bootstrap -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>


