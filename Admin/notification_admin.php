<?php
require_once '../includes/connexion.php';
require_once '../employe_stock/auth.php';
require_role(["Admin"]);
$id_user = $_SESSION['id_utilisateur'];
try {
    $stmt = $pdo->prepare("
        SELECT * 
        FROM notification 
        WHERE id_utilisateur = ? 
        ORDER BY date_notification DESC 
        LIMIT 30
    ");
    $stmt->execute([$id_user]);
    $notifs = $stmt->fetchAll();
    $update = $pdo->prepare("
        UPDATE notification 
        SET etat = 'lu' 
        WHERE id_utilisateur = ? 
        AND etat = 'non_lu'
    ");
    $update->execute([$id_user]);

} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Notifications</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="../css/notifications.css">
</head>

<body>

<div class=" main-container">
     <div class="header">
    
    <div> 
        <h2>Notifications</h2>
        <p class="text-muted small">Gérez les alertes de stock et les messages reçus.</p>
    </div>
      <div class="row">
    <div class="d-flex gap-2 align-items-center">
        <a href="index.php" 
           class="bouton">
            <i class="bi bi-arrow-left me-1"></i> retour
        </a>

        <a href="?" 
           class="bouton">
              <i class="bi bi-arrow-clockwise"></i>
        </a>
    </div>
</div>
</div>
    <div  style="margin-top: 0;  "></div>
    <?php if (empty($notifs)): ?>
     <div class="no-notif">
            <i class="bi bi-bell-slash ;"></i>
            <h5 class="text-muted">Aucune notification pour le moment.</h5>
        </div>
    <?php else: ?>
        <div>

            <?php foreach ($notifs as $n):
                $is_stock = (stripos($n['contenu'], 'stock') !== false || stripos($n['contenu'], 'épuisé') !== false);
               $is_msg   =  stripos($n['contenu'], 'message') !== false;
                if ($n['etat'] === 'non_lu') {
                        $card_class = 'notif-no-lu';
                    } else {
                        $card_class = 'notif-card';
                    }

                if ($is_stock) {
                    $icon = "bi-exclamation-triangle-fill";
                    $bg   = "bg-stock";
                    $label = "Alerte Stock";
                }             
                elseif ($is_msg) {
                    $icon = "bi-envelope-paper-fill";
                    $bg   = "bg-msg";
                    $label = "Nouveau Message";
                } else {
                    $icon = "bi-info-circle-fill";
                    $bg   = "bg-info";
                    $label = "Information";
                }
            ?>
        <div class="<?= $card_class ?>">
                    <div class="icon-circle <?= $bg ?>">
                        <i class="bi <?= $icon ?>"></i>
                    </div>

                    <div class="notif-content ">
                        <div>
                            <h6 ><?= $label ?></h6>
                            <?php if ($n['etat'] === 'non_lu'): ?>
                                <span class="badge bg-primary rounded-pill" style="font-size: 0.6rem;">NOUVEAU</span>
                            <?php endif; ?>
                        </div>

                        <p > <?= htmlspecialchars($n['contenu']); ?></p>

                        <div class="notif-time">
                            <i class="bi bi-clock me-1"></i>
                            <?= date('d M Y à H:i', strtotime($n['date_notification'])); ?>
                        </div>
                    </div>
                </div>

            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</div>
</body>
</html>
