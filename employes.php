<?php
session_start();
include "config.php";
if (!isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit();
}
// Ajouter un employé
if (isset($_POST['add'])) {
    $stmt = $pdo->prepare("INSERT INTO employes (nom, prenom, email, age) VALUES (?, ?, ?, ?)");
    $stmt->execute([$_POST['nom'], $_POST['prenom'], $_POST['email'], $_POST['age']]);
    header("Location: employes.php");
    exit;
}

// Modifier un employé
if (isset($_POST['edit'])) {
    $stmt = $pdo->prepare("UPDATE employes SET nom=?, prenom=?, email=?, age=? WHERE id=?");
    $stmt->execute([$_POST['nom'], $_POST['prenom'], $_POST['email'], $_POST['age'], $_POST['id']]);
    header("Location: employes.php");
    exit;
}

// Supprimer un employé
if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM employes WHERE id=?");
    $stmt->execute([$_GET['delete']]);
    header("Location: employes.php");
    exit;
}

// Récupérer la liste des employés
$employes = $pdo->query("SELECT * FROM employes")->fetchAll(PDO::FETCH_ASSOC);

// Récupérer les données pour modification
$editEmploye = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM employes WHERE id=?");
    $stmt->execute([$_GET['edit']]);
    $editEmploye = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cold Management</title>
    <link rel="icon" type="image/x-icon" href="/static/favicon.ico">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .sidebar {
            background: linear-gradient(135deg, #e6f7ff 0%, #b3e0ff 100%);
        }

        .frosty-bg {
            background-color: #f0f9ff;
        }

        .alert-bubble {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }

            100% {
                transform: scale(1);
            }
        }
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

        <!-- Main Content -->
        <div class="flex-1 overflow-auto">
            <!-- Top Bar -->
            <header class="bg-white shadow-sm p-4 flex justify-between items-center">
                <h2 class="text-xl font-semibold text-blue-800">
                    <i data-feather="users" class="inline mr-2"></i> Gestion des employés
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

            <!-- Dashboard Content -->
            <main class="p-6">
                <div class="bg-white rounded-lg shadow p-6 mb-8">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-semibold text-blue-800 text-xl">Listes des Employés</h3>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                            <i class="mr-2"></i> Ajouter
                        </button>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="table table-bordered w-full">
                            <thead class="bg-blue-50">
                                <tr>
                                    <th>Nom</th>
                                    <th>Prénom</th>
                                    <th>Email</th>
                                    <th>Âge</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($employes as $emp): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($emp['nom']) ?></td>
                                        <td><?= htmlspecialchars($emp['prenom']) ?></td>
                                        <td><?= htmlspecialchars($emp['email']) ?></td>
                                        <td><?= htmlspecialchars($emp['age']) ?></td>
                                        <td>
                                            <a href="?edit=<?= $emp['id'] ?>" class="btn btn-warning btn-sm">Modifier</a>
                                            <a href="?delete=<?= $emp['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer cet employé ?')">Supprimer</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Modal Ajout -->
                <div class="modal fade" id="addModal" tabindex="-1">
                    <div class="modal-dialog">
                        <form method="post" class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Ajouter un Employé</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <input type="text" name="nom" class="form-control mb-2" placeholder="Nom" required>
                                <input type="text" name="prenom" class="form-control mb-2" placeholder="Prénom" required>
                                <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>
                                <input type="number" name="age" class="form-control mb-2" placeholder="Âge" required>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" name="add" class="btn btn-primary">Ajouter</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Modal Modification -->
                <?php if ($editEmploye): ?>
                    <div class="modal fade show" style="display:block; background:rgba(0,0,0,0.5);" id="editModal" tabindex="-1">
                        <div class="modal-dialog">
                            <form method="post" class="modal-content">
                                <input type="hidden" name="id" value="<?= $editEmploye['id'] ?>">
                                <div class="modal-header">
                                    <h5 class="modal-title">Modifier Employé</h5>
                                    <a href="employes.php" class="btn-close"></a>
                                </div>
                                <div class="modal-body">
                                    <input type="text" name="nom" class="form-control mb-2" value="<?= htmlspecialchars($editEmploye['nom']) ?>" required>
                                    <input type="text" name="prenom" class="form-control mb-2" value="<?= htmlspecialchars($editEmploye['prenom']) ?>" required>
                                    <input type="email" name="email" class="form-control mb-2" value="<?= htmlspecialchars($editEmploye['email']) ?>" required>
                                    <input type="number" name="age" class="form-control mb-2" value="<?= htmlspecialchars($editEmploye['age']) ?>" required>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" name="edit" class="btn btn-warning">Modifier</button>
                                    <a href="employes.php" class="btn btn-secondary">Annuler</a>
                                </div>
                            </form>
                        </div>
                    </div>
                    <script>
                        document.body.classList.add('modal-open');
                    </script>
                <?php endif; ?>
            </main>
        </div>
    </div>

    <script>
        feather.replace();

        // Simple animation for stats cards
        document.querySelectorAll('.bg-white').forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = `all 0.3s ease ${index * 0.1}s`;

            setTimeout(() => {
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, 100);
        });
    </script>
</body>

</html>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>