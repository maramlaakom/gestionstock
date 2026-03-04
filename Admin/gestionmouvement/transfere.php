
<?php

require_once '../../includes/connexion.php';
require_once '../../employe_stock/auth.php';
require_role(["Admin","employe_stock"]);

// تصحيح: التأكد من وجود ID الطلب في الرابط (URL)


//if (isset($_SESSION['role'])) {
    $role = $_SESSION['role'];
//} else {
  //  $role = ''; 
//}
if (strtolower($role )=== strtolower('employe_stock')){
if (!isset($_GET['id'])) {
    die("ID  manquant.");
}
$id_dem = intval($_GET['id']);
}

//if (isset($_SESSION['id_utilisateur'])) {
    $id_user = $_SESSION['id_utilisateur'];
//} else {
  //  $id_user = 1; 
//}

$tousarticle = $pdo->query("SELECT a.id_article, a.nom_article, a.modele, a.quantite, a.id_magasin, m.nom_magasin FROM article a JOIN magasin m ON a.id_magasin = m.id_magasin WHERE a.etat = 'actif' AND a.quantite > 0")->fetchAll(PDO::FETCH_ASSOC);
$tousmagasin = $pdo->query("SELECT * FROM magasin")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_article = intval($_POST['id_article']);
    $id_magasin_dst = intval($_POST['magasin_dst']);
    $qte_transfert = intval($_POST['quantite']);

    try {

        $pdo->beginTransaction();
         // 2. جلب بيانات المقال الحالي
        $stmtArt = $pdo->prepare("SELECT * FROM article WHERE id_article = ?");
        $stmtArt->execute([$id_article]);
        $article = $stmtArt->fetch();

        if (strtolower($role )=== strtolower('employe_stock')){

        // 1. جلب بيانات الطلب (المرجع الأساسي)
        $stmtDem = $pdo->prepare("SELECT qte_demande, id_article, id_magasin_dest FROM demande_contact WHERE id_demande = ?");
        $stmtDem->execute([$id_dem]);
        $donner_demande = $stmtDem->fetch();

        if (!$donner_demande) {
            throw new Exception("Demande introuvable ou ID incorrect.");
        }
        // تثبت هل المقال هو نفسه اللي في الطلب
        if (intval($donner_demande['id_article']) !== $id_article) {
            throw new Exception("L'article choisi ne correspond pas à la demande.");
        }

        if (intval($donner_demande['id_magasin_dest']) !== intval($id_magasin_dst)) {
          throw new Exception("Le magasin de destination   .($$id_magasin_dst).ne correspond pas à celui de la demande  (ID: " . $donner_demande['id_magasin_dest'] . ")");
        }

        // تثبت من الكمية
        if (intval($donner_demande['qte_demande']) !== $qte_transfert) {
            throw new Exception("La quantité est différente de celle autorisée dans la demande.");
        }
        }
            // --- التثبت من صحة البيانات (الرقابة) ---
          if (!$article) /*= if(article==false )*/{
            throw new Exception("Article introuvable.");
        }

        if ($qte_transfert > $article['quantite']) {
            throw new Exception("Quantité insuffisante en stock.");
        }

        $id_magasin_src = $article['id_magasin'];

          if ( $id_magasin_src ===  $id_magasin_dst ) {
            throw new Exception("transfere en meme magasin .");
        }

        /////////////////////
        // Diminuer source
        $stmt = $pdo->prepare("UPDATE article SET quantite = quantite - ? WHERE id_article = ?");
        $stmt->execute([$qte_transfert, $id_article]);
        // etnawej 3ala article eli bech etna9lou fi magasin destination
        $stmt = $pdo->prepare("SELECT id_article FROM article WHERE nom_article = ? AND modele = ? AND id_magasin = ?");
        $stmt->execute([$article['nom_article'], $article['modele'], $id_magasin_dst]);
        $article_dst = $stmt->fetch();

        if ($article_dst) {
            //ken mawjout  kima el9oulou bech ena9lou souris hp enchoufouha ken mawjouta fi magaasin-dest  elwali  enzit fi qte akahaw 
            $stmt = $pdo->prepare("UPDATE article SET quantite = quantite + ? WHERE id_article = ?");
            $stmt->execute([$qte_transfert, $article_dst['id_article']]);
        } else {
              //ken mich mawjout etwali etzitou article
            $stmt = $pdo->prepare("INSERT INTO article (nom_article, modele, numero_serie, cout, quantite, id_magasin) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$article['nom_article'], $article['modele'], null, $article['cout'], $qte_transfert, $id_magasin_dst]);
        }

        // Historique
$stmtMvt = $pdo->prepare("INSERT INTO historique_movement (id_article, type_mouvement, quantite, id_utilisateur, id_magasin_src, id_magasin_dst, commentaire, date_mouvement) VALUES (?, 'transfert', ?, ?, ?, ?, ?, NOW())");
$res = $stmtMvt->execute([$id_article, $qte_transfert, $id_user, $id_magasin_src, $id_magasin_dst, 'Transfert effectué']);
if (strtolower($role )=== strtolower('employe_stock')){
if ($res) {
    $updateDemande = $pdo->prepare("UPDATE demande_contact SET statut = 'executed' WHERE id_demande = ?");
    $updateDemande->execute([$id_dem]); // استعملنا $id_dem اللي خذيناه مالـ URL
    
    $success_message = "Transfert effectué avec succès et demande clôturée.";
}
}
/*
$stmtCheck = $pdo->prepare("SELECT quantite FROM article WHERE id_article = ?");
$stmtCheck->execute([$id_article]);
$current_qte = $stmtCheck->fetchColumn();

if ($current_qte <= 0) {
    // نغيرو الحالة لـ inactif باش ما عادش تظهر في الـ Select متاعك howa elsuprimiou ken article eli id emta3ou haki 
    // eli na9altou m'en magasin eli et7eb etfasekhha ama donner emta3article you9e3tou elkol ama etbatel magasin oui 
    $stmtInactivate = $pdo->prepare("UPDATE article SET etat = 'suprimer' WHERE id_article = ?");
    $stmtInactivate->execute([$id_article]);
}
*/
        $pdo->commit();
        $success_message = "Transfert effectué avec succès";
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
            <input type="number" name="quantite"step="1" class="form-control" required min="1" placeholder="Entrez la quantité">
        </div>

        <div class="row g-3 mt-4">
            <div class="col-6">
                <button type="submit" class="btn btn-primary w-100">
                    Transférer
                </button>
            </div>
            <div class="col-6">
             
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
        </div>
    </form>
</div>

</body>
</html>
