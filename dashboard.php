<?php
session_start();
if (!isset($_SESSION['user_id']) ) {
    header('Location: ../index.php');
    exit();
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
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
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
                <i data-feather="package" class="mr-2"></i> Produits & Stocks
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
                <i data-feather="bell" class="mr-2"></i> Alertes (stock / péremption)
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
        <a href="logout.php" class="flex items-center px-4 py-2 text-red-700 hover:bg-red-50 rounded-lg">
            <i data-feather="log-out" class="mr-2"></i> Déconnexion
        </a>
    </li>

</ul>

                </nav>
            </div>

            <div class="p-4 border-t border-blue-200">
                <a href="../deconnexion.php" class="flex items-center btn btn-primary px-4 py-2 text-white-600 hover:bg-red-50 rounded-lg">
                    <i class="mr-2"></i> <b>Deconnexion</b>
                </a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 overflow-auto">
            <!-- Top Bar -->
            <header class="bg-white shadow-sm p-4 flex justify-between items-center">
                <h2 class="text-xl font-semibold text-blue-800">
                    <i data-feather="home" class="inline mr-2"></i> 
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
                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm text-gray-500">Total Produits</p>
                                <h3 class="text-2xl font-bold text-blue-800">1,245</h3>
                            </div>
                            <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                                <i data-feather="package"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-red-500">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm text-gray-500">Produit Expirer</p>
                                <h3 class="text-2xl font-bold text-red-800">23</h3>
                            </div>
                            <div class="p-3 rounded-full bg-red-100 text-red-600">
                                <i data-feather="alert-circle"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm text-gray-500">Total Ventes</p>
                                <h3 class="text-2xl font-bold text-green-800">$42,567</h3>
                            </div>
                            <div class="p-3 rounded-full bg-green-100 text-green-600">
                                <i data-feather="dollar-sign"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-purple-500">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm text-gray-500">Clients</p>
                                <h3 class="text-2xl font-bold text-purple-800">89</h3>
                            </div>
                            <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                                <i data-feather="users"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charts Section -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="font-semibold text-blue-800">Sales Overview</h3>
                            <div class="flex space-x-2">
                                <button class="px-3 py-1 text-xs bg-blue-100 text-blue-800 rounded">Week</button>
                                <button class="px-3 py-1 text-xs bg-white text-gray-600 rounded">Month</button>
                                <button class="px-3 py-1 text-xs bg-white text-gray-600 rounded">Year</button>
                            </div>
                        </div>
                        <div class="h-64 bg-gray-50 rounded flex items-center justify-center">
                            <p class="text-gray-400">Chart will be rendered here</p>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="font-semibold text-blue-800">Product Categories</h3>
                            <i data-feather="more-horizontal" class="text-gray-400"></i>
                        </div>
                        <div class="h-64 bg-gray-50 rounded flex items-center justify-center">
                            <p class="text-gray-400">Pie chart will be rendered here</p>
                        </div>
                    </div>
                </div>

                <!-- Recent Alerts -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="p-4 border-b border-gray-200">
                        <h3 class="font-semibold text-blue-800 flex items-center">
                            <i data-feather="bell" class="mr-2"></i> Recent Alerts
                        </h3>
                    </div>
                    <div class="divide-y divide-gray-200">
                        <div class="p-4 hover:bg-blue-50 flex items-start">
                            <div class="p-2 rounded-full bg-red-100 text-red-600 mr-3">
                                <i data-feather="alert-triangle" class="w-4 h-4"></i>
                            </div>
                            <div>
                                <p class="font-medium">12 products will expire tomorrow!</p>
                                <p class="text-sm text-gray-500">Meat category - Cold Room A</p>
                            </div>
                            <div class="ml-auto text-sm text-gray-500">2h ago</div>
                        </div>
                        <div class="p-4 hover:bg-blue-50 flex items-start">
                            <div class="p-2 rounded-full bg-orange-100 text-orange-600 mr-3">
                                <i data-feather="alert-circle" class="w-4 h-4"></i>
                            </div>
                            <div>
                                <p class="font-medium">Low stock for dairy products</p>
                                <p class="text-sm text-gray-500">Only 5 units remaining</p>
                            </div>
                            <div class="ml-auto text-sm text-gray-500">5h ago</div>
                        </div>
                        <div class="p-4 hover:bg-blue-50 flex items-start">
                            <div class="p-2 rounded-full bg-yellow-100 text-yellow-600 mr-3">
                                <i data-feather="clock" class="w-4 h-4"></i>
                            </div>
                            <div>
                                <p class="font-medium">Temperature alert in Cold Room B</p>
                                <p class="text-sm text-gray-500">Temperature rose to 5°C</p>
                            </div>
                            <div class="ml-auto text-sm text-gray-500">1d ago</div>
                        </div>
                    </div>
                    <div class="p-3 bg-gray-50 text-center">
                        <a href="#" class="text-sm text-blue-600 hover:underline">View all alerts</a>
                    </div>
                </div>
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
