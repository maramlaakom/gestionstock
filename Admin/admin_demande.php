<?php


require_once '../includes/connexion.php';
require_once '../employe_stock/auth.php';
require_role(["Admin"]);
$id_user_admin = $_SESSION['id_utilisateur'] ;

$msg = "";
if (isset($_POST['accepter'])) {
    $id_demande = $_POST['id_demande'];
    $id_user_target = $_POST['id_user'];

    $stmt_upd = $pdo->prepare("UPDATE demande_contact SET statut = 'approuvee' WHERE id_demande = ?");
    $stmt_upd->execute([$id_demande]);

    $msg_accepte = "OK_DEMANDE_" . $id_demande;
    $stmt_notif = $pdo->prepare("INSERT INTO notification (contenu, date_notification) VALUES (?, NOW())");
    if ($stmt_notif->execute([$msg_accepte])) {
        $id_notification = $pdo->lastInsertId();
        $notif_user= $pdo->prepare("INSERT INTO notification_utilisateur (id_notification, id_utilisateur) VALUES (?, ?)");
        $notif_user->execute([$id_notification, $id_user_target]);
        $msg = "<div  class='alert alert-success '>Demande accepter.</div>";
    }
}
if (isset($_POST['refuser'])) {

    $id_demande     = $_POST['id_demande'];
    $id_user_target = $_POST['id_user'];
    $stmt_upd = $pdo->prepare("UPDATE demande_contact SET statut = 'refusee' WHERE id_demande = ?");
    $stmt_upd->execute([$id_demande]);
    $msg_refus = "REFUS_DEMANDE_" . $id_demande;
    $stmt_notif = $pdo->prepare("INSERT INTO notification (contenu, date_notification) VALUES (?, NOW())");
    if ($stmt_notif->execute([$msg_refus])) {
        $id_notification = $pdo->lastInsertId();
        $notif_user= $pdo->prepare("INSERT INTO notification_utilisateur (id_notification, id_utilisateur) VALUES (?, ?)");
        $notif_user->execute([$id_notification, $id_user_target]);
        $msg = "<div class='alert alert-danger'>Demande refusee.</div>";
    }
}
$sql = "SELECT d.*, u.nom FROM demande_contact d 
        JOIN utilisateur u ON d.id_utilisateur = u.id_utilisateur 
        WHERE d.statut = 'en_attente' 
        ORDER BY d.date_demande DESC";
$demandes = $pdo->query($sql)->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration - Autorisations</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <link rel="stylesheet" href="../css/base.css">   
     <link rel="stylesheet" href="../css/tables.css">  <style>
       
        .container-custom {
            background-color: white;
            border-radius: 12px;
            padding: 35px;
            box-shadow: 0 10px 30px rgba(135, 206, 235, 0.3);
            max-width: 900px;
            width: 95%;
            margin: auto;
        }
        
    </style>
</head>
<body >

<div  style= "  padding: 30px;">
    <h2  class="text-center" >
        <span><i class="bi bi-shield-lock-fill  "></i> Autorisations</span>
        <span class="badge bg-primary fs-6"  ><?= count($demandes) ?> en attente</span>
    </h2>

    <?= $msg ?>
    <div >
        <table class="table align-middle">
            <thead>
                <tr>
                    <th >Employe</th>
                    <th >Détails de l'operation</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($demandes as $d): ?>
                <tr >
                    <td>
                        <div class="fw-bold text-dark"><?= htmlspecialchars($d['nom']) ?></div>
                        <small class="text-muted"><i class="bi bi-clock me-1"></i><?= date('d/m/Y H:i', strtotime($d['date_demande'])) ?></small>
                    </td>
                    <td style="width: 40%;">
    <span class="badge-msg">
        <i class="bi bi-info-circle me-1"></i> 
        <?= str_replace('|', '<br>', htmlspecialchars($d['message'])) ?>
    </span>
</td>

                    <td class="text-center">
                        <form method="POST">
                            <input type="hidden" name="id_demande" value="<?= $d['id_demande'] ?>">
                            <input type="hidden" name="id_user" value="<?= $d['id_utilisateur'] ?>">
                            <button type="submit" name="accepter" class="btn btn-accept btn-sm">
                                <i class="bi bi-check-lg"></i> Autoriser
                            </button> 
                            <button type="submit" name="refuser" class="btn btn-reject btn-sm">
                                <i class="bi bi-x-lg"></i> Refuser
                            </button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>

                <?php if(empty($demandes)): ?>
                <tr>
                    <td colspan="3">
                        <div class="no-results">
                            <i class="bi bi-check2-all" style="font-size: 2rem;" ></i>
                            <p >Tout est traite !  Aucune demande en attente.</p>
                        </div>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>