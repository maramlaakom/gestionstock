<?php
session_start();
require_once '../includes/connexion.php';
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
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'maramlaakom2@gmail.com'; 
            $mail->Password   = 'oxzd tezz euem uqcv';   
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

