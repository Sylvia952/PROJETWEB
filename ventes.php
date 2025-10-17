<?php
session_start();
include "config.php";
if (!isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit();
}

// ➕ Ajouter une vente
if (isset($_POST['add'])) {
    $produit_id = $_POST['produit_id'];
    $client_id = $_POST['client_id'];
    $quantite = $_POST['quantite'];

    // Récupérer le prix et la quantité du produit
    $stmt = $pdo->prepare("SELECT prix, quantite FROM produits WHERE id=?");
    $stmt->execute([$produit_id]);
    $produit = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($produit && $quantite > 0 && $quantite <= $produit['quantite']) {
        $total = $produit['prix'] * $quantite;

        // Insérer la vente
        $stmt = $pdo->prepare("INSERT INTO ventes (produit_id, client_id, quantite, total) VALUES (?, ?, ?, ?)");
        $stmt->execute([$produit_id, $client_id, $quantite, $total]);

        // Mettre à jour le stock
        $newStock = $produit['quantite'] - $quantite;
        $updateStock = $pdo->prepare("UPDATE produits SET quantite=? WHERE id=?");
        $updateStock->execute([$newStock, $produit_id]);
    }

    header("Location: ventes.php");
    exit;
}

// 🗑️ Supprimer une vente
if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM ventes WHERE id=?");
    $stmt->execute([$_GET['delete']]);
    header("Location: ventes.php");
    exit;
}

// 📋 Récupérer la liste des ventes
$ventes = $pdo->query("
    SELECT v.*, p.nom AS produit_nom, c.nom AS client_nom
    FROM ventes v
    JOIN produits p ON v.produit_id = p.id
    JOIN clients c ON v.client_id = c.id
    ORDER BY v.id DESC
")->fetchAll(PDO::FETCH_ASSOC);

// Récupérer les produits et clients pour le formulaire
$produits = $pdo->query("SELECT id, nom FROM produits")->fetchAll(PDO::FETCH_ASSOC);
$clients = $pdo->query("SELECT id, nom FROM clients")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cold Management - Ventes</title>
    <link rel="icon" type="image/x-icon" href="/static/favicon.ico">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .sidebar {
            background: linear-gradient(135deg, #e6f7ff 0%, #b3e0ff 100%);
        }
        .frosty-bg { background-color: #f0f9ff; }
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
                            <a href="index.php" class="flex items-center px-4 py-2 text-blue-900 bg-blue-100 rounded-lg">
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
                                <a href="paiements.php" class="flex items-center px-4 py-2 text-blue-800 hover:bg-blue-50 rounded-lg">
                                    <i data-feather="credit-card" class="mr-2"></i> Paiements
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

                            <li>
                                <a href="paiements.php" class="flex items-center px-4 py-2 text-blue-800 hover:bg-blue-50 rounded-lg">
                                    <i data-feather="credit-card" class="mr-2"></i> Paiements
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

    <!-- Contenu principal -->
    <div class="flex-1 overflow-auto">
        <header class="bg-white shadow-sm p-4 flex justify-between items-center">
                <h2 class="text-xl font-semibold text-blue-800">
                    <i data-feather="users" class="inline mr-2"></i> Gestion des ventes
                </h2>

                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <i data-feather="bell" class="text-blue-600"></i>
                        <span class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 text-white text-xs rounded-full flex items-center justify-center alert-bubble">3</span>
                    </div>
                    <div class="w-8 h-8 rounded-full bg-blue-100 overflow-hidden">
                        <img src="http://static.photos/blue/200x200/42" class="w-full h-full object-cover">
                    </div>
                    <b>
                        <?php echo $_SESSION['user_nom'] . ' ' . $_SESSION['user_prenom']; ?>

                    </b>
                </div>
            </header>

        <main class="p-6">
            <div class="bg-white rounded-lg shadow p-6 mb-8">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-semibold text-blue-800 text-xl">Liste des ventes</h3>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                        <i data-feather="plus"></i> Ajouter
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="table table-bordered w-full">
                        <thead class="bg-blue-50">
                            <tr>
                                <th>Produit</th>
                                <th>Client</th>
                                <th>Quantité</th>
                                <th>Total</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($ventes as $v): ?>
                            <tr>
                                <td><?= htmlspecialchars($v['produit_nom']) ?></td>
                                <td><?= htmlspecialchars($v['client_nom']) ?></td>
                                <td><?= $v['quantite'] ?></td>
                                <td><strong><?= number_format($v['total'], 2, ',', ' ') ?> F</strong></td>
                                <td><?= date('d/m/Y H:i', strtotime($v['date_vente'])) ?></td>
                                <td>
                                    <a href="?delete=<?= $v['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer cette vente ?')">
                                        <i data-feather="trash-2"></i>
                                    </a>
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

<!-- Modal Ajout Vente -->
<div class="modal fade" id="addModal" tabindex="-1">
  <div class="modal-dialog">
    <form method="post" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Nouvelle Vente</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <select name="produit_id" class="form-select mb-3" required>
            <option value="">Sélectionner un produit</option>
            <?php foreach ($produits as $p): ?>
                <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['nom']) ?></option>
            <?php endforeach; ?>
        </select>

        <select name="client_id" class="form-select mb-3" required>
            <option value="">Sélectionner un client</option>
            <?php foreach ($clients as $c): ?>
                <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['nom']) ?></option>
            <?php endforeach; ?>
        </select>

        <input type="number" name="quantite" class="form-control mb-2" placeholder="Quantité" min="1" required>
      </div>
      <div class="modal-footer">
        <button type="submit" name="add" class="btn btn-success">Enregistrer</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
      </div>
    </form>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>feather.replace();</script>
</body>
</html>
