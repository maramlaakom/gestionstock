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
                WHERE email = :useremail"; 

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':useremail', $email);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

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
    } catch (PDOException $e) {
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
    
   /* body {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        background-color: var(--bg); /* نعيطو للمتغير من base.css */
    /*}
    .login-container {
        background-color: white;
        padding: 50px 40px;
        border-radius: 12px; /* رجعناها 12px باش تولي تشبه للكوارط لخرين *//*
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        width: 100%;
        max-width: 450px;
        text-align: center;
    }
        */
       .forgot-password {
            display: block;
            margin-top: 20px;
            color: #3498db;
            text-decoration: none;
            font-size: 14px;
              text-align:center!important ;
        }
    ./*form-group {
        display: flex;
        flex-direction: column; /* أسهل في الخدمة *//*
        align-items: flex-start;
        margin-bottom: 20px;
    }
    .form-group label {
        margin-bottom: 8px;
        color: var(--text-muted);
        font-weight: bold;
    }
        */
     .footer-links {
    margin-top: 50px;
    font-size: 14px;
    /*color: #534f4f;*/
    width: 100%;
}

        .footer-links a {
            color: #3498db;
            text-decoration: none;
          /*  margin-left: 0 5px;*/
            
        }
    /*
        body {
            /*background-color: #ffffffff;*//*
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .login-container {
            background-color: white;
            padding: 50px 40px;
            border-radius: 5px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 550px;
            text-align: center;
        }
        h2 {
             color: #2866da;
            font-weight: bold;
            margin-bottom: 40px;
            font-size: 28px;
        }
        .form-group {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        .form-group label {
            width: 160px;
            text-align: left;
            font-weight: bold;
            font-size: 16px;
            color: #333;
        }
        .form-control {
            flex: 1;
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 8px 12px;
            background-color: #fff;
        }
        .form-control::placeholder {
            color: #bdc3c7;
            font-size: 14px;
        }
        .btn-connect {
            background-color:  #1e90ff;
            color: white;
            border: none;
            padding: 10px 0;
            width: 70%;
            font-size: 16px;
            font-weight: bold;
            border-radius: 4px;
            margin-top: 10px;
            transition: background 0.3s;
        }
        .btn-connect:hover {
            background-color:#c5daff;
            color: white;
        }
        .footer-links {
            margin-top: 25px;
            font-size: 14px;
            color: #555;
        }
        .footer-links a {
            color: #3498db;
            text-decoration: none;
            margin-left: 5px;
        }
        .forgot-password {
            display: block;
            margin-top: 20px;
            color: #3498db;
            text-decoration: none;
            font-size: 14px;
        }
        .error-msg {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 20px;
            font-size: 14px;
        }*/
    </style>
</head>
<body class ="page-form ">
<div class="form-container ">
    <h2>Connexion a votre compte</h2>

    <?php if (!empty($error)) { ?>
        <div class="error-msg"><?= htmlspecialchars($error) ?></div>
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
