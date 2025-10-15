<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
    header('Location: ../index.php');
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Admin</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Dashboard Administrateur</h1>
        <div class="alert alert-info">
            <p>Bienvenue <strong><?php echo $_SESSION['user_nom'] . ' ' . $_SESSION['user_prenom']; ?></strong>!</p>
            <p>Vous avez accès à toutes les fonctionnalités administratives.</p>
        </div>
        <a href="produits.php" class="btn btn-primary">Gérer les produits</a>
        <a href="../deconnexion.php" class="btn btn-secondary">Déconnexion</a>
    </div>
</body>
</html>