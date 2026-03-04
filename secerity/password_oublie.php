<?php
/*require_once '../includes/connexion.php';

$message = "";
$error = "";

if (isset($_POST['submit'])) {
    $email = trim($_POST['email']);

    try {
        $stmt = $pdo->prepare("SELECT id_utilisateur FROM utilisateur WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        if ($user) {
           
            header("Location: modifier_password.php?id=" . $user['id_utilisateur']);
            exit();
        } else {
            $error = "Aucun compte n'est associe a cet email.";
        }
    } catch (PDOException $e) {
        $error = "Erreur : " . $e->getMessage();
    }
}*/
/*

session_start();
require_once '../includes/connexion.php';

$error = "";
$message = "";

if (isset($_POST['submit'])) {
    $email = trim($_POST['email']);

    $stmt = $pdo->prepare("SELECT id_utilisateur FROM utilisateur WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    if ($user) {
        $code = rand(100000, 999999);

        $stmt = $pdo->prepare("
            UPDATE utilisateur 
            SET token_recuperation = :code 
            WHERE id_utilisateur = :id
        ");
        $stmt->execute([
            'code' => $code,
            'id'   => $user['id_utilisateur']
        ]);

        $_SESSION['reset_email'] = $email;

        header("Location: verif.php");
        exit();
    } else {
        $error = "Aucun compte associe a cet email.";
    }
}



      //  $message = ": Le code genere est <strong>$code</strong>. <br> <a href='verif.php' class='alert-link'>Cliquez ici pour continuer</a>";
?>        
 

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Recuperation de mot de passe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex justify-content-center align-items-center vh-100" style="background:#7f8c8d;">
<div class="card p-4" style="width:400px; border-radius:15px; box-shadow: 0 10px 20px rgba(0,0,0,0.2);">
    <h3 class="text-center mb-3 fw-bold">Recuperation</h3>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <?php if ($message): ?>
        <div class="alert alert-success"><?= $message ?></div>
    <?php endif; ?>
    
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Email de votre compte</label>
            <input type="email" name="email" class="form-control" placeholder="votre@email.com" required>
        </div>
        <button type="submit" name="submit" class="btn btn-primary w-100">Envoyer le code</button>
    </form>
    <a href="login.php" class="d-block mt-3 text-center text-muted small text-decoration-none">Retour à la connexion</a>
</div>
</body>
</html>
*/


session_start();
require_once '../includes/connexion.php';

// نعيطو للملفات اللي حطيناهم في مجلد PHPMailer
require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$msg = ""; $error = "";

if (isset($_POST['submit'])) {
    $email = trim($_POST['email']);
    
    $stmt = $pdo->prepare("SELECT id_utilisateur, nom FROM utilisateur WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user) {
        $code = rand(100000, 999999);
        $pdo->prepare("UPDATE utilisateur SET code_verif = ? WHERE email = ?")->execute([$code, $email]);

        $mail = new PHPMailer(true);
        try {
            // pqrq;etre server
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'maramlaakom2@gmail.com'; 
            $mail->Password   = 'oxzd tezz euem uqcv';   // App Password 
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );

            
            $mail->setFrom('maramlaakom2@gmail.com', 'Gestion de Stock');
            $mail->addAddress($email);

            // contenu el;qil ei yousoulou 
            $mail->isHTML(true);
            $mail->Subject = 'Code de recuperation';
            $mail->Body    = "Bonjour " . $user['nom'] . ",<br>Votre code de vérification est : <b>$code</b>";

            $mail->send();
            
            
            $_SESSION['email_reset'] = $email;
            header("Location: verif.php");
            exit;

        } catch (Exception $e) {
            $error = "Erreur d'envoi : " . $mail->ErrorInfo;
        }
        
    } else {
        $error = "Email non trouve !";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Recuperation de mot de passe</title>
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
         <h2 class=" text-center">Récupération</h2>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?=$error ?></div>
        <?php endif; ?>

        <?php if ($msg): ?>
            <div class="alert alert-success"><?=$msg ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Email de votre compte</label>
                <input type="email" name="email" class="form-control" placeholder="votre@email.com" required>
            </div>
            
            <button type="submit" name="submit" class="btn btn-primary w-100">Envoyer le code</button>
        </form>
              
        <div class ="footer-links">
             <a href="login.php">Retour à la connexion</a>
        </div>

        

    </div>
</body>
</html>

