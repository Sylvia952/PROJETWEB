<?php
session_start();
include "config.php";

// ✅ Vérifier la connexion
if (!isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit();
}

// ✅ Ajouter une catégorie
if (isset($_POST['add'])) {
    $nom = trim($_POST['nom']);
    if ($nom !== '') {
        $stmt = $pdo->prepare("INSERT INTO categories (nom) VALUES (?)");
        $stmt->execute([$nom]);
    }
    header("Location: categories.php");
    exit;
}

// ✅ Modifier une catégorie
if (isset($_POST['edit'])) {
    $stmt = $pdo->prepare("UPDATE categories SET nom=? WHERE id=?");
    $stmt->execute([$_POST['nom'], $_POST['id']]);
    header("Location: categories.php");
    exit;
}

// ✅ Supprimer une catégorie
if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM categories WHERE id=?");
    $stmt->execute([$_GET['delete']]);
    header("Location: categories.php");
    exit;
}

// ✅ Récupérer la liste des catégories
$categories = $pdo->query("SELECT * FROM categories ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);

// ✅ Récupérer les données pour modification
$editCategory = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM categories WHERE id=?");
    $stmt->execute([$_GET['edit']]);
    $editCategory = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Cold Manager - Catégories</title>
<link rel="icon" type="image/x-icon" href="/static/favicon.ico">
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
.sidebar { background: linear-gradient(135deg,#e6f7ff 0%,#b3e0ff 100%); }
.frosty-bg { background-color: #f0f9ff; }
</style>
</head>
<body class="frosty-bg">
<div class="flex h-screen">

    <!-- ✅ Sidebar -->
    <div class="sidebar w-64 shadow-lg flex flex-col">
        <div class="p-4 text-center border-b border-blue-200">
            <h1 class="text-2xl font-bold text-blue-800 flex items-center justify-center">
                <i data-feather="wind" class="mr-2"></i> Cold Manager
            </h1>
        </div>
        <div class="p-4 flex-1">
            <nav>

                    <ul class="space-y-1">

                        <?php if ($_SESSION['role'] === 'admin'): ?>
                        <!-- Lien commun à tous -->
                        <li>
                            <a href="dashboard.php" class="flex items-center px-4 py-2 text-blue-900 bg-blue-100 rounded-lg">
                                <i data-feather="home" class="mr-2"></i> Tableau de bord
                            </a>
                        </li>

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

    <!-- ✅ Contenu principal -->
    <div class="flex-1 overflow-auto">
         <header class="bg-white shadow-sm p-4 flex justify-between items-center">
                <h2 class="text-xl font-semibold text-blue-800">
                    <i data-feather="grid" class="inline mr-2"></i> Gestion des catégories
                </h2>
                  <div class="flex items-center space-x-4">
                    <i data-feather="bell" class="text-blue-600"></i>
                    <div class="w-8 h-8 rounded-full bg-blue-100 overflow-hidden">
                        <img src="http://static.photos/blue/200x200/42" class="w-full h-full object-cover">
                    </div>
                    <b><?= $_SESSION['user_nom'] . ' ' . $_SESSION['user_prenom'] ?></b>
                </div>
            </header>
        </header>

        <main class="p-6">
            <!-- ✅ Liste des catégories -->
            <div class="bg-white rounded-lg shadow p-6 mb-8">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-semibold text-blue-800 text-xl">Liste des catégories</h3>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                        Ajouter
                    </button>
                </div>

                <table class="table table-bordered">
                    <thead class="bg-blue-50">
                        <tr>
                            <th>#</th>
                            <th>Nom</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($categories as $cat): ?>
                            <tr>
                                <td><?= $cat['id'] ?></td>
                                <td><?= htmlspecialchars($cat['nom']) ?></td>
                                <td>
                                    <a href="?edit=<?= $cat['id'] ?>" class="btn btn-warning btn-sm">Modifier</a>
                                    <a href="?delete=<?= $cat['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer cette catégorie ?')">Supprimer</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- ✅ Modal Ajout -->
            <div class="modal fade" id="addModal" tabindex="-1">
                <div class="modal-dialog">
                    <form method="post" class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Ajouter une catégorie</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <input type="text" name="nom" class="form-control mb-2" placeholder="Nom" required>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" name="add" class="btn btn-primary">Ajouter</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- ✅ Modal Édition -->
            <?php if ($editCategory): ?>
                <div class="modal fade show" style="display:block; background:rgba(0,0,0,0.5);" id="editModal">
                    <div class="modal-dialog">
                        <form method="post" class="modal-content">
                            <input type="hidden" name="id" value="<?= $editCategory['id'] ?>">
                            <div class="modal-header">
                                <h5 class="modal-title">Modifier catégorie</h5>
                                <a href="categories.php" class="btn-close"></a>
                            </div>
                            <div class="modal-body">
                                <input type="text" name="nom" class="form-control mb-2" value="<?= htmlspecialchars($editCategory['nom']) ?>" required>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" name="edit" class="btn btn-warning">Modifier</button>
                                <a href="categories.php" class="btn btn-secondary">Annuler</a>
                            </div>
                        </form>
                    </div>
                </div>
                <script>document.body.classList.add('modal-open');</script>
            <?php endif; ?>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>feather.replace();</script>
</body>
</html>
