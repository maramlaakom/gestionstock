

<?php
require_once '../includes/connexion.php';
require_once "auth.php";
require_role(["employe_stock"]);

$msg = "";
$error = "";

//if (isset($_SESSION['id_utilisateur'])) {
    $id_user = $_SESSION['id_utilisateur'];
//} else {
  //  header("Location: login.php");
    //exit();
//}

if (isset($_POST['envoyer_demande'])) {
    $id_art = $_POST['id_article'];
    $type = $_POST['type_action'];
    $qte = $_POST['quantite'];
    
  //ma3naha ha4a estar eichouf input fi formulaire emmta3 magqasin_dest ken 3amarha user wa9ta rahi ouvement transfer 
//ou nemchi en7out el9ima emta3 formulaire fi variable v$magasin_dest ou ken mahich em3amra ma3naha ferkha rahi sortie ou maiest7a9ech 
//ela magasin_dest eiwali varible ei7out feha N/A 9ima eftira4ia 
//3alakhater fi mouvement maneset7a9ouch ela magasine detination
    $id_magasin_dest = ($type === 'transfert') ? $_POST['magasin_dest'] : null;

 // etjib  tous les  nom  de article  avec  le nom  magasin src  emta3 kol article 
    $stmt = $pdo->prepare("SELECT a.nom_article, m.nom_magasin, m.id_magasin FROM article a 
                           JOIN magasin m ON a.id_magasin = m.id_magasin 
                           WHERE a.id_article = ?");
    $stmt->execute([$id_art]);
    $art = $stmt->fetch();

    // 3. تصحيح: جلب اسم مخزن الوجهة فقط إذا كان نوع العملية 'transfert'
    $nom_mag_dest = 'N/A';
    if ($type === 'transfert' && !empty($id_magasin_dest)) {
        $stmtMag = $pdo->prepare("SELECT nom_magasin FROM magasin WHERE id_magasin = ?");
        $stmtMag->execute([$id_magasin_dest]);
        $resMag = $stmtMag->fetch();
        $nom_mag_dest = $resMag['nom_magasin'] ;
    }

    // 4. جلب بيانات المستخدم
    $stmtUser = $pdo->prepare("SELECT prenom, nom FROM utilisateur WHERE id_utilisateur = ?");
    $stmtUser->execute([$id_user]);
    $user = $stmtUser->fetch();

    $magasin_source_nom = $art['nom_magasin'];
    $id_magasin_source = $art['id_magasin'];

    // 5. التحقق: لا يمكن التحويل لنفس المخزن
    if ($type === 'transfert' && intval($id_magasin_source) === intval($id_magasin_dest)) {
        $error = "Erreur : Le magasin de destination doit être différent du magasin actuel ($magasin_source_nom) !";
    } else {
        $nom_complet = ($user['prenom'] ?? '') . ' ' . ($user['nom'] ?? '');
        // preparer  message pour envoyer le admin
        $message = "DEMANDE_ACCES | Employé: {$nom_complet} | Art: {$art['nom_article']} | Qty: {$qte} | Type: {$type} | From: {$magasin_source_nom} | To: {$nom_mag_dest}";

        // 6. الإدخال في قاعدة البيانات (6 علامات استفهام لـ 6 قيم)
        $ins = $pdo->prepare("INSERT INTO demande_contact 
            (id_utilisateur, id_article, id_magasin_dest, qte_demande, sujet, message, date_demande, statut) 
            VALUES (?, ?, ?, ?, 'DEMANDE PERMISSION', ?, NOW(), 'en_attente')");
        
        if ($ins->execute([$id_user, $id_art, $id_magasin_dest, $qte, $message])) {
            $msg = "Demande envoyée avec succès !";

            // إرسال التنبيهات للأدمن
            $stmtAdmin = $pdo->query("SELECT id_utilisateur FROM utilisateur WHERE role = 'Admin'");
            $admins = $stmtAdmin->fetchAll();

            if ($admins) {
                $notif_text = "Nouvelle demande ($type) de la part de $nom_complet $message";
                $insNotif = $pdo->prepare("INSERT INTO notification (id_utilisateur, contenu, etat) VALUES (?, ?, 'non_lu')");
                foreach ($admins as $admin) {
                    $insNotif->execute([$admin['id_utilisateur'], $notif_text]);
                }
            }
        }
    }
}

// جلب القوائم للفورم
$articles = $pdo->query("SELECT a.*, m.nom_magasin FROM article a JOIN magasin m ON a.id_magasin = m.id_magasin WHERE a.etat = 'actif'AND quantite > 0")->fetchAll();
$magasins = $pdo->query("SELECT * FROM magasin")->fetchAll();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Demande de Permission Detaillee</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
   <!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Demande de Permission Detaillee</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
       <link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="../css/forms.css">

   
    <style>
    /* 1. Layout khass: y7ot el form fil west dhabt */
   /* .page-wrapper {
        min-height: calc(100vh - 160px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 20px;
    }

    /* 2. Custom Card: mouch kima el user-card el 3adiya *//*
    .form-container-card {
        background: white;
        padding: 45px;
        border-radius: 20px;
        max-width: 680px;
        width: 100%;
        border: 2px solid var(--secondary); /* Nesta3mlou variable mel externe *//*
        box-shadow: 0 15px 40px rgba(135, 206, 235, 0.25);
        position: relative;
    }

    /* 3. Notification Dropdown: lazemha style hna khaterha lié lel JS mta3 el page *//*
    .notif-dropdown {
        display: none;
        position: absolute;
        right: 0;
        top: 55px;
        background: white;
        width: 280px;
        border-radius: 15px;
        z-index: 9999;
        border: 1px solid #eef2f7;
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    }

    /* 4. Button Special: ykoun akber w fih icon mel jnab *//*
    .btn-submit-pro {
        background-color: var(--primary) !important;
        border: none !important;
        color: white !important;
        padding: 16px !important;
        font-size: 1.1rem !important;
        border-radius: 12px !important;
        width: 100%;
        font-weight: bold;
        transition: all 0.3s ease;
    }

    .btn-submit-pro:hover {
        background-color: var(--primary-dark) !important;
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(30, 144, 255, 0.3);
    }

    /* 5. Transfert Field: animation ki yedh-her *//*
    #magasin_field {
        background: #f0f7ff;
        padding: 20px;
        border-radius: 12px;
        border-left: 5px solid var(--primary);
        margin-top: 15px;
    }
        */
</style>
</head>
<body>
<div class="page-form">
    <div class="form-container">
        <h2>Nouvelle Demande d'Accès</h2>
        <?php if($msg): ?>
            <div class="alert alert-success"><?= $msg ?></div>
        <?php endif; ?>
        
        <?php if($error): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-4">
                <label class="form-label">Article Sélectionné</label>
                <select name="id_article" class="form-select" required>
                    <?php foreach($articles as $a): ?>
                        <option value="<?= $a['id_article'] ?>">
                            <?= $a['nom_article'] ?> (Stock: <?= $a['quantite'] ?>) — [<?= $a['nom_magasin'] ?>]
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="row">
                <div class="col-md-6 mb-4">
                    <label class="form-label">Type d'Opération</label>
                    <select name="type_action" id="type_action" class="form-select" onchange="toggleMagasin()" required>
                        <option value="sortie">Sortie simple</option>
                        <option value="transfert">Transfert de stock</option>
                    </select>
                </div>
                <div class="col-md-6 mb-4">
                    <label class="form-label">Quantité Prévue</label>
                    <input type="number" name="quantite" class="form-control" min="1" placeholder="Ex: 10" required>
                </div>
            </div>

            <div class="mb-4 d-none" id="magasin_field">
                <label class="form-label text-primary">Magasin de Destination</label>
                <select name="magasin_dest" class="form-select " >
                    <?php foreach($magasins as $m): ?>
                        <option value="<?= $m['id_magasin'] ?>"><?= $m['nom_magasin'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="d-grid mt-2">
                <button type="submit" name="envoyer_demande" class="btn btn-primary w-100">
                    <i class="bi bi-send-fill me-2"></i> Envoyer la Demande
                </button>
            </div>
        </form>
    </div>
</div>
<script>
    
function toggleMagasin() {
    // bech enjib typpe mouvement ou en7outha fi  variable type  
    var type = document.getElementById('type_action').value;
    
    var field = document.getElementById('magasin_field');

    
    if(type === 'transfert') {
        // ken mouvement tranfere eifasekh d_none hya  eli teKHfi label
        field.classList.remove('d-none'); // afficher 
    } else {
        field.classList.add('d-none');   
    }
}
</script>
</body>
</html>