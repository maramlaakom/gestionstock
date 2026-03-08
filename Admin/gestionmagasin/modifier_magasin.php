<?php

require_once '../../includes/connexion.php';
require_once '../../employe_stock/auth.php';
require_role(["Admin"]);
if (!isset($_GET['id'])) {
    header("Location: gestionmagasins.php");
    exit;
}

$id = $_GET['id'];

$sql = "SELECT * FROM magasin WHERE id_magasin = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
$magasin = $stmt->fetch();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = trim($_POST['nom_magasin']);
            $adresse = trim($_POST['adresse']);

            $sql = "UPDATE magasin 
                    SET nom_magasin = ?, adresse = ?
                    WHERE id_magasin = ?";
            $stmt = $pdo->prepare($sql);
            if ($stmt->execute([$nom, $adresse, $id])){;

            header("Location: gestionmagasins.php");
           exit;
            }
        }
        

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Modifier Magasin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/base.css">  
      <link rel="stylesheet" href="../../css/forms.css">
    <body class="page-form">
         <div class="form-container">
         <h2>  <i class="bi bi-pencil-square"></i>Modifier le Magasin</h2>

        <form method="post">
            <div class="mb-4 ">
                <label class="form-label">Nom du magasin <span class="required-star">*</span></label>
                <input type="text" name="nom_magasin" class="form-control" 
                       value="<?= htmlspecialchars($magasin['nom_magasin']) ?>" required>
            </div>

            <div class="mb-4">
                <label class="form-label">Adresse <span class="required-star">*</span></label>
                <input type="text" name="adresse" class="form-control" 
                       value="<?= htmlspecialchars($magasin['adresse']) ?>" required>
            </div>
            <div class="row g-3 mt-4"> 
                <div class="col-6">
                    <button type="submit" class="btn btn-primary w-100"> Mettre a jour</button>
                </div>
                <div class="col-6">
                    <a href="gestionmagasins.php" class="btn btn-secondary w-100 ">
                        Retour
                    </a>
                </div>
            </div>
        </form>



</body>
</html>