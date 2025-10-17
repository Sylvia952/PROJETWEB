<?php
session_start();
include "config.php";

if (!isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit();
}

// Marquer une alerte comme lue
if (isset($_GET['read'])) {
    $stmt = $pdo->prepare("UPDATE alertes SET lue = 1 WHERE id = ?");
    $stmt->execute([$_GET['read']]);
    header("Location: alertes.php");
    exit;
}

// Supprimer une alerte
if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM alertes WHERE id = ?");
    $stmt->execute([$_GET['delete']]);
    header("Location: alertes.php");
    exit;
}

// Récupérer toutes les alertes
$alertes = $pdo->query("SELECT a.*, c.nom AS client_nom FROM alertes a LEFT JOIN clients c ON a.client_id = c.id ORDER BY a.date_alert DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Cold Manager - Alertes</title>
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
.sidebar { background: linear-gradient(135deg, #e6f7ff 0%, #b3e0ff 100%); }
.frosty-bg { background-color: #f0f9ff; }
.alert-unread { font-weight: bold; background-color: #e6f7ff; }
</style>
</head>
<body class="frosty-bg">
<div class="flex h-screen">
    <!-- Sidebar -->
    <div class="sidebar w-64 shadow-lg flex flex-col">
        <div class="p-4 text-center border-b border-blue-200">
            <h1 class="text-2xl font-bold text-blue-800 flex items-center justify-center">
                <i data-feather="wind" class="mr-2"></i> Cold Manager
            </h1>
        </div>
        <div class="p-4 flex-1">
           <nav>
                    <ul class="space-y-1">

                        <!-- Lien commun à tous -->
                        <li>
                            <a href="dashboard.php" class="flex items-center px-4 py-2 text-blue-900 bg-blue-100 rounded-lg">
                                <i data-feather="home" class="mr-2"></i> Tableau de bord
                            </a>
                        </li>

                        <?php if ($_SESSION['role'] === 'admin'): ?>
                            <!-- 👑 MENU ADMINISTRATEUR -->
                            <li>
                                <a href="employes.php" class="flex items-center px-4 py-2 text-blue-800 hover:bg-blue-50 rounded-lg">
                                    <i data-feather="users" class="mr-2"></i> Employés
                                </a>
                            </li>

                            <li>
                                <a href="clients.php" class="flex items-center px-4 py-2 text-blue-800 hover:bg-blue-50 rounded-lg">
                                    <i data-feather="user-check" class="mr-2"></i> Clients
                                </a>
                            </li>

                            <li>
                                <a href="produits.php" class="flex items-center px-4 py-2 text-blue-800 hover:bg-blue-50 rounded-lg">
                                    <i data-feather="package" class="mr-2"></i> Produits
                                </a>
                            </li>

                            <li>
                                <a href="categories.php" class="flex items-center px-4 py-2 text-blue-800 hover:bg-blue-50 rounded-lg">
                                    <i data-feather="grid" class="mr-2"></i> Catégories
                                </a>
                            </li>

                            <li>
                                <a href="ventes.php" class="flex items-center px-4 py-2 text-blue-800 hover:bg-blue-50 rounded-lg">
                                    <i data-feather="shopping-cart" class="mr-2"></i> Ventes
                                </a>
                            </li>

                            <li>
                                <a href="factures.php" class="flex items-center px-4 py-2 text-blue-800 hover:bg-blue-50 rounded-lg">
                                    <i data-feather="file-text" class="mr-2"></i> Factures
                                </a>
                            </li>

                            <li>
                                <a href="alertes.php" class="flex items-center px-4 py-2 text-blue-800 hover:bg-blue-50 rounded-lg">
                                    <i data-feather="bell" class="mr-2"></i> Alertes
                                </a>
                            </li>


                            <li>
                                <a href="statistiques.php" class="flex items-center px-4 py-2 text-blue-800 hover:bg-blue-50 rounded-lg">
                                    <i data-feather="bar-chart-2" class="mr-2"></i> Statistiques
                                </a>
                            </li>

                        <?php elseif ($_SESSION['role'] === 'user'): ?>
                            <!-- 👷 MENU EMPLOYÉ -->
                            <li>
                                <a href="clients.php" class="flex items-center px-4 py-2 text-blue-800 hover:bg-blue-50 rounded-lg">
                                    <i data-feather="users" class="mr-2"></i> Clients
                                </a>
                            </li>

                            <li>
                                <a href="ventes.php" class="flex items-center px-4 py-2 text-blue-800 hover:bg-blue-50 rounded-lg">
                                    <i data-feather="shopping-cart" class="mr-2"></i> Enregistrer une vente
                                </a>
                            </li>

                            <li>
                                <a href="produits.php" class="flex items-center px-4 py-2 text-blue-800 hover:bg-blue-50 rounded-lg">
                                    <i data-feather="package" class="mr-2"></i> Produits disponibles
                                </a>
                            </li>

                            <li>
                                <a href="factures.php" class="flex items-center px-4 py-2 text-blue-800 hover:bg-blue-50 rounded-lg">
                                    <i data-feather="file-text" class="mr-2"></i> Factures
                                </a>
                            </li>

                            <li>
                                <a href="alertes.php" class="flex items-center px-4 py-2 text-blue-800 hover:bg-blue-50 rounded-lg">
                                    <i data-feather="bell" class="mr-2"></i> Alertes
                                </a>
                            </li>

                           

                        <?php endif; ?>

                        <!-- Lien commun -->
                        <li>
                            <a href="../deconnexion.php" class="flex items-center px-4 py-2 text-red-700 hover:bg-red-50 rounded-lg">
                                <i data-feather="log-out" class="mr-2"></i> Déconnexion
                            </a>
                        </li>

                    </ul>

                </nav>
        </div>
    </div>

    <!-- Main content -->
    <div class="flex-1 overflow-auto">
        <header class="bg-white shadow-sm p-4 flex justify-between items-center">
            <h2 class="text-xl font-semibold text-blue-800"><i data-feather="bell" class="inline mr-2"></i> Alertes</h2>
            <b><?= htmlspecialchars($_SESSION['user_nom'] . ' ' . $_SESSION['user_prenom']) ?></b>
        </header>

        <main class="p-6">
            <div class="bg-white rounded-lg shadow p-6 mb-8">
                <h3 class="font-semibold text-blue-800 text-xl mb-4">Liste des alertes</h3>
                <div class="overflow-x-auto">
                    <table class="table table-bordered w-full">
                        <thead class="bg-blue-50">
                            <tr>
                                <th>ID</th>
                                <th>Client</th>
                                <th>Message</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($alertes as $a): ?>
                                <tr class="<?= $a['lue'] ? '' : 'alert-unread' ?>">
                                    <td><?= $a['id'] ?></td>
                                    <td><?= htmlspecialchars($a['client_nom'] ?? '-') ?></td>
                                    <td><?= htmlspecialchars($a['message']) ?></td>
                                    <td><?= date('d/m/Y H:i', strtotime($a['date_alert'])) ?></td>
                                    <td>
                                        <?php if (!$a['lue']): ?>
                                            <a href="?read=<?= $a['id'] ?>" class="btn btn-success btn-sm">Marquer lu</a>
                                        <?php endif; ?>
                                        <a href="?delete=<?= $a['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer cette alerte ?')">Supprimer</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>feather.replace();</script>
</body>
</html>
