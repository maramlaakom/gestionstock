<?php
require_once '../../includes/connexion.php';
require_once '../../employe_stock/auth.php';
require_role(["Admin","employe_stock"]);
    $role = $_SESSION['role'];
    $id_user = $_SESSION['id_utilisateur'];
    if (strtolower($role )=== strtolower('employe_stock')){
    if (!isset($_GET['id'])) {
    die("ID demante manquant.");
}
$id_dem = intval($_GET['id']);
}
$articles = $pdo->query("SELECT id_article, nom_article, modele, quantite FROM article WHERE quantite >0 ")->fetchAll();
$success_message = '';
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_article = $_POST['id_article'];
    $qte =  $_POST['quantite'];
        try {
            $pdo->beginTransaction();
            
            $stmt = $pdo->prepare("SELECT a.quantite, m.nom_magasin FROM article a JOIN magasin m ON a.id_magasin = m.id_magasin WHERE a.id_article = ?");
            $stmt->execute([$id_article]);
            $article = $stmt->fetch();
             if (strtolower($role )=== strtolower('employe_stock')){
              $stmt = $pdo->prepare("SELECT  qte_demande ,id_article  FROM demande_contact WHERE id_demande = ?");
            $stmt->execute([$id_dem]);
            $donner_demande = $stmt->fetch();    
            if (!$donner_demande) {
    throw new Exception("Demande introuvable ou ID incorrect.");
}


if (intval ($donner_demande['id_article']) !==intval($id_article)) {
    throw new Exception("Cet article ne correspond pas à la demande");
}

             if ($donner_demande['qte_demande'] !== $qte){
              throw new Exception ("la quantite diferent dde quantite de demande ");
              }
             
             }

            if ($qte > $article['quantite']) {
                throw new Exception("Quantité insuffisante en stock");
            }
            
            if (!$article) {
    throw new Exception("Article introuvable");
}

            $new_qte = $article['quantite'] - $qte;
            $stmt = $pdo->prepare("UPDATE article SET quantite = ? WHERE id_article = ?");
            $stmt->execute([$new_qte, $id_article]);
           $ommentaire =   "Sortie du magasin: " . $article['nom_magasin'];
        $stmtHist = $pdo->prepare("INSERT INTO historique_movement 
        (id_article, type_mouvement, quantite, id_utilisateur, date_mouvement, commentaire) 
        VALUES (?, 'sortie', ?, ?, NOW(), ?)");


        $res = $stmtHist->execute([$id_article,  $qte,  $id_user,   $ommentaire  ]);
                    if (strtolower($role )=== strtolower('employe_stock')){
                      if ($res) {
                $updateStatus = $pdo->prepare("UPDATE demande_contact SET statut = 'executed' WHERE id_demande = ?");
                $updateStatus->execute([$id_dem]);
                
              
            }}

            $pdo->commit();
            $success_message = "Sortie de stock effectuée avec succes";
         

        } catch (Exception $e) {
            $pdo->rollBack();
            $error_message = $e->getMessage();
        }
    }


?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sortie Stock</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/base.css">  
    <link rel="stylesheet" href="../../css/forms.css">
</head>
<?php?>
<body class="page-form">

<div class="form-container">
    <h2>Sortie de Stock</h2>

    <?php if ($success_message): ?>
        <div class="alert alert-success"><?=$success_message ?></div>
    <?php endif; ?>
    
    <?php if ($error_message): ?>
        <div class="alert alert-danger"><?=$error_message ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-4">
            <label class="form-label">Article <span class="required-star">*</span></label>
            <select name="id_article" class="form-select" required>
                <option value="">-- Choisir article --</option>
                <?php foreach ($articles as $art): ?>
                    <option value="<?= $art['id_article'] ?>">
                        <?= htmlspecialchars($art['nom_article'] . ' - ' . $art['modele'] . ' | Stock: ' . $art['quantite']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-4">
            <label class="form-label">Quantité sortie <span class="required-star">*</span></label>
            <input type="number" name="quantite" class="form-control" min="1" required placeholder="Entrez la quantité">
        </div>

         <div class="d-flex gap-3">
            
                <button type="submit" name="sortie" class="btn btn-primary w-100">
                    Enregistrer
                </button>
            
                   
  <?php if ($role == 'admin'): ?>

        <a href="gestionmouvement.php" class="btn btn-secondary w-100 d-flex align-items-center justify-content-center" style="height: 48px; text-decoration: none;" >

            Retour

        </a>

    <?php elseif( $role == 'employe_stock'): ?>

        <a href="../../employe_stock/mouvement.php" class="btn btn-secondary w-100 d-flex align-items-center justify-content-center" style="height: 48px; text-decoration: none;">

            Retour

        </a>
        <?php endif ?>
        
            
        </div>
    </form>
</div>

</body>
</html>