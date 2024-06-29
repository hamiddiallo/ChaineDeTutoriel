<?php
    require "../Include/bdd.php";
    require "../Fonction/fonction.php";
    // Vérifie si le formulaire de connexion a été soumis
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["connexion"])) {
        // Récupère les valeurs du formulaire
        $mail = $_POST["email"];
        $password = hash('sha256', $_POST["password"]);
    
        // Utilisation de paramètres de requête sécurisés
        $sql = "SELECT * FROM Etudiant WHERE mail = :mail AND password = :password";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':mail', $mail);
        $stmt->bindParam(':password', $password);
        $stmt->execute();
        $data = $stmt->fetch();

    
        // Vérifie les identifiants
        if ($data !== false) {
            // Authentification réussie, initialise la session et redirige vers la page sécurisée
            session_start();
            $_SESSION["etudiant"] = $data->idEtud;
            $_SESSION["login"] =  $data->mail;
            header("Location: ../View/etudiant.php");//etudiant=$data->idEtud
            exit;
        } else {
            // Identifiants invalides, affiche un message d'erreur
            header("Location: ../View/connexion.php?error");
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["inscription"])) {
        try {
            session_start();
            // Récupération des données de session et de POST
            $nom = $_SESSION['etudiant']['nom'];
            $prenom = $_SESSION['etudiant']['prenom'];
            $email = $_SESSION['etudiant']['email'];
            $password = hash('sha256',$_SESSION['etudiant']['password']);
            $cours = isset($_POST['cours']) ? $_POST['cours'] : [];
    
            // Démarrer la transaction
            $pdo->beginTransaction();
    
            // Préparation de la requête d'insertion pour la table etudiant
            $stmt = $pdo->prepare("INSERT INTO etudiant (nom, prenom, mail, password) VALUES (?, ?, ?, ?)");
            if ($stmt->execute([$nom, $prenom, $email, $password])) {
                // Récupération de l'ID de l'étudiant inséré
                $etudiantId = $pdo->lastInsertId();
    
                // Insérer les cours associés
                if (!empty($cours)) {
                    $stmt = $pdo->prepare("INSERT INTO etudiant_matiere (idEtud, idMat) VALUES (?, ?)");
                    foreach ($cours as $mat) {
                        $stmt->bindValue(1, $etudiantId, PDO::PARAM_INT);
                        $stmt->bindValue(2, $mat, PDO::PARAM_INT);
                        $stmt->execute();
                    }
                }
    
                // Valider la transaction
                $pdo->commit();
                unset($_SESSION['etudiant']);
                header("Location: ../View/connexion.php?created=true");
                exit;
            } else {
                // En cas d'échec, annuler la transaction
                $pdo->rollBack();
                echo "Erreur lors de l'insertion des données de l'étudiant.";
            }
        } catch (Exception $e) {
            // Annuler la transaction en cas d'erreur
            $pdo->rollBack();
            echo "Erreur : " . $e->getMessage();
        }
        // finally{
        //     unset($_SESSION['etudiant']);
        // }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["ajouter"])) {
        session_start();
        $cours = isset($_POST['cours']) ? $_POST['cours'] : [];
        // Insérer les cours associés
        if (!empty($cours)) {
            $stmt = $pdo->prepare("INSERT INTO etudiant_matiere (idEtud, idMat) VALUES (?, ?)");
            foreach ($cours as $mat) {
                $stmt->bindValue(1, $_SESSION['etudiant'], PDO::PARAM_INT);
                $stmt->bindValue(2, $mat, PDO::PARAM_INT);
                $stmt->execute();
            }
        }
        header("Location: ../etudiant.php");
    }
    
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["modifier"])) {
        $etudiant = getRawById($pdo,'etudiant',$_POST['hidden'],'idEtud');
        $tableauEtudiant = [
            "nom"=> $etudiant->nom,
            "prenom"=>$etudiant->prenom,
            "email"=>$etudiant->mail
        ];
    
        foreach($tableauEtudiant as $key => $value){
            $modification = false;
            if($_POST[$key] != $value && $_POST[$key] != ''){
                $newTableau[$key] = $_POST[$key];
            }
        }
    
        if(isset($newTableau)){
            updateData($pdo,"etudiant",$newTableau,$_POST['hidden'],"idEtud");
            echo 'modification éffectue';
        }else{
            echo 'modification non éffectue';
        }
    }
   
    

?>