<?php
/*
// session_start(); // Na7i el commentaire ken mahich started fil auth.php
require_once '../includes/connexion.php';
require_once "auth.php";
require_role(["employe_stock"]);

$id_user = $_SESSION['id_utilisateur'];
$error = "";
$success = "";

if (isset($_POST['modifier'])) {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $old_pass = $_POST['old_password'];
    $new_pass = $_POST['new_password'];
    $hash = password_hash($new_pass, PASSWORD_DEFAULT);

    // Mise à jour des infos de base
    $sql_info = "UPDATE utilisateur SET nom = ?, prenom = ?, email = ? , mot_de_passe = ?  WHERE id_utilisateur = ?";
    $stmt_info = $pdo->prepare($sql_info);
    $stmt_info->execute([$nom, $prenom, $email, $id_user,$hash ]);
    $success = "Informations mises à jour.";

    // Changement de mot de passe si rempli
    if (!empty($new_pass)) {
        $stmt_check = $pdo->prepare("SELECT mot_de_passe FROM utilisateur WHERE id_utilisateur = ?");
        $stmt_check->execute([$id_user]);
        $current_hash = $stmt_check->fetchColumn();

        if (password_verify($old_pass, $current_hash)) {
            $new_hash = password_hash($new_pass, PASSWORD_DEFAULT);
            $stmt_upd = $pdo->prepare("UPDATE utilisateur SET mot_de_passe = ? WHERE id_utilisateur = ?");
            $stmt_upd->execute([$new_hash, $id_user]);
            $success .= " Mot de passe modifié !";
        } else {
            $error = "L'ancien mot de passe est incorrect.";
 // On annule le message de succès si le password a échoué
        }
    }
}

$user = $pdo->prepare("SELECT * FROM utilisateur WHERE id_utilisateur = ?");
$user->execute([$id_user]);
$u = $user->fetch();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Compte</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="../css/forms.css">
</head>

<body>
<div class="page-form">
    <div class="form-container shadow-sm">
        
        <div class="mb-4 text-center">
            <h4 class="form-title mb-0">
                <i class="bi bi-person-circle me-2"></i>Mon Compte
            </h4>
            <div class="section-divider"></div> 
        </div>

        <div class="card-body">
            <?php if($success): ?>
                <div class="alert alert-success d-flex align-items-center small py-2">
                    <i class="bi bi-check-circle-fill me-2"></i> <?= $success ?>
                </div>
            <?php endif; ?>

            <?php if($error): ?>
                <div class="alert alert-danger d-flex align-items-center small py-2">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> <?= $error ?>
                </div>
            <?php endif; ?>

            <form method="POST">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nom</label>
                        <input type="text" name="nom" class="form-control" value="<?= htmlspecialchars($u['nom']) ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Prénom</label>
                        <input type="text" name="prenom" class="form-control" value="<?= htmlspecialchars($u['prenom']) ?>" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($u['email']) ?>" required>
                </div>

                <div class="border-top pt-4 mb-4">
                    <p class="form-title mb-3" style="font-size: 1rem;">
                        <i class="bi bi-shield-lock me-1"></i> Sécurité
                    </p>
                    <div class="mb-3">
                        <label class="form-label text-danger">Ancien Mot de passe</label>
                        <input type="password" name="old_password" class="form-control" placeholder="Obligatoire pour modifier" required autocomplete="new-password">
                    </div>
                    <div class="mb-0">
                        <label class="form-label text-success">Nouveau Mot de passe</label>
                        <input type="password" name="new_password" class="form-control" placeholder="Nouveau Mot de passe">
                    </div>
                </div>

                <div class="d-flex gap-3">
                    <button type="submit" name="modifier" class="btn btn-primary w-100">
                        Mettre à jour
                    </button>
                    <a href="index.php" class="btn btn-secondary w-100 text-center text-decoration-none">
                        Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
*
*/


require_once '../includes/connexion.php';
require_once "auth.php";
require_role(["employe_stock"]);
$id_user = $_SESSION['id_utilisateur'];
$error = "";
$success = "";

if (isset($_POST['modifier'])) {

    $nom    = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $email  = trim($_POST['email']);

    $old_pass = $_POST['old_password'] ?? '';
    $new_pass = $_POST['new_password'] ?? '';
    $stmt_info = $pdo->prepare("
        UPDATE utilisateur 
        SET nom = ?, prenom = ?, email = ?
        WHERE id_utilisateur = ?
    ");
    $stmt_info->execute([$nom, $prenom, $email, $id_user]);

    $success = "Informations mises à jour.";
    if (!empty($new_pass)) {

        $stmt_check = $pdo->prepare("SELECT mot_de_passe FROM utilisateur WHERE id_utilisateur = ?");
        $stmt_check->execute([$id_user]);
        $current_hash = $stmt_check->fetchColumn();

        if (password_verify($old_pass, $current_hash)) {

            $new_hash = password_hash($new_pass, PASSWORD_DEFAULT);
            $stmt_upd = $pdo->prepare("
                UPDATE utilisateur 
                SET mot_de_passe = ?
                WHERE id_utilisateur = ?
            ");
            $stmt_upd->execute([$new_hash, $id_user]);

            $success .= " Mot de passe modifié avec succès.";

        } else {
            $error = "L'ancien mot de passe est incorrect.";
            $success = ""; 
        }
    }
}
$user = $pdo->prepare("SELECT * FROM utilisateur WHERE id_utilisateur = ?");
$user->execute([$id_user]);
$u = $user->fetch();

$user = $pdo->prepare("SELECT * FROM utilisateur WHERE id_utilisateur = ?");
$user->execute([$id_user]);
$u = $user->fetch();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Compte</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="../css/forms.css">
</head>

<body>
<div class="page-form">
    <div class="form-container ">
        
        <div class="mb-4 text-center">
            <h2>
                <i class="bi bi-person-circle me-2"></i>Mon Compte
            </h2>
            <!--div class="section-divider"></div> -->
        </div>

        <div>
            <?php if($success): ?>
                <!--  d-flex align-items-center small py-2-->
                <div class="alert alert-success">
                    <i class="bi bi-check-circle-fill me-2"></i> <?= $success ?>
                </div>
            <?php endif; ?>

            <?php if($error): ?>
                <div class="alert alert-danger ">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> <?= $error ?>
                </div>
            <?php endif; ?>

            <form method="POST">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nom</label>
                        <input type="text" name="nom" class="form-control" value="<?= htmlspecialchars($u['nom']) ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Prénom</label>
                        <input type="text" name="prenom" class="form-control" value="<?= htmlspecialchars($u['prenom']) ?>" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($u['email']) ?>" required>
                </div>

                <div class="border-top pt-4 mb-4">
                    <p class=" mb-3" style="font-size: 1.5em; text-align:left;">
                        <i class="bi bi-shield-lock me-1"></i> Sécurité
                    </p>
                    <div class="mb-3">
                        <label class="form-label text-danger">Ancien Mot de passe</label>
                        <input type="password" name="old_password" class="form-control" placeholder="Obligatoire pour modifier" required>
                    </div>
                    <div class="mb-0">
                        <label class="form-label text-success">Nouveau Mot de passe</label>
                        <input type="password" name="new_password" class="form-control" placeholder="Laissez vide si inchangé"required>
                    </div>
                </div>

                <div class="d-flex gap-3">
                    <button type="submit" name="modifier" class="btn btn-primary w-100">
                        Mettre à jour
                    </button>
                    <a href="index.php" class="btn btn-secondary w-100 text-center text-decoration-none">
                        Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>