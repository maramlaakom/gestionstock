<?php

require_once __DIR__ . '/../../includes/connexion.php';
require_once '../../employe_stock/auth.php';
require_role(["Admin"]);
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = ($_POST['nom']);
    $prenom = $_POST['prenom']; 
    $email = $_POST['email'];
    $role = $_POST['role'];
    
   
    $mdp = password_hash($_POST['mot_de_passe'], PASSWORD_DEFAULT); 

    $stmt = $pdo->prepare("
        INSERT INTO utilisateur (nom, prenom, email, mot_de_passe, role, etat_compte)
        VALUES (?, ?, ?, ?, ?, 'actif')
    ");
  if(  $stmt->execute([$nom, $prenom, $email, $mdp, $role])){
        header("Location: listeutilisateur.php");
    exit;
      }  
   

    
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StockSys - Ajouter Utilisateur</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <link rel="stylesheet" href="../../css/base.css">  
    <link rel="stylesheet" href="../../css/forms.css"> 
</head> 

<body class="page-form"> 
    <div class="form-container"> 
        <h2 class=" text-center mb-4">
            <i class="bi bi-person-plus"></i> Ajouter Utilisateur
        </h2>

        <form method="POST">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nom <span class="required-star">*</span></label>
                    <input type="text" name="nom" class="form-control" placeholder="Nom" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Prenom <span class="required-star">*</span></label>
                    <input type="text" name="prenom" class="form-control" placeholder="Prénom" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Email <span class="required-star">*</span></label>
                <input type="email" name="email" class="form-control" placeholder="exemple@mail.com" required autocomplete="off">
            </div>

            <div class="mb-3">
                <label class="form-label">Mot de passe <span class="required-star">*</span></label>
                <input type="password" name="mot_de_passe" class="form-control" placeholder="••••••••" required autocomplete="new-password"> 
            </div>

            <div class="mb-4">
                <label class="form-label">Role <span class="required-star">*</span></label>
                <select name="role" class="form-select">
                    
                    <option >choisir le role </option>
                    <option value="Admin">Admin</option>
                    <option value="employe_stock">employe_stock</option>
                </select>
            </div>

            
                 <div class="d-flex gap-3">
                  <button type="submit" class="btn btn-primary w-100">ajouter </button>
                    </button>
                  <a href="listeutilisateur.php" class="btn btn-secondary w-100 ">
                        Annuler
                    </a>
                </div>
            </div>
        </form>
    </div>
</body>
</body>
</html>