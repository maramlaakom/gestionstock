
<?php
require_once '../includes/connexion.php';
require_once '../employe_stock/auth.php';
require_role(["Admin"]);
$id_user = $_SESSION['id_utilisateur'];
if (isset($_GET['search'])) {
    $search = $_GET['search'];
} else {
    $search = "";
}
if ($search != "") {
    $query_users = $pdo->prepare("SELECT * FROM utilisateur 
                                   WHERE (nom LIKE ? OR prenom LIKE ? OR email LIKE ?) 
                                   AND etat_compte = 'actif' 
                                   AND id_utilisateur != ?");
    $query_users->execute(["%$search%", "%$search%", "%$search%", $id_user]);
} else {
    $query_users = $pdo->prepare("SELECT * FROM utilisateur WHERE etat_compte = 'actif' AND id_utilisateur != ?");
    $query_users->execute([$id_user]);
}
$chat_users = $query_users->fetchAll();
if (isset($_GET['user_id'])) {
    $selected_user = $_GET['user_id'];
} else {
    $selected_user = null;
}
if ($selected_user) {
    $query_msg = $pdo->prepare("
        SELECT * FROM message 
        WHERE id_utilisateur = ? 
        ORDER BY date_message ASC
    ");
    $query_msg->execute([$selected_user]);
    $messages = $query_msg->fetchAll();
}
if (isset($_POST['repondre']) && !empty(trim($_POST['txt_response']))) {
    $msg = htmlspecialchars($_POST['txt_response']);
    $user_to_reply = $_POST['user_id']; 
    $insert = $pdo->prepare("
        INSERT INTO message (id_utilisateur, contenu, type, date_message) 
        VALUES (?, ?, 'chatbot', NOW())
    ");
    $insert->execute([$user_to_reply, $msg]);

    $notif_content = "L'administrateur vous a envoyé un nouveau message.";
    $insert_notif = $pdo->prepare("
        INSERT INTO notification (id_utilisateur, contenu, etat) 
        VALUES (?, ?, 'non_lu')
    ");
    $insert_notif->execute([$user_to_reply, $notif_content]);
   header("Location: mesangerie.php?user_id=" . $user_to_reply);
    exit();
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messagerie Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../css/base.css"> 
   <link rel="stylesheet" href="../css/messenger.css">
         <link rel="stylesheet" href="../../css/forms.css"> 
</head>
<body class="page-form">
<div class=" page-messanger container ">      
        <div class="messenger-header ">
            <div class="d-flex align-items-center">
                <div class="chat-icon">
                <i class="bi bi-chat-left-dots-fill"></i>
                </div>
                <h5 >Mesangerie Admin</h5>
              
            </div>
            <div>
   <a  class=" badge lien" href="?">refrechi</a>
     <a href="index.php" class=" badge lien">Retour</a>

 
            <span  class=" badge lien">
                <?= count($chat_users) ?> Contacts
            </span>
       
</div>
        </div>
        <div class="d-flex" style="height: 65vh;">
            <div class="user-sidebar border-end">
                <div class="p-3 border-bottom">
          <div class="search-container">
        <form method="GET">
            <div class="input-group">
                <input type="text" name="search" class="form-control p-3" placeholder="Rechercher..." value="<?= htmlspecialchars($search) ?>">
                <button class="btn btn-primary px-4"><i class="bi bi-search"></i></button>
            </div>
        </form>
    </div>
</div>
            
    
                        <a href="?user_id=<//?= $user['id_utilisateur'] ?>"
                
                           class="list-group-item list-group-item-action border-0 py-3 px-4 ">
                              
                    <div class="list-group ">
                    <?php foreach($chat_users as $user): ?>
                        <a href="?user_id=<?= $user['id_utilisateur']  ?>"
                        
                           class="list-group-item border-0 py-3 px-4 <?= ($selected_user == $user['id_utilisateur']) ? 'active-chat' : '' ?>">
                            <div class="d-flex align-items-center">
                                <div class="user-avatar" > <?= strtoupper(substr($user['nom'], 0, 1)) ?>    </div>        
                                <div >
                                    <h6 class="mb-0 fw-bold text-dark "><?= htmlspecialchars($user['nom'] . ' ' . $user['prenom']) ?></h6>
                                    <btr> <?= htmlspecialchars($user['role']) ?><br>
                                    <small class="text-muted">Voir la discussion</small>
                                </div>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
      <section class="chat-area">
                <?php if($selected_user): ?>
                    <div class="chat-messages " id="chatBox" >          
                            <?php foreach($messages as $m): ?>
                                <div class="d-flex <?= ($m['type'] == 'chatbot') ? 'justify-content-end' : 'justify-content-start' ?>">
                                    <div class="bubble <?= ($m['type'] == 'chatbot') ? 'admin-msg' : 'user-msg' ?>">
                                        <?= htmlspecialchars($m['contenu']) ?>
                                        <div class="msg-time"><?= date('H:i', strtotime($m['date_message'])) ?></div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                       
                    </div>
                    
                    <div class="chat-footer p-3  border-top">
                        <form method="POST" class="d-flex gap-2">

                            <input type="hidden" name="user_id" value="<?= $selected_user ?>">
                            <input type="text" name="txt_response"class="form-control rounded-pill border-2 px-4" 
                       placeholder="Écrivez votre message..." required 
                       style="border-color: var(--secondary); height: 45px;">
                            <button type="submit" name="repondre" class="btn-envoye">
                                <i class="bi bi-send-fill"></i>
                            </button>
                        </form>
                    </div>
                <?php else: ?>
                    <div class="empty-chat d-flex flex-column align-items-center justify-content-center h-100 text-center">
                        <div class="icon-circle mb-3 bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                            <i class="bi bi-chat-quote  " style="font-size: 3rem;  color: var( --secondary) ;"></i>
                        </div>
                        <h6 class="text-info fw-semibold">Sélectionnez une discussion pour commencer</h6>
                    </div>
                <?php endif; ?>
            </section>
        </div>
   
</div>
    
<script>
const chat = document.getElementById("chatBox");
    if(chat) 
    { chat.scrollTop = chat.scrollHeight; }
</script>
</body>
</html>