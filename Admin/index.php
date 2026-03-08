<?php
require_once '../includes/connexion.php';
require_once '../employe_stock/auth.php';
require_role(["Admin"]);
$id_user = $_SESSION['id_utilisateur'] ;
$nom_user = $_SESSION['nom'] ;
$prenom_user = $_SESSION['prenom'];
include 'alert_stock.php';

try {
    $unread_notif = $pdo->query("SELECT COUNT(*) FROM notification WHERE id_utilisateur = $id_user AND etat = 'non_lu'")->fetchColumn() ?: 0;
    $total_art = $pdo->query("SELECT COUNT(*) FROM article WHERE etat = 'actif'")->fetchColumn() ?: 0;
    $total_mag = $pdo->query("SELECT COUNT(*) FROM magasin")->fetchColumn() ?: 0;
    $total_mvt = $pdo->query("SELECT COUNT(*) FROM historique_movement WHERE  MONTH(date_mouvement) = MONTH(CURRENT_DATE()) AND YEAR(date_mouvement) = YEAR(CURRENT_DATE())")->fetchColumn() ?: 0;
    $nb_alert_stock = $pdo->query("SELECT COUNT(*) FROM article WHERE quantite <= 20  AND quantite > 0 AND etat = 'actif'")->fetchColumn() ?: 0;
    
    $alerts = $pdo->query("SELECT a.*, m.nom_magasin FROM article a LEFT JOIN magasin m ON a.id_magasin = m.id_magasin WHERE a.quantite <= 20  AND a.quantite > 0 AND a.etat = 'actif' LIMIT 10")->fetchAll(PDO::FETCH_ASSOC);
    
    $stmt = $pdo->prepare("SELECT h.*, a.nom_article FROM historique_movement h JOIN article a ON h.id_article = a.id_article WHERE h.id_utilisateur = ? ORDER BY h.date_mouvement DESC LIMIT 5");
    $stmt->execute([$id_user]);
    $movements = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e)
 { die("Erreur: " . $e->getMessage()); }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="../css/cards.css">
    <style>
    .admin-header { 
        background: white; 
        padding: 15px 25px; 
        border-radius: 12px; 
        margin-bottom: 25px; 
        border: 2px solid var(--secondary);
        display: flex;
        justify-content: space-between;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.25);
    
    }
 
    .dashboard-container {
        padding: 20px;
    }
    .stat-grid {
        display: flex;
        gap: 20px;
        margin-bottom: 25px;
    }
    .section-container {
        background: white;
        border-radius: 12px;
        padding: 25px;
        margin-bottom: 25px;  
        border: 2px solid var(--secondary);
    }


    .bg-entree { background-color: #f0fff4; color: #22c55e;}
    .bg-sortie { background-color: #fff1f2; color: #ef4444; }
    .bg-transfert { background-color: #eff6ff; color: #3b82f6; 
 }

    </style>
</head>
<body>

<div class="dashboard-container">
    <header class=" admin-header ">
        <div class="d-flex align-items-center gap-3">
            <div class="avatar-circle">
                <i class="bi bi-person-fill"></i>
            </div>
            <div>

                <h6 class="mb-0 fw-bold" style="color: #1b254b;"><?= htmlspecialchars($nom_user . ' ' . $prenom_user) ?></h6>

                <small class="text-muted">Admin Stock</small>
            </div>
        </div>
        <div class="d-flex align-items-center gap-4">
            <div class="position-relative">
                 <a href="notification_admin.php"  style="border:none; background:none; padding:5px;">
                    <i class="bi bi-bell fs-4 text-primary"></i>
                    <?php if($unread_notif > 0): ?>
          
                        <span class="position-absolute  badge rounded-pill bg-danger" style="font-size: 0.6rem;">
                            <?= $unread_notif ?>
                        </span>
                    <?php endif; ?>
                    </a>
            </div>
            <div class="ps-3" style="border-left: 1px solid var(--secondary);">
                <span class="d-block text-muted small"><?= date('d M Y') ?></span>
                <span class="fw-bold text-primary"><?= date('H:i') ?></span>
            </div>
        </div>
    </header>

    <div class="stat-grid">
        <div class="stat-card">
           <h6 class="text-muted small text-uppercase">Articles en Stock</h6>
                <h3 class="fw-bold"><?=$total_art ?></h3>
        </div>
        
        <div class="stat-card">
            <h6 class="text-muted small text-uppercase">Magasins</h6>
            <h3 class="fw-bold "><?= $total_mag ?></h3>
        </div>
        <div class="stat-card">
            <h6 class="text-muted small text-uppercase">Mouvements (Mois)</h6>
            <h3 class="fw-bold "><?= $total_mvt ?></h3>
        </div>
        <div class="stat-card" >
            <h6 class="text-muted small text-uppercase">Alertes Stock</h6>
            <h3 class=" fw-bold"><?= $nb_alert_stock ?></h3>
        </div>
    </div>
    <div class="section-container ">
        <div  class="text-danger">
        <h5> <i class="bi bi-exclamation-triangle"></i> Alertes Stock Faible</h5>
        </div>
        <?php if(!empty($alerts)): ?>
            <?php foreach($alerts as $a): ?>
                <div class="d-flex justify-content-between align-items-center p-2 border-bottom">
                    <div>
                        <div class="fw-bold"><?= htmlspecialchars($a['nom_article']) ?></div>
                        <small class="text-muted"><?= htmlspecialchars($a['nom_magasin'] ) ?></small>
                        
                    </div>
                     <div>
                        <span class="badge bg-light text-danger"><?= $a['quantite'] ?> article</span>
                    </div>
                    

                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-muted small">Aucune alerte pour le moment.</p>
        <?php endif; ?>
    </div>
    <div class="section-container ">
        <div class=" text-primary">
           <h5> <i class="bi bi-clock-history"></i> Mouvements Recents</h5>
        </div>
        <div >
            <table class="table table-hover">
                <thead  class="table-light" >
                    <tr>
                        <th>Article</th>
                        <th>Type</th>
                        <th>Quantité</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($movements as $m): ?>
                     <tr>
    <td><?= htmlspecialchars($m['nom_article']) ?></td>
    <td>
        <?php
        if ($m['type_mouvement'] === 'entree') {
            $badgeClass = 'bg-entree';
        } elseif ($m['type_mouvement'] === 'sortie') {
            $badgeClass = 'bg-sortie';
        } else {
            $badgeClass = 'bg-transfert';
        }
        ?>
        
        <span class="badge <?= $badgeClass ?>">
            <?= htmlspecialchars($m['type_mouvement']) ?>
        </span>
    </td>
    <td class="fw-bold"><?= $m['quantite'] ?></td>
    <td class="text-muted small"><?= date('d/m/Y', strtotime($m['date_mouvement'])) ?></td>
</tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>