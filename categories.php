<?php
session_start();
include "config.php";

// Vérification de connexion
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

// ➕ Ajouter une catégorie
if (isset($_POST['add'])) {
    $nom = trim($_POST['nom']);
    if ($nom !== '') {
        $stmt = $pdo->prepare("INSERT INTO categories (nom) VALUES (?)");
        $stmt->execute([$nom]);
    }
    header("Location: categories.php");
    exit();
}

// ✏️ Modifier une catégorie
if (isset($_POST['edit'])) {
    $stmt = $pdo->prepare("UPDATE categories SET nom=? WHERE id=?");
    $stmt->execute([$_POST['nom'], $_POST['id']]);
    header("Location: categories.php");
    exit();
}

// 🗑️ Supprimer une catégorie
if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM categories WHERE id=?");
    $stmt->execute([$_GET['delete']]);
    header("Location: categories.php");
    exit();
}

// Liste des catégories
$categories = $pdo->query("SELECT * FROM categories ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);

// Récupérer les données pour modification
$editCategory = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM categories WHERE id=?");
    $stmt->execute([$_GET['edit']]);
    $editCategory = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Gestion des catégories</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
<style>
.sidebar { background: linear-gradient(135deg,#e6f7ff 0%,#b3e0ff 100%); }
.frosty-bg { background-color: #f0f9ff; }
</style>
</head>
<body class="frosty-bg">

<div class="container mt-5">
    <h2 class="mb-4"><i data-feather="grid"></i> Gestion des catégories</h2>

    <!-- Liste des catégories -->
    <div class="card mb-4">
        <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
            Liste des catégories
            <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#addModal">
                <i data-feather="plus"></i> Ajouter
            </button>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
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
    </div>
</div>

<!-- Modal Ajout -->
<div class="modal fade" id="addModal" tabindex="-1">
  <div class="modal-dialog">
    <form method="post" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Ajouter une catégorie</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="text" name="nom" class="form-control" placeholder="Nom" required>
      </div>
      <div class="modal-footer">
        <button type="submit" name="add" class="btn btn-primary">Ajouter</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal Modification -->
<?php if ($editCategory): ?>
<div class="modal fade show" style="display:block; background:rgba(0,0,0,0.5);" tabindex="-1">
  <div class="modal-dialog">
    <form method="post" class="modal-content">
      <input type="hidden" name="id" value="<?= $editCategory['id'] ?>">
      <div class="modal-header">
        <h5 class="modal-title">Modifier catégorie</h5>
        <a href="categories.php" class="btn-close"></a>
      </div>
      <div class="modal-body">
        <input type="text" name="nom" class="form-control" value="<?= htmlspecialchars($editCategory['nom']) ?>" required>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>feather.replace();</script>
</body>
</html>
