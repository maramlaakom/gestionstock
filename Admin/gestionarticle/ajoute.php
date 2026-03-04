<?php
require_once '../../includes/connexion.php';
require_once '../../employe_stock/auth.php';
require_role(["Admin"]);
$id_user = $_SESSION['id_utilisateur'];

$errors = [];
$success = "";

// Récupérer les magasins
$magasins = $pdo->query("SELECT * FROM magasin")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {// = if (isset($_POST['name button engistrer  ']))
    $nom_article = trim($_POST['nom_article']);
    $modele      = trim($_POST['modele']);
    $sn   = trim($_POST['numero_serie']);
   // $quantite    = intval($_POST['quantite']);
    $cout  = floatval($_POST['prix']);
    $id_magasin  = intval($_POST['id_magasin']);

    // Validation
    if (!$nom_article || !$modele || !$sn  || $cout < 0 || $id_magasin <= 0) {
        $errors[] = "Tous les champs sont obligatoires et doivent avoir des valeurs valides.";
    }

    if (empty($errors)) { 
        try {
            $pdo->beginTransaction();

            // Inserer l'article
            $sql = "INSERT INTO article 
                    (nom_article, modele, numero_serie, quantite, cout, id_magasin) 
                    VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$nom_article, $modele, $sn, 1, $cout, $id_magasin]);

            // Recuperer dernier ID haki etjib akher id takhaltou ela bd akher id article  
            $last_id = $pdo->lastInsertId();

            // Ajouter dans historique_movement
            $sql_hist = "INSERT INTO historique_movement 
                         (id_article, type_mouvement, quantite, id_utilisateur, id_magasin_dst, commentaire)
                         VALUES (?, 'entree', ?, ?, ?, ?)";
            $stmt_hist = $pdo->prepare($sql_hist);
            $stmt_hist->execute([$last_id, 1, $id_user, $id_magasin, "Nouvel article ajoute"]);

            $pdo->commit();
            $success = "Article ajouté et mouvement enregistré avec succès !";

        } catch (Exception $e) {
            $pdo->rollBack();
            $errors[] = "Erreur lors de l'ajout : " . $e->getMessage();
        }
    }
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter Article</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/base.css">  
      <link rel="stylesheet" href="../../css/forms.css"> 
</head>
<body class="page-form"> 
    <div class="form-container"> 
    <h2 class="text-center">Ajouter un Article</h2>

        <?php if (!empty($errors)): ?>
            <div class=" alert-danger">
                <?php foreach ($errors as $err) 
                    echo "<p class='m-0'>$err</p>"; 
                ?>
            </div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="alert alert-success"><?=/* htmlspecialchars*/$success ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Nom de l'article <!--<span class="required-star">*</span>--></label>
                <input type="text" name="nom_article" class="form-control" 
                       placeholder="donner le nom Imprimante " required>
        <!-- required ha4i bech ki tenzel 3ala button ou yabta mahouch em3amer yatna3 blaka eskhira feha veuiilez ....-->
            </div>
            
            <div class="mb-3">
                <label class="form-label">Modele</label>
                <input type="text" name="modele" class="form-control" 
                       placeholder=" type article ">
            </div>
            
            <div class="mb-3">
                <label class="form-label">Numero de serie</label>
                <input type="text" name="numero_serie" class="form-control" 
                       placeholder="numero serie"> 
            </div>
            
            <div class="mb-3">
                <label class="form-label">Magasin <span class="required-star">*</span></label>
                <select name="id_magasin" class="form-select" required>
                    <option value="">-- Choisir magasin --</option>
                    <?php foreach ($magasins as $m): ?>
                    <!--id ma7atethach htmlspecialchar 3alakhater number ou nom char -->
                        <option value="<?= $m['id_magasin'] ?>">
                            <?= htmlspecialchars($m['nom_magasin']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
                   
               <div class="mb-4">
                   <label class="form-label">Prix unitaire (DT) <span class="required-star">*</span></label>
                    <input type="number" step="0.01" name="prix" class="form-control" min="0"    placeholder="000"  required>
                </div>
                
               
           
            
            <div class="row g-3 mt-3">
                <div class="col-6">
                    <button type="submit" class="btn btn-primary w-100">Enregistrer</button>
                </div>
                  <!-- ha4ouma kanou em3a button annuler d-flex align-items-center justify-content-center" style="height: 48px; text-decoration: none; -->
                <div class="col-6">
                    <a href="gestionarticle.php" class="btn btn-secondary w-100 ">Annuler</a>
                </div>
            </div>
            </div>
        </form>
    </div>


</body>
</html>

