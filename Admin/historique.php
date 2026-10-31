///
<?php

require_once '../includes/connexion.php';
require_once '../employe_stock/auth.php';
require_role(["Admin"]);
$sql = "
SELECT 
    h.*,
    a.nom_article,
    u.prenom AS user_prenom,
    u.nom AS user_nom
FROM historique_movement h
LEFT JOIN article a ON h.id_article = a.id_article
LEFT JOIN utilisateur u ON h.id_utilisateur = u.id_utilisateur
ORDER BY h.date_mouvement DESC
";

$stmt = $pdo->query($sql);
$mouvements = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Historique des Mouvements</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="../css/notifications.css">
<style>
    .text-label {
        font-size: 0.65rem;
        font-weight: 800;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 2px;
    }
    .text-value {
        font-weight: 700;
        color: #1e293b;
        font-size: 1.05rem;
    }
    .badge-msg {
    background-color: #eff6ff; 
    color: #3b82f6;           
    padding: 6px 14px;        
    border-radius: 20px;     
    font-weight: 700;
    font-size: 0.8rem;
    display: inline-block;
    line-height: 1;          
    text-align: center;
    border: 1px solid #dbeafe; 
    white-space: nowrap

    }
</style>

<div style="margin-left:100px;margin-right:100px;margin-top:20px">

    <h2 class="mb-4 text-center">
        <i class="bi bi-journal-text me-2"></i>
        Historique des Mouvements
    </h2>
    <?php foreach ($mouvements as $mvt): ?>

        <?php
            $icon  = "bi-plus-lg";
            $label = "ENTREE";
            $color = "bg-msg";

            if ($mvt['type_mouvement'] === 'sortie') {
                $icon  = "bi-dash-lg";
                $label = "SORTIE";
                $color = "bg-stock";
            } elseif ($mvt['type_mouvement'] === 'transfert') {
                $icon  = "bi-arrow-left-right";
                $label = "TRANSFERT";
                $color = "bg-info";
            }
        ?>
        <div class="notif-card"style=" flex-direction: column;">

            <div class="row align-items-center w-100 m-0">

                <div class="col-md-1 p-0 d-flex justify-content-start">

                    <div class="icon-circle <?= $color ?>">
                        <i class="bi <?= $icon ?>"></i>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-label"><?= $label ?></div>
                    <div class="text-value">
                        <?=   htmlspecialchars($mvt['nom_article'])    ?>
                    </div>
                </div>

        
            

                <div class="col-md-3">
                    <div class="text-label">user & DATE</div>
                    <div class="text-value small" style="color: #64748b;">
                        <i class="bi bi-person me-1"></i>
                        <strong><?=  htmlspecialchars($mvt['user_prenom']) ."  " . htmlspecialchars($mvt['user_nom']) ?></strong><br>

                        <span class="text-muted fw-normal" style="font-size: 0.75rem;">

                            <?= date('d/m/Y H:i', strtotime($mvt['date_mouvement'])) ?>
                        </span>
                    </div>
                </div>
                <div class="col-md-2 text-end p-0">
                    <span class="badge-msg">
                        <?= $mvt['quantite'] ?> Unités
                    </span>
                </div>

            </div>
             <?php if (!empty($mvt['commentaire'])): ?>
               <div class="mt-3 p-2 px-3 rounded-2 d-flex align-items-center" 
             style="background-color: #f8fafc; border: 1px solid #f1f5f9; border-left: 4px solid #e2e8f0; width: 100%;">
            <i class="bi bi-chat-left-text me-3 text-muted" style="font-size: 0.9rem;"></i>
            <span style="font-size: 0.85rem; color: #64748b; font-style: italic;">
                "<?= htmlspecialchars($mvt['commentaire']) ?>"
            </span>
        </div>
            <?php endif; ?>

        </div>

    <?php endforeach; ?>

</div>
</body>
</html>

 
      