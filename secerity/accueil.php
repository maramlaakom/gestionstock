<!--<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil - Gestion Stock</title>
        <link rel="stylesheet" href="../css/base.css">
 

    <style>

        body {
            margin:0;
            font-family: Arial, sans-serif;
            /*background: #f0f0f0;*/
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .card {
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            text-align: center;
            width: 400px;
        }
        .card img {
            width: 200px;
            margin-bottom: 20px;
        }
        .card h2 {
            color: #a8c4f8;
            margin-bottom: 30px;
        }/*
        .btn {
            display: block;
            width: 220px;
            margin: 10px auto;
            padding: 12px;
            font-size: 14px;
            color: white;
            background-color: #c5daff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
        }
        .btn:hover { opacity: 0.9; }*/
    </style>
</head>
<body>
    <div class="card">
        <img src="data:image/png;base64,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" alt="Logo">
        <h2>Bienvenue dans le systeme de gestion de stock</h2>
        <a href="login.php" class="btn-primary">inscrie</a>
        <a href="javascript:window.close();" class="btn-primary">Quitter</a>
    </div>
</body>
</html>

-->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil - Gestion Stock</title>
    <link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="../css/forms.css">

    <style>
        /* نخليو كان الحاجات الخاصة باللوغو والتعديلات البسيطة */
      /*  .card-welcome img {
            width: 150px;
            margin-bottom: 20px;
        }*/
      /*  .welcome-title {
            color: var(--primary); /* استعمال المتغير من base.css *//*
            font-size: 1.5rem;
            margin-bottom: 30px;
            font-weight: bold;
        }
       .btn-group-vertical {
            display: flex;
            flex-direction: column;
            gap: 15px;
            align-items: center;
        }
            */
         .btn-primary
        {
            width: 80%; /* توحيد عرض الأزرار */
            text-decoration: none;
            text-align: center;
             display: flex;
            flex-direction: column;
            gap: 15px;
            align-items: center;
            margin-left:40px
        }
            
   
    </style>
</head>
<body class="page-form"> 
    <div class="form-container  "> 
   
        <img src="img/logo.png" alt="Logo"  style="width: 180px; margin-bottom: 20px; display: block; margin-left: auto; margin-right: auto;">

 <h2  style="text-align: center;">Bienvenue dans le système de gestion de stock</h2>
        
            <a href="login.php" class=" btn btn-primary ">connexion</a>
               
          
        </div>
    </div>

</body>
</html>