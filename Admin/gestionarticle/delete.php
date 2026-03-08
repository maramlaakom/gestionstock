
<?php
require_once '../../includes/connexion.php';
require_once '../../employe_stock/auth.php';
require_role(["Admin"]);
if (!isset($_GET['id'])) {
    header("Location: gestionarticle.php");
    exit;
}

$id = intval( $_GET['id']);

$id_user = $_SESSION['id_utilisateur'] ;
$nom_user = $_SESSION['nom'] ;
$prenom_user = $_SESSION['prenom'];

$stmt = $pdo->prepare("SELECT quantite, id_magasin FROM article WHERE id_article = ? AND etat = 'actif'");
$stmt->execute([$id]);
$art = $stmt->fetch();

if ($art) {
    try {
        $pdo->beginTransaction();
        $com= "Suppression definitive par  " . $nom_user ." " .$prenom_user;
        $sql_hist = "
            INSERT INTO historique_movement 
            (id_article, type_mouvement, quantite, id_utilisateur, id_magasin_src, commentaire)
            VALUES (?, 'sortie', ?, ?, ?, ?)
        ";
        $stmt_hist = $pdo->prepare($sql_hist);
        $stmt_hist->execute([
            $id,
            $art['quantite'],
            $id_user, 
            $art['id_magasin'],
            $com
        ]);
        $sql_update = "UPDATE article SET etat = 'supprime', quantite = 0 WHERE id_article = ?";
        $stmt_update = $pdo->prepare($sql_update);
        $stmt_update->execute([$id]);

        $pdo->commit();

    } catch (Exception $e) {
        $pdo->rollBack();
        die("Erreur lors de la suppression : " . $e->getMessage());
    }
}

header("Location: gestionarticle.php");
exit;
