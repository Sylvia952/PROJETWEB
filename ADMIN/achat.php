<?php 
include "connexion.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (
        isset($_POST['nom'], $_POST['categorie'], $_POST['prix'], $_POST['quantite'], $_POST['date_ajout']) &&
        !empty($_POST['nom']) && !empty($_POST['categorie']) &&
        !empty($_POST['prix']) && !empty($_POST['quantite']) && !empty($_POST['date_ajout'])
    ) {
        $nom = trim($_POST['nom']);
        $categorie = trim($_POST['categorie']);
        $prix = trim($_POST['prix']);
        $quantite = trim($_POST['quantite']);
        $date_ajout = date('Y-m-d H:i:s');  

        $stmt = $pdo->prepare("INSERT INTO produits (nom, categorie, prix, quantite, date_ajout) VALUES (?, ?, ?, ?, ?)");

        if ($stmt->execute([$nom, $categorie, $prix, $quantite, $date_ajout])) {

            $id_produits = $pdo->lastInsertId();
        }
     }
    }

    /*
    try {
    $sql = "SELECT * FROM produits ORDER BY date_ajout DESC";
    $stmt = $pdo->query($sql);
    $produits = $stmt->fetchAll();
} catch(PDOException $e) {
    die("Erreur lors de la récupération des produits : " . $e->getMessage());
}
*/

?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ajouter un Étudiant</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center">Ajouter un produit</h2>

    <form method="POST" class="mt-4">
        <div class="form-group">
            <label for="nom">Nom</label>
            <input type="text" class="form-control" name="nom" id="nom" placeholder="Nom" required>
        </div>

        <div class="form-group">
            <label for="categorie">Categorie</label>
        <select id="categorie" name="categorie">
            <option value="">-- Sélectionnez --</option>
            <option value="cosmetiques">Cosmetiques</option>
            <option value="denree alimentaire">Denrees Aimentaires</option>
            <option value="fournitures scolaires">Fournitures scolaires</option>
            <option value="mobile money">Mobiles Money</option>
        </select>
        </div>

        <div class="form-group">
            <label for="prix">Prix</label>
            <input type="text" class="form-control" name="prix" id="prix" placeholder="prix" required>
        </div>

        <div class="form-group">
            <label for="quantite">Quantite</label>
            <input type="text" class="form-control" name="quantite" id="quantite" placeholder="quantite" required>
        </div>

        <div class="form-group">
            <label for="dat">Date d'ajout</label>
            <input type="date" class="form-control" name="date_ajout" id="dat" placeholder="Date_ajout" required>
        </div>

        <button type="submit" class="btn btn-primary btn-block">AJOUTER</button>
    </form>
</div>


<!--
<div class="container mt-5">
    <h2 class="text-center">Liste des produits</h2>

    <table class="table table-bordered table-striped mt-4">
        <thead>
            <tr>
                <th>Categories</th>
                 <th>P</th>
                <th>Prix</th>
                <th>Quantités</th>
                <th>Dates d'ajouts</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($produits  as $produit) : ?>
                <tr>
                    <td><strong><?= htmlspecialchars($produit['nom']) ?></strong></td>
                    <td>
                        <span style="background: #e9ecef; padding: 4px 8px; border-radius: 12px; font-size: 12px;">
                                    <?= htmlspecialchars($produit['categorie']) ?>
                        </span>
                    </td>
                              <td style="font-weight: bold; color: #28a745;">
                                <?= number_format($produit['prix'], 2, ',', ' ') ?> €
                            </td>
                            <td>
                                <?php if ($produit['quantite'] > 10): ?>
                                    <span style="color: #28a745;"><?= $produit['quantite'] ?></span>
                                <?php elseif ($produit['quantite'] > 0): ?>
                                    <span style="color: #ffc107;"><?= $produit['quantite'] ?></span>
                                <?php else: ?>
                                    <span style="color: #dc3545;"><?= $produit['quantite'] ?></span>
                                <?php endif; ?>
                            </td>
                            <td><?= date('d/m/Y H:i', strtotime($produit['date_ajout'])) ?></td>
                        </tr>
<?php if (!empty($produit['id'])) : ?>
    <td class="table-actions">
           // Formulaire MODIFICATION 
        <form method="GET" action="modifier.php" style="display:inline;">
            <input type="hidden" name="id" value="<?= $produit['id'] ?>">
            <button type="submit" class="btn btn-warning btn-sm">✏️ Modifier</button>
        </form>

        // Formulaire SUPPRESSION 
        <form method="POST" action="supprimer.php" style="display:inline;" 
              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?');">
            <input type="hidden" name="id" value="<?= $produit['id'] ?>">
            <button type="submit" class="btn btn-danger btn-sm">🗑️ Supprimer</button>
        </form>
    </td>
<?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

-->

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>


