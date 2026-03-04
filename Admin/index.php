<?php

/*
// 2. الاتصال بقاعدة البيانات
require_once '../includes/connexion.php';


require_once '../employe_stock/auth.php';
require_role(["Admin"]);
// 3. جلب معرف المستخدم الحالي
$id_user = $_SESSION['id_utilisateur'] ;
$nom_user = $_SESSION['nom'] ;
$prenom_user = $_SESSION['prenom'];

// 4. استدعاء ملف التنبيهات (الآن سيتمكن من قراءة البيانات بشكل صحيح)
include 'alert_stock.php';

try {
    // 5. حساب عدد التنبيهات غير المقروءة بعد عملية الإدخال
    $unread_notif = $pdo->query("SELECT COUNT(*) FROM notification WHERE id_utilisateur = $id_user AND etat = 'non_lu'")->fetchColumn() ?: 0;
    $total_mag = $pdo->query("SELECT COUNT(*) FROM magasin")->fetchColumn() ?: 0;
    $total_mvt = $pdo->query("SELECT COUNT(*) FROM historique_movement WHERE MONTH(date_mouvement) = MONTH(CURRENT_DATE()) AND YEAR(date_mouvement) = YEAR(CURRENT_DATE())")->fetchColumn() ?: 0;
    $low_stock_count = $pdo->query("SELECT COUNT(*) FROM article WHERE quantite <= 20 AND etat = 'actif'")->fetchColumn() ?: 0;
 $unread_notif = $pdo->query("SELECT COUNT(*) FROM notification WHERE id_utilisateur = $id_user AND etat = 'non_lu'")->fetchColumn() ?: 0;
    $alerts = $pdo->query("SELECT a.*, m.nom_magasin FROM article a LEFT JOIN magasin m ON a.id_magasin = m.id_magasin WHERE a.quantite <= 20 AND a.etat = 'actif' LIMIT 10")->fetchAll(PDO::FETCH_ASSOC);
     $stmt = $pdo->prepare("SELECT h.*, a.nom_article FROM historique_movement h JOIN article a ON h.id_article = a.id_article WHERE h.id_utilisateur = ? ORDER BY h.date_mouvement DESC LIMIT 5");
      $stmt->execute([$id_user]);
    $movements = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) { die("Erreur: " . $e->getMessage()); }
?>

<?php
// تأكد من استدعاء ملفات الاتصال بقاعدة البيانات والمتغيرات هنا
// $total_art, $total_mag, $unread_notif, $alerts, $movements ... إلخ
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Content</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="../css/cards.css">
    <!--<link rel="stylesheet" href="../css/notifications.css">-->
    <link rel="stylesheet" href="../css/tables.css">
    
<style>
    /* haAi  /* 3. Header Fix: bech yched el jnab lil jnab *//*ha4i emta3 header hya eli etrakAa wen maktoub esem user ou button notificartion*/  /*
.employee-header { 
    background: white; 
    padding: 15px 25px; 
    border-radius: 12px; 
    margin-bottom: 30px; 
    border: 1px solid var(--secondary);
    display: flex;
    justify-content: space-between;
    align-items: center;
}
/*
.avatar-circle {
    width: 45px;
    height: 45px;
    background: var(--primary);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
}
*//* ha4I emta3 wen you4ehrou alertstock ou tableau mouvement *//*
.section-container {
    background: white;
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 25px;
    border: 1px solid var(--secondary);
}
/*hja4i etraka7el3anawin emta3 alert stock ou puvemebt*//*
.section-title {
    font-weight: 700;
    margin-bottom: 15px;
    display: flex;
    align-items: center;
    gap: 10px;
}
  .bg-entree { background-color: #f0fff4; color: #22c55e; }
    .bg-sortie { background-color: #fff1f2; color: #ef4444; }
    .bg-transfert { background-color: #eff6ff; color: #3b82f6; }
</style>

</head>
<body>

   <header class="employee-header shadow-sm d-flex justify-content-between align-items-center">
    <div class="d-flex align-items-center gap-3">
        <div class="avatar-circle">
            <i class="bi bi-person-fill"></i>
        </div>
        <div>
            <h6 class="mb-0 fw-bold" style="color: #1b254b;"><?= htmlspecialchars($nom_user) , htmlspecialchars($prenom_user) ?></h6>
            <small class="text-muted">Admin Stock</small>
        </div>
    </div>

    <div class="d-flex align-items-center gap-4">
        <div class="position-relative">
            <button class="notif-btn" onclick="toggleNotif()" style="border:none; background:none; padding:5px;">
                <i class="bi bi-bell fs-4 text-primary"></i>
                <?php if($unread_notif > 0): ?>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">
                        <?= $unread_notif ?>
                    </span>
                <?php endif; ?>
            </button>
            
            <div id="notif-dropdown" class="notif-dropdown p-3 shadow-lg" style="display:none; position:absolute; right:0; top:45px; background:white; width:250px; border-radius:12px; z-index:1000; border: 1px solid #eee;">
                <h6 class="fw-bold border-bottom pb-2" style="font-size: 14px;">Notifications</h6>
                <p class="text-muted small py-2 mb-2">
                    <?= ($unread_notif > 0) ? "Vous avez $unread_notif alertes." : "Pas de nouvelles notifications."; ?>
                </p>
                <a href="notification_admin.php" class="btn btn-primary btn-sm w-100">Voir tout</a>
            </div>
        </div>

        <div class="ps-3" style="border-left: 1px solid var(--secondary);">
            <span class="d-block text-muted small"><?= date('d M Y') ?></span>
            <span class="fw-bold text-primary"><?= date('H:i') ?></span>
        </div>
    </div>
</header>

    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="stat-card">
                <h6 class="text-muted small uppercase">Total Articles</h6>
                <h3 class="fw-bold mb-0"><?= number_format($total_art ?? 0) ?></h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <h6 class="text-muted small uppercase">Magasins</h6>
                <h3 class="fw-bold mb-0"><?= $total_mag ?? 0 ?></h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <h6 class="text-muted small uppercase">Mouvements</h6>
                <h3 class="fw-bold mb-0"><?= $total_mvt ?? 0 ?></h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card" style="border-left: 5px solid var(--danger);">
                <h6 class="text-muted small uppercase">Alertes Stock</h6>
                <h3 class="text-danger fw-bold mb-0"><?= $low_stock_count ?? 0 ?></h3>
            </div>
        </div>
    </div>
    

    <div class="section-container shadow-sm">
        <div class="section-title text-danger">
            <i class="bi bi-exclamation-triangle"></i> Alertes Stock Faible
        </div>
        <?php if(!empty($alerts)): ?>
            <?php foreach($alerts as $a): ?>
                <div class="d-flex justify-content-between align-items-center p-2 border-bottom">
                    <div>
                        <div class="fw-bold"><?= htmlspecialchars($a['nom_article']) ?></div>
                        <small class="text-muted"><?= htmlspecialchars($a['nom_magasin'] ?? 'Global') ?></small>
                    </div>
                    <div class="text-end">
                        <span class="badge bg-light text-danger"><?= $a['quantite'] ?> unités</span>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-muted small">Aucune alerte pour le moment.</p>
        <?php endif; ?>
    </div>

    <div class="section-container shadow-sm">
        <div class="section-title text-primary">
            <i class="bi bi-clock-history"></i> Mouvements Récents
        </div>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Article</th>
                        <th>Type</th>
                        <th>Quantité</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($movements as $m): ?>
                        <tr>
                            <td><?= htmlspecialchars($m['nom_article']) ?></td>
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
                                     <?= $m['type_mouvement'] ?>
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


    <script>
        function toggleNotif() {
            const dropdown = document.getElementById('notif-dropdown');
            dropdown.style.display = (dropdown.style.display === 'none') ? 'block' : 'none';
        }
        window.onclick = function(event) {
            if (!event.target.closest('.position-relative')) {
                document.getElementById('notif-dropdown').style.display = 'none';
            }
        }
    </script>
</body>
</html>
  <button class="notif-btn" onclick="toggleNotif()" style="border:none; background:none; padding:5px;">
                    <i class="bi bi-bell fs-4 text-primary"></i>
                    <?php if($unread_notif > 0): ?>
                    <!-- position-absolue hya eli etkhali nb notif yet7at wen position relative /rounded-pill eikhali nb notif you4her fi toura  /top-0 start-100 et7atet wen you4eher nb etnajem etna7ihoum maietbatel chay
                      / translate-middle  : hya etkhali tou4her fi wouset button m'en fou9 ken etna7aha eiwali blasa tebatel akahw / pdg: كلاس Bootstrap تعطي ستايل جاهز للرقم.-->
                        <span class="position-absolute  badge rounded-pill bg-danger" style="font-size: 0.6rem;">
                            <?= $unread_notif ?>
                        </span>
                    <?php endif; ?>
                </button>
<!-- haki  el fenetre eli tet7al eli feha buton eihezek ela page notification
                  top: 45px;  etnajem etn7aha  bech ki tet7al tetr7al ta7et button   right:0; bech ki tet7al tet7al 3ala limin button right :0 m'en button
                   position:absolute; et7atetlek l'eblasa eli bech yet7al feha display:none; bech maiet7alech ki awelmatoutkhel maiet7al ken ki tenzel 3ala button  border: 1px solid #eee; ta3mel  eidar l'el fenetre eli tet7al 
                   shadow-lg howa bootstrab bech ya3mel ki 4oul ba74i fenetre eli tet7al   -->
                <div id="notif-dropdown" class="notif-dropdown p-3 shadow-lg" style="display:none; position:absolute; right:0;  background:white; width:250px; border-radius:12px; border: 1px solid #a4e0f8;">
                    <h6 class="fw-bold border-bottom pb-2" style="font-size: 14px;">Notifications</h6>
                    <!--border-bottom pb-2 ya3mel khat ta7et kelmet notification pb-2 Padding Bottom 2: espace interne li kelmet notification bech elkhat mikounech ta7tou be4abet  
                    text-muted: hakio bech etbatel loul lektiba ela gris fate7 / small bech etsakher bi nektiba   -->
                    <p class="text-muted small ">
                        <?= ($unread_notif > 0) ? "Vous avez $unread_notif alertes." : "Pas de nouvelles notifications."; ?>
                    </p>
                    <!-- w-100 width :100% / btn-sm -->
                    <a href="notification_admin.php" class="btn btn-primary  w-100">Voir tout</a>
                </div>
*/
// 2. الاتصال بقاعدة البيانات
require_once '../includes/connexion.php';
require_once '../employe_stock/auth.php';
require_role(["Admin"]);

