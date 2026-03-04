<?php 
/*
require_once __DIR__ . '/../../includes/connexion.php';
$id = $_GET['id'];

//changer etat de compte  bloque
$stmt = $pdo->prepare("UPDATE utilisateur SET etat_compte='bloque' WHERE id_utilisateur=?");
$stmt->execute([$id]);
*/

require_once __DIR__ . '/../../includes/connexion.php';
require_once '../../employe_stock/auth.php';
require_role(["Admin"]);
if (!isset($_GET['id'])) {
    header("location:listeutilisateur.php");
    exit ;
}
$id = $_GET['id'];

//changer etat de compte  bloque
$stmt = $pdo->prepare("UPDATE utilisateur SET etat_compte='bloque' WHERE id_utilisateur=?");
$stmt->execute([$id]);

header("Location: listeutilisateur.php");
exit;
?>