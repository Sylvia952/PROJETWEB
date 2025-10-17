<?php
session_start();
include "config.php";
require_once __DIR__ . '/lib/fpdf.php'; // FPDF inclus directement

if (!isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit();
}

// Récupérer toutes les ventes/factures
$ventes = $pdo->query("
    SELECT v.id, v.date_vente, v.quantite, v.prix_total,
           c.nom AS client_nom,
           p.nom AS produit_nom,
           p.prix AS prix_unitaire
    FROM ventes v
    JOIN clients c ON v.client_id = c.id
    JOIN produits p ON v.produit_id = p.id
    ORDER BY v.date_vente DESC
")->fetchAll(PDO::FETCH_ASSOC);

// Génération PDF avec FPDF si demandé
if (isset($_GET['download'])) {
    $id = intval($_GET['download']);

    $stmt = $pdo->prepare("
        SELECT v.id, v.date_vente, v.quantite, v.prix_total,
               c.nom AS client_nom, c.telephone,
               p.nom AS produit_nom, p.prix AS prix_unitaire
        FROM ventes v
        JOIN clients c ON v.client_id = c.id
        JOIN produits p ON v.produit_id = p.id
        WHERE v.id = ?
    ");
    $stmt->execute([$id]);
    $vente = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$vente) die("Vente non trouvée");

    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 10, "Facture Vente #" . $vente['id'], 0, 1, 'C');

    $pdf->SetFont('Arial', '', 12);
    $pdf->Ln(5);
    $pdf->Cell(50, 8, "Date:", 0, 0);
    $pdf->Cell(0, 8, date('d/m/Y', strtotime($vente['date_vente'])), 0, 1);
    $pdf->Cell(50, 8, "Client:", 0, 0);
    $pdf->Cell(0, 8, $vente['client_nom'], 0, 1);
    $pdf->Cell(50, 8, "Téléphone:", 0, 0);
    $pdf->Cell(0, 8, $vente['telephone'], 0, 1);

    $pdf->Ln(5);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(60, 8, "Produit", 1);
    $pdf->Cell(40, 8, "Prix Unitaire", 1);
    $pdf->Cell(30, 8, "Quantité", 1);
    $pdf->Cell(40, 8, "Total", 1);
    $pdf->Ln();

    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(60, 8, $vente['produit_nom'], 1);
    $pdf->Cell(40, 8, number_format($vente['prix_unitaire'], 2, ",", " "), 1);
    $pdf->Cell(30, 8, $vente['quantite'], 1);
    $pdf->Cell(40, 8, number_format($vente['prix_total'], 2, ",", " "), 1);
    $pdf->Ln(20);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 8, "Montant total: " . number_format($vente['prix_total'], 2, ",", " ") . " FCFA", 0, 1);

    $pdf->Output('D', "facture_vente_" . $vente['id'] . ".pdf");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cold Manager - Factures</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
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
                <h2 class="text-xl font-semibold text-blue-800">
                    <i data-feather="file-text" class="inline mr-2"></i> Factures
                </h2>
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <i data-feather="bell" class="text-blue-600"></i>
                        <span class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 text-white text-xs rounded-full flex items-center justify-center alert-bubble">3</span>
                    </div>
                    <div class="w-8 h-8 rounded-full bg-blue-100 overflow-hidden">
                        <img src="http://static.photos/blue/200x200/42" class="w-full h-full object-cover">
                    </div>
                    <b><?php echo $_SESSION['user_nom'] . ' ' . $_SESSION['user_prenom']; ?></b>
                </div>
            </header>

            <main class="p-6">
                <div class="bg-white rounded-lg shadow p-6 mb-8">
                    <h3 class="font-semibold text-blue-800 text-xl mb-4">Liste des factures</h3>
                    <div class="overflow-x-auto">
                        <table class="table table-bordered w-full">
                            <thead class="bg-blue-50">
                                <tr>
                                    <th>ID</th>
                                    <th>Produit</th>
                                    <th>Client</th>
                                    <th>Quantité</th>
                                    <th>Prix Total (FCFA)</th>
                                    <th>Date</th>
                                    <th>Options</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($ventes as $v): ?>
                                    <tr>
                                        <td><?= $v['id'] ?></td>
                                        <td><?= htmlspecialchars($v['produit_nom']) ?></td>
                                        <td><?= htmlspecialchars($v['client_nom']) ?></td>
                                        <td><?= $v['quantite'] ?></td>
                                        <td><?= number_format($v['prix_total'], 2, ',', ' ') ?></td>
                                        <td><?= date('d/m/Y', strtotime($v['date_vente'])) ?></td>
                                        <td>
                                            <a href="?download=<?= $v['id'] ?>" class="btn btn-success btn-sm">Télécharger PDF</a>
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
    <script>
        feather.replace();
    </script>
</body>

</html>