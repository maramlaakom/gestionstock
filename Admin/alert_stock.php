<?php
require_once '../includes/connexion.php';
require_once '../employe_stock/auth.php';
require_role(["Admin"]);
$alerts = $pdo->query("
    SELECT a.*, m.nom_magasin 
    FROM article a 
    LEFT JOIN magasin m ON a.id_magasin = m.id_magasin 
    WHERE a.quantite <= 20  AND  a.quantite > 0 AND a.etat = 'actif'
")->fetchAll(PDO::FETCH_ASSOC);
$stmt_admins = $pdo->query("SELECT id_utilisateur FROM utilisateur WHERE role = 'admin'");
$admins = $stmt_admins->fetchAll(PDO::FETCH_ASSOC);
if (!empty($admins) && !empty($alerts)) {
    foreach ($alerts as $article) {
        $contenu = "ALERTE STOCK: L'article '" . $article['nom_article'] . "' dans le magasin '" . $article['nom_magasin'] . "' est presque épuisé (Qte: " . $article['quantite'] . ").";      
        foreach ($admins as $admin) {
            $id_admin = $admin['id_utilisateur'];
            $check = $pdo->prepare("SELECT COUNT(*) FROM notification WHERE id_utilisateur = ? AND contenu = ? AND etat = 'non_lu'");
            $check->execute([$id_admin, $contenu]);
            if ($check->fetchColumn() == 0) {
                $insert_notif = $pdo->prepare("
                    INSERT INTO notification (id_utilisateur, contenu, etat, date_notification) 
                    VALUES (?, ?, 'non_lu', NOW())
                ");
                $insert_notif->execute([$id_admin, $contenu]);
            }
        }
    }
}
?>