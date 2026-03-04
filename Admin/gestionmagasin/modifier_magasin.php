<?php

require_once '../../includes/connexion.php';

/*if (!isset($_GET['id'])) {
    die("ID manquant");
}*/
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

/*if (!$magasin) {
    die("Magasin introuvable");
}*/

        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = trim($_POST['nom_magasin']);
            $adresse = trim($_POST['adresse']);

            $sql = "UPDATE magasin 
                    SET nom_magasin = ?, adresse = ?
                    WHERE id_magasin = ?";
            $stmt = $pdo->prepare($sql);
            if ($stmt->execute([$nom, $adresse, $id])){;

            header("Location: gestionmagasins.php");
           // exit;
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
<!--mb-4 hya margin b'en div eli 7atetou fih ou 3ounser eli ba3tou mb4 margin akber m'en mb3 
 [ div ]
   |
   ↓  (margin-bottom)(mb4)
[ العنصر اللي بعده ]
-->
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
<!--row hya et9asem elstar le 12 wa7ta  ha4A oufou9eia bech you4ouhrou deux button bejnab eb3a4houm  ken mat7outhach eijiou ta7et eb3a4houm
g-3 hya espace b'en button ma3espace b'en a3meta eli 9asemhoum row 
mt-4 hya margin top eli ben div oufou9ha ma3naha eli b'en deux button ou cham eli fou9ha 
col-6 bech yakhou 6 coloun m'en 12 eli 9asemhoum row -->
            <div class="row g-3 mt-4"> 
                <div class="col-6">
                    <button type="submit" class="btn btn-primary w-100"> Mettre a jour</button>
                </div>
<!--ha4a tabe3 button retour d-flex align-items-center justify-content-center" style="height: 48px; text-decoration: none;
w : width -->
                <div class="col-6">
                    <a href="gestionmagasins.php" class="btn btn-secondary w-100 ">
                        Retour
                    </a>
                </div>
            </div>
        </form>



</body>
</html>