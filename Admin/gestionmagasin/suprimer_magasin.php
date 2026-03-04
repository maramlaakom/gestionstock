<?php
require_once '../../includes/connexion.php';
require_once '../../employe_stock/auth.php';
require_role(["Admin"]);
/**AAA  3amalt delet 3atya lana ken bech etfasekh  matnejemech etna7a ou article fi woustha
 *  michal ken enti ma3atech tekhtem bi magasin etwali et7awel article ba3et etfasekha heka 
 * historique mouvement mat4i3ech ou howa historique ma3mouna bech ei4abet fi mouvement stock emta3 article  */
if (!isset($_GET['id'])) {
    header("Location: gestionmagasins.php");
    exit;
}

$id1 = $_GET['id'];
// ha4i bech etchiouf article eli fi magasiin eli et7eb etfaskhou 
$sql = "SELECT id_article FROM article WHERE id_magasin = ? AND etat = 'actif' AND quantite > 0";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id1]);
$articles = $stmt->fetchAll();
// ken mafama 7ata article  yetfasekh ama ken fama maietfasakhech 
if (empty($articles)) {
    $sql_delete = "DELETE FROM magasin WHERE id_magasin = ?";
    $stmt_del = $pdo->prepare($sql_delete);
    $stmt_del->execute([$id1]);
   
} 
/// HA4i bech KI YENZel 3ala delet ya3ref fi page gestionarticle echnowa msg  affiche 
//ha4i ken article ferekh ma3laha mafama 7ata article fi magaasin bech tab3eth kelmet deleted o
if (empty($articles)) {
    // كود الحذف
    header("Location: gestionmagasins.php?msg=deleted");
} else {
    // ou ken mahich ferkha bech etwali tab3a4 kelma  error 
    header("Location: gestionmagasins.php?msg=erreur");
}
exit;

//header("Location: gestionmagasins.php");
//exit;

