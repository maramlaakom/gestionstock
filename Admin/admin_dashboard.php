<?php
/*
//session_start();
require_once '../includes/connexion.php';
require_once "../employee/auth.php";
require_role(["Admin"]);


if (!isset($_SESSION['id_utilisateur'])) {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StockSys - Panel</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        * { box-sizing: border-box; font-family: 'Segoe UI', sans-serif; }
        body { display: flex; margin: 0; background-color: #f8f9fa; height: 100vh; overflow: hidden; }
        
        .sidebar { 
            width: 260px; background: #ffffff; height: 100vh; padding: 25px; 
            border-right: 1px solid #edf2f7; flex-shrink: 0; display: flex; flex-direction: column;
        }
        .sidebar h2 { color: #1a202c; font-size: 22px; margin-bottom: 30px; border-bottom: 2px solid #3182ce; display: inline-block; }
        
        .user-info { margin-bottom: 30px; background: #f7fafc; padding: 15px; border-radius: 12px; }

        .menu-item { 
            display: flex; align-items: center; padding: 12px 15px; color: #4a5568; 
            text-decoration: none; border-radius: 10px; margin-bottom: 5px; transition: 0.3s;
        }
        .menu-item i { margin-right: 12px; font-size: 18px; }
        .menu-item:hover, .menu-item.active { background: #ebf4ff; color: #3182ce; }
        
        .main-container { flex-grow: 1; height: 100vh; display: flex; flex-direction: column; }
        iframe { width: 100%; height: 100%; border: none; background: #f8f9fa; }
        .logout { margin-top: auto; color: #e53e3e !important; }
    </style>
</head>
<body>

    <div class="sidebar">
       
      
        
        <nav>
            <a href="index.php" class="menu-item active" target="contentFrame"><i class="bi bi-speedometer2"></i> Dashboard</a>
            <a href="gestionarticle.php" class="menu-item" target="contentFrame"><i class="bi bi-box-seam"></i> Articles</a>
            <a href="gestionmagasins.php" class="menu-item" target="contentFrame"><i class="bi bi-building"></i> Magasins</a>
            <a href="gestionmouvement.php" class="menu-item" target="contentFrame"><i class="bi bi-arrow-left-right"></i> Mouvements</a>
            <a href="admin_demande.php" class="menu-item" target="contentFrame"><i class="bi bi-clipboard-check"></i> Gérer Demandes</a>
            <a href="mesangerie.php" class="menu-item" target="contentFrame"><i class="bi bi-chat-dots"></i> Messagerie</a>
             <a href="historique.php" class="menu-item" target="contentFrame"><i class="bi bi-clipboard-check"></i> Gérer Demandes</a>
            <a href="gestionutilisateur/listeutilisateur.php" class="menu-item" target="contentFrame"><i class="bi bi-arrow-left-right"></i> gerer employe</a>
        </nav> 

        <a href="../secerity/logout.php" class="menu-item logout"><i class="bi bi-box-arrow-right"></i> Déconnexion</a>
    </div>

    <div class="main-container">
        <iframe name="contentFrame" src="index.php" style="width:100%; height:100vh; border:none;"></iframe>
    </div>

    <script>
        const links = document.querySelectorAll('.menu-item');
        links.forEach(link => {
            link.addEventListener('click', function() {
                links.forEach(l => l.classList.remove('active'));
                this.classList.add('active');
            });
        });
    </script>
</body>
</html>
*/
/**الصفحة الرئيسية مقسومة على قسمين:

Menu/sidebar: ثابتة، scrollbar عمودي لو طويل المحتوى

Iframe/main-container: أي صفحة أخرى تظهر هنا، تملأ المساحة كاملة

الـ display:flex على body هو اللي يسمح للقسمين يكونو جنب بعضهم بدون مشاكل في الارتفاع أو العرض. 
ma3naha tawa tableau de bord howa e9samet elpage  pi display fles estar menu ou elakher 
iframe espace yet7al fih contenu emta3paget eloukhrila */

//session_start();
require_once '../includes/connexion.php';
require_once '../employe_stock/auth.php';
require_role(["Admin"]);
//require_once "../employee/auth.php";
//require_role(["Admin"]);


/*if (!isset($_SESSION['id_utilisateur'])) {
    header('Location: login.php');
    exit();
}*/
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>StockSys - Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
<link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="../css/sidebar.css">
    <!--<link rel="stylesheet" href="../css/admin.css">-->
    <style>
  
        /*body { margin: 0; padding: 0; overflow: hidden; display: flex; height: 100vh; background: #f4f7fe; }*/
        
      body {
        /**body howa fih deux 3anaser howa main_container ou sidebar esta3malet flesxbech eikounou
        bejnab eb3a4houm ou a3tetle siedebar height 100vh ou weight 250px ou le maine flex 1 bech takhou eb9iet page   */
    display: flex;
    /*flex-direction: row;*/
}

     /*   .sidebar { width: 250px; min-width: 250px; height: 100vh; position: relative !important;overflow-y: auto; } */
        
