<?php
include "config.php"; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (
        isset($_POST['nom'], $_POST['prenom'], $_POST['email'], $_POST['mdp']) &&
        !empty($_POST['nom']) && !empty($_POST['prenom']) &&
         !empty($_POST['email']) && !empty($_POST['mdp'])
    ) {
        $nom = trim($_POST['nom']);
        $prenom = trim($_POST['prenom']);
        $email = trim($_POST['email']);
        $mdp = password_hash($_POST['mdp'], PASSWORD_DEFAULT); 

        $stmt = $pdo->prepare("INSERT INTO inscription (nom, prenom, email, mdp) VALUES (?, ?, ?, ?)");

        if ($stmt->execute([$nom, $prenom, $email, $mdp])) {

            $id_inscription = $pdo->lastInsertId();

        
            header("Location: connex.php?id_inscription=" . $id_inscription);
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
    <title>INSCRIPTION</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center">S'INSCRIRE</h2>

    <form method="POST" class="mt-4">
        <div class="form-group">
            <label for="nom">Nom</label>
            <input type="text" class="form-control" name="nom" id="nom" placeholder="Nom" required>
        </div>

        <div class="form-group">
            <label for="prenom">Prénom</label>
            <input type="text" class="form-control" name="prenom" id="prenom" placeholder="Prénom" required>
        </div>


        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" name="email" id="email" placeholder="Email" required>
        </div>

        <div class="form-group">
            <label for="mdp">Mot de passe</label>
            <input type="password" class="form-control" name="mdp" id="mdp" placeholder="Mot de passe" required>
        </div>

        <button type="submit" class="btn btn-primary btn-block">INSCRIPTION</button>
    </form>
</div>

<!-- Ajouter les scripts de Bootstrap -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>


