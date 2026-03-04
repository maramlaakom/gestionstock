<?php

require_once '../../includes/connexion.php';
require_once '../../employe_stock/auth.php';
require_role(["Admin"]);
// ki telzel ela modifier howa eihezek ela lien page modifier ou em3a lien tal9a id emta3 article eli bech etbatlou
//ki etjibou testa3mel get 
if (!isset($_GET['id'])) {
    header("Location: gestionarticle.php");
    exit;
}

$id = intval($_GET['id']);
// etjb  dooner  article elkol  eli id haki eli jebetha em3a lien  joiin zaita 3alakhater  maneset7a9ouch ela dooner e=magasin eli feha article ou
// 7ata fi champ eli lazem eikoun selected 3ala nom_magasin nom eijbha m'en $m ma3naha eli 3antha nafes id_magasin 
//m'en tabkeau $magasin hya eli etkoun selected 
$stmt = $pdo->prepare("SELECT a.*/*, m.nom_magasin*/ FROM article a /*LEFT JOIN magasin m ON a.id_magasin = m.id_magasin*/ WHERE a.id_article = ?");
$stmt->execute([$id]);
//$article = $stmt->fetch(PDO::FETCH_ASSOC);
$article = $stmt->fetch();
//ken id khalet mahouch es7i7 etwali yatla3lek fi page ken estar eli fi die 
if (!$article) {
    die("Article introuvable");
}
/* hne masta3maltech try/catch nela fama  ken uptade ken maseretech maietacher chay em3aha */
$magasins = $pdo->query("SELECT * FROM magasin")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom']);
    $modele = trim($_POST['modele']);
    $sn = trim($_POST['sn']);
     $prix = floatval($_POST['prix']);
    $id_magasin = intval($_POST['id_magasin']);

    $stmt = $pdo->prepare("UPDATE article SET nom_article = ?, modele = ?, numero_serie = ?, cout = ?, id_magasin = ? WHERE id_article = ?");
    // ken modifier saret bes7i7 ou donner ejtita etbatlou fi bd wa9etha etraj3ek ela page gestionarticle 
    if ($stmt->execute([$nom, $modele, $sn, $prix, $id_magasin, $id])) {
        header("Location: gestionarticle.php");
       // exit etnajem etna7aha 3alakhater header jaya fi akher code php ou hya kima die etwa9ef elcode php 
       //ba3et exit header  eihezek ela page eli et7eb 3alaha autoumatique ba3et maIkamel if emta3ou ou exit etWa9ef elcode php bech ma3
       //ma3atech ya3mel chay 
       //  exit;

    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier Article</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
     <link rel="stylesheet" href="../../css/base.css">  
      <link rel="stylesheet" href="../../css/forms.css"> 

  
</head>
<body class="page-form"> 
    <div class="form-container"> 
        <h2>   <i class="bi bi-pencil-square"></i>Modifier l'article</h2>

        <form method="POST">
            <div class="mb-4">
                <label class="form-label">Nom de l'article <span class="required-star">*</span></label>
                <input type="text" name="nom" class="form-control" 
                       value="<?= htmlspecialchars($article['nom_article']) ?>" 
                       placeholder="Ex: Imprimante" required>
            </div>
            
            <div class="mb-4">
                <label class="form-label">Modèle</label>
                <input type="text" name="modele" class="form-control" 
                       value="<?= htmlspecialchars($article['modele']) ?>" 
                       placeholder="Ex: HP">
            </div>
            <!--value bech ki et7el bage tal9a ma9touba fi champ value cham eli mawjouta fi bd 
            ki etbatel champ toukhrej ou rt3awet tooutkhel tal9a fi champ el7aja eli bateltha -->
            <div class="mb-4">
                <label class="form-label">Numéro de série</label>
                <input type="text" name="sn" class="form-control" 
                       value="<?= htmlspecialchars($article['numero_serie']) ?>"
                         placeholder="donner le numero de serie " >
            </div>
            
            <div class="mb-4">
                <label class="form-label">Magasin <span class="required-star">*</span></label>
                <select name="id_magasin" class="form-select" required>
                    <option value="">-- Choisir magasin --</option>
                    <?php foreach ($magasins as $m): ?>
                        <option value="<?= $m['id_magasin'] ?>" <?=/**ken el9ima eli fi m hya nafesha eli ekhtarha e9bel wa9etha et7out se
                         * selected  bech  tou4her fi champ ou ya3ref alahi eli moukhtara ken mat7outech selected tou4hernek 
                         * fi champ awel option ou ken et7outha tou4hernek value emta7a eli hya $m['id_magasin'] */ ($m['id_magasin'] == $article['id_magasin']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($m['nom_magasin']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <hr class="section-divider">
            
            <div class="mb-4">
                <label class="form-label">Prix unitaire (DT) <span class="required-star">*</span></label>
                <input type="number" step="0.01" name="prix" class="form-control" 
                       value="<?= $article['cout'] ?>" 
                       placeholder="000" required>
            </div>
            
            <div class="row g-3"> 
                <div class="col-6">
                    <button type="submit" class="btn btn-primary w-100"> Mettre a jour</button>
                </div>
                <!-- ha4oum tab3in btn annuler  d-flex align-items-center justify-content-center" style="height: 48px; text-decoration: none;-->
                <div class="col-6">
                    <a href="gestionarticle.php" class="btn btn-secondary w-100 ">
                        Annuler
                    </a>
                </div>
            </div>
        </form>
    </div>

</body>
</body>
</html>

