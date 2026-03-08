<?php
session_start();
if (!isset($_SESSION['id_utilisateur'])) {
    header("Location:../../secerity/login.php");
    exit();
}
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


