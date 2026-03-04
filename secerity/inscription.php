<?php
/*
require_once '../includes/connexion.php';

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nom        = trim($_POST['nom']);
    $prenom     = trim($_POST['prenom']);
    $email      = trim($_POST['email']);
    $motdepasse = $_POST['motdepasse'];

    // Validation
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

        // Hash mot de passe
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
    <style>
        body { 
           /* background-color: #f8f9fa; *//*
            display: flex; 
            justify-content: center; 
            align-items: center; 
            min-height: 100vh; 
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .container-card { 
            background: #fff; 
            padding: 40px; 
            border-radius: 10px; 
            box-shadow: 0 4px 15px rgba(0,0,0,0.1); 
            width: 100%;
            max-width: 600px;
            text-align: center;
        }
        h2 { 
            color: #003366; 
            font-weight: bold;
            margin-bottom: 35px;
            font-size: 2rem;
        }
        .form-group {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }
        .form-group label {
            width: 150px;
            text-align: right;
            margin-right: 20px;
            font-weight: 500;
            color: #333;
        }
        .form-control {
            flex: 1;
            border-radius: 5px;
            border: 1px solid #ccc;
            padding: 8px 12px;
        }
        .btn-group {
            margin-top: 30px;
        }
        .btn-save {
            background-color: #0066cc;
            color: white; border: none; padding: 10px 25px; border-radius: 5px; margin: 5px;
        }
        .btn-cancel {
            background-color: #ef8579; 
            color: white; border: none; padding: 10px 25px; border-radius: 5px; margin: 5px;
            text-decoration: none; display: inline-block;
        }
        .btn-back {
            background-color:  #87ceeb;
            color: #333; border: 1px solid  #1e90ff; padding: 8px 30px; border-radius: 5px; 
            margin-top: 20px; text-decoration: none; display: inline-block;
        }
        .footer-text { margin-top: 30px; font-size: 0.9rem; color: #555; }
        .error { color: #d9534f; margin-bottom: 10px; list-style: none; padding: 0; }
        .success { color: #5cb85c; margin-bottom: 10px; font-weight: bold; }
    </style>
</head>
<body>

<div class="container-card">
    <h2>Creer un compte</h2>

    <?php if ($errors): ?>
        <ul class="error">
            <?php foreach ($errors as $err): ?>
                <li><?= htmlspecialchars($err) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <?php if ($success): ?>
        <p class="success"><?= $success ?></p>
    <?php endif; ?>

    <form method="post">
        <div class="form-group">
            <label>Nom :</label>
            <input type="text" name="nom" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Prenom :</label>
            <input type="text" name="prenom" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Email :</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Mot de passe :</label>
            <input type="password" name="motdepasse" class="form-control" required>
        </div>

     

        <div class="btn-group">
            <button type="submit" class="btn-save">Enregistrer</button>
            <button type="reset" class="btn-cancel">Annuler</button>
        </div>

        <div>
            <a href="accueil.php" class="btn-back">Retour</a>
        </div>
    </form>

    <div class="footer-text">
        Deja un compte ? <a href="login.php" style="color: #0d6efd; text-decoration: none;">Se connecter</a>
    </div>
</div>

</body>
</html>
*/

require_once '../includes/connexion.php';

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nom        = trim($_POST['nom']);
    $prenom     = trim($_POST['prenom']);
    $email      = trim($_POST['email']);
    $motdepasse = $_POST['motdepasse'];

    // Validation
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

        // Hash mot de passe
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
       /* body { 
           /* background-color: #f8f9fa; *//*
            display: flex; 
            justify-content: center; 
            align-items: center; 
            min-height: 100vh; 
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .container-card { 
            background: #fff; 
            padding: 40px; 
            border-radius: 10px; 
            box-shadow: 0 4px 15px rgba(0,0,0,0.1); 
            width: 100%;
            max-width: 600px;
            text-align: center;
        }
        h2 { 
            color: #003366; 
            font-weight: bold;
            margin-bottom: 35px;
            font-size: 2rem;
        }
        .form-group {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }
        .form-group label {
            width: 150px;
            text-align: right;
            margin-right: 20px;
            font-weight: 500;
            color: #333;
        }
        .form-control {
            flex: 1;
            border-radius: 5px;
            border: 1px solid #ccc;
            padding: 8px 12px;
        }
        .btn-group {
            margin-top: 30px;
        }
        .btn-save {
            background-color: #0066cc;
            color: white; border: none; padding: 10px 25px; border-radius: 5px; margin: 5px;
        }
        .btn-cancel {
            background-color: #ef8579; 
            color: white; border: none; padding: 10px 25px; border-radius: 5px; margin: 5px;
            text-decoration: none; display: inline-block;
        }
        .btn-back {
            background-color:  #87ceeb;
            color: #333; border: 1px solid  #1e90ff; padding: 8px 30px; border-radius: 5px; 
            margin-top: 20px; text-decoration: none; display: inline-block;
        }
        .footer-text { margin-top: 30px; font-size: 0.9rem; color: #555; }
        .error { color: #d9534f; margin-bottom: 10px; list-style: none; padding: 0; }
        .success { color: #5cb85c; margin-bottom: 10px; font-weight: bold; }*/
      
    /* نترك فقط خصائص التمركز في وسط الشاشة */
  /*  body { 
        display: flex; 
        justify-content: center; 
        align-items: center; 
        min-height: 100vh; 
        margin: 0;
    }

    /* تعويض .container-card بـ .form-container الموجود في 4forms *//*
    .container-card { 
        background: #fff; 
        padding: 40px; 
        border-radius: 12px; /* تناسق مع بقية المشروع *//*
        box-shadow: 0 10px 30px rgba(135, 206, 235, 0.3); /* ظل احترافي *//*
        width: 100%;
        max-width: 600px;
    }*/

    /* تنسيق الـ Labels ليصبحوا تحت بعضهم (Modern Look) */
   /*.form-group {
        display: flex;
        flex-direction: column; /* أسهل في الخدمة *//*
        align-items: flex-start;
        margin-bottom: 20px;
    }
*/
        .btn-group {
            margin-top: 30px;
        }
  /*  .form-group label {
        color: var(--text-muted);
        font-weight: bold;
        margin-bottom: 8px;
    }*/
     .btn-primary {
            color: white; border: none; padding: 10px 25px; border-radius: 5px; margin: 5px;
            text-decoration: none; /*display: inline-block;*/
          
        }
        .btn-cancel {
            background-color: #ef8579; 
            color: white; border: none; padding: 10px 25px; border-radius: 5px; margin: 5px;
            text-decoration: none; display: inline-block;
        }
      /*  .btn-retour {
            background-color:  #87ceeb;
            color: #333; border: 1px solid  #1e90ff; padding: 8px 30px; border-radius: 5px; 
            margin-top: 20px; text-decoration: none; display: inline-block;
        }
          .form-group label {
            width: 150px;
            text-align: right;
            margin-right: 20px;
            font-weight: 500;
            color: #333;
        }*/
        .footer-text { 
    margin-top: 30px; 
    font-size: 0.9rem; 
    color: #555; 
    text-align: center; /* يضمن توسيط النص والرابط */
    width: 100%;        /* يأخذ العرض الكامل للحاوية لضمان التوسط */
}

.footer-text a {
    color: #3498db; ; /* استعمل المتغير الموحد بدلاً من اللون اليدوي */
    text-decoration: none;
    /*font-weight: bold;     /* يبرز الرابط أكثر */
    margin-left: 5px;      /* مسافة صغيرة بين النص والرابط */
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
