<?php

require_once '../includes/connexion.php';
require_once '../employe_stock/auth.php';
require_role(["Admin"]);
/* ===============================
   Récupération des mouvements
================================ */
$sql = "
SELECT 
    h.*,
    a.nom_article,
    u.prenom AS user_prenom,
    u.nom AS user_nom,
    m_src.nom_magasin AS magasin_source,
    m_dst.nom_magasin AS magasin_destination
FROM historique_movement h
LEFT JOIN article a ON h.id_article = a.id_article
LEFT JOIN utilisateur u ON h.id_utilisateur = u.id_utilisateur
LEFT JOIN magasin m_src ON h.id_magasin_src = m_src.id_magasin
LEFT JOIN magasin m_dst ON h.id_magasin_dst = m_dst.id_magasin
ORDER BY h.date_mouvement DESC
";

$stmt = $pdo->query($sql);
$mouvements = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Historique des Mouvements</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <!-- CSS Project -->
    <link rel="stylesheet" href="../css/base.css">
   <!-- <link rel="stylesheet" href="../css/tables.css">-->
    <link rel="stylesheet" href="../css/notifications.css">

    <!-- CSS interne (uniquement ce qui n'existe pas ailleurs) -->
    <!--<style>
        .bg-entree {
            background-color: #e6ffe6;
            color: var(--success);
        }
        .bg-sortie {
            background-color: #ffe6e6;
            color: var(--danger);
        }
        .bg-transfert {
            background-color: #e7f1ff;
            color: var(--primary);
        }

        .text-label {
            font-size: .8rem;
            font-weight: bold;
            color: #777;
            text-transform: uppercase;
        }

        .text-value {
            font-weight: 600;
            color: #2c3e50;
        }
    </style-->
<style>
    /* تحسين شكل الحاوية لتكون في المنتصف */
  /*  .container {
        max-width: 1000px;
        margin-top: 50px;
        margin-bottom: 50px;
    }

    /* تصميم الكرت (Card) */
   /* .notif-card {
        background: #ffffff;
        border-radius: 12px;
        padding: 20px 25px;
        margin-bottom: 20px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
        border: 1px solid #f0f2f5;
        display: flex;
        flex-direction: column; /* باش الكومنتار يجي ديما لوطا *//*
    }

    /* تنسيق الدائرة والأيقونات */
  /*  .icon-circle {
        width: 42px;
        height: 42px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
    }
*/
    /* الألوان الهادئة *//*
    .bg-entree { background-color: #f0fff4; color: #22c55e; }
    .bg-sortie { background-color: #fff1f2; color: #ef4444; }
    .bg-transfert { background-color: #eff6ff; color: #3b82f6; }

    /* العناوين الصغيرة */
    .text-label {
        font-size: 0.65rem;
        font-weight: 800;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 2px;
    }

    /* القيم */
    .text-value {
        font-weight: 700;
        color: #1e293b;
        font-size: 1.05rem;
    }

    /* زر الوحدات (Badge) */
    .badge-msg {
    background-color: #eff6ff; /* أزرق فاتح هادي */
    color: #3b82f6;           /* أزرق واضح للكتيبة */
    padding: 6px 14px;        /* تقليل الـ padding شوية باش يتسكر */
    border-radius: 20px;      /* نردوه مدور (Pill) يجي أشب من المربع */
    font-weight: 700;
    font-size: 0.8rem;
    display: inline-block;
    line-height: 1;           /* يخلي الكتيبة في الوسط عمودياً */
    text-align: center;
    border: 1px solid #dbeafe; /* إطار رقيق ياسر باش يظهر الـ Badge مسكر */
    white-space: nowrap

    }
</style>

<div style="margin-left:100px;margin-right:100px;margin-top:20px">

    <h2 class="mb-4 text-center">
        <i class="bi bi-journal-text me-2"></i>
        Historique des Mouvements
    </h2>
<!-- bech enjib mouvement elkol m'en  sql -->
    <?php foreach ($mouvements as $mvt): ?>

        <?php
            $icon  = "bi-plus-lg";
            $label = "ENTRÉE";
            $color = "bg-msg";

            if ($mvt['type_mouvement'] === 'sortie') {
                $icon  = "bi-dash-lg";
                $label = "SORTIE";
                $color = "bg-stock";
            } elseif ($mvt['type_mouvement'] === 'transfert') {
                $icon  = "bi-arrow-left-right";
                $label = "TRANSFERT";
                $color = "bg-info";
            }
        ?>
<!-- partie eloula eliv fi card feha  icon 7aseb mouvemement-->
        <div class="notif-card"style=" flex-direction: column;">

            <div class="row align-items-center w-100 m-0">

                <div class="col-md-1 p-0 d-flex justify-content-start">
    <!-- loul icon 7aseb mouvement -->
                    <div class="icon-circle <?= $color ?>">
                        <i class="bi <?= $icon ?>"></i>
                    </div>
                </div>
<!-- partie 2 eli fi card feha esem mouvement ou feha nom_article -->
                <div class="col-md-3">
                    <div class="text-label"><?= $label ?></div>
                    <div class="text-value">
                        <?= htmlspecialchars($mvt['nom_article']) ?>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="text-label">EMPLACEMENT</div>
                    <div class="text-value small" style="color: #64748b;">
                      <?php
                      //emplacement tetbatel 7aseb mouvement 
$emplacement = '';

if ($mvt['type_mouvement'] === 'transfert') {
    $emplacement = $mvt['magasin_source'] . ' -> ' . $mvt['magasin_destination'];
} elseif ($mvt['type_mouvement'] === 'entree') {
    // المخزن الهدف موجود
    $emplacement = $mvt['magasin_destination'];
} else { // sortie
    // المخزن المصدر موجود
    $emplacement = $mvt['magasin_source'];
}

?>

<i class="bi bi-geo-alt me-1"></i> <?= htmlspecialchars($emplacement) ?>

</div>
                </div>

                <div class="col-md-3">
                    <div class="text-label">user & DATE</div>
                    <div class="text-value small" style="color: #64748b;">
                        <i class="bi bi-person me-1"></i>
                        <strong><?= htmlspecialchars($mvt['user_nom']) ?></strong><br>
    <!--font-weigth:normal -->
                        <span class="text-muted fw-normal" style="font-size: 0.75rem;">
                            <?= date('d/m/Y H:i', strtotime($mvt['date_mouvement'])) ?>
                        </span>
                    </div>
                </div>
    <!-- partie elekhra feha quantite emyta3eli sarelha emplacement-->

                <div class="col-md-2 text-end p-0">
                    <span class="badge-msg">
                        <?= $mvt['quantite'] ?> Unités
                    </span>
                </div>

            </div>
    <!-- comentaire eli you4her enouta-->    

            <?php if (!empty($mvt['commentaire'])): ?>
               <div class="mt-3 p-2 px-3 rounded-2 d-flex align-items-center" 
             style="background-color: #f8fafc; border: 1px solid #f1f5f9; border-left: 4px solid #e2e8f0; width: 100%;">
            <i class="bi bi-chat-left-text me-3 text-muted" style="font-size: 0.9rem;"></i>
            <span style="font-size: 0.85rem; color: #64748b; font-style: italic;">
                "<?= htmlspecialchars($mvt['commentaire']) ?>"
            </span>
        </div>
            <?php endif; ?>

        </div>

    <?php endforeach; ?>

</div>
</body>
</html>

 
      