<?php
require_once '../includes/connexion.php';
require_once '../employe_stock/auth.php';
require_role(["Admin"]);

// 1. جلب المنتجات التي كمية المخزون فيها أقل من أو يساوي 20
$alerts = $pdo->query("
    SELECT a.*, m.nom_magasin 
    FROM article a 
    LEFT JOIN magasin m ON a.id_magasin = m.id_magasin 
    WHERE a.quantite <= 20  AND  a.quantite > 0 AND a.etat = 'actif'
")->fetchAll(PDO::FETCH_ASSOC);

//enjib liste user eli role emta7oum admin bech ki eiwali articlme quantite emta3ou <20 yetba34ou li admin elkol
$stmt_admins = $pdo->query("SELECT id_utilisateur FROM utilisateur WHERE role = 'admin'");
$admins = $stmt_admins->fetchAll(PDO::FETCH_ASSOC);
// ma3naha ken en9e article ou admin
if (!empty($admins) && !empty($alerts)) {
    // eimp=our 3ala article elkol belwa7et belwa7et 
    foreach ($alerts as $article) {
        $contenu = "ALERTE STOCK: L'article '" . $article['nom_article'] . "' dans le magasin '" . $article['nom_magasin'] . "' est presque épuisé (Qte: " . $article['quantite'] . ").";
// ou eimour beladmin elkol bech yabe34elhoum alert         
        foreach ($admins as $admin) {
            $id_admin = $admin['id_utilisateur'];
            //tawa eichouf notification eli feha contenu eli bech taba34ou enti tawa ou ma9rahach admin elkol
            $check = $pdo->prepare("SELECT COUNT(*) FROM notification WHERE id_utilisateur = ? AND contenu = ? AND etat = 'non_lu'");
            $check->execute([$id_admin, $contenu]);
            //ken 3atet coloun emta3 tableau eli 3antha contenu nafsou =0 ei7outou fi tableau emta3notification wela mai7outouch lanou mawjout
            if ($check->fetchColumn() == 0) {
                // 4. إدخال التنبيه لكل آدمن على حدة
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