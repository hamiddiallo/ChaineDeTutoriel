<?php
// Commencer la session
session_start();

// Détruire toutes les variables de session
$_SESSION = array();

// Si un cookie de session existe, le supprimer
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Détruire la session
session_destroy();

// Rediriger vers la page de connexion ou d'accueil
header("Location: ../View/index.php"); 
exit;
?>
