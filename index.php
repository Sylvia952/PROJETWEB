<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Accueil - Gestion de Chambre Froide</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    body {
      background: #f4f8fb;
      font-family: 'Segoe UI', sans-serif;
    }

    /* --- Navbar --- */
    .navbar {
      background: linear-gradient(90deg, #0078D7, #00b894);
      padding: 15px 30px;
    }
    .navbar-brand {
      color: #fff !important;
      font-weight: bold;
      font-size: 1.4rem;
      letter-spacing: 1px;
    }
    .navbar-nav .nav-link {
      color: #fff !important;
      font-weight: 500;
      margin-left: 15px;
      transition: 0.3s;
    }
    .navbar-nav .nav-link:hover {
      text-decoration: underline;
    }

    /* --- Header --- */
    header {
      text-align: center;
      padding: 10px 10px;
      background: #f4f8fb;
    }
    header h1 {
      font-size: 2.5rem;
      font-weight: 700;
      color: #0078D7;
    }
    header p {
      font-size: 1.1rem;
      color: #555;
      margin-top: 10px;
    }

    /* --- Cards Section --- */
    .section {
      padding: 60px 20px;
    }
    .card {
      border: none;
      border-radius: 15px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      transition: transform 0.3s;
    }
    .card:hover {
      transform: translateY(-5px);
    }
    .card i {
      font-size: 40px;
      margin-bottom: 10px;
    }

    /* --- Footer --- */
    footer {
      background: #0078D7;
      color: white;
      text-align: center;
      padding: 15px 0;
      margin-top: 60px;
    }
  </style>
</head>

<body>

  <!--  Navbar -->
  <nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
      <a class="navbar-brand" href="#"><i class="fa-solid fa-snowflake"></i> Chambre Froide</a>
      <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <i class="fa-solid fa-bars"></i>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="#"><i class="fa-solid fa-user-plus"></i> Inscription</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#"><i class="fa-solid fa-right-to-bracket"></i> Connexion</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!--  Header -->
  <header class="mt-5">
    <h1>Bienvenue sur la plateforme de gestion de chambre froide</h1>
    <p>Surveillez, gérez et optimisez vos stocks en toute sécurité.</p>
  </header>

  <!--  Section de présentation -->
  <section class="section text-center">
    <div class="container">
      <div class="row">
        
        <div class="col-md-4 mb-4">
          <div class="card p-4">
            <div class="card-body">
              <i class="fa-solid fa-temperature-half text-primary"></i>
              <h3 class="text-primary mt-2">Surveillance</h3>
              <p>Suivez la température et l’humidité de vos chambres froides en temps réel pour éviter toute perte de produits.</p>
            </div>
          </div>
        </div>

        <div class="col-md-4 mb-4">
          <div class="card p-4">
            <div class="card-body">
              <i class="fa-solid fa-boxes-stacked text-success"></i>
              <h3 class="text-success mt-2">Gestion du stock</h3>
              <p>Ajoutez, consultez et organisez vos produits selon leur type, leur quantité et leur date d’expiration.</p>
            </div>
          </div>
        </div>

        <div class="col-md-4 mb-4">
          <div class="card p-4">
            <div class="card-body">
              <i class="fa-solid fa-bell text-info"></i>
              <h3 class="text-info mt-2">Alertes automatiques</h3>
              <p>Recevez des notifications en cas d’anomalie de température ou de produit proche de la date limite.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

   <!-- Footer -->
    <footer class="py-5 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <h5 class="mb-4 text-accent">Chambre Froide</h5>
                    <p class="mb-4">Surveillez, gérez et optimisez vos stocks en toute sécurité.</p>
                    <div class="d-flex gap-3">
                        <a href="#" class="text-white"><i class="fab fa-facebook fa-lg"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-twitter fa-lg"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-instagram fa-lg"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-linkedin fa-lg"></i></a>
                    </div>
                </div>

             

                <div class="col-lg-3 col-md-4 mb-4 mb-md-0">
                    <h5 class="mb-4">Légal</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Conditions d'utilisation</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Politique de confidentialité</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Mentions légales</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">CGV</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-4">
                    <h5 class="mb-4">Contact</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fas fa-envelope me-2"></i>contact@chambrefroide.com</li>
                        <li class="mb-2"><i class="fas fa-phone me-2"></i>+229 0000000000</li>
                        <li class="mb-2"><i class="fas fa-map-marker-alt me-2"></i>Calavi, Bénin</li>
                    </ul>
                </div>
            </div>

            <hr class="my-4 bg-light opacity-10">

            <div class="row align-items-center ">
                <div class="col-md-6 mb-3 mb-md-0 ">
                    <p class="mb-0">&copy; 2025 Chambre Froide. Tous droits réservés.</p>
                </div>
               
            </div>
        </div>
    </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