// 3. جلب معرف المستخدم الحالي
$id_user = $_SESSION['id_utilisateur'] ;
$nom_user = $_SESSION['nom'] ;
$prenom_user = $_SESSION['prenom'];

// 4. استدعاء ملف التنبيهات
include 'alert_stock.php';

try {
    // 5. جلب البيانات للإحصائيات// KEN  SELECT MARJIB CHAY MA3naha fetchColumn()  mafaha chay eiwali takhou 0
    $unread_notif = $pdo->query("SELECT COUNT(*) FROM notification WHERE id_utilisateur = $id_user AND etat = 'non_lu'")->fetchColumn() ?: 0;
    $total_art = $pdo->query("SELECT COUNT(*) FROM article WHERE etat = 'actif'")->fetchColumn() ?: 0;
    $total_mag = $pdo->query("SELECT COUNT(*) FROM magasin")->fetchColumn() ?: 0;
    $total_mvt = $pdo->query("SELECT COUNT(*) FROM historique_movement WHERE  MONTH(date_mouvement) = MONTH(CURRENT_DATE()) AND YEAR(date_mouvement) = YEAR(CURRENT_DATE())")->fetchColumn() ?: 0;
    $nb_alert_stock = $pdo->query("SELECT COUNT(*) FROM article WHERE quantite <= 20  AND quantite > 0 AND etat = 'actif'")->fetchColumn() ?: 0;
    
    $alerts = $pdo->query("SELECT a.*, m.nom_magasin FROM article a LEFT JOIN magasin m ON a.id_magasin = m.id_magasin WHERE a.quantite <= 20  AND a.quantite > 0 AND a.etat = 'actif' LIMIT 10")->fetchAll(PDO::FETCH_ASSOC);
    
    $stmt = $pdo->prepare("SELECT h.*, a.nom_article FROM historique_movement h JOIN article a ON h.id_article = a.id_article WHERE h.id_utilisateur = ? ORDER BY h.date_mouvement DESC LIMIT 5");
    $stmt->execute([$id_user]);
    $movements = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e)
 { die("Erreur: " . $e->getMessage()); }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
                    <!-- base hya bech etbatel backround emta3 page -->
    <link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="../css/cards.css">
    <!--<link rel="stylesheet" href="../css/tables.css">-->
    
    <style>
 
