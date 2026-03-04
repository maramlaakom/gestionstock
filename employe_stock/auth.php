<?php

session_start();

// bech ychouf ken l'utilisateur mawjoud wele lee fel session
if (!isset($_SESSION['id_utilisateur'])) {
    header("Location:../../secerity/login.php");//ken mawjoud cv snn bech yeb3thou ya3mel login
    exit();
}

// Vérifier les rôles autorisés (bech ychouf 3andou role wela lee)
function require_role(array $roles) 
{
    $roles = array_map('strtolower', $roles);
    $user_role = strtolower($_SESSION['role']);

    if (!in_array($_SESSION['role'], $roles)) {
        http_response_code(403);
        die("Acces refuse");
    }
    
}
?>


