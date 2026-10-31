<?php
require_once '../../employe_stock/auth.php';
require_role(["Admin","employe_stock"]);
require_once '../../includes/connexion.php';
    $role = $_SESSION['role'];
if (isset($_GET['search'])) {
    $search = $_GET['search'];
} else {
    $search = "";
}
if ($search != "") {
    $stmt = $pdo->prepare("SELECT a.*, m.nom_magasin 
                           FROM article a 
                            JOIN magasin m ON a.id_magasin = m.id_magasin 
                           WHERE (a.nom_article LIKE ? OR a.modele LIKE ? OR m.nom_magasin LIKE ?  ) 
                            AND quantite >0");
    $stmt->execute(["%$search%", "%$search%", "%$search%"]);
} else {
    $stmt = $pdo->query("SELECT a.*, m.nom_magasin 
                         FROM article a 
                         JOIN magasin m ON a.id_magasin = m.id_magasin 
                         WHERE quantite >0");
}
$articles = $stmt->fetchAll(); 
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalogue des Articles</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <link rel="stylesheet" href="../../css/base.css">
    <link rel="stylesheet" href="../../css/cards.css">
      <link rel="stylesheet" href="../../css/forms.css">
   <style>
.bg1 { background-color: #7cbbff ; color: black; }
.bg2 { background-color: #ff6f59 ; color: black }
</style>
</head>
<body>
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-0"><i class="bi bi-box-seam"></i> Gestion des Articles</h2>
            <p class="text-muted small ">Gérer le stock et les détails des articles</p>
        </div>
        <?php if($role == 'admin'): ?>
            <a href="ajoute.php" class="btn btn-primary ">
                <i class="bi bi-plus-lg"></i> Ajouter Article
            </a>
        <?php endif; ?>
    </div>

    <div class="search-container ">
        <form method="GET" >
            <div class="input-group">
                <input type="text" name="search" class="form-control p-3" placeholder="Rechercher un article...">
                <button class="btn btn-primary px-4"><i class="bi bi-search"></i></button>
            </div>
        </form>
    </div>
    <div class="row g-4">
        <?php if (empty($articles)): ?>
            <div class="col-12">
                <div class="no-results ">
                    <i class="bi bi-inbox" style="font-size: 4rem; color: var(--secondary);"></i>
                    <h4 class="mt-3 fw-bold" style="color: var(--primary);">Aucun article trouvé</h4>
                    <p class="text-muted">Essayez une autre recherche ou ajoutez un nouvel article</p>
                </div>
            </div>
        <?php else: ?>
            <?php foreach ($articles as $a): ?>
                <div class="col-4">
                    <div class="user-card"> 
                        <div class="d-flex justify-content-between align-items-start mb-4">
                            <div class="avatar-circle">
                                <i class="bi bi-box-fill"></i>
                            </div>
                            <span class="badge rounded-pill <?= ($a['quantite'] > 20) ? 'bg1' : 'bg2' ?> px-3 py-2">
                                <?= $a['quantite'] ?> article
                            </span>
                        </div>
                        
                        <h5 class="fw-bold mb-1 text-primary"><?= htmlspecialchars($a['nom_article']) ?></h5>
                    
                        <div class="mb-4">
                            <label class="text-muted small d-block mb-1 fw-bold">Détails</label>
                            <div class="small text-dark">
                                <i class="bi bi-tag me-1"></i> <strong>Modele:</strong> <?= htmlspecialchars($a['modele']) ?><br>
                                <i class="bi bi-shop me-1"></i> <strong>Magasin:</strong> <?= htmlspecialchars($a['nom_magasin'] )?>
                            </div>
                        </div>
                        <div class="mb-4">
                            <span class="small text-primary fw-bold">
                                 <span >Prix</span>
                        <span ><?= $a['cout']?> DT</span>
                               
                            </span>
                        </div>
                        <div class="d-flex gap-2 pt-3 ">
                               <?php if($role == 'admin'): ?>
                            <a href="edit.php?id=<?= $a['id_article'] ?>"
                             class="btn btn-outline-primary flex-grow-1">
                                <i class="bi bi-pencil-square"></i> Modifier
                            </a>
                            <a href="delete.php?id=<?= $a['id_article'] ?>" 
                               class="btn btn-outline-danger"
                               onclick="return confirm('Voulez-vous vraiment supprimer cet article ?')">
                                <i class="bi bi-trash"></i>
                            </a>
                                <?php endif; ?>

                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

</body>
</html>