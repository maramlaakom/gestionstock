<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    
<style>
/* --- الـ CSS الداخلي المكمل لملفاتك --- */

.dashboard-mouvement {
    display: flex;
    justify-content: center;
    gap: 25px;
    padding: 50px 20px;
   /* background-color: var(--bg); /* يستعمل اللون من base.css */
}

/* تعديل كلاس user-card لتناسب صفحة التحركات */
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
    padding: 40px 20px !important;
    background: white !important;
    /** eli ya3mel cadre emta3ou */
    border: 2px solid var(--secondary) !important; /* يستعمل اللون من base.css */
    border-radius: 15px !important;
    transition: transform 0.3s ease;
}
.mvt-card-custom:hover {
    transform: translateY(-5px);
      box-shadow: 0 0 0 .25rem rgba(73, 149, 224, 0.3);
}
/* ستايل الأيقونات */
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

/* ألوان التحركات الخاصة */
.bg-entree { background-color: #e8f8f5; color: #2ecc71; }
.bg-sortie { background-color: #fdedec; color: #e74c3c; }
.bg-transfert { background-color: #ebf5fb; color: #3498db; }

/* تنسيق النصوص */
.mvt-card-custom h3 {
    color: var(--primary); /* اللون الأزرق من base.css */
    font-size: 20px;
    margin-bottom: 10px;
    font-weight: bold;
}

.mvt-card-custom p {
    color: var(--text-muted); /* اللون الرمادي من base.css */
    font-size: 14px;
    margin: 0;
}

/* Responsive للتليفون */
@media (max-width: 768px) {
    .dashboard-mouvement {
        flex-direction: column;
        align-items: center;
    }
    .mvt-card-custom {
        width: 100%;
    }
}
</style>
</head>
<body>
    <?php
require_once '../../includes/connexion.php';
require_once '../../employe_stock/auth.php';
require_role(["Admin"]);
?>
  <a href="?">reflechi</a> 
<link rel="stylesheet" href="../../css/base.css">
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

<!--
<div class="dashboard-mouvement">
    <a href="entrestock.php?type=entree" class="mvt-card">
        <div class="icon-circle bg-entree">↓</div>
        <h3>Entree de Stock</h3>
        <p>Ajouter des articles au stock</p>
    </a>

    <a href="sortiestock.php?type=sortie" class="mvt-card">
        <div class="icon-circle bg-sortie">↑</div>
        <h3>Sortie de Stock</h3>
        <p>Retirer des articles du stock</p>
    </a>

    <a href="transfere.php?type=transfert" class="mvt-card">
        <div class="icon-circle bg-transfert">⇄</div>
        <h3>Transfert</h3>
        <p>Transferer entre magasins</p>
    </a>
</div>
<style>
.dashboard-mouvement {
    display: flex;
    justify-content: space-around;
    padding: 50px;
    background-color:#f0f8ff;
}
.mvt-card {
    background: white;
    border-radius: 15px;
    width: 30%;
    border: 2px solid #87ceeb;
    padding: 40px 20px;
    text-align: center;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    transition: transform 0.3s;
    cursor: pointer;
    text-decoration: none;
    color: #2d3436;
}
.mvt-card:hover { transform: translateY(-10px); }
.icon-circle {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
    font-size: 24px;
}

.bg-entree { background-color: #e8f8f5; color: #2ecc71; }
.bg-sortie { background-color: #fdedec; color: #e74c3c; }
.bg-transfert { background-color: #ebf5fb; color: #3498db; }

.mvt-card h3 { margin-bottom: 10px; font-size: 20px; }
.mvt-card p { color: #b4d7e4; font-size: 14px; }
body{  background-color: #f0f8ff;}
</style>
-->
