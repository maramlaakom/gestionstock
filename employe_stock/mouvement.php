<?php
// session_start();
require_once '../includes/connexion.php';
require_once "auth.php";
require_role([ "employe_stock"]);
//ha4i ken session mafihach   id_utilisateur ma3naha takhel bi lien eihezou zla  interface emta3 login
/*if (!isset($_SESSION['id_utilisateur'])) { 
    header("Location: ../login.php"); 
    exit(); 
}*/

$id_user = $_SESSION['id_utilisateur'];



// 2. enjib des demandes  emta3 contact eli eb3a4houm utilisateu eli takheklel tawa 
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
    <!-- margin-left: 0;-->

    <div style=" padding: 30px;">
        
        <h2 class="text-center">
            <i class="bi bi-card-checklist me-2"></i>État de vos demandes
        </h2>
        <a href="?" 
           class="bouton text-right">
              <i class="bi bi-arrow-clockwise"></i>
        </a>

       <!-- <div class=" shadow-sm border-0">-->
            <div class="table-responsive">
<!--mb-0 margin botton-->
                <table class="table align-middle ">
                    <thead>
                        <tr>
<!--ps padding start ma3naha m'en l'eysar b'en kelma ou bord emta3 tableu  -->
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
    <!--d-block (bootstrao) en css display:block hya  bech etkhali <i>icon tother fi star wa7atha ou jomla fi star -->
                    <i class="bi bi-inbox d-block mb-2"style="font-size: 2rem;" ></i>
                    <p> Aucune demande trouvée.</p>
                </div>
            </td>
        </tr>
    <?php else: ?>
        <?php foreach($dem as $h): ?>
        <tr > 
            <td >
                <!-- fw-bold :eikhale4 fi l'ektiba -->
                <div class="fw-bold mb-1 small text-uppercase">
                    <?= htmlspecialchars($h['message']) ?>
                </div>
        <!-- text-muted :eifate7 fi l'ektiba bech etwali gris-->
                <div class=" small">
                    <i class="bi bi-calendar3 me-1"></i> 
                    <?= date('d M Y, H:i', strtotime($h['date_demande'])) ?>
                </div>
            </td>
            <td>
        <!-- rounded-pill : ta3ti arken moustatira -->
                <?php if($h['statut'] === 'en_attente'): ?>
                    <span class="badge rounded-pill stock-high px-3 py-2" style="background: #a1edf2; color: #000;">En attente</span>
                <?php elseif($h['statut'] === 'approuvee'): ?>
                    <span class="badge rounded-pill" style="background: #85f197; color: #000;">Approuvée</span>
                <?php elseif($h['statut'] === 'executed'): ?>
                    <span class="badge rounded-pill" style="background: #d1d1d1; color: #555;">Terminé</span>
                <?php else: ?>
                <!--stock-low/ px-3 py-2 padding -->
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
            <!--"background-color: var(--success) !important; border:none; 
             btn-sm : bech eisakher fi button(bootstrape)/ btn-succes fi bootstrape ya3ti loul ak4er l'el button /btn ya3ti forme buttton  
             px-3 padding oufou9i m'en fou9 ou louta/ shadow-sm-->
            <a href="../Admin/gestionmouvement/sortiestock.php?id=<?= $h['id_demande'] ?>" 
               class="btn btn-sm px-4 "style="background-color: var(--success) ;color:white ">
                Sortie <i class="bi bi-box-arrow-up"></i>
            </a>
        <?php endif; ?>

    <?php elseif ($h['statut'] === 'executed'): ?>
     <!--  text-muted :eifate7 fi loun icon eiroutou gris/fs-5 :  font-size  =5rem -->
        <i class="bi bi-check-circle-fill text-muted  fs-5"></i>
    <?php else: ?>
    <!-- opacity-50 bech eifate7fi icon -->
        <i class="bi bi-lock-fill  opacity-50 fs-5 "></i>

    <?php endif; ?>
</td>

        </tr>
        <?php endforeach; ?>
    <?php endif; ?>
</tbody>
                </table>
            </div>
        <!--</div>-->
    </div>

</body>
</html>