<?php

require_once '../../includes/connexion.php';
require_once '../../employe_stock/auth.php';
require_role(["Admin"]);
if (!isset($_GET['id'])) {
    header("Location: gestionarticle.php");
    exit;
}
$id = intval($_GET['id']);
$stmt = $pdo->prepare("SELECT * FROM article   WHERE id_article = ?");
$stmt->execute([$id]);
$article = $stmt->fetch();
if (!$article) {
    die("Article introuvable");
}
$magasins = $pdo->query("SELECT * FROM magasin")->fetchAll();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom']);
    $modele = trim($_POST['modele']);
     $prix = floatval($_POST['prix']);
    $id_magasin = intval($_POST['id_magasin']);

    $stmt = $pdo->prepare("UPDATE article SET nom_article = ?, modele = ?, cout = ?, id_magasin = ? WHERE id_article = ?");
    if ($stmt->execute([$nom, $modele, $prix, $id_magasin, $id])) {
        header("Location: gestionarticle.php");
        exit;

    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier Article</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
     <link rel="stylesheet" href="../../css/base.css">  
      <link rel="stylesheet" href="../../css/forms.css"> 

  
</head>
<body class="page-form"> 
    <div class="form-container"> 
        <h2>   <i class="bi bi-pencil-square"></i>Modifier l'article</h2>

        <form method="POST">
            <div class="mb-4">
                <label class="form-label">Nom de l'article <span class="required-star">*</span></label>
                <input type="text" name="nom" class="form-control" 
                       value="<?= htmlspecialchars($article['nom_article']) ?>" 
                       placeholder="Ex: Imprimante" required>
            </div>
            
            <div class="mb-4">
                <label class="form-label">Modèle</label>
                <input type="text" name="modele" class="form-control" 
                       value="<?= htmlspecialchars($article['modele']) ?>" 
                       placeholder="Ex: HP">
            </div>
            <div class="mb-4">
                <label class="form-label">Magasin <span class="required-star">*</span></label>
                <select name="id_magasin" class="form-select" required>
                    <option value="">-- Choisir magasin --</option>
                    <?php foreach ($magasins as $m): ?>
                        <option value="<?= $m['id_magasin'] ?>" <?=($m['id_magasin'] == $article['id_magasin']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($m['nom_magasin']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <hr class="section-divider">
            
            <div class="mb-4">
                <label class="form-label">Prix unitaire (DT) <span class="required-star">*</span></label>
                <input type="number" step="0.01" name="prix" class="form-control" 
                       value="<?= $article['cout'] ?>" 
                       placeholder="000" required>
            </div>
            
            <div class="row g-3"> 
                <div class="col-6">
                    <button type="submit" class="btn btn-primary w-100"> Mettre a jour</button>
                </div>
                <div class="col-6">
                    <a href="gestionarticle.php" class="btn btn-secondary w-100 ">
                        Annuler
                    </a>
                </div>
            </div>
        </form>
    </div>

</body>
</body>
</html>

