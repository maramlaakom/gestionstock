<?php
require_once '../includes/connexion.php';
require_once "auth.php";
require_role(["employe_stock"]);

/*if (!isset($_SESSION['id_utilisateur'])) {
    header("Location: ../secerity/login.php");
    exit();
}*/
/*
// ... داخل جزء إرسال الرسالة ...
if (isset($_POST['envoyer']) && !empty(trim($_POST['txt_message']))) {
    $msg = htmlspecialchars($_POST['txt_message']);
    // id_utilisateur = 13 (صاحب المحادثة) | id_expediteur = 13 (المرسل)
    $insert = $pdo->prepare("INSERT INTO message (id_utilisateur, id_expediteur, contenu, type) VALUES (?, ?, ?, 'utilisateur')");
    $insert->execute([$id_user, $id_user, $msg]);
    // ... بقية الكود (إرسال التنبيهات للآدمن) كما هو ...
}
*/

$id_user = $_SESSION['id_utilisateur'];
//id_utilisateur ht=ya emta3 employe 
// معالجة إرسال الرسالة
if (isset($_POST['repondre']) && !empty(trim($_POST['txt_message']))) {
    $msg = htmlspecialchars($_POST['txt_message']);
    $insert = $pdo->prepare("INSERT INTO message (id_utilisateur, contenu, type) VALUES (?, ?, 'utilisateur')");
    $insert->execute([$id_user, $msg]);

    $stmtAdmin = $pdo->query("SELECT id_utilisateur FROM utilisateur WHERE role = 'Admin'");
    $admins = $stmtAdmin->fetchAll();

    if ($admins) {
       if (isset($_SESSION['nom'])) {
         $nom_sender = $_SESSION['nom'];
        } else {
        $nom_sender = '';
        }     
        $notif_txt = "Nouveau message de " . $nom_sender;
        // ha4i etjib eli 3anthoum  role admin elkol ou etour 3alihoum elkol bech taba34enhoum no
        //notification admin elkol touslelhoum notification nafes contenu ama mich nafes id_notification
        //enti prepar(ma3naha et7a4er estar ek=li bech etzitou ou ba3et fi execute et3awe4 ? bi 9yam emta7a ) notification   mara wa7ta ama exexute ma3naha etakhalha lel bd 3ala 3ated admin haK 3alah id emta3 n
        //notification kol mara tetebatel 3alakhater kol ma EXECUTE etsir execute bi id moukhtalfa
        $insNotif = $pdo->prepare("INSERT INTO notification (id_utilisateur, contenu, etat) VALUES (?, ?, 'non_lu')");
        foreach ($admins as $admin) {
            $insNotif->execute([$admin['id_utilisateur'], $notif_txt]);
        }
    }
    //bech kol mateb3e4 msg e
    //header("Location: mesangerie.php"); 
    //exit();
}

$query = $pdo->prepare("SELECT * FROM message WHERE id_utilisateur = ? ORDER BY date_message ASC");
$query->execute([$id_user]);
$messages = $query->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Messagerie - StockSys</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <link rel="stylesheet" href="../css/base.css"> 
    <link rel="stylesheet" href="../css/messenger.css">

    <style>
      
    </style>
</head>

<body class="page-form">

<div class="container py-4">  
<!--gap-3-->
    <div class="page-messanger " style="max-width: 850px; ">
        
        <div class="messenger-header">
           
                <div class="d-flex align-items-center ">
                    <div class="chat-icon">
                        <i class="bi bi-chat-left-dots-fill "></i>
                    </div>
                    <div>
                            <h5>contact avec  Admin</h5>
                           <small class="text-muted small">Chat en direct</small>
                    </div>
                </div>
                
              
                    <div>
                <!-- border: ha4a eli ya3mel cadre eteiri /border-primary-subtle: hya bech etbatel cadre azre9 / rounded-pill bech ta3tih fourmet toura -->
 <a class="badge  lien" href="?">refrechi</a>

  <a href="index.php" class=" badge lien">Retour</a>
 
           
       
</div>
        
            
        </div>
<!-- ha4a chatbox  eli you4eshrou fih messaget elkol -->

          <section class="chat-area">
          <div class="chat-messages " id="chatBox" style="height:480px" > 
           
                <?php foreach($messages as $m): ?>
                    <div class="d-flex <?= ($m['type'] == 'utilisateur') ? 'justify-content-end' : 'justify-content-start' ?>">
                        <div class="bubble <?= ($m['type'] == 'utilisateur') ? 'admin-msg' : 'user-msg' ?>">
                            <div class="msg-content"><?= htmlspecialchars($m['contenu']) ?></div>
                            <div class="msg-time"><?= date('H:i', strtotime($m['date_message'])) ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>
                </div>
            
        

        <div class="card-footer bg-white p-3 border-top">
            <form method="POST" class="d-flex gap-2 align-items-center">
                <input type="text" name="txt_message" class="form-control rounded-pill border-2 px-4 " 
                       placeholder="Écrivez votre message..." required 
                       style="border-color: var(--secondary); height: 45px;">
                   <button type="submit" name="repondre" class="btn-envoye">
                                <i class="bi bi-send-fill"></i>
                            </button>
            </form>
        </div>
                </section>
    </div>
</div>

<script>
    //bech etjib div eli fih  id = chatbox
    var objDiv = document.getElementById("chatBox");
    if(objDiv) objDiv.scrollTop = objDiv.scrollHeight;
</script>

</body>
</html>