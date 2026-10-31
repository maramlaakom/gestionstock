<?php 
require_once '../../includes/connexion.php';
require_once '../../employe_stock/auth.php';
require_role(["Admin"]);
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
    <link rel="stylesheet" href="../../css/cards.css"> 
</head>



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

    <div class="search-container ">
        <form method="GET" >
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
                <h4 class="mt-3 fw-bold" style="color: var(--primary);">Aucun utilisateur trouve</h4>
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
                                if($u['role'] == 'Admin') echo "Tous les acces";
                                elseif($u['role'] == 'employe_stock') echo "Sorties, entres, Transferts, Consultation";
                            ?>
                        </span>
                    </div>

                    <div class="mb-4">
                        <span class="small text-primary fw-bold">
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
</div>
</body>

</html>