/* etrake7 partie eli yet7al feha paget target ma3naha paget emta3 ki tenzel 3ala lien yet7al  */
      /* .main-container { flex-grow: 1; 
    height: 100vh; 
    overflow: hidden;
    position: relative; }  */
    .main-container {
    /*  خلي الـ container ياخذ بقية مساحة الشاشة 
    ou lazem enti etkoun 7atet fi body  display:flex hya eli ta3ti elmisa7a elmoutaba9ia lel main*/
    flex: 1;
    /* 
height: 100vh;
Permet au conteneur d'occuper toute la hauteur de l’écran,
quel que soit le type d’appareil (PC, tablette ou smartphone),
afin d’assurer un alignement uniforme avec la sidebar.
*/

/*
overflow: hidden;
Empêche le débordement du contenu hors de l’écran
et évite l’apparition d’un scroll global,
notamment sur les écrans mobiles.
*/
/** heigth ou overlow ki etna7ihoum ou et7el site 3ala 
pc you93et emrekla 3alakhater ecran pc ekbir ou contenu e9sir ama
ki et7elou fi telephone eiwali contenu emta3 iframe youtkhel ba34ou  */
    /* container takhou toul echacha elkol  tet7at fi siedbar zata bech eikoulou nafes elkober  */
    height: 100vh;
    /**bech eikhali contenu matetna3ech m'en chacha  */
    overflow: hidden;
}
      /*  iframe { width: 100%; height: 100%; border: none; }*/
        /*iframe {
    width: 100%;
    height: 100%;
    border: none;
    display: block;
    // eikhaliouk tatla3 ou tahbet ki hyabda contenu atwel m'en page 
    matet7atech fi iframe lan hya espace yet7al fi woustou page tet7at fi page eli feha contenu kima  index
    overflow-y: auto;
    overflow-x: hidden;
}*/
/**أي صفحة تفتح في الـ iframe تظهر داخل نفس الإطار بدون ما تغيّر layout الكل. */
iframe {
    /** bech cntenu eli yet7al fi iframe you4her 3ala 3ore4 iframe elkol  */
   width: 100%;
    height: 100%;
    /** bech maikounech fama cadre lel iframe  3alakhater ba3e4 navigater 
    kit7el fihoum site ya3tiou border eftira4i */
    border: none;
   /* display: block;*/
}

    </style>
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <h2><i class="bi bi-box-seam"></i> StockSys</h2>
        </div>
       
        <div class="nav-menu">
            <a href="index.php" class="menu-item " target="contentFrame"><i class="bi bi-speedometer2"></i> index</a>
            <a href="gestionarticle/gestionarticle.php" class="menu-item" target="contentFrame"><i class="bi bi-box-seam"></i> Articles</a>
            <a href="gestionmagasin/gestionmagasins.php " class="menu-item " target="contentFrame"><i class="bi bi-building"></i> Magasins</a>
            <a href="gestionmouvement/gestionmouvement.php" class="menu-item" target="contentFrame"><i class="bi bi-arrow-left-right"></i> Mouvements</a>
            <a href="admin_demande.php" class="menu-item" target="contentFrame"><i class="bi bi-clipboard-check"></i> Demandes</a>
            <a href="mesangerie.php" class="menu-item" target="contentFrame"><i class="bi bi-chat-dots"></i> Messagerie</a>
            <a href="historique.php" class="menu-item" target="contentFrame"><i class="bi bi-clock-history"></i> Historique</a>
            <a href="gestionutilisateur/listeutilisateur.php" class="menu-item" target="contentFrame"><i class="bi bi-people"></i> Employes</a>
        </div>
                  <div class="logout-section">
            <a href="../secerity/logout.php" class="btn-logout"><i class="bi bi-box-arrow-right"></i> Deconnexion</a>   
        </div>
    </div>

    <div class="main-container">
<!-- fi iframe src=index.php hak 3alah awel matoutkhel bi admin tal9a index-->
        <iframe name="contentFrame" src="index.php"></iframe>
    </div>
    
    <script>
    /*
        const links = document.querySelectorAll('.menu-item');
        links.forEach(link => {
            link.addEventListener('click', function() {
                links.forEach(l => l.classList.remove('active'));
                this.classList.add('active');
            });
        });
        */
        
    </script>
</body>
</html>