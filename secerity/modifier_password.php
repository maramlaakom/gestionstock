<?php
session_start();
require_once '../includes/connexion.php'; 
if (!isset($_SESSION['autorise_reset']) || $_SESSION['autorise_reset'] !== true) {
    header("Location: password_oublie.php");
    exit;
}

$error = "";
$success = "";

if (isset($_POST['modifier'])) {
    $p1 = $_POST['mot_de_passe'];
    $p2 = $_POST['confirm_password'];
    $email = $_SESSION['email_reset']; 

    if ($p1 === $p2) {
     
        $hashed_password = password_hash($p1, PASSWORD_DEFAULT);

        
        $stmt = $pdo->prepare("UPDATE utilisateur SET mot_de_passe = ?, code_verif = NULL WHERE email = ?");
        
        if ($stmt->execute([$hashed_password, $email])) {
            
            if ($stmt->rowCount() > 0) {
                $success = "Mot de passe modifie avec succes ! ";
               
                session_destroy();
                header("refresh:3;url=login.php");
            } else {
                $error = "Aucun compte trouve pour cet e-mail ";
            }
        } else {
            $error = "Erreur technique lors de la mise a jour ";
        }
    } else {
        $error = "Les mots de passe ne sont pas identiques ";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Nouveau mot de passe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
       <link rel="stylesheet" href="../css/base.css">
     <link rel="stylesheet" href="../css/forms.css">
      
</head>


<body class="page-form"> 
    <div class="form-container">
    <h2 class="text-center ">Nouveau mot de passe</h2>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="alert alert-succes ">
            <?= $success ?> <br> 
            <small>Redirection vers la connexion...</small>
        </div>
    <?php else: ?>
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Nouveau mot de passe</label>
                <div class="input-group">
                    <input type="password" name="mot_de_passe" id="p1" class="form-control" placeholder="Entrez votre mot de passe" required>
                    <button class="btn btn-outline-secondary" type="button" onclick="togglePass('p1', 'eye1')">
                        <i class="bi bi-eye" id="eye1"></i>
                    </button>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label">Confirmer le mot de passe</label>
                <div class="input-group">
                    <input type="password" name="confirm_password" id="p2" class="form-control" placeholder="Confirmez votre mot de passe" required>
                    <button class="btn btn-outline-secondary" type="button" onclick="togglePass('p2', 'eye2')">
                        <i class="bi bi-eye" id="eye2"></i>
                    </button>
                </div>
            </div>

            <button type="submit" name="modifier" class="btn btn-primary w-100 fw-bold">Enregistrer</button>
        </form>
    <?php endif; ?>
</div>

<script>
function togglePass(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);
    if (input.type === "password") {
        input.type = "text";
        icon.classList.replace('bi-eye', 'bi-eye-slash');
    } else {
        input.type = "password";
        icon.classList.replace('bi-eye-slash', 'bi-eye');
    }
}
</script>
</body>
</html>