<?php


require_once '../includes/connexion.php';
require_once '../employe_stock/auth.php';
require_role(["Admin"]);

// utilisateur connecte (Admin par exemple)
$id_user_admin = $_SESSION['id_utilisateur'] ;

$msg = "";

// ken form teb3a4 bi accepter
if (isset($_POST['accepter'])) {
    $id_demande = $_POST['id_demande'];
    $id_user_target = $_POST['id_user'];

    $stmt_upd = $pdo->prepare("UPDATE demande_contact SET statut = 'approuvee' WHERE id_demande = ?");
    $stmt_upd->execute([$id_demande]);

    $msg_accepte = "OK_DEMANDE_" . $id_demande;
    $stmt_notif = $pdo->prepare("INSERT INTO notification (id_utilisateur, contenu, date_notification) VALUES (?, ?, NOW())");
    
    if ($stmt_notif->execute([$id_user_target, $msg_accepte])) {
        $msg = "<div class='alert alert-success'>Demande autorisée avec succès !</div>";
    }
}

// Refuse Logic
if (isset($_POST['refuser'])) {

    $id_demande     = $_POST['id_demande'];
    $id_user_target = $_POST['id_user'];

    // تحديث حالة الطلب
    $stmt_upd = $pdo->prepare(
        "UPDATE demande_contact 
         SET statut = 'refusee' 
         WHERE id_demande = ?"
    );
    $stmt_upd->execute([$id_demande]);

    // إنشاء الإشعار
    $msg_refus = "REFUS_DEMANDE_" . $id_demande;

    $stmt_notif = $pdo->prepare(
        "INSERT INTO notification (id_utilisateur, contenu, date_notification) 
         VALUES (?, ?, NOW())"
    );

    if ($stmt_notif->execute([$id_user_target, $msg_refus])) {
        $msg = "<div class='alert alert-danger'>Demande refusée.</div>";
    }
}


// eijb demande en attent elkol em3a esem user eli eb3a4ha 
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
        
     /*   body {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 0;
            min-height: 100vh;
        }*/
    </style>
</head>
<body >

<div  style= "  padding: 30px;">
    <h2  class="text-center" >
<!--me (bootstrap : margin end 3ala lymin eykhali espace 2 rem)-->
<!-- me-2 (Bootstrap) = margin-end → يعطي espace صغير على اليمين بعد الأيقونة -->
        <span><i class="bi bi-shield-lock-fill  "></i> Autorisations</span>
<!--badge hya ta3mel ki cadre eli yet7at fih klam /primary hya bech ta3ti loul bdge loul azre9 /  fs-6 bech etsakher fi taille emta3 klam (ha4ouma bootstrap) badge eikoun koubrou ou toulou  3ala 7aseb leklam ken etfasekh leklam tetfasekh
style="color:blue ;background:blue; etnajem etbatlha beha ama bi bootstrap a7la  -->
        <span class="badge bg-primary fs-6"  ><?= count($demandes) ?> en attente</span>
    </h2>

    <?= $msg ?>

<!-- table-resposive : howa bootstrap bech eikhali tableau you4her 3al 7aseb ecrant bech ki yet7al fi telephone you93et emna4em scrall oufou9i ki ecran youskher eiwali 
 you4her bi toul ki ecran youSkher cech maioutkhelech ba34ou michal kiet7elou bi telephone
 table howa class Bootstrap ya3mel style 7a4er lel tableau padding داخل الخاناتborders منظمينtable مرتبة و نظيفة font و spacing باهي makher mateset7a9 tekteb css 
 align-middle haki tekhtem hosizental etkhali contenu eli fi td ou th yetekteb fi wouset la fou9 la elouta -->
    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th >Employé</th>
                    <th >Détails de l'opération</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- bech no93et elmour 3ala demandes elkol eli en attende -->
                <?php foreach($demandes as $d): ?>
                <tr >
                    <td>
                        <div class="fw-bold text-dark"><?= htmlspecialchars($d['nom']) ?></div>
                        <small class="text-muted"><i class="bi bi-clock me-1"></i><?= date('d/m/Y H:i', strtotime($d['date_demande'])) ?></small>
                    </td>
                <!-- takhou ken 40% m'en 3oure4 colone 2 -->
                    <td style="width: 40%;">
    <span class="badge-msg">
        <i class="bi bi-info-circle me-1"></i> 
        <?= str_replace('|', '<br>', htmlspecialchars($d['message'])) ?>
    </span>
</td>

                    <td class="text-center">
                <!-- d-inline-flex :bech eikhali  you4ehrou faret estar el3anaser ou
                 maiehebtouch kol wa7et fi estar /gap-2 espace b'en el3anaser '(deux button)-->
                        <form method="POST">
                             <!--ha4ouma champ maie4ahrouch bech ki tenzel 3al button yeteb3a4 em3ahoum id_demande eli 
                             eli enzelet button emta7a ou id_utilisateur emta3 demande -->
                            <input type="hidden" name="id_demande" value="<?= $d['id_demande'] ?>">
                            <input type="hidden" name="id_user" value="<?= $d['id_utilisateur'] ?>">
                <!-- btn-sm howa eisakher fi btn'(howa bootstrap)-->
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
                <!-- colspan="3" (html ha4i)ha4I bech kiabta mafamech demande tou4her fi colone -->
                    <td colspan="3">
                        <div class="no-results">
                            <i class="bi bi-check2-all" style="font-size: 2rem;" ></i>
                            <!-- class="m-0" margin =0-->
                            <p >Tout est traité !  Aucune demande en attente.</p>
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