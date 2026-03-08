

<?php
require_once '../includes/connexion.php';
require_once "auth.php";
require_role(["employe_stock"]);

$msg = "";
$error = "";
    $id_user = $_SESSION['id_utilisateur'];
if (isset($_POST['envoyer_demande'])) {
    $id_art = $_POST['id_article'];
    $type = $_POST['type_action'];
    $qte = $_POST['quantite'];
    $id_magasin_dest = ($type === 'transfert') ? $_POST['magasin_dest'] : null;
    $stmt = $pdo->prepare("SELECT a.nom_article, m.nom_magasin, m.id_magasin FROM article a 
                           JOIN magasin m ON a.id_magasin = m.id_magasin 
                           WHERE a.id_article = ?");
    $stmt->execute([$id_art]);
    $art = $stmt->fetch();
    $nom_mag_dest = 'N/A';
    if ($type === 'transfert' && !empty($id_magasin_dest)) {
        $stmtMag = $pdo->prepare("SELECT nom_magasin FROM magasin WHERE id_magasin = ?");
        $stmtMag->execute([$id_magasin_dest]);
        $resMag = $stmtMag->fetch();
        $nom_mag_dest = $resMag['nom_magasin'] ;
    }
    $stmtUser = $pdo->prepare("SELECT prenom, nom FROM utilisateur WHERE id_utilisateur = ?");
    $stmtUser->execute([$id_user]);
    $user = $stmtUser->fetch();

    $magasin_source_nom = $art['nom_magasin'];
    $id_magasin_source = $art['id_magasin'];
    if ($type === 'transfert' && intval($id_magasin_source) === intval($id_magasin_dest)) {
        $error = "Erreur : Le magasin de destination doit être différent du magasin actuel ($magasin_source_nom) !";
    } else {
        $nom_complet = ($user['prenom'] ?? '') . ' ' . ($user['nom'] ?? '');
        $message = "DEMANDE_ACCES | Employé: {$nom_complet} | Art: {$art['nom_article']} | Qty: {$qte} | Type: {$type} | From: {$magasin_source_nom} | To: {$nom_mag_dest}";
        $ins = $pdo->prepare("INSERT INTO demande_contact 
            (id_utilisateur, id_article, id_magasin_dest, qte_demande, sujet, message, date_demande, statut) 
            VALUES (?, ?, ?, ?, 'DEMANDE PERMISSION', ?, NOW(), 'en_attente')");
        
        if ($ins->execute([$id_user, $id_art, $id_magasin_dest, $qte, $message])) {
            $msg = "Demande envoyée avec succès !";
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
$articles = $pdo->query("SELECT a.*, m.nom_magasin FROM article a JOIN magasin m ON a.id_magasin = m.id_magasin WHERE a.etat = 'actif'AND quantite > 0")->fetchAll();
$magasins = $pdo->query("SELECT * FROM magasin")->fetchAll();

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Demande de Permission Detaillee</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="../css/forms.css">
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
    var type = document.getElementById('type_action').value;    
    var field = document.getElementById('magasin_field'); 
    if(type === 'transfert') {
        field.classList.remove('d-none');  
    } else {
        field.classList.add('d-none');   
    }
}
</script>
</body>
</html>