<?php
require "../Include/bdd.php";
require "../Fonction/fonction.php";
session_start();

// Vérifie si le formulaire de connexion a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["connexion"])) {
    // Récupère les valeurs du formulaire
    $mail = $_POST["email"];
    $password = hash('sha256', $_POST["password"]);
    
    // Utilisation de paramètres de requête sécurisés
    $sql = "SELECT * FROM instructeur WHERE mail = :mail AND password = :password";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':mail', $mail);
    $stmt->bindParam(':password', $password);
    $stmt->execute();
    $data = $stmt->fetch();
    
    // Vérifie les identifiants
    if ($data !== false) {
        // Authentification réussie, initialise la session et redirige vers la page sécurisée
        $_SESSION["instructeur"] = $data->idInstructeur;
        $_SESSION["login"] =  $data->mail;
        
        header("Location: ../View/instructeur.php");//instructeur=$data->idInstructeur
        exit;
    } else {
        // Identifiants invalides, affiche un message d'erreur
        header("Location: ../View/connexion.php?error");
    }
}

// Vérifie si le formulaire d'inscription a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["inscription"])) {
    try {
        // Récupération des données de session et de POST
        $nom = $_SESSION['instructeur']['nom'];
        $prenom = $_SESSION['instructeur']['prenom'];
        $email = $_SESSION['instructeur']['email'];
        $password = hash('sha256',$_SESSION['instructeur']['password']);
        $expertise = isset($_POST['expertise']) ? $_POST['expertise'] : [];

        // Répertoire de téléchargement
        $uploadDir = 'Justificatif/';

         // Vérifie si un fichier a été téléchargé et si c'est un PDF
        if (isset($_FILES['certification']) && mime_content_type($_FILES['certification']['tmp_name']) === 'application/pdf') {
            // Génère un nom de fichier unique
            $fileName = uniqid() . '-' . basename($_FILES['certification']['name']);
            $filePath = $uploadDir . $fileName;

            // Déplace le fichier téléchargé vers le répertoire de téléchargement
            if (!move_uploaded_file($_FILES['certification']['tmp_name'], "../" . $filePath)) {
                echo "Failed to move the uploaded file.";
                exit;
            }
        } else {
            echo "Please upload a valid PDF file.";
            exit;
        }

        // Démarrer la transaction
        $pdo->beginTransaction();

        // Préparation de la requête d'insertion pour la table instructeur
        $stmt = $pdo->prepare("INSERT INTO instructeur (nom, prenom, mail, password) VALUES (?, ?, ?, ?)");
        if ($stmt->execute([$nom, $prenom, $email, $password])) {
            // Récupération de l'ID de l'instructeur inséré
            $idInstructeur = $pdo->lastInsertId();

            // Insérer les expertises associées
            if (!empty($expertise)) {
                $stmt = $pdo->prepare("INSERT INTO InstructeurMatiere (idInstructeur, idMat, justificatif) VALUES (?, ?, ?)");
                foreach ($expertise as $exp) {
                    $stmt->bindValue(1, $idInstructeur, PDO::PARAM_INT);
                    $stmt->bindValue(2, $exp, PDO::PARAM_INT);
                    $stmt->bindValue(3, $filePath, PDO::PARAM_STR);
                    $stmt->execute();
                }
            }

            // Valider la transaction
            $pdo->commit();
            unset($_SESSION['instructeur']);
            header("Location: ../connexion.php?created=true");
            exit;
        } else {
            // En cas d'échec, annuler la transaction
            $pdo->rollBack();
            echo "Erreur lors de l'insertion des données de l'instructeur.";
        }
    } catch (Exception $e) {
        // Annuler la transaction en cas d'erreur
        $pdo->rollBack();
        echo "Erreur : " . $e->getMessage();
    } finally {
        // unset($_SESSION['instructeur']);
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["ajouter"])) {
    // Répertoire de téléchargement
    $uploadDir = 'Justificatif/';
    
    $expertise = isset($_POST['expertise']) ? $_POST['expertise'] : [];
    
    // Vérifie si un fichier a été téléchargé et si c'est un PDF
    if (isset($_FILES['certification']) && mime_content_type($_FILES['certification']['tmp_name']) === 'application/pdf') {
        // Récupère les données de l'instructeur
        $instructeur = getRawById($pdo, "instructeur", $_SESSION['instructeur'], "idInstructeur");
        $prenom = $instructeur->prenom;

        // Génère un nom de fichier unique
        $fileName = uniqid() . '-' . basename($_FILES['certification']['name']);
        $filePath = $uploadDir . $fileName;

        // Déplace le fichier téléchargé vers le répertoire de téléchargement
        if (!move_uploaded_file($_FILES['certification']['tmp_name'], "../" . $filePath)) {
            echo "Failed to move the uploaded file.";
            exit;
        }
    } else {
        echo "Please upload a valid PDF file.";
        exit;
    }

    // Insérer les cours associés
    if (!empty($expertise)) {
        $stmt = $pdo->prepare("INSERT INTO InstructeurMatiere (idInstructeur, idMat, justificatif) VALUES (?, ?, ?)");
        foreach ($expertise as $exp) {
            $stmt->bindValue(1, $_SESSION['instructeur'], PDO::PARAM_INT);
            $stmt->bindValue(2, $exp, PDO::PARAM_INT);
            $stmt->bindValue(3, $filePath, PDO::PARAM_STR);
            $stmt->execute();
        }
    }
    
    header("Location: ../instructeur.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["modifier"])) {
    $instructeur = getRawById($pdo,'instructeur',$_POST['hidden'],'idInstructeur');
        $tableauInsrtucteur = [
            "nom"=> $instructeur->nom,
            "prenom"=>$instructeur->prenom,
            "email"=>$instructeur->mail
        ];
    
        foreach($tableauInsrtucteur as $key => $value){
            $modification = false;
            if($_POST[$key] != $value && $_POST[$key] != ''){
                $newTableau[$key] = $_POST[$key];
            }
        }
    
        if(isset($newTableau)){
            updateData($pdo,"instructeur",$newTableau,$_POST['hidden'],"idInstructeur");
            echo 'modification éffectue';
        }else{
            echo 'modification non éffectue';
        }
}




