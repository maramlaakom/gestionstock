<?php
require_once '../includes/connexion.php';
require_once "auth.php"; 
require_role([ "employe_stock"]);

$id_user = $_SESSION['id_utilisateur'];
$nom_user = $_SESSION['nom'] ;
$prenom_user = $_SESSION['prenom'];

try {
    $total_art = $pdo->query("SELECT SUM(quantite) FROM article WHERE etat = 'actif'")->fetchColumn() ?: 0;
    $unread_notif = $pdo->query("SELECT COUNT(*) FROM notification WHERE id_utilisateur = $id_user AND etat = 'non_lu'")->fetchColumn() ?: 0;
        $total_mvt = $pdo->query("SELECT COUNT(*) FROM historique_movement WHERE id_utilisateur = $id_user AND  MONTH(date_mouvement) = MONTH(CURRENT_DATE()) AND YEAR(date_mouvement) = YEAR(CURRENT_DATE())")->fetchColumn() ?: 0;
         $total_mag = $pdo->query("SELECT COUNT(*) FROM magasin")->fetchColumn() ?: 0;
    $total_demandes = $pdo->query("SELECT COUNT(*) FROM demande_contact WHERE id_utilisateur = $id_user")->fetchColumn() ?: 0;
    $stmt = $pdo->prepare("SELECT h.*, a.nom_article FROM historique_movement h JOIN article a ON h.id_article = a.id_article WHERE h.id_utilisateur = ? ORDER BY h.date_mouvement DESC LIMIT 20");
    $stmt->execute([$id_user]);
    
    $movements = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) 
{ die("Erreur : " . $e->getMessage()); }




?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
   
 <link rel="stylesheet" href="../css/base.css">
<link rel="stylesheet" href="../css/cards.css">
<link rel="stylesheet" href="../css/tables.css">

  <style>
   .dashboard-container {
        padding: 20px;

    }


   .employee-header{
        background: white;
        padding: 15px 25px;
        border-radius: 12px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        border: 2px solid var(--secondary);
        width: 100%;
        box-sizing: border-box;
        box-shadow: 0 4px 15px rgba(135, 206, 235, 0.1);
    }
     .stat-grid {
        gap: 20px;
        margin-bottom: 25px;
        display: flex;
    }
    .stat-card {
        width: 100% !important;
        margin: 0 !important;
        display: flex;
        flex-direction: column;
        justify-content: center;
        min-height: 120px;
    }
    .content-section {
        background: white;
        border-radius: 12px;
        padding: 25px;
        margin-bottom: 25px;
        border: 2px solid var(--secondary);
    }
      .bg-entree { background-color: #f0fff4; color: #22c55e; }
    .bg-sortie { background-color: #fff1f2; color: #ef4444; }
    .bg-transfert { background-color: #eff6ff; color: #3b82f6; }
</style>

<body>
    <div class="dashboard-container">
    <header class="employee-header">
    <div class="d-flex align-items-center gap-3"> 
        <div class="avatar-circle">
            <i class="bi bi-person-fill"></i>
        </div>
        <div>
            <h6 class="mb-0 fw-bold" style="color: #1b254b;"><?= htmlspecialchars($nom_user) , htmlspecialchars($prenom_user) ?></h6>
            <small class="text-muted">Employé</small>
        </div>
    </div>

    <div class="d-flex align-items-center gap-4">
          <div class="position-relative">
                 <a href="notification.php"  style="border:none; background:none; padding:5px;">
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
                <h3 class="fw-bold "><?=$total_art ?></h3>

            </div>
             <div class="stat-card">
                <h6 class="text-muted small text-uppercaset">nb magasin</h6>
                <h3 class="fw-bold "><?= $total_mag ?></h3>
            </div>
            <div class="stat-card">
                <h6 class="text-muted small text-uppercase">mouvement (mois)</h6>
                <h3 class="fw-bold  "><?= $total_mvt  ?></h3>
            </div>
            <div class="stat-card">
                <h6 class="text-muted small text-uppercaset">Demandes Envoyées</h6>
                <h3 class="fw-bold  "><?= $total_demandes ?></h3>
            </div>
             
        </div>

        <div class="content-section">
             <div class=" text-primary">
          <h5>    <i class="bi bi-clock-history"></i> Mouvements Récents </h5>
        </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ARTICLE</th>
                            <th >TYPE</th>
                            <th>QUANTITÉ</th>
                            <th>DATE</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($movements as $m): ?>
                        <tr>
                            <td class="fw-bold py-3 text-dark"><?= htmlspecialchars($m['nom_article']) ?></td>
                            <td>
                                    <?php
                                if ($m['type_mouvement'] === 'entree') {
                                        $badgeClass = 'bg-entree';
                                } elseif ($m['type_mouvement'] === 'sortie')  {
                                 $badgeClass = 'bg-sortie';
                                    }else{ 
                                          $badgeClass = 'bg-transfert';

                                    }
                                    ?>
                                    
  

                               <span class="badge <?= $badgeClass ?>">
                                     <?= htmlspecialchars($m['type_mouvement'] )?>
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
