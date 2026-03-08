<?php
require_once '../includes/connexion.php';
require_once "auth.php";
require_role([ "employe_stock"]);
    $role = 'employe_stock';
$search = $_GET['search'] ?? "";
if ($search != "") {
    $stmt = $pdo->prepare("SELECT a.*, m.nom_magasin 
                           FROM article a 
                           LEFT JOIN magasin m ON a.id_magasin = m.id_magasin 
                           WHERE a.nom_article LIKE ? AND a.etat='actif'");
    $stmt->execute(["%$search%"]);
} else {
    $stmt = $pdo->query("SELECT a.*, m.nom_magasin 
                         FROM article a 
                         LEFT JOIN magasin m ON a.id_magasin = m.id_magasin 
                         WHERE a.etat='actif'");
}
$articles = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Catalogue des Articles</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        
        body { background-color: #fcfcfc; font-family: 'Segoe UI', sans-serif; }
        
        .page-header h2 { font-weight: 700; color: #0f172a; }
        .page-header p { color: #64748b; }

        .search-container { position: relative; margin-bottom: 35px; }
        .search-container .form-control {
            padding: 12px 20px 12px 45px;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
        }
        .search-container i { position: absolute; left: 18px; top: 50%; transform: translateY(-50%); color: #94a3b8; }

        .article-card {
            background: #fff;
            border-radius: 16px;
            border: 1px solid #f1f5f9;
            padding: 24px;
            transition: all 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
            box-shadow: 0 4px 6px rgba(0,0,0,0.02);
        }
        .article-card:hover { transform: translateY(-5px); box-shadow: 0 10px 15px rgba(0,0,0,0.08); }

        .article-title { font-size: 1.1rem; font-weight: 700; color: #1e293b; margin: 0; }
        .article-desc { font-size: 0.85rem; color: #64748b; margin-bottom: 15px; }

        .badge-status { padding: 4px 12px; border-radius: 20px; font-weight: 600; font-size: 0.7rem; }
        .status-ok { background-color: #dcfce7; color: #15803d; }
        .status-low { background-color: #ffedd5; color: #ea580c; }

        .info-row { display: flex; justify-content: space-between; margin-bottom: 10px; border-bottom: 1px solid #f8fafc; padding-bottom: 8px; }
        .info-label { color: #94a3b8; font-size: 0.85rem; }
        .info-value { font-weight: 600; color: #1e293b; font-size: 0.9rem; }
        .magasin-tag { color: #475569; font-size: 0.85rem; display: flex; align-items: center; gap: 5px; margin-top: 10px; padding-top: 10px; border-top: 1px dashed #e2e8f0; }

        .btn-modifier { background: #fff; border: 1px solid #e2e8f0; color: #1e293b; font-weight: 600; border-radius: 10px; padding: 8px; flex-grow: 1; text-align: center; text-decoration: none; }
        .btn-delete { border: 1px solid #fee2e2; color: #ef4444; background: #fff; border-radius: 10px; padding: 8px 12px; text-decoration: none; }
        
        .btn-add { background: #0f172a; color: #fff; border-radius: 10px; font-weight: 600; padding: 10px 20px; text-decoration: none; }
    </style>
</head>
<body>

<div class="container py-5">
    
    <div class="page-header d-flex justify-content-between align-items-start mb-4">
        <div>
            <h2>Articles</h2>
            <p>Gérer le catalogue d'articles et stocks</p>
        </div>
        <?php if($role == 'admin'): ?>
            <a href="ajoute.php" class="btn-add">
                <i class="bi bi-plus-lg"></i> Nouvel Article
            </a>
        <?php endif; ?>
    </div>

    <form class="search-container">
        <i class="bi bi-search"></i>
        <input name="search" class="form-control" placeholder="Rechercher par nom..." value="<?= htmlspecialchars($search) ?>">
    </form>

    <div class="row g-4">
        <?php foreach($articles as $a): ?>
            <div class="col-md-4">
                <div class="article-card">
                    <div class="d-flex justify-content-between align-items-start mb-1">
                        <h3 class="article-title"><?= htmlspecialchars($a['nom_article']) ?></h3>
                        <?php if($a['quantite'] > 10): ?>
                            <span class="badge-status status-ok">OK</span>
                        <?php else: ?>
                            <span class="badge-status status-low">FAIBLE</span>
                        <?php endif; ?>
                    </div>
                    
                    <p class="article-desc">ModEle: <?= htmlspecialchars($a['modele']) ?></p>

                    <div class="info-row">
                        <span class="info-label">Quantite</span>
                        <span class="info-value"><?= $a['quantite'] ?></span>
                    </div>

                    <div class="info-row">
                        <span class="info-label">Prix</span>
                        <span class="info-value text-primary"><?= number_format($a['cout'], 2) ?> DT</span>
                    </div>

                    <div class="magasin-tag">
                        <i class="bi bi-geo-alt"></i>
                        <span>Magasin: <b><?= htmlspecialchars($a['nom_magasin'] ?? 'Non assigné') ?></b></span>
                    </div>

                    <?php if($role == 'admin'): ?>
                        <div class="mt-auto pt-4 d-flex gap-2">
                            <a href="edit.php?id=<?= $a['id_article'] ?>" class="btn-modifier">
                                <i class="bi bi-pencil-square me-1"></i> Modifier
                            </a>
                            <a href="delete.php?id=<?= $a['id_article'] ?>" 
                               class="btn-delete" 
                               onclick="return confirm('Supprimer cet article ?')">
                                <i class="bi bi-trash3"></i>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

</body>
</html>