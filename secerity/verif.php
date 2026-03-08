<?php
session_start();
require_once '../includes/connexion.php';

if (!isset($_SESSION['email_reset'])) {
    header("Location: password_oublie.php");
    exit;
}

$error = "";

       
if (isset($_POST['valider'])) {
    $code = $_POST['code'];
    $email = $_SESSION['email_reset'];

    $stmt = $pdo->prepare("
        SELECT id_utilisateur 
        FROM utilisateur 
        WHERE email=? AND code_verif=?
    ");
    $stmt->execute([$email, $code]);

    if ($stmt->rowCount() == 1) {
        $_SESSION['autorise_reset'] = true;
        header("Location: modifier_password.php");
        exit;
    } else {
        $error = "Code incorrec";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Vérification du code</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
   <link rel="stylesheet" href="../css/base.css">
     <link rel="stylesheet" href="../css/forms.css">
     <style>
      .footer-links , a {
            color: #3498db;
            text-decoration: none;
            margin-left: 5px;
             margin-top: 25px;
            font-size: 14px;
            text-align: center; 
             width: 100%;}
             </style>
 
</head>
<body class="page-form"> 
    <div class="form-container">
         <div class="text-center mb-4">
            <h2>Vérification</h2> 
            <p style="color: var(--text-muted);">Entrez le code à 6 chiffres que vous avez reçu.</p>
        </div>

        <?php if ($error): ?>
            <div class="alert alert-danger text-center"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-4">
                <input type="text" name="code" class="form-control text-center fw-bold" 
                       style="letter-spacing: 5px; font-size: 1.5rem;"
                       placeholder="000000" maxlength="6" required autocomplete="off">
            </div>
            
            <button type="submit" name="valider" class="btn-primary w-100">
                Vérifier le code
            </button>
        </form>
        <div class ="footer-links">
             <a href="password_oublie.php">Renvoyer un code
             </a>
        </div>


    </div>

</body>
</html>
