<?php

// Démarrage de la session pour gérer l'authentification
require_once '../../employe_stock/auth.php';
require_role(["Admin","employe_stock"]);

// Inclusion du fichier de connexion à la base de données
require_once '../../includes/connexion.php';

// On vérifie si le rôle existe dans la session
//if (isset($_SESSION['role'])) {
    // Si oui, on utilise le rôle stocké
    $role = $_SESSION['role'];
//} else {
    // Sinon, on donne le rôle 'employee' par défaut
  //  $role = '';
//}

// Gestion de la recherche : récupération du mot-clé depuis l'URL
// nesta3mlou get lana elma3louma eli fi formulaire mahich mouhema 
if (isset($_GET['search'])) {
    $search = $_GET['search'];
} else {
    $search = "";
}


// Préparation et exécution de la requête SQL selon la recherche

// إبقاء منطق PHP والبحث كما هو

//$search = isset($_GET['search']) ? trim($_GET['search']) : "";

if ($search != "") {
    $stmt = $pdo->prepare("SELECT a.*, m.nom_magasin 
                           FROM article a 
                            JOIN magasin m ON a.id_magasin = m.id_magasin 
                           WHERE (a.nom_article LIKE ? OR a.modele LIKE ? OR m.nom_magasin LIKE ?  ) 
                           AND a.etat = 'actif'AND quantite >0");
    $stmt->execute(["%$search%", "%$search%", "%$search%"]);
} else {
    $stmt = $pdo->query("SELECT a.*, m.nom_magasin 
                         FROM article a 
                         JOIN magasin m ON a.id_magasin = m.id_magasin 
                         WHERE a.etat = 'actif'AND quantite >0");
}
//$articles = $stmt->fetchAll(PDO::FETCH_ASSOC); 
$articles = $stmt->fetchAll(); 
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalogue des Articles</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <link rel="stylesheet" href="../../css/base.css">
    <link rel="stylesheet" href="../../css/cards.css">
      <link rel="stylesheet" href="../../css/forms.css">
   <style>
    .bg1 { background-color: #7cbbff !important; color: black; }
.bg2 { background-color: #ff6f59 !important; color: black }
</style>
</head>
<body>
<!--container hya bootstrap bech hya ta3ti hya ta3ti 3ore4 max l'el page etwaset page oufou9ia nesta3malha fi page 3atia kima gestionarticle ou dashbord ou poage-form testa3malha bech et7out elpage fi wouset 3amoutia hya css enti  3amaltou    -->
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-0"><i class="bi bi-box-seam"></i> Gestion des Articles</h2>
            <p class="text-muted small ">Gérer le stock et les détails des articles</p>
        </div>
        <?php if($role == 'admin'): ?>
            <a href="ajoute.php" class="btn btn-primary ">
                <i class="bi bi-plus-lg"></i> Ajouter Article
            </a>
        <?php endif; ?>
    </div>

    <div class="search-container ">
        <!--The requested resource /Admin/gestionarticle/index.php?search=clavier was not found on this server. ki tekteb action ou testa3mel get recherche teteb3ath em3 lien 
        ki telzel 3ala button  donner emta3 formulaire yetba34ou le lien eli ectebtou fi action action  '(action="index.php")ou ki matekteb chay yeteb3ath ela nafes page emta3 formulaire '-->
        <form method="GET" >
            <div class="input-group">
                <input type="text" name="search" class="form-control p-3" placeholder="Rechercher un article...">
                <button class="btn btn-primary px-4"><i class="bi bi-search"></i></button>
            </div>
        </form>
    </div>
        <!--g-4 ha4i gap:4-->
    <div class="row g-4">
        <?php if (empty($articles)): ?>
            <div class="col-12">
                <div class="no-results ">
                    <i class="bi bi-inbox" style="font-size: 4rem; color: var(--secondary);"></i>
                    <h4 class="mt-3 fw-bold" style="color: var(--primary);">Aucun article trouvé</h4>
                    <p class="text-muted">Essayez une autre recherche ou ajoutez un nouvel article</p>
                </div>
            </div>
        <?php else: ?>
            <?php foreach ($articles as $a): ?>
                <div class="col-4">
            <!--user-card haki css ani 3amlou bech etnajem ta3mel card -->
                    <div class="user-card"> 
                        <div class="d-flex justify-content-between align-items-start mb-4">
                            <div class="avatar-circle">
                                <i class="bi bi-box-fill"></i>
                            </div>
                            <span class="badge rounded-pill <?= ($a['quantite'] > 20) ? 'bg1' : 'bg2' ?> px-3 py-2">
                                <?= $a['quantite'] ?> article
                            </span>
                        </div>
                        
                        <h5 class="fw-bold mb-1 text-primary"><?= htmlspecialchars($a['nom_article']) ?></h5>
                     <?php
                   /* if (isset($a['numero_serie']) && $a['numero_serie'] !== '') {
                            $numero = $a['numero_serie'];
                     else {
                            $numero = '---';
                            }
                   */ ?>
                    <p class="text-muted small mb-4">Réf: <?= htmlspecialchars($a['numero_serie']) ?></p>

                        
                        <div class="mb-4">
                            <label class="text-muted small d-block mb-1 fw-bold">Détails</label>
<!--small bech etsakher quantite emta3 div  -->
                            <div class="small text-dark">
                                <i class="bi bi-tag me-1"></i> <strong>Modèle:</strong> <?= htmlspecialchars($a['modele']) ?><br>
                                <i class="bi bi-shop me-1"></i> <strong>Magasin:</strong> <?= htmlspecialchars($a['nom_magasin'] /*?? 'Non assigné') */)?>
                            </div>
                        </div>
                        

                        <div class="mb-4">
                            <span class="small text-primary fw-bold">
                                 <span >Prix</span>
                        <span ><?= $a['cout']?> DT</span>
                               
                            </span>
                        </div>
                        
<!--pt-3 → padding-top من فوق (≈ 1rem)

mt-auto → margin-top: auto
-->
                        <div class="d-flex gap-2 pt-3 ">
                               <?php if(/*isset($role) && */$role == 'admin'): ?>
                            <a href="edit.php?id=<?= $a['id_article'] ?>"
                             class="btn btn-outline-primary flex-grow-1">
                                <i class="bi bi-pencil-square"></i> Modifier
                            </a>
                               <!--"btn btn-outline-danger" hua fi bootstrap ta3ti loul a7mer lel boutton -->
                            <a href="delete.php?id=<?= $a['id_article'] ?>" 
                               class="btn btn-outline-danger"
                               onclick="return confirm('Voulez-vous vraiment supprimer cet article ?')">
                                <i class="bi bi-trash"></i>
                            </a>
                                <?php endif; ?>

                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

</body>
</html>