/* استعمل html body باش تزيد القوة (Specificity) */



    /*ha4i etrake7 elheader emta3 index awel card */
    .admin-header { 
        /**bech etkoun elpartie haki m'en eli hya admin-header backroun white  */
        background: white; 
        /**ta3mel espace takhel card  15 3ala l'eimin ou l'eisar ou 
        25 m='en fou9 ou louta  */
        padding: 15px 25px; 
        /**haki bech etkoun el7awef emtaWrin eta3 card  */
        border-radius: 12px; 
        /** bech etkali espace b'en card header ou eli ta7etha  */
        margin-bottom: 25px; 
        /**estar eli ben  bouton notification ou date */
        border: 2px solid var(--secondary);
        /**display flex hya eli etkhai elcomposant kima div eli fi wousou admin header elkoul you4ehrou bejnab eb3a4houm */
        display: flex;
        /** ta3mel espace b'en composant  */
        justify-content: space-between;

       /* align-items: center;*/
       /* width: 100%;
        /*box-sizing: border-box;*/
        /**Hha4a etnajem etna7ih houwa eizaiel cadre ya3malou ki e4el l'el cadre 0.25 kouber e4el 
        0 → الإزاحة الأفقية (horizontal shift) → الظل ما يتحركش يمين ولا يسار

4px → الإزاحة الرأسية (vertical shift) → الظل يتحرك 4 بيكسل تحت العنصر

15px → التشويش أو الانتشار (blur radius) → يجعل الظل يتوزع بشكل ناعم

rgba(0,0,0,0.25) → لون الظل مع شفافية 25%  */
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.25);
    
    }
 
    .dashboard-container {
        /*width: 100% !important;
        max-width: 100% !important;*/
        padding: 20px;
        /*box-sizing: border-box;*/
    }
