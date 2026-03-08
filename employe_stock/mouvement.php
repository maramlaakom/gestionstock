<?php
require_once '../includes/connexion.php';
require_once "auth.php";
require_role([ "employe_stock"]);
$id_user = $_SESSION['id_utilisateur'];
$stmt_hist = $pdo->prepare("SELECT * FROM demande_contact WHERE id_utilisateur = ? ORDER BY date_demande DESC");
$stmt_hist->execute([$id_user]);
$dem = $stmt_hist->fetchAll(); 

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mouvements - Gestion Stock</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="../css/tables.css">
 </head>
<body >
    <div style=" padding: 30px;">
        
        <h2 class="text-center">
            <i class="bi bi-card-checklist me-2"></i>État de vos demandes
        </h2>
        <a href="?" 
           class="bouton text-right">
              <i class="bi bi-arrow-clockwise"></i>
        </a>
            <div class="table-responsive">
                <table class="table align-middle ">
                    <thead>
                        <tr>
                            <th>Détails de l'opération</th>
                            <th>Statut</th>
                            <th c>Action</th>
                        </tr>
                    </thead>
                <tbody>
    <?php if (empty($dem)): ?>
        <tr>
            <td colspan="3" class="text-center py-5">
                <div class="no-results">
                    <i class="bi bi-inbox d-block mb-2"style="font-size: 2rem;" ></i>
                    <p> Aucune demande trouvée.</p>
                </div>
            </td>
        </tr>
    <?php else: ?>
        <?php foreach($dem as $h): ?>
        <tr > 
            <td >
                <div class="fw-bold mb-1 small text-uppercase">
                    <?= htmlspecialchars($h['message']) ?>
                </div>
                <div class=" small">
                    <i class="bi bi-calendar3 me-1"></i> 
                    <?= date('d M Y, H:i', strtotime($h['date_demande'])) ?>
                </div>
            </td>
            <td>
                <?php if($h['statut'] === 'en_attente'): ?>
                    <span class="badge rounded-pill stock-high px-3 py-2" style="background: #a1edf2; color: #000;">En attente</span>
                <?php elseif($h['statut'] === 'approuvee'): ?>
                    <span class="badge rounded-pill" style="background: #85f197; color: #000;">Approuvée</span>
                <?php elseif($h['statut'] === 'executed'): ?>
                    <span class="badge rounded-pill" style="background: #d1d1d1; color: #555;">Terminé</span>
                <?php else: ?>
                    <span class="badge rounded-pill  px-3 py-1" style="background: #ffb0b0; color: #000;">Refusée</span>
                <?php endif; ?>
            </td>
         <td class="text-center">
    <?php if ($h['statut'] === 'approuvee'): ?>

        <?php if (stripos($h['message'], 'transfert') !== false): ?>
            <a href="../Admin/gestionmouvement/transfere.php?id=<?= $h['id_demande'] ?>" 
               class="btn btn-accept btn-sm px-3 ">
                Transfert <i class="bi bi-arrow-right-short"></i>
            </a>
        <?php else: ?>
            <a href="../Admin/gestionmouvement/sortiestock.php?id=<?= $h['id_demande'] ?>" 
               class="btn btn-sm px-4 "style="background-color: var(--success) ;color:white ">
                Sortie <i class="bi bi-box-arrow-up"></i>
            </a>
        <?php endif; ?>

    <?php elseif ($h['statut'] === 'executed'): ?>
        <i class="bi bi-check-circle-fill text-muted  fs-5"></i>
    <?php else: ?>
        <i class="bi bi-lock-fill  opacity-50 fs-5 "></i>

    <?php endif; ?>
</td>

        </tr>
        <?php endforeach; ?>
    <?php endif; ?>
</tbody>
                </table>
            </div>
    </div>

</body>
</html>