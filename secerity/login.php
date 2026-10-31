<?php
session_start();
require_once '../includes/connexion.php';

$error = "";

if (isset($_POST['submit'])) {
    $email = $_POST['useremail'];
    $password = $_POST['password'];


    try {
        $sql = "SELECT id_utilisateur, role,nom,email ,prenom,mot_de_passe 
                FROM utilisateur 
                WHERE email = ?"; 

        $stmt = $pdo->prepare($sql);
        $stmt->execute([ $email]);

        $user = $stmt->fetch();

        if ($user) {
          
            if  (password_verify($password, $user['mot_de_passe'])) {
                $_SESSION['id_utilisateur'] = $user['id_utilisateur'];
                $_SESSION['role'] = strtolower($user['role']);
                $_SESSION['nom'] = $user['nom']; 
                  $_SESSION['prenom'] = $user['prenom']; 
                $_SESSION['email'] = $user['email'];

                switch ($_SESSION['role']) {
                    case 'admin':
                        header("Location: ../Admin/admin_dashboard.php");
                        exit();
                    case 'employe_stock':
                        header("Location: ../employe_stock/dashboard_employe.php");
                        exit();
                    default:
                        $error = "Role inconnu.";
                }
            } else {
                $error = "Mot de passe incorrect.";
            }
        } else {
            $error = "Utilisateur non trouve.";
        }
    } catch (Exception $e) {
        $error = "Erreur SQL : " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion a votre compte</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
   <link rel="stylesheet" href="../css/base.css">
<link rel="stylesheet" href="../css/forms.css">
    <style>
       .forgot-password {
            display: block;
            margin-top: 20px;
            color: #3498db;
            text-decoration: none;
            font-size: 14px;
              text-align:center!important ;
        }
     .footer-links {
    margin-top: 50px;
    font-size: 14px;
    width: 100%;
}

        .footer-links a {
            color: #3498db;
            text-decoration: none;          
        }
    </style>
</head>
<body class ="page-form ">
<div class="form-container ">
    <h2>Connexion a votre compte</h2>

    <?php if (!empty($error)) { ?>
         <div class="alert alert-danger text-center"><?= htmlspecialchars($error) ?></div>
    <?php } ?>

    <form method="POST">
        <div  class="mb-3">
            <label  class="form-label">Email :</label>
            <input type="email" name="useremail" class="form-control" placeholder="Entrez votre adresse email" required>
        </div>

        <div  class="mb-3">
            <label  class="form-label">Mot de passe :</label>
            <input type="password" name="password" class="form-control" placeholder="Entrez votre mot de passe" required>
        </div>

        <button type="submit" name="submit" class="btn-primary w-100">Se connecter</button>
    </form>

    <div class="footer-links  text-center">
        Pas de compte ? <a href="inscription.php">Creer un compte</a>
    </div>

    <a href="password_oublie.php" class="forgot-password">Mot de passe oublie ?</a>
</div>

</body>
</html>
