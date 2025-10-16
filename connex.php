<?php
include "config.php"; 
session_start();

// Vérifier si l'utilisateur est déjà connecté
if (isset($_SESSION['connex_id'])) {
    header('Location: dashboard.html.php');
    exit();
}

// Traitement du formulaire de connexion
$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    
    // Validation des champs
    if (empty($email) || empty($password)) {
        $error = "Veuillez remplir tous les champs";
    } else {
        try {
            // Connexion à la base de données
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Rechercher l'utilisateur par email dans la table INSCRIPTION
            $stmt = $pdo->prepare("SELECT id, nom, prenom, email, mdp FROM inscription WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($user) {
                // Vérifier le mot de passe
                if (password_verify($password, $user['mdp'])) {
                    // Connexion réussie
                    $_SESSION['connex_id'] = $user['id'];
                    $_SESSION['user_email'] = $user['email'];
                    $_SESSION['user_nom'] = $user['nom'];
                    $_SESSION['user_prenom'] = $user['prenom'];
                    
                    // Redirection vers le dashboard
                    header('Location: dashboard.php');
                    exit();
                } else {
                    $error = "Email ou mot de passe incorrect";
                }
            } else {
                $error = "Email ou mot de passe incorrect";
            }
            
        } catch (PDOException $e) {
            $error = "Erreur de connexion: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 400px;
            margin: 100px auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .form-container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
            font-weight: bold;
        }
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 16px;
        }
        button {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .error {
            color: #dc3545;
            text-align: center;
            margin-bottom: 15px;
            padding: 10px;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            border-radius: 4px;
        }
        .links {
            text-align: center;
            margin-top: 20px;
        }
        .links a {
            color: #007bff;
            text-decoration: none;
        }
        .links a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Connexion</h2>
        
        <?php if (!empty($error)): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="email">Email :</label>
                <input type="email" id="email" name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
            </div>
            
            <div class="form-group">
                <label for="password">Mot de passe :</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <button type="submit">Se connecter</button>
        </form>
        
        <div class="links">
            <p>Pas encore de compte ? <a href="inscription.php">S'inscrire</a></p>
            <p><a href="mot-de-passe-oublie.php">Mot de passe oublié ?</a></p>
        </div>
    </div>
</body>
</html>