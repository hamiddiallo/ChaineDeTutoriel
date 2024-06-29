<?php
    session_start();
    require "../Include/bdd.php";
    require "../Fonction/fonction.php";
    verifierAuthentification();
    if (isset($_SESSION['instructeur'])){
        //Nombre d'enregistrements par page
        $records_per_page = 12;
        
        // Page actuelle (défaut à 1 si non spécifiée)
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($page < 1) $page = 1;
        
        // Calculer l'offset pour la requête SQL
        $offset = ($page - 1) * $records_per_page;
        $instructeur =  $_SESSION['instructeur'];
        // Récupérer le nombre total d'enregistrements
        $total_records_query = $pdo->query("SELECT COUNT(*) FROM Tutoriel where instructeur = $instructeur ");
        $total_records = $total_records_query->fetchColumn();
        
        // Calculer le nombre total de pages
        $total_pages = ceil($total_records / $records_per_page);
        
        // Récupérer les enregistrements pour la page actuelle
        $tutos = getEntityByIdWithOffset($pdo,"tutoriel", "instructeur",$instructeur,$records_per_page, $offset);
        $instructeur = getRawById($pdo,"instructeur", $_SESSION['instructeur'], "idInstructeur");
    }

    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>intructeur</title>
    <link rel="stylesheet" href="style/style.css">
    <script src="https://kit.fontawesome.com/01cba61c97.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.5.1/gsap.min.js"></script>
    <script src="script/script.js" defer></script>
