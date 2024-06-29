<?php
function inserer_dans_la_bdd($pdo,$table, $Columns, $value){
    try {
        $placeholder = implode(",", array_fill(0, count($value), "?"));
        $sql = "INSERT INTO $table ($Columns) VALUES ($placeholder)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute($value);
    } catch (PDOException $e) {
       echo "Erreur lors de l'insertion dans la base de données : ".$e->getMessage();
    }
}

function getFromTables($pdo,$tableName){
    $stmt = $pdo->prepare("SELECT * FROM $tableName");
    $stmt->execute();
    $data = $stmt->fetchAll();
    return $data;
}
                            
function getFromTablesWithExcept($pdo, $table1, $nomID ,$table2,$nomID2 , $idTable2){
    $stmt = $pdo->prepare("SELECT * FROM $table1 where $nomID not in (select $nomID from $table2 where $nomID2 = $idTable2)");
    $stmt->execute();
    $data = $stmt->fetchAll();
    return $data;
}

function getFromTablesWithOffset($pdo, $table, $limit, $offset) {
    $query = $pdo->prepare("SELECT * FROM $table LIMIT :limit OFFSET :offset");
    $query->bindValue(':limit', $limit, PDO::PARAM_INT);
    $query->bindValue(':offset', $offset, PDO::PARAM_INT);
    $query->execute();
    return $query->fetchAll(PDO::FETCH_OBJ);
}

function getFilter($pdo,$table,$limit,$offset,$critere){
    $query = $pdo->prepare("SELECT * FROM $table WHERE $critere LIMIT :limit OFFSET :offset");
    $query->bindValue(':limit', $limit, PDO::PARAM_INT);
    $query->bindValue(':offset', $offset, PDO::PARAM_INT);
    $query->execute();
    return $query->fetchAll(PDO::FETCH_OBJ);
}

function getEntityByIdWithOffset($pdo,$table, $idTable, $nomID,$limit, $offset){
    $sql = "SELECT * FROM $table WHERE $nomID = $idTable LIMIT :limit OFFSET :offset";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $data = $stmt->fetchAll();  
    return $data;
}

function updateData($pdo, $table, $params, $idTable, $nomID){
    $setClause = "";
    $values = [];
    foreach ($params as $key => $value){
        $setClause .= "$key = ?,";
        $values[] = $value;
    }
    $trimClause = trim($setClause, ",");
    $sql = "UPDATE $table SET $trimClause WHERE $nomID = ?";
    $values[] = $idTable;
    $stmt = $pdo->prepare($sql);
    return $stmt->execute($values);
}

function supprimerData($pdo,$table, $idTable, $nomID){
    $sql = "DELETE FROM $table WHERE $nomID in ($idTable)";
    $pdo->query("SET foreign_key_checks = 0");
    $stmt = $pdo->prepare($sql);
    $stmt->execute(); 
    $pdo->query("SET foreign_key_checks = 1");

}
function getEntityById($pdo,$table, $idTable, $nomID){
    $sql = "SELECT * FROM $table WHERE $nomID = $idTable";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $data = $stmt->fetchAll();
    return $data;
}
function getRawById($pdo,$table, $idTable, $nomID){
    $sql = "SELECT * FROM $table WHERE $nomID = $idTable";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $data = $stmt->fetch();
    return $data;
}
function getLastId($pdo,$table, $nomID) {
    $sql = "SELECT MAX($nomID) AS last_id FROM $table";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $data = $stmt->fetch(PDO::FETCH_ASSOC); 
    return $data['last_id'];
}

    // Fonction pour vérifier si l'utilisateur est connecté
    function verifierAuthentification() {

        // Vérifie si l'utilisateur est déjà connecté, sinon le redirige vers la page de connexion
        if (!isset($_SESSION['login'])) {
            // // Obtient le chemin du répertoire actuel
            // $dir = basename(__DIR__);
            // echo $dir;
            // // Détermine le chemin de la page de connexion en fonction du répertoire courant
            // $pathConnexionPage = ($dir == "projetDevWeb1") ? "connexion.php" : "../connexion.php";
            // echo  $pathConnexionPage;
            // die();

            // Redirection vers la page de connexion
            header("Location: connexion.php");
            exit;
        }
    }
?>