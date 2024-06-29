<?php 
    require '../Fonction/fonction.php';
    require '../Include/bdd.php';
    $instructeur = getFromTables($pdo,'instructeur');
    header('Content-Type: application/json');
    echo json_encode($instructeur );