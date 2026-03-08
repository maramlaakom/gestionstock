<?php
require_once '../includes/connexion.php';

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nom        = trim($_POST['nom']);
    $prenom     = trim($_POST['prenom']);
    $email      = trim($_POST['email']);
    $motdepasse = $_POST['motdepasse'];
    if (!$nom || !$prenom || !$email || !$motdepasse) {
        $errors[] = "Tous les champs sont obligatoires.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email invalide.";
    }

    if (strlen($motdepasse) < 0) {
        $errors[] = "Le mot de passe doit contenir au moins 8 caracteres.";
    }

    if (empty($errors)) {
        $hash = password_hash($motdepasse, PASSWORD_DEFAULT);

        try {
            $stmt = $pdo->prepare("
                INSERT INTO utilisateur (nom, prenom, email, mot_de_passe, role)
                VALUES (?, ?, ?, ?, ?)
            ");

            $stmt->execute([
                $nom,
                $prenom,
                $email,
                $hash,
                'employe_stock' 
            ]);

            $success = "Utilisateur enregistre avec succes !";

        } catch (PDOException $e) {

            if ($e->getCode() == 23000) {
                $errors[] = "Cet email existe deja.";
            } else {
                $errors[] = "Erreur base de donnees : " . $e->getMessage();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Creer un compte</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
 <link rel="stylesheet" href="../css/base.css">
<link rel="stylesheet" href="../css/forms.css">
    <style>
        .btn-group {
            margin-top: 30px;
        }
     .btn-primary {
            color: white; border: none; padding: 10px 25px; border-radius: 5px; margin: 5px;
            text-decoration: none; 
          
        }
        .btn-cancel {
            background-color: #ef8579; 
            color: white; border: none; padding: 10px 25px; border-radius: 5px; margin: 5px;
            text-decoration: none; display: inline-block;
        }
        .footer-text { 
    margin-top: 30px; 
    font-size: 0.9rem; 
    color: #555; 
    text-align: center; 
    width: 100%;   
}
.footer-text a {
    color: #3498db; ; 
    text-decoration: none;
    margin-left: 5px;      
}
</style>
</head>
<body class="page-form">

 <div class="form-container">
     <h2 >Créer un compte</h2>

    <?php if ($errors): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach ($errors as $err): ?>
                    <li><?= htmlspecialchars($err) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="alert alert-success">
            <?= htmlspecialchars($success) ?>
        </div>
    <?php endif; ?>

    <form method="post">
        <div class="mb-3">
            <label class="form-label">Nom :</label>
            <input type="text" name="nom" class="form-control" placeholder="Votre nom" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Prénom :</label>
            <input type="text" name="prenom" class="form-control" placeholder="Votre prénom" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email :</label>
            <input type="email" name="email" class="form-control" placeholder="exemple@mail.com" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Mot de passe :</label>
            <input type="password" name="motdepasse" class="form-control" placeholder="••••••••" required>
        </div>

        <div class="btn-group d-flex gap-2 justify-content-center">
            <button type="submit" class="btn-primary">Enregistrer</button>
            <button type="reset" class="btn-cancel">Annuler</button>
        </div>

        <div class="text-center mt-3">
            <a href="accueil.php" class="btn-secondary"seyle="  margin-top: 50px; padding: 8px 30px;">Retour</a>
        </div>
    </form>

        <div class="footer-text">
        Deja un compte ? <a href="login.php">Se connecter</a>
    </div>
</div>
</body>
</html>
