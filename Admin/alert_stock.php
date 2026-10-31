<?php
require_once '../includes/connexion.php';
require_once '../employe_stock/auth.php';
require_role(["Admin"]);
$alerts = $pdo->query("
    SELECT a.*, m.nom_magasin 
    FROM article a 
     JOIN magasin m ON a.id_magasin = m.id_magasin 
    WHERE a.quantite <= 20 AND a.quantite > 0")->fetchAll();
$stmt_admins = $pdo->query("SELECT id_utilisateur FROM utilisateur WHERE role = 'Admin'");
$admins = $stmt_admins->fetchAll();

if (!empty($admins) && !empty($alerts)) {
    foreach ($alerts as $article) {
        $contenu = "ALERTE STOCK: L'article '" . $article['nom_article'] . "' dans le magasin '" . $article['nom_magasin'] . "' est presque epuise (Qte: " . $article['quantite'] . ").";      
        $insert_notif = $pdo->prepare("INSERT INTO notification (contenu, etat, date_notification) VALUES (?, 'non_lu', NOW())");
        $insert_notif->execute([$contenu]);
        $id_notification = $pdo->lastInsertId();
        $insert = $pdo->prepare("INSERT INTO notification_utilisateur (id_notification, id_utilisateur) VALUES (?, ?)");
        foreach ($admins as $admin) {
            $id_admin = $admin['id_utilisateur'];
            $insert->execute([$id_notification, $id_admin]);
        }
    }
}
?>