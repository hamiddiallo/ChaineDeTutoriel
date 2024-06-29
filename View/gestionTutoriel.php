<?php
session_start();
require "../Include/bdd.php";
require "../Fonction/fonction.php";
verifierAuthentification();

if (isset($_SESSION['instructeur'])){
    //Nombre d'enregistrements par page
    $records_per_page = 10;
    
    // Page actuelle (défaut à 1 si non spécifiée)
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    if ($page < 1) $page = 1;
    
    // Calculer l'offset pour la requête SQL
    $offset = ($page - 1) * $records_per_page;
    
    // Supprimer un tutoriel si l'id est spécifié
    if (isset($_GET["idTuto"])) {
        supprimerData($pdo, "tutoriel", $_GET["idTuto"], "id_tuto");
    }
    $instructeur =  $_SESSION['instructeur'];
    // Récupérer le nombre total d'enregistrements
    $total_records_query = $pdo->query("SELECT COUNT(*) FROM Tutoriel where instructeur = $instructeur ");
    $total_records = $total_records_query->fetchColumn();
    
    // Calculer le nombre total de pages
    $total_pages = ceil($total_records / $records_per_page);
    $stmt = $pdo->prepare("Select * from matiere where idMat in (Select idMat from InstructeurMatiere where idInstructeur = $instructeur and isValid = 1)");
    $stmt->execute();
    $matieres = $stmt->fetchAll();
    // Récupérer les enregistrements pour la page actuelle
    $data = getEntityByIdWithOffset($pdo,"tutoriel", "instructeur",$instructeur,$records_per_page, $offset);
    $instructeur = getRawById($pdo,"instructeur", $_SESSION['instructeur'], "idInstructeur");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>instructeur</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body <?= isset($_COOKIE['theme'])?'class='.$_COOKIE['theme']:''?>>
    <header class="header-user">
       <nav class="header-nav">
            <span><a href="instructeur.php">instructeur</a></span>
            <span class="active"><a href="gestionTutoriel.php">tutoriel</a></span>
       </nav>
        <div class="englobe">
            <span id="user-name">
                <span><?=$instructeur->nom?> <?=$instructeur->prenom?></span>   
            </span>
            <ul class="fonctionnalite">
                <li><a href="choisirSpecialite.php?ajout"><i class="fa-solid fa-plus"></i>ajouter expertise</a></li>
                <li><a href="../Controlleur/deconnexion.php"><i class="fa-solid fa-right-from-bracket"></i>déconnexion</a></li>
            </ul>
        </div>
    </header>
    <main class="container espacement">
        <div class="element-recherche">
            <input type="text" class="rechercher" placeholder="rechercher selon le titre...">
            <svg class="rechercher-logo" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"/></svg>
        </div>
        <table class="tableau">
    <tr>
        <th>Titre</th>
        <th>Matiere</th>
        <th>Action</th>
    </tr>
    <?php foreach ($data as $tuto): ?>
    <tr data-id="<?= $tuto->id_tuto ?>" data-titre="<?= htmlspecialchars($tuto->titre) ?>" data-description="<?= htmlspecialchars($tuto->description) ?>" data-matiere="<?= htmlspecialchars($tuto->matiere) ?>" data-niveau="<?= htmlspecialchars($tuto->niveau) ?>">
        <td><?= htmlspecialchars($tuto->titre) ?></td>
        <td><?=getRawById($pdo,"matiere", $tuto->matiere, "idMat")->nomMat?></td>
        <td>
            <a href="gestionTutoriel.php?idTuto=<?= $tuto->id_tuto ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce tutoriel ?')">
                <svg class="trash" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M135.2 17.7C140.6 6.8 151.7 0 163.8 0H284.2c12.1 0 23.2 6.8 28.6 17.7L320 32h96c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 96 0 81.7 0 64S14.3 32 32 32h96l7.2-14.3zM32 128H416V448c0 35.3-28.7 64-64 64H96c-35.3 0-64-28.7-64-64V128zm96 64c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16z"/></svg>
            </a>
            <a href="javascript:void(0)" class="edit-btn">
                <svg class="pen" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M368.4 18.3L312.7 74.1 437.9 199.3l55.7-55.7c21.9-21.9 21.9-57.3 0-79.2L447.6 18.3c-21.9-21.9-57.3-21.9-79.2 0zM288 94.6l-9.2 2.8L134.7 140.6c-19.9 6-35.7 21.2-42.3 41L3.8 445.8c-3.8 11.3-1 23.9 7.3 32.4L164.7 324.7c-3-6.3-4.7-13.3-4.7-20.7c0-26.5 21.5-48 48-48s48 21.5 48 48s-21.5 48-48 48c-7.4 0-14.4-1.7-20.7-4.7L33.7 500.9c8.6 8.3 21.1 11.2 32.4 7.3l264.3-88.6c19.7-6.6 35-22.4 41-42.3l43.2-144.1 2.8-9.2L288 94.6z"></svg>
            </a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<?php if (!empty($matieres)): ?>
    <button class="ajouter">Ajouter</button>
<?php else: ?>
    <p class="centrer">Veuillez attendre qu'on vous donne l'autorisation pour ajouter du contenu</p>
<?php endif; ?>

<div class="popup-overlay" data-close="true">
    <div class="popup">
        <span></span>
        <form id="editForm" method="post" action="../Controlleur/controlTuto.php" enctype="multipart/form-data">
            <input class="fonctionnalites" type="hidden" name=""/>
            <input type="hidden" id="id_tuto" name="id_tuto"/>
            <label for="titre">Titre</label>
            <input type="text" id="titre" name="titre" required/>
            <label for="description">Description</label>
            <input type="text" id="description" name="description"/>
            <label for="matiere">Matiere</label>
            <select name="matiere" id="matiere">
                <?php foreach($matieres as $matiere): ?>
                <option value="<?= $matiere->idMat ?>" required><?= $matiere->nomMat ?></option>
                <?php endforeach ?>
            </select>
            <label for="niveau">Niveau</label>
            <select name="niveau" id="niveau">
                <option value="debutant" required>debutant</option>
                <option value="amateur" required>amateur</option>
                <option value="expert" required>expert</option>
            </select>
            <label for="video" class="video">Video</label>
            <label for="video" class="customButton video"><i class="fa-solid fa-download"></i> choisir une video</label>
            <input type="file" id="video" name="video" class="video"/>
            <input type="submit" name="enregistrer"/>
        </form>

    </div>
</div>

    </main>
    <?php if($total_pages > 1):?>
    <div class="pagination">
        <!-- Lien vers la page précédente -->
        <?php if ($page > 1): ?>
            <a href="?page=<?= $page - 1 ?>"><span class="elementpagination">«</span></a>
        <?php else: ?>
            <span class="elementinactif">«</span>
        <?php endif; ?>

        <!-- Liens vers toutes les pages -->
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <?php if ($i == $page): ?>
                <span class="elementinactif"><?= $i ?></span>
            <?php else: ?>
                <a href="?page=<?= $i ?>"><span class="elementpagination"><?= $i ?></span></a>
            <?php endif; ?>
        <?php endfor; ?>

        <!-- Lien vers la page suivante -->
        <?php if ($page < $total_pages): ?>
            <a href="?page=<?= $page + 1 ?>"><span class="elementpagination">»</span></a>
        <?php else: ?>
            <span class="elementinactif">»</span>
        <?php endif; ?>
    </div>
    <?php endif;?>
    <footer class="footer-student">
        <div class="motivation">
            <div class="entete">Ma motivation</div>
            <p>Chaque défi en mathématiques nous enseigne que derrière chaque problème complexe se cache une solution attendue, rappelle-toi que poursuivre tes rêves est un puzzle que tu es capable de résoudre, alors continue d'avancer, pas à pas, vers l'infini de tes possibilités.</p>
        </div>
        <div class="contact">
            <div class="entete">Me contacter</div>
            <p><i class="fa-solid fa-envelope"></i> Par email</p>
            <div class="entete">Thème</div>
            <span class="champ" tabindex="0">
                    <span class="bouttonRond <?= (isset($_COOKIE['theme']) && $_COOKIE['theme'] == 'theme-dark')?'position':''?>">
                        <?php if(!isset($_COOKIE['theme']) || (isset($_COOKIE['theme']) && $_COOKIE['theme'] != 'theme-dark')):?>
                            <i class="fa-regular fa-sun"></i>
                        <?php elseif(isset($_COOKIE['theme']) && $_COOKIE['theme'] == 'theme-dark'): ?>
                            <i class="fa-regular fa-moon"></i>
                        <?php endif; ?>
                    </span>
            </span>
        </div>
    </footer>
    <script>
        let data,idInstructeur,newLigne;
        newLigne = `
            <tr> 
                <td>Titre</td>  
                <td>Matiere</td> 
                <td>Action</td>
            </tr>                        
        `
        idInstructeur = <?= $_SESSION['instructeur']?>;
        const rechercher = document.querySelector(".rechercher");
        const xhr = new XMLHttpRequest();
        xhr.open('GET', 'tutorielDonnee.php', true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                data = JSON.parse(xhr.responseText)
            }
        };
        xhr.send();

        rechercher.addEventListener('input', function(event) {
            const tableau = document.querySelector('.tableau')
            newLigne = `
            <tr> 
                <td>Titre</td>  
                <td>Matiere</td> 
                <td>Action</td>
            </tr>                        
        `
            tableau.innerHTML = newLigne
            for(tuto of data){
                if (idInstructeur == tuto.instructeur && event.target.value.toLowerCase() === tuto.titre.substring(0, event.target.value.length).toLowerCase()) {
                    newLigne += `
                        <tr data-id="${tuto.id_tuto}" data-titre="${tuto.titre}" data-description="${tuto.description}" data-matiere="${tuto.matiere}" data-niveau="${tuto.niveau}"> 
                            <td>${tuto.titre}</td>  
                            <td>${tuto.matiere}</td> 
                            <td>
                                <a href="gestionTutoriel.php?idTuto=<?= $tuto->id_tuto ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce tutoriel ?')">
                                    <svg class="trash" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M135.2 17.7C140.6 6.8 151.7 0 163.8 0H284.2c12.1 0 23.2 6.8 28.6 17.7L320 32h96c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 96 0 81.7 0 64S14.3 32 32 32h96l7.2-14.3zM32 128H416V448c0 35.3-28.7 64-64 64H96c-35.3 0-64-28.7-64-64V128zm96 64c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16z"/></svg>
                                </a>
                                <a href="javascript:void(0)" class="edit-btn">
                                    <svg class="pen" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M368.4 18.3L312.7 74.1 437.9 199.3l55.7-55.7c21.9-21.9 21.9-57.3 0-79.2L447.6 18.3c-21.9-21.9-57.3-21.9-79.2 0zM288 94.6l-9.2 2.8L134.7 140.6c-19.9 6-35.7 21.2-42.3 41L3.8 445.8c-3.8 11.3-1 23.9 7.3 32.4L164.7 324.7c-3-6.3-4.7-13.3-4.7-20.7c0-26.5 21.5-48 48-48s48 21.5 48 48s-21.5 48-48 48c-7.4 0-14.4-1.7-20.7-4.7L33.7 500.9c8.6 8.3 21.1 11.2 32.4 7.3l264.3-88.6c19.7-6.6 35-22.4 41-42.3l43.2-144.1 2.8-9.2L288 94.6z"></svg>
                                </a>
                            </td>
                        </tr>                        
                    `
                }
            }
            tableau.innerHTML = newLigne
            const editForm = document.getElementById('editForm')
            const pens = document.querySelectorAll('.edit-btn')
            pens.forEach(pen => pen.addEventListener("click", function (event) {
                event.preventDefault();
                const tr = this.closest('tr');

                const id = tr.getAttribute('data-id');
                const titre = tr.getAttribute('data-titre');
                const description = tr.getAttribute('data-description');
                const matiere = tr.getAttribute('data-matiere');
                const niveau = tr.getAttribute('data-niveau');

                editForm.id_tuto.value = id;
                editForm.titre.value = titre;
                editForm.description.value = description;
                editForm.matiere.value = matiere;
                editForm.niveau.value = niveau;

                document.querySelector(".fonctionnalites").name = "modifier";
                document.querySelector(".popup span").textContent = "Modifier un tutoriel";
                document.querySelector("form input[type='submit']").name = "modifier";
                document.querySelector("form input[type='submit']").value = "modifier";
                afficherPopup();
            }));
        });

    </script>
    <script src="https://kit.fontawesome.com/01cba61c97.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.5.1/gsap.min.js"></script>
    <script src="script/script.js"></script>
</body>
</html>