</head>
<body <?= isset($_COOKIE['theme'])?'class='.$_COOKIE['theme']:''?>>
    <header class="header-user">
       <nav class="header-nav">
            <span class="active"><a href="instructeur.php">instructeur</a></span>
            <span><a href="gestionTutoriel.php">tutoriel</a></span>
       </nav>
        <div class="englobe">
            <span id="user-name">
                <span><?=$instructeur->nom?> <?=$instructeur->prenom?></span>   
            </span>
            <ul class="fonctionnalite">
            <a href="choisirSpecialite.php?ajout"><li><i class="fa-solid fa-plus"></i>ajouter expertise</li>
                <a href="../Controlleur/deconnexion.php"><li><i class="fa-solid fa-right-from-bracket"></i>déconnexion</li></a>
            </ul>
        </div>
    </header>
    <main class="container">
        <div class="citation"> 
            <h1>les <span>mathématiques</span></h1> 
            <p>sont le languages avec lequel Dieu a écrit l'univers.</p>
        </div>
        
        <?php foreach($tutos as $tuto):?>
            <a href="tutoriel.php?tuto=<?=$tuto->id_tuto?>">
            <section class="tutoriel">
            <div class="cadre">
                <span class="niveau <?=$tuto->niveau?>"><?=$tuto->niveau?></span>
                <header class="header-tutoriel"><?=$tuto->titre?></header>
                <p><?=$tuto->description?></p>
            </div>
            <footer class="footer-tutoriel">
                <span class="matiere">
                    <svg  viewBox="0 0 1024 1024"  version="1.1" xmlns="http://www.w3.org/2000/svg"  class="logo-Matiere">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                        <g id="SVGRepo_iconCarrier">
                        <path d="M91.89 238.457c-29.899 0-54.133 24.239-54.133 54.134 0 29.899 24.234 54.137 54.133 54.137s54.138-24.238 54.138-54.137c0-29.896-24.239-54.134-54.138-54.134z"/>
                        <path d="M91.89 462.463c-29.899 0-54.133 24.239-54.133 54.139 0 29.895 24.234 54.133 54.133 54.133s54.138-24.238 54.138-54.133c0-29.9-24.239-54.139-54.138-54.139z"/>
                        <path d="M91.89 686.475c-29.899 0-54.133 24.237-54.133 54.133 0 29.899 24.234 54.138 54.133 54.138s54.138-24.238 54.138-54.138c0-29.896-24.239-54.133-54.138-54.133z"/>
                        <path d="M941.26 234.723H328.964c-28.867 0-52.263 23.4-52.263 52.268v3.734c0 28.868 23.396 52.269 52.263 52.269H941.26c28.869 0 52.269-23.401 52.269-52.269v-3.734c-0.001-28.868-23.4-52.268-52.269-52.268z"/>
                        <path d="M941.26 682.74H328.964c-28.867 0-52.263 23.399-52.263 52.268v3.734c0 28.863 23.396 52.269 52.263 52.269H941.26c28.869 0 52.269-23.405 52.269-52.269v-3.734c-0.001-28.868-23.4-52.268-52.269-52.268z"/>
                        <path d="M709.781 458.729H328.964c-28.867 0-52.263 23.4-52.263 52.269v3.734c0 28.873 23.396 52.269 52.263 52.269h380.817c28.866 0 52.271-23.396 52.271-52.269v-3.734c0.001-28.869-23.405-52.269-52.271-52.269z"/></g>
                        </svg>
                        <?=getRawById($pdo,"matiere", $tuto->matiere, "idMat")->nomMat?>
                </span>
                <span class="heure">    
                    <svg  viewBox="0 0 32 32" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;" version="1.1" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:serif="http://www.serif.com/" xmlns:xlink="http://www.w3.org/1999/xlink" class="logo-Heure">
                        <g id="Icon"/>
                        <path d="M16,6c-5.519,0 -10,4.481 -10,10c0,5.519 4.481,10 10,10c5.519,0 10,-4.481 10,-10c0,-5.519 -4.481,-10 -10,-10Zm0,2c4.415,0 8,3.585 8,8c0,4.415 -3.585,8 -8,8c-4.415,0 -8,-3.585 -8,-8c0,-4.415 3.585,-8 8,-8Z"/>
                        <path d="M15.5,13l0,3c0,0.099 0.029,0.195 0.084,0.277l2,3c0.153,0.23 0.464,0.292 0.693,0.139c0.23,-0.153 0.292,-0.464 0.139,-0.693l-1.916,-2.874c0,-0 0,-2.849 0,-2.849c0,-0.276 -0.224,-0.5 -0.5,-0.5c-0.276,-0 -0.5,0.224 -0.5,0.5Z"/>
                        <path d="M7,16.5l4,-0c0.276,0 0.5,-0.224 0.5,-0.5c0,-0.276 -0.224,-0.5 -0.5,-0.5l-4,0c-0.276,0 -0.5,0.224 -0.5,0.5c0,0.276 0.224,0.5 0.5,0.5Z"/>
                        <path d="M15.5,7l0,4c0,0.276 0.224,0.5 0.5,0.5c0.276,-0 0.5,-0.224 0.5,-0.5l0,-4c0,-0.276 -0.224,-0.5 -0.5,-0.5c-0.276,-0 -0.5,0.224 -0.5,0.5Z"/>
                        <path d="M25,15.5l-4,0c-0.276,0 -0.5,0.224 -0.5,0.5c0,0.276 0.224,0.5 0.5,0.5l4,-0c0.276,0 0.5,-0.224 0.5,-0.5c0,-0.276 -0.224,-0.5 -0.5,-0.5Z"/>
                        <path d="M16.5,25l0,-4c0,-0.276 -0.224,-0.5 -0.5,-0.5c-0.276,-0 -0.5,0.224 -0.5,0.5l0,4c0,0.276 0.224,0.5 0.5,0.5c0.276,-0 0.5,-0.224 0.5,-0.5Z"/>
                    </svg>
                    <?=$tuto->duree?>
                </span>
            </footer>
        </section>
        </a>
        <?php endforeach?>
        
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
                <p>Chaque défi en mathématiques nous enseigne que derrière chaque problème complexe se cache une solution attendue,rappelle-toi que poursuivre tes rêves est un puzzle que tu es capable de résoudre, alors continue d'avancer, pas à pas, vers l'infini de tes possibilités.</p>
            </div>
            <div class="contact">
                <div class="entete">Me contacter</div>
                <p><i class="fa-solid fa-envelope"></i>   Par email</p>
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
</body>
</html>