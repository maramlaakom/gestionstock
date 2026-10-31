<?php
require_once "auth.php";
require_role([ "employe_stock"]); 
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>table de bord</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="../css/sidebar.css">
 <style>     
    body {
    display: flex;
    flex-direction: row;
}
    .main-container {
    flex: 1;
    height: 100vh;
    overflow: hidden;
}
iframe {
    width: 100%;
    height: 100%;
    border: none;
    display: block;
}
</style>

</head>
<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <h2><i class="bi bi-box2-fill"></i> StockSys</h2>
        </div>
        <nav class="nav-menu">
            <a href="index.php" class="menu-item " target="contentFrame"><i class="bi bi-grid"></i> Tableau de bord </a>
            <a href="../Admin/gestionmagasin/gestionmagasins.php" class="menu-item" target="contentFrame"><i class="bi bi-building"></i> Consulter magasin</a>
            <a href="../Admin/gestionarticle/gestionarticle.php" class="menu-item" target="contentFrame"> <i class="bi bi-box-seam"></i> Consulter Article</a>
            <a href="mouvement.php" class="menu-item" target="contentFrame"><i class="bi bi-card-checklist"></i> <span>Suivi des Demandes</span> </a>
            <a href="envoye_demande.php" class="menu-item" target="contentFrame"><i class="bi bi-send"></i> envoyer  Demandes</a>
            <a href="../Admin/gestionmouvement/entrestock.php" class="menu-item" target="contentFrame"><i class="bi bi-box-arrow-in-down"></i> entre stock</a>
            <a href="profile.php" class="menu-item" target="contentFrame"><i class="bi bi-person-gear"></i> Mon Profil</a>
          
                
        </nav> 

              <div class="logout-section">
            <a href="../secerity/logout.php" class="btn-logout"><i class="bi bi-box-arrow-right"></i> Deconnexion</a>   
        </div>
</div>

    <main class="main-container">
        <iframe name="contentFrame" src="index.php"></iframe>
    </main>
</body>
</html>
