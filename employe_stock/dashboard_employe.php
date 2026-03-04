<?php
require_once "auth.php";
require_role([ "employe_stock"]); 
//$nom_user = $_SESSION['nom'] ?? "Utilisateur";
//$email_user = $_SESSION['email'] ?? "user@stock.com";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>StockSys - Panel Employé</title>

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- CSS Structure -->
    <link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="../css/sidebar.css">
    <!--<link rel="stylesheet" href="../css/admin.css">-->
    <!--<link rel="stylesheet" href="../css/forms.css">-->
<!--<link rel="stylesheet" href="../css/tables.css">-->
    <!--<link rel="stylesheet" href="../css/cards.css">-->
    <!--<link rel="stylesheet" href="../css/messenger.css">-->
    <!--<link rel="stylesheet" href="../css/notifications.css">-->
 <style>
/* ============ RESET ============ *//*
* {
    box-sizing: border-box;
}/*

html, body {
    margin: 0;
    padding: 0;
    width: 100%;
    height: 100%;
    background: #f4f7fe;
    overflow: hidden;
}

/* ============ LAYOUT ============ */

      
       body {
    display: flex;
    flex-direction: row;
}

        

        
/* etrake7 partie eli yet7al feha paget target ma3naha paget emta3 ki tenzel 3ala lien yet7al  */
      /* .main-container { flex-grow: 1; 
    height: 100vh; 
    overflow: hidden;
    position: relative; }  */
    .main-container {
    /* خلي الـ container ياخذ بقية مساحة الشاشة */
    flex: 1;
    height: 100vh;
    overflow: hidden;
}
      /*  iframe { width: 100%; height: 100%; border: none; }*/
        /*iframe {
    width: 100%;
    height: 100%;
    border: none;
    display: block;
    overflow-y: auto;
    overflow-x: hidden;
}*/
iframe {
    width: 100%;
    height: 100%;
    border: none;
    display: block;
}

/* ============ SIDEBAR ============ */


/* ============ SECURITY AGAIN OVERFLOW ============ *//*
.main-container,
iframe {
    max-width: 100%;
}*/
</style>

</head>
<body>

    <!-- Sidebar -->
    
    <div class="sidebar">
        <div class="sidebar-header">
            <h2><i class="bi bi-box2-fill"></i> StockSys</h2>
        </div>

       <!-- <div class="user-info">
            <h6><//?= $nom_user ?></h6>
            <small><//?= $email_user ?></small>
            <span class="role-badge">Employé</span>
        </div>-->

        <nav class="nav-menu">
<!--      <a href="index.php" class="menu-item active" target="contentFrame"><i class="bi bi-grid"></i> index</a> active et7atet em3a index lanha hya awel page tet7a l li4alek awel mat7el page lazem lien index howa lei yetnawel  -->
            <a href="index.php" class="menu-item " target="contentFrame"><i class="bi bi-grid"></i> index</a>
            <a href="mouvement.php" class="menu-item" target="contentFrame"><i class="bi bi-arrow-left-right"></i> Mouvements</a>
            <a href="envoye_demande.php" class="menu-item" target="contentFrame"><i class="bi bi-send"></i> Mes Demandes</a>
              <a href="../Admin/gestionmouvement/entrestock.php" class="menu-item" target="contentFrame"><i class="bi bi-card-text"></i> entre stock</a>
           <a href="mesangerie.php" class="menu-item" target="contentFrame"><i class="bi bi-chat-dots"></i> Messagerie</a>
            <a href="../Admin/gestionarticle/gestionarticle.php" class="menu-item" target="contentFrame"><i class="bi bi-card-text"></i> Consulter Article</a>
            <a href="profile.php" class="menu-item" target="contentFrame"><i class="bi bi-person-gear"></i> Mon Profil</a>
                <a href="../Admin/gestionmagasin/gestionmagasins.php" class="menu-item" target="contentFrame"><i class="bi bi-card-text"></i> Consulter magasin</a>
                
        </nav> 

              <div class="logout-section">
            <a href="../secerity/logout.php" class="btn-logout"><i class="bi bi-box-arrow-right"></i> Deconnexion</a>   
        </div>
</div>
    <!-- Main Content -->
    <main class="main-container">
        <iframe name="contentFrame" src="index.php"></iframe>
    </main>

    <script>
        // Changement du lien actif
        /*
        // bech eijib lien menu-item elkol  elkol 
        etjib eli 3anthoum classe menu_item elkol ou ei7outhoum fi liste varible links
        const links = document.querySelectorAll('.menu-item');
        haka 3alakhater 3ana akther m'en lien  ribarcourire elkol belwa7et belwa7et
        links.forEach(link => {
        //ken enzenet 3ala lien wa9etha function () tekhtem  click hya eli ta3ref enou enti enzelet 3ala lien 
            link.addEventListener('click', function() {
            eitour 3ala 3ala lienet elkol ou ken el9e active eifasekhha bech yetnz7a colore 3ala lien le9tim eli konet nazel 3alih
                links.forEach(l => l.classList.remove('active'));
                //ou eizit classe  active le lien eli enzenet 3alih this tarja3 3ala lien eli enzenet 3alih tawa 
                this.classList.add('active');
            });
        });
        */
    </script>
</body>
</html>