/**ha4i lel card elkol elio feha nb artuicle ou magasin el partie 2 m'en page   
stat-grid lel bech etrateb card ejnab eb3a4houm ou elmasafet benhoum */
    .stat-grid {
        /** bech etkhalihoum 4 bejnab eb3a4houm  */
      /** display:grid  */
        display: flex;
         
      /* على شاشة كبيرة → كل cards تتوزع في صفوف وأعمدة حسب المساحة.

على شاشة صغيرة (مثل الهاتف) → الأعمدة تتقلص وعددها يقل تلقائيًا، حتى كل card تبقى واضحة وما تصغرش أقل من 240px.
ma3naha hya eli et9asem espace 3ala 7aseb 3atet card ou kouber ecran 
na7etha leni batenet display ela flex ou hya tekhtem em3a grid hya 
etkhali ki etzit card ken ecran yekfi ei7outha ou  eina9es fi kouber cardet elkoukhrin ama mayfoutech 240 
ou ken espace maiekfich ou eiwali card loukhrina yeskharou a9al m'en 240 px 
eiwali eihabatha louta ama flex etkhalihoum elkoul you4ehrou faret estar 7ata ken espace maiekfich etsakher 
fi loukrina ama flex etsakher fi card oukhrina ou et7outhoum elkol ejnab eb3a4hou howa ani tima 3anti 4 card li4alek esta3malt flex */
     /*   grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        /** howa espace eli b'en card ou oukhra  b'en kol card eli fi partie 2 m'en page  */
        gap: 20px;
    /** espace eli ben 4 card ou eli ta7etha (emta3 alert stock) */
        margin-bottom: 25px;
       
       /* width: 100%;*/
    }
