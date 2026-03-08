<?php
require_once '../../includes/connexion.php';
require_once '../../employe_stock/auth.php';
require_role(["Admin"]);
if (!isset($_GET['id'])) {
    header("Location: gestionmagasins.php");
    exit;
}
$id1 = $_GET['id'];
$sql = "SELECT id_article FROM article WHERE id_magasin = ? AND etat = 'actif' AND quantite > 0";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id1]);
$articles = $stmt->fetchAll();
if (empty($articles)) {
    $sql_delete = "DELETE FROM magasin WHERE id_magasin = ?";
    $stmt_del = $pdo->prepare($sql_delete);
    $stmt_del->execute([$id1]); 
} 
if (empty($articles)) {
    header("Location: gestionmagasins.php?msg=deleted");
} else {
    header("Location: gestionmagasins.php?msg=erreur");
}
exit;
