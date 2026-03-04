<?php
require_once '../../includes/connexion.php';
require_once '../../employe_stock/auth.php';
require_role(["Admin","employe_stock"]);


//if (isset($_SESSION['role'])) {
    $role = $_SESSION['role'];
//} else {
  //  $role = '';
//}


// utilisateur connecté (exemple)
//if (isset($_SESSION['id_utilisateur'])) {
    $id_user = $_SESSION['id_utilisateur'];
//} else {
  //  $id_user = 1;
//}

if (strtolower($role )=== strtolower('employe_stock')){
if (!isset($_GET['id'])) {
    die("ID  manquant.");
}
$id_dem = intval($_GET['id']);
}

// جلب المقالات النشطة

$articles = $pdo->query("SELECT id_article, nom_article, modele, quantite FROM article WHERE etat = 'actif' AND quantite >0 ")->fetchAll(PDO::FETCH_ASSOC);
$success_message = '';
$error_message = '';

if (isset($_POST['sortie'])) {
    $id_article = $_POST['id_article'];
    $qte = intval ($_POST['quantite']);

    //if ($qte <= 0) {
      //  $error_message = "Quantité invalide";
   // } else {
        try {
            $pdo->beginTransaction();
            
            $stmt = $pdo->prepare("SELECT nom_article, quantite, id_magasin FROM article WHERE id_article = ?");
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

            // تسجيل الحركة
           $stmtHist = $pdo->prepare("
                INSERT INTO historique_movement 
                (id_article, type_mouvement, quantite, id_utilisateur, id_magasin_src, date_mouvement, commentaire) 
                VALUES (?, 'sortie', ?, ?, ?, NOW(), ?)
            ");
          $res = $stmtHist->execute([$id_article, $qte, $id_user, $article['id_magasin'], 'Sortie validée']);

            // 3. التحديث المهم: إغلاق الطلب
       

            // إرسال تنبيه إذا انخفض المخزون
           /* if ($new_qte <= 20) {
                $stmtAdmin = $pdo->query("SELECT id_utilisateur FROM utilisateur WHERE role = 'Admin'");
                $admins = $stmtAdmin->fetchAll();
                if ($admins) {
                    $nom_art = $article['nom_article'];
                    $notif_msg = "Alerte Stock : L'article [" . $nom_art . "] est presque épuisé (" . $new_qte . " restants).";
                    $insNotif = $pdo->prepare("INSERT INTO notification (id_utilisateur, contenu, etat, date_notification) VALUES (?, ?, 'non_lu', NOW())");
                    foreach ($admins as $admin) {
                        $insNotif->execute([$admin['id_utilisateur'], $notif_msg]);
                    }
                }
            }*/
                // كود يتحط في صفحة sortiestock.php مثلاً
                        if (strtolower($role )=== strtolower('employe_stock')){
                        // ma3naha ken res execute ma3naha et9aitet mouvement fi tableau historique de mouvement  3alakhater 
                        // ken et9aited fi lmouvement rahi c'est bon saret 
                      if ($res) {
                $updateStatus = $pdo->prepare("UPDATE demande_contact SET statut = 'executed' WHERE id_demande = ?");
                $updateStatus->execute([$id_dem]);
                
              
            }}

            $pdo->commit();
            $success_message = "Sortie de stock effectuée avec succès";
            
            // تحديث القائمة
            $articles = $pdo->query("SELECT id_article, nom_article, modele, quantite FROM article WHERE etat = 'actif'")->fetchAll();

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
<?php// echo $role?>
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

        <div class="row g-3 mt-4">
            <div class="col-6">
                <button type="submit" name="sortie" class="btn btn-primary w-100">
                    Enregistrer
                </button>
            </div>
            <div class="col-6">
                   
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
        </div>
    </form>
</div>

</body>
</html>