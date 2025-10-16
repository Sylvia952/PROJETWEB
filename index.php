<?php
session_start();
include "config.php";

$error = '';
$success = '';

try {
    // Vérifie s'il y a déjà des utilisateurs
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM inscription");
    $count = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

    // Si aucun utilisateur, créer un admin par défaut
    if ($count == 0) {
        $default_email = "admin@coldmanager.com";
        $default_pass = password_hash("admin123", PASSWORD_DEFAULT);
        $pdo->prepare("INSERT INTO inscription (nom, prenom, email, mdp, role) VALUES (?, ?, ?, ?, ?)")
            ->execute(["Admin", "Principal", $default_email, $default_pass, "admin"]);
    }
} catch (PDOException $e) {
    die("Erreur initiale : " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // === CONNEXION ===
    if (isset($_POST['login'])) {
        $email = trim($_POST['email']);
        $password = $_POST['mdp'];

        if (empty($email) || empty($password)) {
            $error = "Veuillez remplir tous les champs";
        } else {
            try {
                $stmt = $pdo->prepare("SELECT * FROM inscription WHERE email = ?");
                $stmt->execute([$email]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($user && password_verify($password, $user['mdp'])) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_email'] = $user['email'];
                    $_SESSION['user_nom'] = $user['nom'];
                    $_SESSION['user_prenom'] = $user['prenom'];
                    $_SESSION['user_role'] = $user['role'];

                    if ($user['role'] == 'admin') {
                        header('Location: dashboard.php');
                    } else {
                        header('Location: produits.php');
                    }
                    exit();
                } else {
                    $error = "Email ou mot de passe incorrect";
                }
            } catch (PDOException $e) {
                $error = "Erreur de connexion: " . $e->getMessage();
            }
        }
    }

    // === INSCRIPTION ===
    if (isset($_POST['register'])) {
        $nom = trim($_POST['nom']);
        $prenom = trim($_POST['prenom']);
        $email = trim($_POST['email']);
        $password = $_POST['password'];

        if (empty($nom) || empty($prenom) || empty($email) || empty($password)) {
            $error = "Tous les champs sont obligatoires";
        } else {
            try {
                // Vérifier si l'email existe déjà
                $stmt = $pdo->prepare("SELECT * FROM inscription WHERE email = ?");
                $stmt->execute([$email]);
                if ($stmt->fetch()) {
                    $error = "Cet email est déjà utilisé";
                } else {
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                    $stmt = $pdo->prepare("INSERT INTO inscription (nom, prenom, email, mdp, role) VALUES (?, ?, ?, ?, ?)");
                    $stmt->execute([$nom, $prenom, $email, $hashedPassword, 'user']);
                    $success = "Inscription réussie ! Vous pouvez maintenant vous connecter.";
                }
            } catch (PDOException $e) {
                $error = "Erreur d'inscription : " . $e->getMessage();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Connexion - Cold Manager</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    body {
      background: linear-gradient(120deg, #0078D7, #00b894);
      font-family: 'Segoe UI', sans-serif;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .auth-container {
      background: #fff;
      border-radius: 15px;
      box-shadow: 0 5px 20px rgba(0,0,0,0.15);
      width: 400px;
      padding: 40px;
      transition: all 0.4s ease-in-out;
    }
    .auth-container h2 {
      text-align: center;
      color: #0078D7;
      margin-bottom: 30px;
      font-weight: 700;
    }
    .btn-custom {
      background: linear-gradient(90deg, #0078D7, #00b894);
      border: none;
      color: #fff;
      border-radius: 10px;
      width: 100%;
      font-weight: 600;
    }
    .btn-custom:hover {
      opacity: 0.9;
    }
    .switch-link {
      text-align: center;
      margin-top: 15px;
    }
    .switch-link a {
      color: #0078D7;
      font-weight: 600;
      text-decoration: none;
    }
    .switch-link a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

  <!-- ======== Connexion ======== -->
  <div class="auth-container" id="loginForm">
    <h2><i class="fa-solid fa-right-to-bracket me-2"></i>Connexion</h2>

    <?php if (!empty($error) && isset($_POST['login'])): ?>
      <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <?php if (!empty($success) && isset($_POST['login'])): ?>
      <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
    <?php endif; ?>

    <form method="POST" action="">
      <input type="hidden" name="login" value="1">
      <div class="mb-3">
        <label for="email" class="form-label">Adresse e-mail</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="Entrez votre e-mail" required>
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">Mot de passe</label>
        <input type="password" class="form-control" id="password" name="mdp" placeholder="Entrez votre mot de passe" required>
      </div>

      <button type="submit" class="btn btn-custom mt-3"><i class="fa-solid fa-lock me-2"></i> Se connecter</button>
    </form>

    <div class="switch-link">
      <p>Pas encore de compte ? <a href="#" onclick="toggleForms()">Inscrivez-vous</a></p>
    </div>
  </div>

  <!-- ======== Inscription ======== -->
  <div class="auth-container d-none" id="registerForm">
    <h2><i class="fa-solid fa-user-plus me-2"></i>Inscription</h2>

    <?php if (!empty($error) && isset($_POST['register'])): ?>
      <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <?php if (!empty($success) && isset($_POST['register'])): ?>
      <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
    <?php endif; ?>

    <form method="POST" action="">
      <input type="hidden" name="register" value="1">
      <div class="mb-3">
        <label for="nom" class="form-label">Nom</label>
        <input type="text" class="form-control" id="nom" name="nom" placeholder="Votre nom" required>
      </div>

      <div class="mb-3">
        <label for="prenom" class="form-label">Prénom</label>
        <input type="text" class="form-control" id="prenom" name="prenom" placeholder="Votre prénom" required>
      </div>

      <div class="mb-3">
        <label for="email2" class="form-label">Adresse e-mail</label>
        <input type="email" class="form-control" id="email2" name="email" placeholder="Entrez votre e-mail" required>
      </div>

      <div class="mb-3">
        <label for="password2" class="form-label">Mot de passe</label>
        <input type="password" class="form-control" id="password2" name="password" placeholder="Créez un mot de passe" required>
      </div>

      <button type="submit" class="btn btn-custom mt-3"><i class="fa-solid fa-user-check me-2"></i> S'inscrire</button>
    </form>

    <div class="switch-link">
      <p>Déjà inscrit ? <a href="#" onclick="toggleForms()">Connectez-vous</a></p>
    </div>
  </div>

  <script>
    function toggleForms() {
      document.getElementById('loginForm').classList.toggle('d-none');
      document.getElementById('registerForm').classList.toggle('d-none');
    }
  </script>
</body>
</html>
