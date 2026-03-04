<?php 
/*
require_once __DIR__ . '/../../includes/connexion.php';

// جلب البيانات مع التأكد من أسماء الأعمدة الصحيحة
$users = $pdo->query("SELECT * FROM utilisateur")->fetchAll(PDO::FETCH_ASSOC); 
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between mb-3">
        <h2>Liste des Utilisateurs</h2>
        <a href="add_user.php" class="btn btn-primary">➕ Ajouter</a>
    </div>
    <table class="table table-hover shadow-sm">
        <thead class="table-dark">
            <tr>
                <th>Nom & Prénom</th>
                <th>Email</th>
                <th>Rôle</th>
                <th>État</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $u): ?>
            <tr>
                <td><?= htmlspecialchars($u['nom'] . ' ' . $u['prenom']) ?></td>
                <td><?= htmlspecialchars($u['email']) ?></td>
                <td><span class="badge bg-info"><?= $u['role'] ?></span></td>
                <td>
                    <span class="badge <?= $u['etat_compte'] == 'actif' ? 'bg-success' : 'bg-danger' ?>">
                        <?= $u['etat_compte'] ?>
                    </span>
                </td>
                <td>
                    <a href="edit_user.php?id=<?= $u['id_utilisateur'] ?>" class="btn btn-warning btn-sm">✏️</a>
                    <a href="delete_user.php?id=<?= $u['id_utilisateur'] ?>" 
                       class="btn btn-danger btn-sm"
                       onclick="return confirm('Voulez-vous vraiment bloquer cet utilisateur ?')">
                       
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
*/
/*

require_once __DIR__ . '/../../includes/connexion.php';
//stocke  d tous le utilisateur m'en BD 
$users = $pdo->query("SELECT * FROM utilisateur")->fetchAll(PDO::FETCH_ASSOC); 
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { background-color: #f8f9fa; font-family: 'Segoe UI', sans-serif; }
        .user-card { border: none; border-radius: 15px; transition: 0.3s; height: 100%; }
        .user-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important; }
        .avatar-circle { width: 50px; height: 50px; background: #6366f1; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 20px; }
        .badge-admin { background-color: #fee2e2; color: #ef4444; }
        .badge-employe { background-color: #dbeafe; color: #3b82f6; }
        .status-dot { width: 10px; height: 10px; border-radius: 50%; display: inline-block; margin-right: 5px; }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="fw-bold mb-0"><i class="bi bi-shield-check"></i> Gestion des Utilisateurs</h2>
            <p class="text-muted">Gerer les utilisateurs et leurs permissions</p>
        </div>
        <a href="adduser.php" class="btn btn-dark rounded-pill px-4 shadow-sm">
            <i class="bi bi-plus-lg"></i> Nouvel Utilisateur
        </a>
    </div>

    <div class="row g-4">
        <?php foreach ($users as $u): 
          // declaration le variable pour choisir par rapport le  role le designe de card si role 
          //=admin affiche  designe  card  user  badge-admin ou =employe affiche  designe  card  user badge-employe
            $role_class = " ";
            if ($u['role'] == 'Admin') $role_class = 'badge-admin';
            else/* ($u['role'] == 'Employe')  $role_class = 'badge-employe';
        ?>
            <div class="col-md-4">
                <div class="card user-card shadow-sm p-4">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div class="avatar-circle">
                            <i class="bi bi-person-fill"></i>
                        </div>
                <span class="badge rounded-pill <?php echo $role_class; ?> px-3 py-2">
                <?php echo $u['role']; ?>
                </span>
                    </div>
                    
                    <h5 class="fw-bold mb-1"><?php echo  htmlspecialchars($u['nom'] . ' ' . $u['prenom']) ?></h5>
                    <p class="text-muted small mb-4"><?php/* pour afficher email user eli jabou m'en BD  echo htmlspecialchars($u['email']) ?></p>
                    
                    <div class="mb-4">
                        <label class="text-muted small d-block mb-1">Permissions</label>
                        <span class="small fw-semibold text-dark">
                            <?php 
                                if($u['role'] == 'Admin') echo "Tous les acces";
                                elseif($u['role'] == 'Employe') echo "Sorties, Transferts, Consultation";
                                
                            ?>
                        </span>
                    </div>

                    <div class="mb-4">
                        <? //  class="small bech takhtar loun   ken condition es7i7 'etat_compte' bi loul  text-success ou ken khalta bi loul text-danger   ?>
                        <span class="small <?= /* <?= comme <?php echo   $u['etat_compte'] == 'actif' ? 'text-success' : 'text-danger' ?> fw-bold">
                            <?// haki condition takhtar backround ?>
                            <span class="status-dot <?= $u['etat_compte'] == 'actif' ? 'bg-success' : 'bg-danger' ?>"></span>
                            <?=/* ucfirst pur afficher le mot premier 7aref en majus et ba9i bi miniscule  ucfirst($u['etat_compte']) ?>
                        </span>
                    </div>

                    <div class="d-flex gap-2 border-top pt-3">
                        <a href="modifieruser.php?id=<?= $u['id_utilisateur'] ?>" class="btn btn-light flex-grow-1 border">
                            <i class="bi bi-pencil-square"></i> Modifier
                        </a>
                        <a href="deleteuser.php?id=<?= $u['id_utilisateur'] ?>" 
                         class="btn btn-light text-danger border"
                          <?php // oncllick :  hya tekhtem  ki tenzel 3ala lien ?>
                    onclick="return  confirm('Voulez-vous vraiment supprimer cet utilisateur ?')">
                 <i class="bi bi-trash"></i>
                    </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    // oncllick :  hya tekhtem  ki tenzel 3ala lien

    <div class="card mt-5 border-0 shadow-sm p-4 rounded-4 bg-white">
        <h6 class="fw-bold mb-3">Description des Roles</h6>
        <div class="row small g-3">
            <div class="col-md-4">
                <span class="badge badge-employe mb-2">Employe</span>
                <p class="text-muted mb-0">Peut effectuer des sorties de stock et transfere </p>
            </div>
            <div class="col-md-4">
                <span class="badge badge-admin mb-2">Administrateur</span>
                <p class="text-muted mb-0">Acces complet: gestion des magasins, articles, dashboard, et utilisateurs.</p>
            </div>
        </div>
    </div>
</div>

</body>
</html>
*/
/*
require_once __DIR__ . '/../../includes/connexion.php';


$search = isset($_GET['search']) ? trim($_GET['search']) : "";

if ($search != "") {
    $stmt = $pdo->prepare("SELECT * FROM utilisateur 
                           WHERE (nom LIKE ? OR prenom LIKE ? OR email LIKE ?)AND etat_compte = 'actif'");;
    $stmt->execute(["%$search%", "%$search%", "%$search%"]);
} else {
    $stmt = $pdo->query("SELECT * FROM utilisateur WHERE etat_compte = 'actif' ");
}

$users = $stmt->fetchAll(PDO::FETCH_ASSOC); 
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { background-color: #f8f9fa; font-family: 'Segoe UI', sans-serif; }
        .user-card { border: none; border-radius: 15px; transition: 0.3s; height: 100%; display: flex; flex-direction: column; }
        .user-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important; }
        .avatar-circle { width: 50px; height: 50px; background: #6366f1; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 20px; }
        .badge-admin { background-color: #fee2e2; color: #ef4444; }
        .badge-employe { background-color: #dbeafe; color: #3b82f6; }
        .status-dot { width: 10px; height: 10px; border-radius: 50%; display: inline-block; margin-right: 5px; }
        .search-bar { border-radius: 20px; border: 1px solid #ddd; padding-left: 20px; }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0"><i class="bi bi-shield-check"></i> Gestion des Utilisateurs</h2>
            <p class="text-muted">Gerer les utilisateurs et leurs permissions</p>
        </div>
        <a href="adduser.php" class="btn btn-dark rounded-pill px-4 shadow-sm">
            <i class="bi bi-plus-lg"></i> Nouvel Utilisateur
        </a>
    </div>

    <form method="GET" class="mb-5">
        <div class="input-group shadow-sm rounded-pill overflow-hidden">
            <input type="text" name="search" class="form-control border-0 p-3 px-4" placeholder="Rechercher par nom, prénom ou email..." value="<?= htmlspecialchars($search) ?>">
            <button class="btn btn-primary px-4"><i class="bi bi-search"></i></button>
        </div>
    </form>

    <div class="row g-4">
        <?php foreach ($users as $u): 
            $role_class = ($u['role'] == 'Admin') ? 'badge-admin' : 'badge-employe';
        ?>
            <div class="col-md-4">
                <div class="card user-card shadow-sm p-4">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div class="avatar-circle">
                            <i class="bi bi-person-fill"></i>
                        </div>
                        <span class="badge rounded-pill <?php echo $role_class; ?> px-3 py-2">
                            <?php echo $u['role']; ?>
                        </span>
                    </div>
                    
                    <h5 class="fw-bold mb-1"><?php echo htmlspecialchars($u['nom'] . ' ' . $u['prenom']) ?></h5>
                    <p class="text-muted small mb-4"><?php /* pour afficher email user eli jabou m'en BD *//* echo htmlspecialchars($u['email']) ?></p>
                    
                    <div class="mb-3">
                        <label class="text-muted small d-block mb-1">Permissions</label>
                        <span class="small fw-semibold text-dark">
                            <?php 
                                if($u['role'] == 'Admin') echo "Tous les acces";
                                elseif($u['role'] == 'Employe') echo "Sorties, Transferts, Consultation";
                            ?>
                        </span>
                    </div>

                    <div class="mb-4">
                        <span class="small <?= $u['etat_compte'] == 'actif' ? 'text-success' : 'text-danger' ?> fw-bold">
                            <span class="status-dot <?= $u['etat_compte'] == 'actif' ? 'bg-success' : 'bg-danger' ?>"></span>
                            <?= ucfirst($u['etat_compte']) ?>
                        </span>
                    </div>

                    <div class="d-flex gap-2 border-top pt-3 mt-auto">
                        <a href="modifieruser.php?id=<?= $u['id_utilisateur'] ?>" class="btn btn-light flex-grow-1 border">
                            <i class="bi bi-pencil-square"></i> Modifier
                        </a>
                        <a href="deleteuser.php?id=<?= $u['id_utilisateur'] ?>" 
                           class="btn btn-light text-danger border"
                           onclick="return confirm('Voulez-vous vraiment supprimer cet utilisateur ?')">
                            <i class="bi bi-trash"></i>
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="card mt-5 border-0 shadow-sm p-4 rounded-4 bg-white">
        <h6 class="fw-bold mb-3">Description des Roles</h6>
        <div class="row small g-3">
            <div class="col-md-4">
                <span class="badge badge-employe mb-2">Employe</span>
                <p class="text-muted mb-0">Peut effectuer des sorties de stock et transfere </p>
            </div>
            <div class="col-md-4">
                <span class="badge badge-admin mb-2">Administrateur</span>
                <p class="text-muted mb-0">Acces complet: gestion des magasins, articles, dashboard, et utilisateurs.</p>
            </div>
        </div>
    </div>
</div>
</body>
</html>
*/

