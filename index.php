<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Connexion - Chambre Froide</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Font Awesome -->
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

    <form>
      <div class="mb-3">
        <label for="email" class="form-label">Adresse e-mail</label>
        <input type="email" class="form-control" id="email" placeholder="Entrez votre e-mail">
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">Mot de passe</label>
        <input type="password" class="form-control" id="password" placeholder="Entrez votre mot de passe">
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

    <form>
      <div class="mb-3">
        <label for="fullname" class="form-label">Nom complet</label>
        <input type="text" class="form-control" id="fullname" placeholder="Votre nom complet">
      </div>

      <div class="mb-3">
        <label for="email2" class="form-label">Adresse e-mail</label>
        <input type="email" class="form-control" id="email2" placeholder="Entrez votre e-mail">
      </div>

      <div class="mb-3">
        <label for="password2" class="form-label">Mot de passe</label>
        <input type="password" class="form-control" id="password2" placeholder="Créez un mot de passe">
      </div>

      <button type="submit" class="btn btn-custom mt-3"><i class="fa-solid fa-user-check me-2"></i> S'inscrire</button>
    </form>

    <div class="switch-link">
      <p>Déjà inscrit ? <a href="#" onclick="toggleForms()">Connectez-vous</a></p>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Script de bascule -->
  <script>
    function toggleForms() {
      document.getElementById('loginForm').classList.toggle('d-none');
      document.getElementById('registerForm').classList.toggle('d-none');
    }
  </script>
</body>
</html>
