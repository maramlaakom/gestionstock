<?php

require_once '../../includes/connexion.php';
require_once '../../employe_stock/auth.php';
require_role(["Admin"]);
$errors = [];
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom_magasin = trim($_POST['nom_magasin']);
    $adresse = trim($_POST['adresse']);

    if (!$nom_magasin || !$adresse) {
        $errors[] = "Tous les champs sont obligatoires et doivent avoir des valeurs valides.";
    }

    if (empty($errors)) {
        $sql = "INSERT INTO magasin (nom_magasin, adresse )
                VALUES (?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([ $nom_magasin , $adresse ]);

        $success = "Magasin ajouté avec succès !";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter Magasin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/base.css">  
      <link rel="stylesheet" href="../../css/forms.css">  
      </head>
      <body class="page-form"> 
        <div class="form-container"> 
        <h2>Ajouter un magasin</h2>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <?php foreach ($errors as $err): ?>
                    <p class="m-0"><?= $err?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="alert alert-success"><?= $success ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-4">
                <label class="form-label">Nom magasin <span class="required-star">*</span></label>
                <input type="text" name="nom_magasin" class="form-control" placeholder="Entrez le nom" required>
            </div>

            <div class="mb-4">
                <label class="form-label">Adresse <span class="required-star">*</span></label>
                <input type="text" name="adresse" class="form-control" placeholder="Entrez l'adresse" required>
            </div>

            <div class="row g-3 mt-4">
    <div class="col-6">
        <button type="submit" class="btn btn-primary w-100">Ajouter</button>
    </div>
    <div class="col-6">
        <a href="gestionmagasins.php" class="btn btn-secondary w-100">Retour</a>
    </div>
</div>
        </form>
    </div>

</body>
</html>


    
