<?php 
    require "../Fonction/fonction.php";
    require "../Include/bdd.php";

    $tutoriel = getFromTables($pdo,"tutoriel");
    header("Content-Type:application/json");
    echo json_encode($tutoriel);