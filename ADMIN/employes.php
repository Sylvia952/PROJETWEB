<?php 
include "../config.php"; 
if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
    if (
        isset($_POST['nom'], $_POST['prenom'], $_POST['email'], $_POST['age']) &&
        !empty($_POST['nom']) && !empty($_POST['prenom']) &&
        !empty($_POST['email']) && !empty($_POST['age'])
    ) {
        $nom = trim($_POST['nom']);
        $prenom = trim($_POST['prenom']);
        $email = trim($_POST['email']);
        $age = trim($_POST['age']); 

     try {
            
            $checkStmt = $pdo->prepare("SELECT id FROM employes WHERE email = ?");
            $checkStmt->execute([$email]);
            $existingEmployes = $checkStmt->fetch();

            if ($existingEmployes) {
                $message_erreur = "❌ L'email '$email' est déjà utilisé par un autre employé.";
            } else {
                $stmt = $pdo->prepare("INSERT INTO employes (nom, prenom, email, age) VALUES (?, ?, ?, ?)");
                
                if ($stmt->execute([$nom, $prenom, $email, $age])) {
                    $id_employes = $pdo->lastInsertId();
                    $message_success = " Employé $prenom $nom ajouté avec succès! (ID: $id_employes)";

                    $stmt = $pdo->query("SELECT * FROM employes ORDER BY id DESC");
                    $employes = $stmt->fetchAll(PDO::FETCH_ASSOC);
                } else {
                    $message_erreur = "❌ Erreur lors de l'insertion dans la base de données.";
                }
            }
        } catch(PDOException $e) {
            $message_erreur = "❌ Erreur base de données : " . $e->getMessage();
        }
    } else {
        $message_erreur = "❌ Tous les champs sont obligatoires.";
    }
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ADMIN</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center">Ajouter un employé</h2>

    <form method="POST" class="mt-4">
        <div class="form-group">
            <label for="nom">Nom</label>
            <input type="text" class="form-control" name="nom" id="nom" placeholder="Nom" required>
        </div>

        <div class="form-group">
            <label for="prenom">Prenoms</label>
         <input type="text" class="form-control" name="prenom" id="prenom" placeholder="Prenoms" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" name="email" id="eamil" placeholder="Votre email" required>
        </div>

        <div class="form-group">
            <label for="age">Âge</label>
            <input type="text" class="form-control" name="age" id="age" placeholder="Votre âge" required>
        </div>

        <button type="submit" class="btn btn-primary btn-block">AJOUTER</button>
    </form>
</div>



<div class="container mt-5">
    <h2 class="text-center">Liste des employés</h2>

    <table class="table table-bordered table-striped mt-4">
        <thead>
            <tr>
                <th>NOMS</th>
                <th>PRENOMS</th>
                <th>EMAIL</th>
                <th>ÂGE</th>
                <th>ACTION</th>
            </tr>
        </thead>
         <tbody>
            <?php if (!empty($employes)): ?>
                <?php foreach ($employes as $employe): ?>
                <tr>
                    <td><strong><?= htmlspecialchars($employe['nom']) ?></strong></td>
                    <td>
                        <span style="background: #e9ecef; padding: 4px 8px; border-radius: 12px; font-size: 12px;">
                            <?= htmlspecialchars($employe['prenom']) ?>
                        </span>
                    </td>
                    <td>
                        <span style="background: #e9ecef; padding: 4px 8px; border-radius: 12px; font-size: 12px;">
                            <?= htmlspecialchars($employe['email']) ?>
                        </span>
                    </td>
                    <td>
                        <span style="background: #e9ecef; padding: 4px 8px; border-radius: 12px; font-size: 12px;">
                            <?= htmlspecialchars($employe['age']) ?>
                        </span>
                    </td>
                    <td>
                        <?php if (!empty($employe['id'])): ?>
                        <form method="GET" action="modif_employe.php" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $employe['id'] ?>">
                            <button type="submit" class="btn btn-warning btn-sm">✏️ Modifier</button>
                        </form>

                        <form method="POST" action="suppr_employe.php" style="display:inline;" 
                            onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet employé ?');">
                            <input type="hidden" name="id" value="<?= $employe['id'] ?>">
                            <button type="submit" class="btn btn-danger btn-sm">🗑️ Supprimer</button>
                        </form>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">Aucun employé trouvé</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>



<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>