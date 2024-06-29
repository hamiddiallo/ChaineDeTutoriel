<?php
require "../Include/bdd.php";
require "../Fonction/fonction.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["enregistrer"])) {
   
    $matiere = $_POST["Matiere"];
    // Insérer les cours associés
        $stmt = $pdo->prepare("INSERT INTO matiere (nomMat) VALUES (?)");
        

            $stmt->bindValue(1, $matiere, PDO::PARAM_STR);
            $stmt->execute();
     
    
    header("Location: ../View/gestionMatiere.php");
    exit;
}

