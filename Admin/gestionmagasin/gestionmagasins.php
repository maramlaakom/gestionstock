<?php
require_once '../../includes/connexion.php';
require_once '../../employe_stock/auth.php';
require_role(["Admin","employe_stock"]);
if (isset($_GET['search'])) {
    $search = $_GET['search'];
} else {
    $search = "";
}
    $role = $_SESSION['role'];
$CAPACITE_DEFAUT = 2000; 
    if ($search != "") {
        $sql = "SELECT m.*, COUNT(a.id_article) AS nb_types, IFNULL(SUM(a.quantite), 0) AS total_qte FROM magasin m
        LEFT JOIN article a ON m.id_magasin = a.id_magasin AND a.etat = 'actif' AND a.quantite > 0
        WHERE m.nom_magasin LIKE ? 
        GROUP BY m.id_magasin";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(["%$search%"]);
    } else {
        $sql = "SELECT m.*, COUNT(a.id_article) AS nb_types, IFNULL(SUM(a.quantite), 0) AS total_qte
                FROM magasin m
                LEFT JOIN article a ON m.id_magasin = a.id_magasin AND a.etat = 'actif'AND a.quantite > 0
                GROUP BY m.id_magasin";
        $stmt = $pdo->query($sql);
    }
    $magasins = $stmt->fetchAll();
    foreach ($magasins as &$m) {
        $stmt_art = $pdo->prepare("SELECT nom_article, quantite FROM article WHERE id_magasin = ? AND etat = 'actif' AND quantite >0 ");
        $stmt_art->execute([$m['id_magasin']]);
        $m['list_articles'] = $stmt_art->fetchAll();
        unset($m);
    }
    

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Magasins</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <link rel="stylesheet" href="../../css/base.css">
    <link rel="stylesheet" href="../../css/cards.css">
    <link rel="stylesheet" href="../../css/forms.css">
</head>
<body>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-0 "><i class="bi bi-building me-2"></i> Gestion des Magasins</h2>
            <p class="text-muted small">Gestion des stocks et inventaire par entrepôt</p>
        </div>
         <?php if( $role == 'admin'): ?>
        <a href="ajout_magasin.php" class="btn btn-primary   ">
            <i class="bi bi-plus-lg "></i> Ajouter Magasin
        </a>
              <?php endif; ?>
    </div>
    <div class="search-container  ">
        <form method="GET">
            <div class="input-group">
                <input type="text" name="search" class="form-control p-3 " 
                       placeholder="Rechercher un magasin ..." >
                <button class="btn btn-primary px-4"><i class="bi bi-search"></i></button>
            </div>
        </form>
    </div>


    <div class="row g-4">
        <?php if(empty($magasins)): ?>
            <div class="col-12">
                <div class="no-results shadow-sm">
                    <i class="bi bi-building-exclamation" style="font-size: 4rem; color: var(--secondary);"></i>
                    <h4 class="mt-3 fw-bold " style="color: var(--primary);">Aucun magasin trouvé</h4>
                    <p class="text-muted">Essayez un autre mot-clé ou créez un nouveau magasin.</p>
                </div>
            </div>
        <?php else: ?>
            <?php foreach($magasins as $m): 
                $usage_percent = ($m['total_qte'] / $CAPACITE_DEFAUT) * 100;
               if ($usage_percent > 85) {
               $bar_color = 'bg-danger';
                } elseif ($usage_percent > 50) {
                $bar_color = 'bg-warning';
                } else {
                $bar_color = 'bg-success';
                }?>    
                <div class="col-4">
                    <div class="user-card ">
                        
                        <div class="mb-3">
                            <h4 class="fw-bold text-dark mb-1 text-uppercase"><?= htmlspecialchars($m['nom_magasin']) ?></h4>
                            <div class="text-primary small">
                                <i class="bi bi-geo-alt"></i> <?= htmlspecialchars($m['adresse']) ?>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="small text-muted fw-bold">Utilisation</span>
                                <span class="fw-bold small text-dark"><?=($m['total_qte']) ?> / <?= $CAPACITE_DEFAUT ?></span>
                            </div>
                            <div class="progress" style="height: 10px; background-color: #f0f2f5; border-radius: 10px;">
                                <div class="progress-bar <?= $bar_color ?> rounded-pill" style="width: <?= min($usage_percent, 100) ?>%"><??> </div>
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-6">
                                <div class="border rounded p-3 text-center bg-white ">
                                    <h3 class="fw-bold mb-0 text-dark"><?= $m['nb_types'] ?></h3>
                                    <small class="text-primary fw-bold">nb peripherique </small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="border rounded p-3 text-center bg-white ">
                                    <h3 class="fw-bold mb-0 text-dark"><?= $m['total_qte'] ?></h3>
                                    <small class="text-primary fw-bold">Total Qte</small>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="fw-bold text-muted small mb-2 text-uppercase">Contenu recent :</label>
                            <div class="bg-light rounded p-3 border-start border-4 border-primary ">
                                <?php if(empty($m['list_articles'])): ?>
                                    <div class="text-muted small text-center italic">Aucun article actif</div>
                                <?php else: ?>
                                    <?php foreach($m['list_articles'] as $art): ?>
                                        <div class="d-flex justify-content-between align-items-center mb-2 border-bottom  border-white">
                                            <span class="text-dark small"><?= htmlspecialchars($art['nom_article']) ?></span>
                                            <span class="badge bg-white text-primary border  px-2"><?= $art['quantite'] ?></span>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="d-flex gap-2 mt-auto pt-3">
                               <?php if( $role == 'admin'): ?>
                            <a href="modifier_magasin.php?id=<?= $m['id_magasin'] ?>" 
                               class="btn btn-outline-primary flex-grow-1 ">
                               <i class="bi bi-pencil-square me-1"></i> Modifier
                            </a>
                            <a href="suprimer_magasin.php?id=<?= $m['id_magasin'] ?>" 
                               class="btn btn-outline-danger " 
                               
                               onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce magasin ?')">
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
<?php if (isset($_GET['msg'])): ?>
    <script>
        <?php if ($_GET['msg'] == 'erreur'): ?>
            alert("Impossible de supprimer : ce magasin contient encore des articles !");
        <?php elseif ($_GET['msg'] == 'deleted'): ?>
            alert("Magasin supprimé avec succès.");
        <?php endif; ?>
    </script>
<?php endif; ?>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>