require_once '../../includes/connexion.php';
require_once '../../employe_stock/auth.php';
require_role(["Admin"]);
/*bahi 3alach ki nelzel 3ala recherche maitla3ech lien 3alakhater ani esta3malet iframe hya  fi d
dashbord ma3naha     elkhetma elkol etsir fi page dashbord wa9et testa3mel iframe enti 3antek 2 paget ma7louli fi nafes el wa9et
page eloul hya  eloum eli feha iframe eli tet7al feha page oukhra ou hya eli lie,n emta7a you 4her fi url
page 2 hya gestion article hya ekli mawjouta takhel iframe hya tet7ali fi woust iframe

*/

if (isset($_GET['search'])) {
    $search = $_GET['search'];
} else {
    $search = "";
}


if ($search != "") {
    $stmt = $pdo->prepare("SELECT * FROM utilisateur 
                           WHERE (nom LIKE ? OR prenom LIKE ? OR email LIKE ?) AND etat_compte = 'actif'");
    $stmt->execute(["%$search%", "%$search%", "%$search%"]);
} else {
    $stmt = $pdo->query("SELECT * FROM utilisateur WHERE etat_compte = 'actif'");
}

$users = $stmt->fetchAll(); 
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Utilisateurs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    
    <link rel="stylesheet" href="../../css/base.css">
    <link rel="stylesheet" href="../../css/cards.css"> </head>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Utilisateurs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../../css/base.css">
    <link rel="stylesheet" href="../../css/cards.css">
</head>
<body>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-0"><i class="bi bi-shield-check"></i> Gestion des Utilisateurs</h2>
            <p class="text-muted small">Gérer les utilisateurs et leurs permissions</p>
        </div>
        <a href="adduser.php" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-lg"></i> Nouvel Utilisateur
        </a>
    </div>

    <div class="search-container shadow-sm">
        <form method="GET">
            <div class="input-group">
                <input type="text" name="search" class="form-control p-3" placeholder="Rechercher...">
                <button class="btn btn-primary px-4"><i class="bi bi-search"></i></button>
            </div>
        </form>
    </div>

     <div class="row g-4">
    <?php if (empty($users)): ?>
        <div class="col-12">
            <div class="no-results shadow-sm">
                <i class="bi bi-person-x" style="font-size: 4rem; color: var(--secondary);"></i>
                <h4 class="mt-3 fw-bold" style="color: var(--primary);">Aucun utilisateur trouvé</h4>
                <p class="text-muted">Essayez une autre recherche ou ajoutez un nouvel utilisateur</p>
            </div>
        </div>

    <?php else: ?>
        <?php foreach ($users as $u): 
            $role_badge = ($u['role'] == 'Admin') ? 'bg-admin' : 'bg-employe';
        ?>
            <div class="col-md-4">
                <div class="user-card">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div class="avatar-circle">
                            <i class="bi bi-person-fill"></i>
                        </div>
                        <span class="badge rounded-pill <?= $role_badge ?> px-3 py-2">
                            <?= htmlspecialchars($u['role']) ?>
                        </span>
                    </div>
                    
                    <h5 class="fw-bold mb-1 text-primary"><?= htmlspecialchars($u['nom'] . ' ' . $u['prenom']) ?></h5>
                    <p class="text-muted small mb-4"><?= htmlspecialchars($u['email']) ?></p>
                    
                    <div class="mb-4">
                        <label class="text-muted small d-block mb-1 fw-bold">Permissions</label>
                        <span class="small text-dark">
                            <?php 
                                if($u['role'] == 'Admin') echo "Tous les accès";
                                elseif($u['role'] == 'employe_stock') echo "Sorties, entres, Transferts, Consultation";
                            ?>
                        </span>
                    </div>

                    <div class="mb-4">
                        <span class="small text-primary fw-bold">
                            <!--span class="status-dot"></span>-->
                            <?= ucfirst(htmlspecialchars($u['etat_compte'])) ?>
                        </span>
                    </div>

                    <div class="d-flex gap-2 border-top pt-3 mt-auto">
                        <a href="modifieruser.php?id=<?= $u['id_utilisateur'] ?>" class="btn btn-outline-primary flex-grow-1">
                            <i class="bi bi-pencil-square"></i> Modifier
                        </a>
                        <a href="deleteuser.php?id=<?= $u['id_utilisateur'] ?>" 
                           class="btn btn-outline-danger"
                           onclick="return confirm('Voulez-vous vraiment supprimer cet utilisateur ?')">
                            <i class="bi bi-trash"></i>
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

  <!--  <div class="stat-card mt-5">
        <h6 class="fw-bold mb-3 text-primary">Description des Rôles</h6>
        <div class="row small g-3">
            <div class="col-md-6 border-end">
                <span class="badge bg-employe mb-2">Employé</span>
                <p class="text-muted mb-0">Peut effectuer des sorties de stock et des transferts.</p>
            </div>
            <div class="col-md-6">
                <span class="badge bg-admin mb-2">Administrateur</span>
                <p class="text-muted mb-0">Accès كامل لإدارة النظام والمستخدمين.</p>
            </div>
        </div>
    </div>-->
</div>
</body>

</html>