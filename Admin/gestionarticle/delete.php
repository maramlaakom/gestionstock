
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

$stmt = $pdo->prepare("SELECT quantite, id_magasin FROM article WHERE id_article = ? AND  quantite > 0 ");
$stmt->execute([$id]);
$art = $stmt->fetch();

if ($art) {
    try {
        $pdo->beginTransaction();
          $stmt_mag = $pdo->prepare("SELECT nom_magasin FROM magasin WHERE id_magasin = ?");
            $stmt_mag->execute([$art["id_magasin"]]);
            $mag = $stmt_mag->fetch();
            $nom_magasin = $mag['nom_magasin'];
        $sql_update = "UPDATE article SET  quantite = 0 WHERE id_article = ?";
        $stmt_update = $pdo->prepare($sql_update);
        $stmt_update->execute([$id]);
        $com = "Article retire par " . $nom_user . "  " . $prenom_user . "  "." du magasin : "."  " . $nom_magasin;
        $sql_hist = "
            INSERT INTO historique_movement 
            (id_article, type_mouvement, quantite, id_utilisateur, commentaire)
            VALUES (?, 'sortie', ?,?, ?)
        ";
        $stmt_hist = $pdo->prepare($sql_hist);6
        $stmt_hist->execute([
            $id,
            $art['quantite'],
            $id_user, 
            $com
        ]);

        $pdo->commit();

    } catch (Exception $e) {
        $pdo->rollBack();
        die("Erreur lors de la suppression : " . $e->getMessage());
    }
}

header("Location: gestionarticle.php");
exit;
