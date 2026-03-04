<?php
// ... نفس الكود البرمجي (session, queries) اللي عندك في الأعلى ...
?>
<?php
require_once '../includes/connexion.php';
require_once '../employe_stock/auth.php';
require_role(["Admin"]);
// التأكد من تسجيل الدخول
$id_user = $_SESSION['id_utilisateur'];
// نجيبوا كلمة البحث من الفورم (إذا الأدمن كتب حاجة)
if (isset($_GET['search'])) {
    $search = $_GET['search'];
} else {
    $search = "";
}
if ($search != "") {
    // نلوجوا بالاسم أو اللقب ونثبتوا أن الحساب actif وننحيوا الأدمن الحالي
    $query_users = $pdo->prepare("SELECT * FROM utilisateur 
                                   WHERE (nom LIKE ? OR prenom LIKE ? OR email LIKE ?) 
                                   AND etat_compte = 'actif' 
                                   AND id_utilisateur != ?");
    $query_users->execute(["%$search%", "%$search%", "%$search%", $id_user]);
} else {
    // إذا ما ثماش بحث، نجيبوا الناس الكل (actifs) ما عدا الأدمن الحالي
    $query_users = $pdo->prepare("SELECT * FROM utilisateur WHERE etat_compte = 'actif' AND id_utilisateur != ?");
    $query_users->execute([$id_user]);
}
// التعديل هنا: استعملي نفس اسم المتغير اللي الفوق
//$chat_users = $query_users->fetchAll(PDO::FETCH_ASSOC);
$chat_users = $query_users->fetchAll();
//ki yakhter admin  employee eli bech ya7ki em3ah nakhthou id emta3ou ki telzel 3ala  esmou 
// employe enou howa lien ya3mel reflechi l'elpage nafesha ou yab3e4 id emta3 employee eli ekhtaertha ou
// ou id eli yaba3thou lien yet7at fi get ba    3et ken ket feha 7aja ma3naha enzelet 3ala employe 
// etwali id emta3 employe haka yet7at fi selector_user
//ki telzel 3alapage ya3mel refrechi ou ki ya3mel refrechi msg tou4ehrou 
if (isset($_GET['user_id'])) {
    $selected_user = $_GET['user_id'];
} else {
    // ki maie7ki em3a 7at 
    $selected_user = null;
}
//etjib msg emta3 user eli ekhtarou admin
//$messages = []; 
//ken selecto_user mahich farkha etjib message emta3ou ta3erfou eli message marbout em3a id emta3 employe
if ($selected_user) {
    $query_msg = $pdo->prepare("
        SELECT * FROM message 
        WHERE id_utilisateur = ? 
        ORDER BY date_message ASC
    ");
    $query_msg->execute([$selected_user]);
    $messages = $query_msg->fetchAll();
}
//ma3naha meloul ei4ebet enou admin enzel 3ala button envoyer ou enou ekteb 7aja fi cham  txt_reponse 
if (isset($_POST['repondre']) && !empty(trim($_POST['txt_response']))) {
    $msg = htmlspecialchars($_POST['txt_response']);
    $user_to_reply = $_POST['user_id']; 
    
    /*// ... داخل جزء رد الأدمن ...
if (isset($_POST['repondre']) && !empty(trim($_POST['txt_response']))) {
    $msg = htmlspecialchars($_POST['txt_response']);
    $user_to_reply = $_POST['user_id']; // الموظف المستهدف
    $admin_id = $_SESSION['id_utilisateur']; // الأدمن الحالي

    // id_utilisateur = الموظف | id_expediteur = الأدمن
    $insert = $pdo->prepare("INSERT INTO message (id_utilisateur, id_expediteur, contenu, type, date_message) VALUES (?, ?, ?, 'chatbot', NOW())");
    $insert->execute([$user_to_reply, $admin_id, $msg]);
    // ... التنبيهات ...
}*/
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
    //ba3et mateb3eth el msg mateset7a9ech enekta3mel reflechi bech to4herlek header et3awet 
    //etakhlek l'el em3ah id user eli eb3a4etnou  bech eihezek l'el fenetre emta3 user eli eba4ethounou
    //?user_id.user_reply_id bech ki  yeteb3a4 "ou  ki ei3awet youtkhel l'elpage bi header you93et fi nafes espace  messageet emta3 eli ya7ki 3alih 
    //ou  awel maieb3e4 msg  get takhou id  m'en lien emta3  header ou et3awet affiche msget eli tab3il id 
   header("Location: mesangerie.php?user_id=" . $user_to_reply);
    exit();
}
// LIEN <a> hya testa3malha bach totkhel akhaw etra discution ou bech takhtar echkoun et7eb ta7ki em3ah
// ou input type hydden hya wa9et C4EST bon ekhtaret  em3a echkoun bech ta7ki ou bech tab3a4lou msg 
//ki  tab3eth msg id employe eli bech tab3a4lou yeteb3a4 fi post bech ta3ref ki etji et9aitou fi tableau msg yet9aid id_utilisateur em3a msg eli eb3a4tou becba3et etnajem etjib msg eli tab3in 
//employe_eli e7ket em3ah 
/** alien <a > hpwa yekhtem em3a get ou khetemtou hya eibatelek ben p disction ou eiwarik disction emta3 employee 
 * eli ekhtartou kol matenzel 3ala employe akher eisir reflechi ou selected tebetel l'el employe eli ekhtartou ejtit
 *  ou wa9etha php et3awet tekhtem select message  et3awet tekhtem menoun ou tjib message emta3 employe ejtid 
 * input hidden hya mouhema fi envoye msg  hya tekhtem em3a post  wa9et teKteb msg ou tenzel 3ala envoye php ye7tej ya3ref msg lechkoun
 * bech yeteb3a4 LANA FI INSERT MESSAGE EINAWAJ 3ala id_utilisateur eli bech yeteb3a4lou msg ou input hidden hya eli ta3ref beha lechkoun
 * bech yetab3ath msg makherha matnejemech ta3ref howa einajem ya3erfou m'en lien ama ki testa3mel input hidden akther secerit 3alakhater 
 * id maiOU4herech fi url lanou einajem ki testa3mel <a>n einajem yetbetel id howa lien< a> etnajem testa3melha tekhtem ama  input akther secerite
 * 
 *  */
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
<!--container howa 3onser bootstrap ei7atet 3our4 page ou paddineg emta7a-->
   
<div class=" page-messanger container ">      
        <div class="messenger-header ">
<!-- align-items-center bech et7outhoum fi wouset "/"d-flex bech eina4em icon ou h5 bejnab eb3a4houm  -->
            <div class="d-flex align-items-center">
                <div class="chat-icon">
                <i class="bi bi-chat-left-dots-fill"></i>
                </div>
                <h5 >Mesangerie Admin</h5>
              
            </div>
<!--div eloula eli feha i ou h5 tet7at 3ala leymin ou div ethanya eli feha 2 span tet7at 3ala leysar -->
            <div>
                <!-- border: ha4a eli ya3mel cadre eteiri /border-primary-subtle: hya bech etbatel cadre azre9 / rounded-pill bech ta3tih fourmet toura -->

   <a  class=" badge lien" href="?">refrechi</a>
     <a href="index.php" class=" badge lien">Retour</a>

 
            <span  class=" badge lien">
                <?= count($chat_users) ?> Contacts
            </span>
       
</div>
        </div>
<!--ha4i  emta3 eli feha block elkol ma3naha elpartie ha4i "height: 65vh; kouberha 65vh ou esta3mal d-flex bech enajem en9asemb'en partie user-siedebar ou chatbox -->
        <div class="d-flex" style="height: 65vh;">
            <!--  border-end" elkhat eli b'en liste employe ou blaset msget -->
<!--user-sidebar eimathel elpartie lei 3ala ejnab ekol eli feha user elkol ou recherche 
liste-group classe bootstrape eima4el user elkol eina4emhoum 
liste_group-item howa classe bootstrab el user elwa7et eirak7ou kima padding
<div class="user-sidebar">      <SIDEBAR (bloc kbir)

    <div class="list-group">     LISTE USERS 

        <a class="list-group-item">User 1</a>   <USER WAHED
        <a class="list-group-item">User 2</a>
        <a class="list-group-item">User 3</a>

    </div>

</div>
 --><!--partie emta3 asemi employe OU RECHERCHE -->
            <div class="user-sidebar border-end">
                <div class="p-3 border-bottom">
<!-- shadow-sm -->
          <div class="search-container">
        <form method="GET">
            <div class="input-group">
                <input type="text" name="search" class="form-control p-3" placeholder="Rechercher..." value="<?= htmlspecialchars($search) ?>">
                <button class="btn btn-primary px-4"><i class="bi bi-search"></i></button>
            </div>
        </form>
    </div>
</div>
                <!--<div class="list-group list-group-flush">
                              <?php //foreach($chat_users as $user):
                        // ha4a bech ki tenzel 3ale user  eli bech ta7ki 3alih eihezek ela chatbox?>
                        <a href="?user_id=<//?= $user['id_utilisateur'] ?>"
                        <?// ha4i bech ken user[]id_utilisateur hya nafsou eli ya7ki m3ah eiZitou style active_chat ?>
                           class="list-group-item list-group-item-action border-0 py-3 px-4 <?//= ($selected_user == $user['id_utilisateur']) ? 'active-chat' : '' ?>">/-->
                              <!-- list-group: (bootstrap ) howa eina4em liste kima menu ou liste user 
                               list-group-flush (bootstrap) eina7i border / id="userList" -->
                    <div class="list-group ">
                    <?php foreach($chat_users as $user): 
                        //3alakhater href =?  ma3naha ki telzl 3ala lien ya3mel actueliser ela nafes page eli fih lien ou yab3e4 donner fi url l'el page nafesha eli hya 
                        // id_user eli ekhtartou ma3naaha lien li howa kol employe esmou yeta3mel fi lien ?>
                        <a href="?user_id=<?= $user['id_utilisateur']
                        //list-group-item-action fasekhetha m'en ba74i class list-group-item (liste-group-items howa 3amlou fi fichier  css) 
                        //  border-0 eina7i border m'en card eli feha user elkol  ?>"
                        
                           class="list-group-item border-0 py-3 px-4 <?= ($selected_user == $user['id_utilisateur']) ? 'active-chat' : '' ?>">
                            <div class="d-flex align-items-center">
                                <div class="user-avatar" > <?= strtoupper(substr($user['nom'], 0, 1)) ?>    </div>    
                                <!-- flex-grow-1 hya bootstrap fi css flex:1 ma3naha enou yakhou espace elmoutaba9i fasekhetha 
                                 overflow-hidde :ki yabta enas etwil ei9ous ezaiet bech maietna3ech m'en espace emta3ou fasekhetha 
                                 text-start : howa yabta m'en l'eysar enas fasekhatha -->      
                                <div >
                                    <!--text-truncate ha4i bootstrap etkhali enas ki yabta etwil yet9as  ou you4her fi nekhar...maneset7a9hach nana enas e9sir-->
                                    <h6 class="mb-0 fw-bold text-dark "><?= htmlspecialchars($user['nom'] . ' ' . $user['prenom']) ?></h6>
                                    <btr> <?= htmlspecialchars($user['role']) ?><br>
                                    <!--text-muted eibatel eloul ela gris /small eina9es fi kouber lektiba-->
                                    <small class="text-muted">Voir la discussion</small>
                                </div>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
                    <!--chat-area howa elpartie eli feha chatbox emta3 msg ki takhter employe  ou formulaire eli yab3e4 msg ow eldesine emta3 awel mateb3e4 msg  
                    class area-msg fi woustou class chat-msg chatbox 
 chat-area (flex column, bg-white)
│
├─ chat-messages (scrollable)
│   ├─ message 1
│   ├─ message 2
│   └─ ...
│
|-─ chat-input (zone باش تكتب رسالتك)
|
-->
            <section class="chat-area">
                <?php if($selected_user): ?>
                    <!-- chatbox eli  affiche feha msg -->
                    <div class="chat-messages " id="chatBox" >          
                            <?php foreach($messages as $m): ?>
                                <div class="d-flex <?= ($m['type'] == 'chatbot') ? 'justify-content-end' : 'justify-content-start' ?>">
                            <!--bouble howa le9aleb emta3 msg ebsifa 3ama -->
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
                            <!--shadow-none eina7i ay  shadaw -->
                            <input type="text" name="txt_response"class="form-control rounded-pill border-2 px-4" 
                       placeholder="Écrivez votre message..." required 
                       style="border-color: var(--secondary); height: 45px;">
                            <button type="submit" name="repondre" class="btn-envoye">
                                <i class="bi bi-send-fill"></i>
                            </button>
                        </form>
                    </div>
<!--<ken selected_user farkha ma3naha enti mizelet ki etkhalet l'el page ou makhtertech employee manzeltech 3ala employe ki tenzel 3ala employ
employe you93et feha  id emta3employe eli ekhtartou maietbatel ken ki telzel 3ala employe akher ou ki ta3mel reflechi lelpage wa9etha  etwali farkha selected_employe
awel matoutkhel selectred yabta feha null li4alek  mai4arlek 7ata discution-->
                <?php else: ?>
                <!-- h-1(bootstrap) height: 100%;-->
                    <div class="empty-chat d-flex flex-column align-items-center justify-content-center h-100 text-center">
                        <div class="icon-circle mb-3 bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                            <i class="bi bi-chat-quote  " style="font-size: 3rem;  color: var( --secondary) ;"></i>
                <!--opacity-50 ma3naha nesbet chafafia emta7A ki et7out 0 ma3atech tou4her  etwali chafefa  -->
                        </div>
                        <h6 class="text-info fw-semibold">Sélectionnez une discussion pour commencer</h6>
                    </div>
                <?php endif; ?>
            </section>
        </div>
   
</div>
    
<script>

    /**vاختصار: هذا الكود يخلي صندوق الشات يتمركز دائماً على آخر رسالة بعد ما يضيف محتوى جديد. */
const chat = document.getElementById("chatBox");
/**ken div eli 3antou id chat mawjout wa9etha youtkhel ela if
 * scrollTop haki hya eli yet7at feha position verticale l'el div eli id emta3ou  ou   
 * scrollHeightou ha4i houteur emta3 div enwali position en7out feha toul page bech tahbet autaumatique 
scrollTop → c’est la position verticale actuelle du scroll dans la div.

scrollHeight → c’est la hauteur totale du contenu de la div, même ce qui n’est pas visible.

Donc quand tu écris :

objDiv.scrollTop = objDiv.scrollHeight;


Ça dit : « mets la position verticale du scroll à la hauteur totale du contenu », ce qui a pour effet que la div défile automatiquement jusqu’en bas et affiche les derniers messages.
*/
    if(chat) 
    { chat.scrollTop = chat.scrollHeight; }
</script>
<!--
        
script>
document.getElementById('userSearch').addEventListener('keyup', function() {
    let filter = this.value.toLowerCase(); // الكلمة اللي كتبها الأدمن
    let users = document.querySelectorAll('.user-item'); // القائمة الكل

    users.forEach(function(user) {
        let name = user.getAttribute('data-name'); // اسم الموظف
        if (name.includes(filter)) {
            user.style.setProperty('display', 'block', 'important'); // يظهره
        } else {
            user.style.setProperty('display', 'none', 'important'); // يخفيه
        }
    });
});
</script>-->
</body>
</html>