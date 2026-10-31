//
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/base.css">
    
<style>
.dashboard-mouvement {
    display: flex;
    justify-content: center;
    gap: 25px;
    padding: 50px 20px;
}
.mvt-card-custom {
    flex: 1;
    max-width: 350px;
    min-height: 280px;
    text-align: center;
    text-decoration: none ;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 40px 20px;
    background: white ;
    border: 2px solid var(--secondary) ; 
    border-radius: 15px ;
    transition: transform 0.3s ease;
}
.mvt-card-custom:hover {
    transform: translateY(-5px);
      box-shadow: 0 0 0 .25rem rgba(73, 149, 224, 0.3);
}
.icon-circle {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 20px;
    font-size: 28px;
    font-weight: bold;
}
.bg-entree { background-color: #e8f8f5; color: #2ecc71; }
.bg-sortie { background-color: #fdedec; color: #e74c3c; }
.bg-transfert { background-color: #ebf5fb; color: #3498db; }
.mvt-card-custom h3 {
    color: var(--primary); 
    font-size: 20px;
    margin-bottom: 10px;
    font-weight: bold;
}

.mvt-card-custom p {
    color: var(--text-muted); 
    font-size: 14px;
    margin: 0;
}


</style>
</head>
<body>
    <?php
require_once '../../includes/connexion.php';
require_once '../../employe_stock/auth.php';
require_role(["Admin"]);
?>


<div class="dashboard-mouvement">
    <a href="entrestock.php" class=" mvt-card-custom">
        <div class="icon-circle bg-entree"> <i class="bi bi-plus-lg"> </i></div>
        <h3>Entree de Stock</h3>
        <p>Ajouter des articles au stock</p>
    </a>

    <a href="sortiestock.php" class=" mvt-card-custom">
        <div class="icon-circle bg-sortie"> <i class="bi bi-dash-lg"> </i></div>
        <h3>Sortie de Stock</h3>
        <p>Retirer des articles du stock</p>
    </a>

    <a href="transfere.php" class=" mvt-card-custom">
        <div class="icon-circle bg-transfert"> <i class="bi bi-arrow-left-right"> </i></div>
        <h3>Transfert</h3>
        <p>Transferer entre magasins</p>
    </a>
</div>

    
</body>
</html>

