# PROJETWEB
REMARQUES ET RECOMMANDATIONS

- il faut toujours avoir un fichier index qui demarre le projet 
pourquoi ? 

parceque: Le fichier index est le point d’entrée principal d’un site web

- ajouter ne marche pas  
- pour tous projet en ce qui concerce les fonctionnalités , il faut avoir l'habitude de commencer par l'authentification(inscription et connexion)

- tu peux faire la mise en forme de index.php comme ca te plait , moi j'ai juste faire quelque chose 






<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
    header('Location: ../index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - ColdManager</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .sidebar {
            background: linear-gradient(135deg, #0078D7, #00b894);
            color: white;
            min-height: 100vh;
            box-shadow: 3px 0 10px rgba(0,0,0,0.1);
        }
        .sidebar .nav-link {
            color: white;
            padding: 15px 20px;
            margin: 5px 0;
            border-radius: 8px;
            transition: all 0.3s;
        }
        .sidebar .nav-link:hover {
            background-color: rgba(255,255,255,0.2);
            transform: translateX(5px);
        }
        .sidebar .nav-link.active {
            background-color: rgba(255,255,255,0.3);
            font-weight: bold;
        }
        .main-content {
            padding: 30px;
        }
        .welcome-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        .stat-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
            transition: transform 0.3s;
            border-left: 4px solid #0078D7;
        }
        .stat-card:hover {
            transform: translateY(-5px);
        }
        .admin-avatar {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #0078D7, #00b894);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: white;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 sidebar">
                <div class="position-sticky pt-4">
                    <!-- Admin Info -->
                    <div class="text-center mb-4">
                        <div class="admin-avatar mb-3">
                            <i class="fas fa-crown"></i>
                        </div>
                        <h5>HOUNDJO Sylvia</h5>
                        <p class="text-light">Administrateur</p>
                        <small>sylviahoundjo9@gmail.com</small>
                    </div>

                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="dashboard.php">
                                <i class="fas fa-tachometer-alt me-2"></i>
                                Tableau de Bord
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="produits.php">
                                <i class="fas fa-box me-2"></i>
                                Gestion des Produits
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="utilisateurs.php">
                                <i class="fas fa-users me-2"></i>
                                Gestion des Utilisateurs
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="rapports.php">
                                <i class="fas fa-chart-bar me-2"></i>
                                Rapports
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="parametres.php">
                                <i class="fas fa-cogs me-2"></i>
                                Paramètres
                            </a>
                        </li>
                        <li class="nav-item mt-4">
                            <a class="nav-link text-warning" href="../deconnexion.php">
                                <i class="fas fa-sign-out-alt me-2"></i>
                                Déconnexion
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 main-content">
                <!-- Welcome Card -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card welcome-card">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <h2 class="card-title">Bonjour, HOUNDJO Sylvia ! 👑</h2>
                                        <p class="card-text">Bienvenue dans votre espace d'administration ColdManager.</p>
                                        <p class="card-text">Vous avez un accès complet à toutes les fonctionnalités du système.</p>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <i class="fas fa-shield-alt fa-5x opacity-75"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Statistics Cards -->
                <div class="row">
                    <div class="col-md-3 mb-4">
                        <div class="card stat-card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h3 class="text-primary">156</h3>
                                        <p class="text-muted">Produits Total</p>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-boxes text-primary fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-3 mb-4">
                        <div class="card stat-card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h3 class="text-success">24</h3>
                                        <p class="text-muted">Utilisateurs</p>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-users text-success fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-3 mb-4">
                        <div class="card stat-card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h3 class="text-warning">8</h3>
                                        <p class="text-muted">Produits Expirés</p>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-exclamation-triangle text-warning fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-3 mb-4">
                        <div class="card stat-card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h3 class="text-info">12</h3>
                                        <p class="text-muted">Bientôt Expirés</p>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-clock text-info fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">
                                    <i class="fas fa-bolt me-2"></i>
                                    Actions Rapides
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3 text-center mb-3">
                                        <a href="ajt_pdt.php" class="btn btn-outline-primary btn-lg p-3 w-100">
                                            <i class="fas fa-plus-circle fa-2x mb-2"></i><br>
                                            Ajouter Produit
                                        </a>
                                    </div>
                                    <div class="col-md-3 text-center mb-3">
                                        <a href="produits.php" class="btn btn-outline-success btn-lg p-3 w-100">
                                            <i class="fas fa-list fa-2x mb-2"></i><br>
                                            Voir Produits
                                        </a>
                                    </div>
                                    <div class="col-md-3 text-center mb-3">
                                        <a href="utilisateurs.php" class="btn btn-outline-info btn-lg p-3 w-100">
                                            <i class="fas fa-user-plus fa-2x mb-2"></i><br>
                                            Gérer Utilisateurs
                                        </a>
                                    </div>
                                    <div class="col-md-3 text-center mb-3">
                                        <a href="rapports.php" class="btn btn-outline-warning btn-lg p-3 w-100">
                                            <i class="fas fa-chart-pie fa-2x mb-2"></i><br>
                                            Voir Rapports
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-info text-white">
                                <h5 class="mb-0">
                                    <i class="fas fa-history me-2"></i>
                                    Activité Récente
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="list-group">
                                    <div class="list-group-item">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1">Nouveau produit ajouté</h6>
                                            <small>Il y a 5 minutes</small>
                                        </div>
                                        <p class="mb-1">Poisson frais - Catégorie Poissons</p>
                                    </div>
                                    <div class="list-group-item">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1">Utilisateur connecté</h6>
                                            <small>Il y a 15 minutes</small>
                                        </div>
                                        <p class="mb-1">Jean Dupont s'est connecté</p>
                                    </div>
                                    <div class="list-group-item">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1">Produit supprimé</h6>
                                            <small>Il y a 1 heure</small>
                                        </div>
                                        <p class="mb-1">Viande expirée supprimée</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>