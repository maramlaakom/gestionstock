<?php 
require_once __DIR__ . '/../../includes/connexion.php';
require_once '../../employe_stock/auth.php';
require_role(["Admin"]);
// variabe $id = id envoyer avec lien  "modifieruser.php?id=<?= $u['id_utilisateur'] "
if (!isset($_GET['id'])) {
    header("location:listeutilisateur.php");
    exit;
}
$id = $_GET['id'];
//select donner de user de id emta3ou eli fi BD =$id
$stmt = $pdo->prepare("SELECT * FROM utilisateur WHERE id_utilisateur=?");
$stmt->execute([$id]);
$user = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("
        UPDATE utilisateur 
        SET nom=?, prenom=?, email=?, role=?, etat_compte=?
        WHERE id_utilisateur=?
    ");
    if (  $stmt->execute([
        $_POST['nom'],
        $_POST['prenom'],
        $_POST['email'],
        $_POST['role'],
        $_POST['etat_compte'],
        $id
    ])) {
    header("Location:  listeutilisateur.php");
    //exit;
    }
}?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StockSys - Modifier Utilisateur</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <link rel="stylesheet" href="../../css/base.css">  
    <link rel="stylesheet" href="../../css/forms.css"> 
</head> 

<body class="page-form"> 
    <div class="form-container"> 
   <h2>   <i class="bi bi-pencil-square"></i> Modifier utilisateur</h2> 
        
<!--  autocomplete="off ha4i kanet fi form -->
        <form method="POST"> 
            <div class="row  g-3 ">
                <div class="col-6">
                    <label class="form-label">Nom <span class="required-star">*</span></label>
                    <input type="text" name="nom" value="<?= htmlspecialchars($user['nom']) ?>" class="form-control" required>
                </div>
                <div class="col-6">
                    <label class="form-label">Prenom <span class="required-star">*</span></label>
                    <input type="text" name="prenom" value="<?= htmlspecialchars($user['prenom']) ?>" class="form-control" required>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label">Email <span class="required-star">*</span></label>
                <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" class="form-control" required autocomplete="off">
            </div>

             <div class="row g-3 ">
                <div class="col-6">
                    <label class="form-label">Rôle <span class="required-star">*</span></label>
                    <select name="role" class="form-select">
                         <option value="">-- Choisir role--</option>
                        <option value="Admin" <?= $user['role'] == 'Admin' ? 'selected' : '' ?>>Admin</option>
                        <option value="employe_stock" <?= $user['role'] == 'employe_stock' ? 'selected' : '' ?>>employe_stock</option>
                    </select>
                </div>
                <div class="col-6">
                    <label class="form-label">État du compte <span class="required-star">*</span></label>
                    <select name="etat_compte" class="form-select">
                         <option value="">-- Choisir etat de compte --</option>
                        <option value="actif" <?= $user['etat_compte'] == 'actif' ? 'selected' : '' ?>>Actif</option>
                        <option value="bloque" <?= $user['etat_compte'] == 'bloque' ? 'selected' : '' ?>>Bloqué</option>
                    </select>
                </div>
            </div>

            <div class="row g-3 mt-4">
                <div class="col-6">
                    <button type="submit" class="btn btn-primary w-100" style="height: 48px;">
                        Mettre a jour
                    </button>
                </div>
                <div class="col-6">
                    <a href="listeutilisateur.php" class="btn btn-secondary w-100 d-flex align-items-center justify-content-center" style="height: 48px; text-decoration: none;">
                        Retour
                    </a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>