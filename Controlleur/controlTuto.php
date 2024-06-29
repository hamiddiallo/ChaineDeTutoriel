<?php
session_start();
require "../Include/bdd.php";
require "../Fonction/fonction.php";
require '../vendor/autoload.php';
// Fonction pour vérifier si le fichier est une vidéo valide
function isValidVideo($file) {
    $allowed_types = ['mp4', 'avi', 'mov'];
    $videoFileType = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $check = mime_content_type($file['tmp_name']);
    
    if (strpos($check, "video") === false) {
        return "Le fichier n'est pas une vidéo.";
    }
    
    if ($file["size"] > 50000000) {
        return "Le fichier est trop volumineux.";
    }
    
    if (!in_array($videoFileType, $allowed_types)) {
        return "Seuls les fichiers MP4, AVI et MOV sont autorisés.";
    }
    
    return true;
}

// Fonction pour télécharger le fichier
function uploadVideo($file, $target_dir = "../videos/") {
    $target_file = $target_dir . basename($file["name"]);
    
    if (move_uploaded_file($file["tmp_name"], $target_file)) {
        return "videos/".basename($file["name"]);
    }
    
    return false;
}


// Traitement du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['enregistrer'])) {
    $titre = htmlspecialchars($_POST['titre']);
    $matiere = htmlspecialchars($_POST['matiere']);
    $niveau = htmlspecialchars($_POST['niveau']);
    $description = htmlspecialchars($_POST['description']);
    $instructeur = $_SESSION['instructeur'];
    $matiere = htmlspecialchars($_POST['matiere']);


    
    $videoCheck = isValidVideo($_FILES["video"]);
    if ($videoCheck === true) {
        $chemin = uploadVideo($_FILES["video"]);
        if ($chemin !== false) {
            // Créer une instance de getID3
            $getID3 = new getID3;
            // Analyser le fichier vidéo
            $fileInfo = $getID3->analyze("../".$chemin);
            
            
            $columns = "chemin, instructeur, matiere, titre, niveau, description,duree";
            $values =[$chemin, $instructeur, $matiere, $titre, $niveau, $description,$fileInfo['playtime_string']];
            
            if (inserer_dans_la_bdd($pdo,"tutoriel",$columns,$values)) {
                echo "Nouveau tutoriel inséré avec succès.";
            } else {
                echo "Pas insere";
            }
        
        } else {
            echo "Erreur lors du téléchargement de la vidéo.";
        }
    } else {
        echo $videoCheck;
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['modifier'])) {
    if (isset($_POST['id_tuto']) && isset($_POST['titre']) && isset($_POST['description']) && isset($_POST['matiere']) && isset($_POST['niveau'])) {
        $id_tuto = $_POST['id_tuto'];
        $titre = $_POST['titre'];
        $description = $_POST['description'];
        $matiere = $_POST['matiere'];
        $niveau = $_POST['niveau'];
        
        // Handle file upload if a new file is provided
        if (isset($_FILES['video']) && $_FILES['video']['error'] === UPLOAD_ERR_OK) {
            $chemin = 'uploads/' . basename($_FILES['video']['name']);
            move_uploaded_file($_FILES['video']['tmp_name'], $chemin);
        } else {
            // Retrieve the current path if no new file is uploaded
            $stmt = $pdo->prepare("SELECT chemin FROM tutoriel WHERE id_tuto = :id_tuto");
            $stmt->execute(['id_tuto' => $id_tuto]);
            $result = $stmt->fetch();
            $chemin = $result->chemin;
        }

        // Prepare SQL statement
        $stmt = $pdo->prepare("UPDATE tutoriel SET titre = :titre, description = :description, matiere = :matiere, niveau = :niveau, chemin = :chemin WHERE id_tuto = :id_tuto");

        // Bind parameters
        $stmt->bindParam(':id_tuto', $id_tuto, PDO::PARAM_INT);
        $stmt->bindParam(':titre', $titre, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':matiere', $matiere, PDO::PARAM_INT);
        $stmt->bindParam(':niveau', $niveau, PDO::PARAM_STR);
        $stmt->bindParam(':chemin', $chemin, PDO::PARAM_STR);

        // Execute the query
        if ($stmt->execute()) {
            header('Location: ../View/gestionTutoriel.php?success=1');
        } else {
            header('Location: ../View/gestionTutoriel.php?error=1');
        }
    }
} else {
    header('Location: ../View/gestionTutoriel.php');
}

?>
