<?php
session_start();
include "config.php";
/*
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    
    if (empty($email) || empty($password)) {
        $error = "Veuillez remplir tous les champs";
    } else {
        try {
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $stmt = $pdo->prepare("SELECT id, nom, prenom, email, mdp FROM connex WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($user && password_verify($password, $user['mdp'])) {
              
                $_SESSION['connex_id'] = $user['id'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_nom'] = $user['nom'];
                $_SESSION['user_prenom'] = $user['prenom'];
                
            
                header('Location: DASHBOARD/produits.php');
                exit();
            } else {
                $error = "Email ou mot de passe incorrect";
            }
            
        } catch (PDOException $e) {
            $error = "Erreur de connexion: " . $e->getMessage();
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    
    if (empty($nom) || empty($prenom) || empty($email) || empty($password)) {
        $error = "Tous les champs doivent être remplis";
    } else {
        try {
          
            $stmt = $pdo->prepare("SELECT id FROM inscription WHERE email = ?");
            $stmt->execute([$email]);
            
            if ($stmt->fetch()) {
                $error = "Cet email est déjà utilisé";
            } else {
              
                $mdp_hashed = password_hash($password, PASSWORD_DEFAULT);
                
                $stmt = $pdo->prepare("INSERT INTO inscription (nom, prenom, email, mdp) VALUES (?, ?, ?, ?)");
                
                if ($stmt->execute([$nom, $prenom, $email, $mdp_hashed])) {
                    $success = "Inscription réussie ! Vous pouvez maintenant vous connecter.";
                   
                    echo "<script>document.getElementById('loginForm').classList.remove('d-none'); document.getElementById('registerForm').classList.add('d-none');</script>";
                } else {
                    $error = "Erreur lors de l'inscription";
                }
            }
            
        } catch (PDOException $e) {
            $error = "Erreur: " . $e->getMessage();
        }
    }
}


if (isset($_SESSION['connex_id'])) {
    header('Location: DASHBOARD/produits.php');
    exit();
}
*/
?>





<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Connexion - Chambre Froide</title>

  
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

    .form-control {
      border-radius: 10px;
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

    <?php if (!empty($success)): ?>
      <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
    <?php endif; ?>

    <form method="POST" action="">
      <input type="hidden" name="login" value="1">
      <div class="mb-3">
        <label for="email" class="form-label">Adresse e-mail</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="Entrez votre e-mail" value="<?php echo isset($_POST['email']) && isset($_POST['login']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">Mot de passe</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Entrez votre mot de passe" required>
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

    <form method="POST" action="">
      <input type="hidden" name="register" value="1">
      <div class="mb-3">
        <label for="nom" class="form-label">Nom</label>
        <input type="text" class="form-control" id="nom" name="nom" placeholder="Votre nom" value="<?php echo isset($_POST['nom']) && isset($_POST['register']) ? htmlspecialchars($_POST['nom']) : ''; ?>" required>
      </div>

      <div class="mb-3">
        <label for="prenom" class="form-label">Prénom</label>
        <input type="text" class="form-control" id="prenom" name="prenom" placeholder="Votre prénom" value="<?php echo isset($_POST['prenom']) && isset($_POST['register']) ? htmlspecialchars($_POST['prenom']) : ''; ?>" required>
      </div>

      <div class="mb-3">
        <label for="email2" class="form-label">Adresse e-mail</label>
        <input type="email" class="form-control" id="email2" name="email" placeholder="Entrez votre e-mail" value="<?php echo isset($_POST['email']) && isset($_POST['register']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
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

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    function toggleForms() {
      document.getElementById('loginForm').classList.toggle('d-none');
      document.getElementById('registerForm').classList.toggle('d-none');
    }
  </script>
</body>
</html>
