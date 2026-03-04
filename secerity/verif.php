<?php
/*
session_start();
require_once '../includes/connexion.php';

if (!isset($_SESSION['reset_email'])) {
    header("Location: password_oublie.php");
    exit();
}

$error = "";

if (isset($_POST['valider'])) {
    $code = trim($_POST['code']);
    $email = $_SESSION['reset_email'];

    $stmt = $pdo->prepare("
        SELECT id_utilisateur 
        FROM utilisateur 
        WHERE email = :email AND token_recuperation = :code
    ");
    $stmt->execute([
        'email' => $email,
        'code'  => $code
    ]);

    $user = $stmt->fetch();

    if ($user) {
        $_SESSION['user_id_allowed'] = $user['id_utilisateur'];

        header("Location: modifier_password.php");
        exit();
    } else {
        $error = "Code incorrect.";
    }
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Vérification du code</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #7f8c8d; }
        .card-verif {
            width: 400px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            border: none;
        }
        .code-input {
            letter-spacing: 5px;
            text-align: center;
            font-size: 1.5rem;
            font-weight: bold;
        }
    </style>
</head>
<body class="d-flex justify-content-center align-items-center vh-100">

<div class="card card-verif p-4">
    <div class="text-center mb-4">
        <h3 class="fw-bold">Verification</h3>
        <p class="text-muted small">Entrez le code a 6 chiffres que vous avez recu.</p>
    </div>

    <?php if ($error): ?>
        <div class="alert alert-danger py-2 small text-center"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-4">
            <input type="text" name="code" class="form-control code-input" 
                   placeholder="000000" maxlength="6" required autocomplete="off">
        </div>
        
        <button type="submit" name="valider" class="btn btn-success w-100 fw-bold py-2">
            Verifier le code
        </button>
    </form>

    <div class="text-center mt-4">
        <a href="password_oublie.php" class="text-decoration-none small text-secondary">
            < i class="bi bi-arrow-left"></i> Renvoyer un code
        </a>
    </div>
</div>

</body>
</html>
*/

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
<!--
<body class="page-form"> <div class="form-container"> 
<div class="card card-verif p-4">
    <div class="text-center mb-4">
        <h2 class="fw-bold">Verification</h2>
        <p>Entrez le code a 6 chiffres que vous avez recu.</p>
    </div>

    <//?php if ($error): ?>
        <div class="alert alert-danger py-2 small text-center"><//?= $error ?></div>
    <//?php endif; ?>

    <form method="POST">
        <div class="mb-4">
            <input type="text" name="code" class="form-control code-input" 
                   placeholder="000000" maxlength="6" required autocomplete="off">
        </div>
        
        <button type="submit" name="valider" class="btn btn-primary w-100 fw-bold py-2">
            Verifier le code
        </button>
    </form>

    <div class="text-center mt-4">
        <a href="password_oublie.php" class="text-decoration-none small text-secondary">
            <i class="bi bi-arrow-left"></i> Renvoyer un code
        </a>
    </div>
</div>

</body>
-->
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
