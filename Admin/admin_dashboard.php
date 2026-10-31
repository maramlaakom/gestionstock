
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>StockSys - Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
<link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="../css/sidebar.css">
    <style>        
      body {
    display: flex;
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
}

    </style>
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <h2><i class="bi bi-box-seam"></i> StockSys</h2>
        </div>
       
        <div class="nav-menu">
            <a href="index.php" class="menu-item " target="contentFrame"><i class="bi bi-speedometer2"></i> Tableau de bord </a>
            <a href="gestionarticle/gestionarticle.php" class="menu-item" target="contentFrame"><i class="bi bi-box-seam"></i> Articles</a>
            <a href="gestionmagasin/gestionmagasins.php " class="menu-item " target="contentFrame"><i class="bi bi-building"></i> Magasins</a>
            <a href="gestionmouvement/gestionmouvement.php" class="menu-item" target="contentFrame"><i class="bi bi-arrow-left-right"></i> Mouvements</a>
             <a href="historique.php" class="menu-item" target="contentFrame"><i class="bi bi-clock-history"></i> Historique</a>
            <a href="admin_demande.php" class="menu-item" target="contentFrame"><i class="bi bi-clipboard-check"></i>gestion-autorisations.</a>
            <a href="gestionutilisateur/listeutilisateur.php" class="menu-item" target="contentFrame"><i class="bi bi-people"></i> Employes</a>
        </div>
                  <div class="logout-section">
            <a href="../secerity/logout.php" class="btn-logout"><i class="bi bi-box-arrow-right"></i> Deconnexion</a>   
        </div>
    </div>

    <div class="main-container">
        <iframe name="contentFrame" src="index.php"></iframe>
    </div>
</body>
</html>