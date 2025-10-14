<?php
include "config.php";

if (!isset($_GET['id'])) {  
    die("❌ ID de l'employé manquant.");
}

$id_employe = $_GET['id'];  

$stmt = $pdo->prepare("SELECT * FROM employes WHERE id = ?");
$stmt->execute([$id_employe]); 
$employe = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$employe) {
    die("Employé non trouvé.");
}

$message = '';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $age = $_POST['age'];
    

    try {
        $stmt = $pdo->prepare("UPDATE employes SET nom = ?, prenom = ?, email = ?, age = ? WHERE id = ?");
        $stmt->execute([$nom, $prenom, $email, $age, $id_employe]); 
        
        $message = '<div class="alert alert-success">Employé modifié avec succès !</div>';
        
        $stmt = $pdo->prepare("SELECT * FROM employes WHERE id = ?");
        $stmt->execute([$id_employe]);  
        $employe = $stmt->fetch(PDO::FETCH_ASSOC);
        
    } catch(PDOException $e) {
        $message = '<div class="alert alert-danger"> Erreur : ' . $e->getMessage() . '</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Modifier l'employé</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center">Modifier l'employé</h2>
    
    <?= $message ?>
    
    <form method="POST" class="mt-4">
        
        <div class="form-group">
            <label for="nom">Nom</label>
            <input type="text" class="form-control" name="nom" id="nom" 
                   value="<?= htmlspecialchars($employe['nom']) ?>" required>
        </div>

         <label for="prenom">Prénoms</label>
            <input type="text" class="form-control" name="prenom" id="prenom" 
                   value="<?= htmlspecialchars($employe['nom']) ?>" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" name="email" id="email" 
                  value="<?= htmlspecialchars($employe['email']) ?>" required>
        </div>

        <div class="form-group">
            <label for="age">Âge</label>
            <input type="text" class="form-control" name="age" id="age" 
                  value="<?= htmlspecialchars($employe['age']) ?>" required>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block">Mettre à jour</button>
            <a href="employes.php" class="btn btn-secondary btn-block mt-2">Retour à la liste</a>
        </div>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>