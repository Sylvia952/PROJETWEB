<?php
include "config.php";
session_start();
//j'ai supprimer la session qui étais ici 


try {
    $stmt = $pdo->prepare("SELECT * FROM ajt_pdt ORDER BY nom ASC");// le nom de la table ici, c'est ajt_pdt et non produits car tu nas pas une table produits dans ta base de donnée et aussi le nom de l'attribut apres  ORDER BY c'est nom et non dtp
    $stmt->execute();
    $produits = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur lors de la récupération des produits: " . $e->getMessage());
}

$success_message = '';
if (isset($_GET['id_produit'])) {
    $success_message = "Produit ajouté avec succès !";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Produits - ColdManager</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        .card {
            transition: transform 0.2s;
            margin-bottom: 20px;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .badge-categorie {
            font-size: 0.8rem;
        }
        .table th {
            background-color: #f8f9fa;
        }
        .alert-success {
            border-radius: 10px;
        }
        .expired {
            background-color: #ffe6e6;
        }
        .soon-expiring {
            background-color: #fff3cd;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="produits.php">
                                <i class="fas fa-box me-2"></i>
                                Produits
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../ADMIN/ajt_pdt.php">
                                <i class="fas fa-plus me-2"></i>
                                Ajouter Produit
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../deconnexion.php">
                                <i class="fas fa-sign-out-alt me-2"></i>
                                Déconnexion
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">
                        <i class="fas fa-boxes me-2"></i>
                        Liste des Produits
                    </h1>
                    <a href="../ADMIN/ajt_pdt.php" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i> Nouveau Produit
                    </a>
                </div>

                <?php if ($success_message): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?php echo htmlspecialchars($success_message); ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>

            
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card text-white bg-primary">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4><?php echo count($produits); ?></h4>
                                        <p>Total Produits</p>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-boxes fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <?php

                    $categories_count = [];
                    foreach ($produits as $produit) {
                        $categorie = $produit['categorie'];
                        if (!isset($categories_count[$categorie])) {
                            $categories_count[$categorie] = 0;
                        }
                        $categories_count[$categorie]++;
                    }
                    
                    $categorie_colors = [
                        'poissons' => 'info',
                        'viandes' => 'danger',
                        'saucisses' => 'warning'
                    ];
                    
                    foreach ($categories_count as $categorie => $count):
                        $color = $categorie_colors[$categorie] ?? 'secondary';
                    ?>
                    <div class="col-md-3">
                        <div class="card text-white bg-<?php echo $color; ?>">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4><?php echo $count; ?></h4>
                                        <p><?php echo strtoupper($categorie); ?></p>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-<?php echo $categorie == 'poissons' ? 'fish' : ($categorie == 'viandes' ? 'drumstick-bite' : 'hotdog'); ?> fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

            
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-list me-2"></i>
                            Détails des Produits
                        </h5>
                    </div>
                    <div class="card-body">
                        <?php if (empty($produits)): ?>
                            <div class="alert alert-info text-center">
                                <i class="fas fa-info-circle me-2"></i>
                                Aucun produit enregistré pour le moment.
                                <a href="../ADMIN/ajt_pdt.php" class="alert-link">Ajouter un produit</a>
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>ID</th>
                                            <th>Catégorie</th>
                                            <th>Nom</th>
                                            <th>Date de Péremption</th>
                                            <th>Jours Restants</th>
                                            <th>Statut</th>
                                            <th>Date d'ajout</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($produits as $produit): 
                                            $date_peremption = new DateTime($produit['dtp']);
                                            $aujourdhui = new DateTime();
                                            $interval = $aujourdhui->diff($date_peremption);
                                            $jours_restants = $interval->days;
                                            $is_past = $interval->invert; 
                                            
                                            if ($is_past) {
                                                $statut = 'text-danger';
                                                $badge = 'danger';
                                                $message = 'Expiré';
                                                $row_class = 'expired';
                                            } elseif ($jours_restants <= 3) {
                                                $statut = 'text-warning';
                                                $badge = 'warning';
                                                $message = 'Bientôt expiré';
                                                $row_class = 'soon-expiring';
                                            } else {
                                                $statut = 'text-success';
                                                $badge = 'success';
                                                $message = 'Valide';
                                                $row_class = '';
                                            }
                                        ?>
                                        <tr class="<?php echo $row_class; ?>">
                                            <td><?php echo htmlspecialchars($produit['id']); ?></td>
                                            <td>
                                                <span class="badge badge-<?php echo $categorie_colors[$produit['categorie']] ?? 'secondary'; ?> badge-categorie">
                                                    <?php echo strtoupper(htmlspecialchars($produit['categorie'])); ?>
                                                </span>
                                            </td>
                                            <td><?php echo htmlspecialchars($produit['nom']); ?></td>
                                            <td><?php echo htmlspecialchars(date('d/m/Y', strtotime($produit['dtp']))); ?></td>
                                            <td class="<?php echo $statut; ?> font-weight-bold">
                                                <?php 
                                                if ($is_past) {
                                                    echo 'Expiré depuis ' . $jours_restants . ' jour(s)';
                                                } else {
                                                    echo $jours_restants . ' jour(s)';
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <span class="badge badge-<?php echo $badge; ?>">
                                                    <?php echo $message; ?>
                                                </span>
                                            </td>
                                            <td>
                                                <?php echo htmlspecialchars(date('d/m/Y H:i', strtotime($produit['created_at']))); ?>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="modif_pdt.php?id=<?php echo $produit['id']; ?>" class="btn btn-outline-primary" title="Modifier">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="suppr_pdt.php?id=<?php echo $produit['id']; ?>" 
                                                       class="btn btn-outline-danger" 
                                                       onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?')">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </main>
        </div>
    </div>

    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
    
        $(document).ready(function() {
            setTimeout(function() {
                $('.alert').alert('close');
            }, 5000);
        });
    </script>
</body>
</html>