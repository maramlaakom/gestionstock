
<?php

require_once '../../includes/connexion.php';
require_once '../../employe_stock/auth.php';
require_role(["Admin","employe_stock"]);
    $role = $_SESSION['role'];
if (strtolower($role )=== strtolower('employe_stock')){
if (!isset($_GET['id'])) {
    die("ID demante manquant.");
}
$id_dem = intval($_GET['id']);
}
    $id_user = $_SESSION['id_utilisateur'];
$tousarticle = $pdo->query("SELECT a.id_article, a.nom_article, a.modele, a.quantite, a.id_magasin, m.nom_magasin FROM article a JOIN magasin m ON a.id_magasin = m.id_magasin WHERE  a.quantite > 0")->fetchAll();
$tousmagasin = $pdo->query("SELECT * FROM magasin")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_article = intval($_POST['id_article']);
    $id_magasin_dst = intval($_POST['magasin_dst']);
    $qte_transfert = $_POST['quantite'];

    try {

        $pdo->beginTransaction();
       $stmtArt = $pdo->prepare("SELECT a.*, m.nom_magasin as nom_magasin_src FROM article a JOIN magasin m ON a.id_magasin = m.id_magasin 
       WHERE a.id_article = ?");
        $stmtArt->execute([$id_article]);
        $article = $stmtArt->fetch();

        if (strtolower($role )=== strtolower('employe_stock')){
        $stmtDem = $pdo->prepare("SELECT qte_demande, id_article, id_magasin_dest FROM demande_contact WHERE id_demande = ?");
        $stmtDem->execute([$id_dem]);
        $donner_demande = $stmtDem->fetch();

        if (!$donner_demande) {
            throw new Exception("Demande introuvable ou ID incorrect.");
        }
        if (intval($donner_demande['id_article']) !== $id_article) {
            throw new Exception("L'article choisi ne correspond pas à la demande.");
        }

        if (intval($donner_demande['id_magasin_dest']) !== intval($id_magasin_dst)) {
          throw new Exception("Le magasin de destination   .($$id_magasin_dst).ne correspond pas à celui de la demande  (ID: " . $donner_demande['id_magasin_dest'] . ")");
        }
        if (intval($donner_demande['qte_demande']) !== $qte_transfert) {
            
            throw new Exception("La quantite est differente de celle autorisee dans la demande.");
        }
        }
          if (!$article) {
            throw new Exception("Article introuvable.");
        }

        if ($qte_transfert > $article['quantite']) {
            throw new Exception("Quantité insuffisante en stock.");
        }

        $id_magasin_src = $article['id_magasin'];

          if ( $id_magasin_src ===  $id_magasin_dst ) {
            throw new Exception("transfere en meme magasin .");
        }

        $stmt = $pdo->prepare("UPDATE article SET quantite = quantite - ? WHERE id_article = ?");
        $stmt->execute([$qte_transfert, $id_article]);
        $stmt = $pdo->prepare("SELECT id_article FROM article WHERE nom_article = ? AND modele = ? AND id_magasin = ?");
        $stmt->execute([$article['nom_article'], $article['modele'], $id_magasin_dst]);
        $article_dst = $stmt->fetch();

        if ($article_dst) {
            $stmt = $pdo->prepare("UPDATE article SET quantite = quantite + ? WHERE id_article = ?");
            $stmt->execute([$qte_transfert, $article_dst['id_article']]);
        } else {
            $stmt = $pdo->prepare("INSERT INTO article (nom_article, modele,  cout, quantite, id_magasin) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$article['nom_article'], $article['modele'], $article['cout'], $qte_transfert, $id_magasin_dst]);
        }
        $stmtDst = $pdo->prepare("SELECT nom_magasin FROM magasin WHERE id_magasin = ?");
$stmtDst->execute([$id_magasin_dst]);
$nom_magasin_dst = $stmtDst->fetch();
        $commentaire = "Transfert effectué de " .  $article  ['nom_magasin_src']. " vers " . $nom_magasin_dst['nom_magasin'];
        $stmtMvt = $pdo->prepare("INSERT INTO historique_movement (id_article, type_mouvement, quantite, id_utilisateur, commentaire, date_mouvement) VALUES (?, 'transfert', ?, ?, ?, NOW())");
        $res = $stmtMvt->execute([$id_article, $qte_transfert, $id_user,$commentaire ]);
        if (strtolower($role )=== strtolower('employe_stock')){
        if ($res) {
         $updateDemande = $pdo->prepare("UPDATE demande_contact SET statut = 'executed' WHERE id_demande = ?");
        $updateDemande->execute([$id_dem]); 
        $success_message = "Transfert effectue avec succes .";
        }
        }
        $pdo->commit();
        $success_message = "Transfert effectue avec succes";
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
    <title>Transfert Article</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/base.css">  
    <link rel="stylesheet" href="../../css/forms.css">
</head>
<body class="page-form">

<div class="form-container">
    <h2>Transfert d'Article</h2>

    <?php if (isset($success_message)): ?>
        <div class="alert alert-success"><?=$success_message ?></div>
    <?php endif; ?>
    
    <?php if (isset($error_message)): ?>
        <div class="alert alert-danger"><?=$error_message ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-4">
            <label class="form-label">Article à transférer <span class="required-star">*</span></label>
            <select name="id_article" class="form-select" required>
                <option value="">-- Choisir article --</option>
                <?php foreach ($tousarticle as $art): ?>
                    <option value="<?= $art['id_article'] ?>">
                        <?= htmlspecialchars($art['nom_article'] . " - " . $art['modele'] . " (Stock: " . $art['quantite'] . ", Magasin src: " . $art['nom_magasin'] . ")") ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-4">
            <label class="form-label">Magasin de destination <span class="required-star">*</span></label>
            <select name="magasin_dst" class="form-select" required>
                <option value="">-- Choisir magasin --</option>
                <?php foreach ($tousmagasin as $mag): ?>
                    <option value="<?= $mag['id_magasin'] ?>">
                        <?= htmlspecialchars($mag['nom_magasin'] . " - " . $mag['adresse']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        

        <div class="mb-4">
            <label class="form-label">Quantité <span class="required-star">*</span></label>
            <input type="number" name="quantite"step="1" class="form-control" required min="1" placeholder="Entrez la quantite">
        </div>

         <div class="d-flex gap-3">
        
                <button type="submit" class="btn btn-primary w-100">
                    Transférer
                </button>
           
             
  <?php if(isset($role) && $role == 'admin'): ?>

        <a href="gestionmouvement.php" class="btn btn-secondary w-100 d-flex align-items-center justify-content-center" style="height: 48px; text-decoration: none;" >

            Retour

        </a>

    <?php elseif(isset($role) && $role == 'employe_stock'): ?>

        <a href="../../employe_stock/mouvement.php"class="btn btn-secondary w-100 d-flex align-items-center justify-content-center" style="height: 48px; text-decoration: none;">

            Retour

        </a>
        <?php endif ?>
           
        </div>
    </form>
</div>

</body>
</html>
