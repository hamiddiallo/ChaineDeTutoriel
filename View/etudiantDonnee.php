<?php 
    require '../Fonction/fonction.php';
    require '../Include/bdd.php';
    $etudiants = getFromTables($pdo,'etudiant');
    header('Content-Type: application/json');
    echo json_encode($etudiants);