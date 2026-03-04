
<?php


require_once '../../includes/connexion.php';
require_once '../../employe_stock/auth.php';
require_role(["Admin" ,"employe_stock"]);
//if (isset($_SESSION['role'])) {
    $role = $_SESSION['role'];
//} else {
  //  $role = '';
//}


// utilisateur connecté (exemple)
   $id_user = $_SESSION['id_utilisateur'];

// charger articles
$articles = $pdo->query("SELECT id_article, nom_article, modele, quantite FROM article WHERE etat = 'actif'AND quantite > 0")->fetchAll();

$success_message = '';
$error_message = '';

if (isset($_POST['entree'])) {
    $id_article = $_POST['id_article'];
    $qte = intval ($_POST['quantite']);

   
        try {
            // transaction
            $pdo->beginTransaction();

            // récupérer article
            $stmt = $pdo->prepare("SELECT quantite, id_magasin FROM article WHERE id_article = ?");
            $stmt->execute([$id_article]);
            $article = $stmt->fetch();

                 
            if (!$article) {
    throw new Exception("Article introuvable");
}

            // mise à jour stock
            $new_qte = $article['quantite'] + $qte;
            $stmt = $pdo->prepare("UPDATE article SET quantite = ? WHERE id_article = ?");
            $stmt->execute([$new_qte, $id_article]);

            // historique
            $stmt = $pdo->prepare("
                INSERT INTO historique_movement
                (id_article, type_mouvement, quantite, id_utilisateur, id_magasin_dst, date_mouvement)
                VALUES (?, 'entree', ?, ?, ?, NOW())
            ");
            $stmt->execute([
                $id_article,
                $qte,
                $id_user,
                $article['id_magasin']
            ]);

            // confirmation
            $pdo->commit();
            $success_message = "Entrée stock réussie";

        } catch (Exception $e) {
            $pdo->rollBack();
            $error_message = "Erreur : " . $e->getMessage();
        }
    
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Entrée Stock</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
     <link rel="stylesheet" href="../../css/base.css">  
      <link rel="stylesheet" href="../../css/forms.css">
   <body class="page-form"> 
    <div class="form-container"> 
        <h2>Entrée de Stock</h2>

        <?php if ($success_message): ?>
            <div class="alert alert-success"><?=$success_message ?></div>
        <?php endif; ?>
        
        <?php if ($error_message): ?>
            <div class="alert alert-danger"><?= $error_message ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-4">
                <label class="form-label">Article <span class="required-star">*</span></label>
                <select name="id_article" class="form-select" required>
                    <option value="">-- Choisir article --</option>
                    <?php foreach ($articles as $art): ?>
                        <option value="<?= $art['id_article'] ?>">
                            <?= htmlspecialchars($art['nom_article'] . ' - ' . $art['modele'] . ' (Stock actuel: ' . $art['quantite'] . ')') ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-4">
                <label class="form-label">Quantité entrée <span class="required-star">*</span></label>
                <input type="number" name="quantite" class="form-control" min="1" required placeholder="Entrez la quantité">
            </div>

            <div class="row g-3 mt-4"> 
                <div class="col-6">
                    <button type="submit" name="entree" class="btn btn-primary w-100">
                        Entrée stock
                    </button>
                </div>
                <div class="col-6">
                  <?php if($role == 'admin'): ?>

        <a href="gestionmouvement.php" class="btn btn-secondary w-100 d-flex align-items-center justify-content-center" style="height: 48px; text-decoration: none;">

            Retour

        </a>

    <?php elseif( $role == 'employe_stock'): ?>

        <a href="../../employe_stock/index.php"class="btn btn-secondary w-100 d-flex align-items-center justify-content-center" style="height: 48px; text-decoration: none;">

            Retour

        </a>

    <?php endif; ?>
        </div>

                </div>
            </div>
        </form>
    </div>

</body>
</html>