/**ha4i lel feha tableau ou aler stock  */
    .section-container {
        background: white;
        border-radius: 12px;
         /* padding داخلي: يخلّي المحتوى ما يلصقش في حواف الكارد */
        padding: 25px;/** eikjhali espace interne eli fi carxe 25 bech etji lektiba fi wouset  */
        margin-bottom: 25px;  /* مسافة تحت الكارد (بينه وبين القسم اللي بعده) */
        /*ha4i bech tasna3 card  */
        border: 2px solid var(--secondary);
      /*  width: 100%;*/
       /* box-sizing: border-box;*/
    }

   /* .section-title {
        font-weight: 700;
        font-size: 1.2rem;f
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
        color: var(--primary);
    }*/
      /*  stat_card l'el  taille card  ou toulou ou tartib donner emta3  card ou  */
       /*  la7etha lenha mawjouta fi fichier card.CSS
       .stat-card {
        width: 100% !important;
        /*margin: 0 !important;*/
       /* min-width: 240px; /**card maieskharech akther m'en 240 px bech 7ata ken zete card oukhra flex matsekherech card eloukhrina  */
       /* display: flex;
        flex-direction: column;
        justify-content: center;*/
        /*min-height: 120px;
    }*/

    .bg-entree { background-color: #f0fff4; color: #22c55e;}
    .bg-sortie { background-color: #fff1f2; color: #ef4444; }
    .bg-transfert { background-color: #eff6ff; color: #3b82f6; 
 }
 /** lahi bi cercle eli ba74i esem user eli fi header  */
      /* .avatar-circle {
        width: 45px;
       height: 45px;
        background: var(--primary);
        color: white;
       /*  border-radius: 50%;*/
    
       /*  display: flex;
          /** ha4ouma estoura 2 bech eikhaliou contenu emta3 cercle fi wouset  */
      /*  align-items: center;
        justify-content: center;*/
        /** taille emta3 taswira eli fi cercle  */
       /* font-size: 1.2rem;
    }*/
    </style>
</head>
<body>

<div class="dashboard-container">
<!--kenet fi classse admin_header shadow-sm-->
    <header class=" admin-header ">
<!--d-flex  hya display flex fi3ou4 man3mel classe css esta3malet  bootstra  align-items-center  bech et7out contenu emta3 div haka fi wouset ertifa3 ma3naha lahi fou9 ou louta
gap-3" hya espace ben composant eli fi wouset div haki 3 hya 1rem  -->
        <div class="d-flex align-items-center gap-3">
            <div class="avatar-circle">
                <i class="bi bi-person-fill"></i>
            </div>
            <div>
<!-- mb-0 marginbutton ma3naha espace ben nom ou  eli ba3etha (kelmet adminstock) =0 / fw-bold hya fi css  font-weight: bold  etkaber elkhat -->
                <h6 class="mb-0 fw-bold" style="color: #1b254b;"><?= htmlspecialchars($nom_user . ' ' . $prenom_user) ?></h6>
<!--text-muted bech eibatel fi noul lektiba -->
                <small class="text-muted">Admin Stock</small>
            </div>
        </div>
<!-- absolue howa eli ei7out nb fi blsa eli et7eb 3ala 
 relative howa l'eplace eli yet7at feha nb notif -->

        <div class="d-flex align-items-center gap-4">
<!-- position-relative eikhali 3atet notif ye7at fou9 button notif eni howa fi wouet div position-realative ki etna7i relativbe wa9etha eiwali you4her fi blasa khalta  -->
            <div class="position-relative">
                 <a href="notification_admin.php"  style="border:none; background:none; padding:5px;">
                    <i class="bi bi-bell fs-4 text-primary"></i>
                    <?php if($unread_notif > 0): ?>
                    <!-- position-absolue hya eli etkhali nb notif yet7at wen position relative /rounded-pill eikhali nb notif you4her fi toura  /top-0 start-100 et7atet wen you4eher nb etnajem etna7ihoum maietbatel chay
                      / translate-middle  : hya etkhali tou4her fi wouset button m'en fou9 ken etna7aha eiwali blasa tebatel akahw / pdg: كلاس Bootstrap تعطي ستايل جاهز للرقم.-->
                        <span class="position-absolute  badge rounded-pill bg-danger" style="font-size: 0.6rem;">
                            <?= $unread_notif ?>
                        </span>
                    <?php endif; ?>
                    </a>
            </div>
            <!--Padding Start = 3 ma3naha espace interne eli 3al leisar 3rem bech eiba3et contenu emta3 div 3ala elkhat eli 3al leysa 
            eli 3amlou ha4a border-left: 1px solid var(--secondary); -->
            <div class="ps-3" style="border-left: 1px solid var(--secondary);">
                    <!-- d-block : ma3nha bech eikhali estar eli ba3tou yahbet ma3naha date fi star ou elwa9et fi estar
                     fw-bold: Font Weight Bold  eikhale4h fi elkhat text-primary bech ya3ti loul lel kelma -->
                <span class="d-block text-muted small"><?= date('d M Y') ?></span>
                <span class="fw-bold text-primary"><?= date('H:i') ?></span>
            </div>
        </div>
    </header>

    <div class="stat-grid">
                    <!--text-uppercas ei7awel elkelma ela majuscule/ mb-0 : margin boutton :0 -->
        <div class="stat-card">
           <h6 class="text-muted small text-uppercase">Articles en Stock</h6>
                <h3 class="fw-bold"><?=$total_art ?></h3>
        </div>
        
        <div class="stat-card">
            <h6 class="text-muted small text-uppercase">Magasins</h6>
            <h3 class="fw-bold "><?= $total_mag ?></h3>
        </div>
        <div class="stat-card">
            <h6 class="text-muted small text-uppercase">Mouvements (Mois)</h6>
            <h3 class="fw-bold "><?= $total_mvt ?></h3>
        </div>
        <div class="stat-card" >
            <h6 class="text-muted small text-uppercase">Alertes Stock</h6>
            <h3 class=" fw-bold"><?= $nb_alert_stock ?></h3>
        </div>
    </div>
                    <!--kanet classe section-conntainer shadow-sm-->
    <div class="section-container ">
        <div  class="text-danger">
        <h5> <i class="bi bi-exclamation-triangle"></i> Alertes Stock Faible</h5>
        </div>
        <?php if(!empty($alerts)): ?>
            <?php foreach($alerts as $a): ?>
            <!-- estar emta3 kol alert /justify-content-between /EIKHALI CONTENU  DIV 3 ala leymin ou div 3ala let=ysar bech eikoul elesem ou magasin 3ala leymin ou quantite 3ala l'eysar 
              align-items-center  ei7out el contenu fi wouset 3amoutia ma3naha lahi elfou9 ou elouta  -->
                <div class="d-flex justify-content-between align-items-center p-2 border-bottom">
                    <div>
                        <div class="fw-bold"><?= htmlspecialchars($a['nom_article']) ?></div>
                        <small class="text-muted"><?= htmlspecialchars($a['nom_magasin'] ) ?></small>
                        
                    </div>
                    <!-- text-end eikhali contenu 3ala leymin (enajem ena7aha lana 3anti fi div eli feha elkol justify-content-between
                     bg-light bech ya3mel kbackroun gris fate7 / badge hya et7out quantite fi toura ou bg-light etroutha gris fate7  -->
                     <div>
                        <span class="badge bg-light text-danger"><?= $a['quantite'] ?> article</span>
                    </div>
                    

                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-muted small">Aucune alerte pour le moment.</p>
        <?php endif; ?>
    </div>
    <!-- kanet fi section-contenat --shadow-sm"-->

    <div class="section-container ">
        <div class=" text-primary">
           <h5> <i class="bi bi-clock-history"></i> Mouvements Recents</h5>
        </div>
        <!-- table-responsive ha4i bech tableau you4her emrkel fi teliphone li4anek etnajem etna7aha
         table : haka ya3mel forma emta3 table  / table-hover :bech ki ei9areb souris couloun etwali gris 
         table-light bech ya3ti loun el couloun eloul eli fih titre -->
        <div >
            <table class="table table-hover">
                <thead  class="table-light" >
                    <tr>
                        <th>Article</th>
                        <th>Type</th>
                        <th>Quantité</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($movements as $m): ?>
                     <tr>
    <td><?= htmlspecialchars($m['nom_article']) ?></td>
    <td>
        <?php
        if ($m['type_mouvement'] === 'entree') {
            $badgeClass = 'bg-entree';
        } elseif ($m['type_mouvement'] === 'sortie') {
            $badgeClass = 'bg-sortie';
        } else {
            $badgeClass = 'bg-transfert';
        }
        ?>
        
        <span class="badge <?= $badgeClass ?>">
            <?= htmlspecialchars($m['type_mouvement']) ?>
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

<script>
    /*
    function toggleNotif() {
        const dropdown = document.getElementById('notif-dropdown');
        dropdown.style.display = (dropdown.style.display === 'none') ? 'block' : 'none';
    }
    window.onclick = function(event) {
        if (!event.target.closest('.position-relative')) {
            const dropdown = document.getElementById('notif-dropdown');
            if (dropdown) dropdown.style.display = 'none';
        }
    }*/
</script>
</body>
</html>