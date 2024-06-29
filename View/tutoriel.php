<?php
    session_start();
    require "../Include/bdd.php";
    require "../Fonction/fonction.php";
    //verifierAuthentification();
    if (isset($_GET["tuto"])) {
        $video = getRawById($pdo,"lesTutoriels",$_GET["tuto"],"id_tuto");
    }
    if (isset($_SESSION['etudiant'])) {
        $sql = "SELECT * from matiere where idMat in (SELECT idMat from etudiant_matiere) and idMat in (SELECT matiere from tutoriel)";
        $tutoriel = "etudiant.php";
    }
    elseif(isset($_SESSION['instructeur'])){
        $sql = "SELECT * from matiere where idMat in (SELECT idMat from InstructeurMatiere) and idMat in (SELECT matiere from tutoriel)";
        $tutoriel = "instructeur.php";
    }
    else {
        $sql = "SELECT * from matiere where idMat in (SELECT matiere from tutoriel)";
        $tutoriel = "index.php";
    }
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $matiere = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>tutoriel</title>
    <script src="https://kit.fontawesome.com/01cba61c97.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.5.1/gsap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.plyr.io/3.7.8/plyr.css"/>
    <link rel="stylesheet" href="style/style.css">
</head>
<body <?= isset($_COOKIE['theme'])?'class='.$_COOKIE['theme']:''?>>
    <header class="header-user diminuerMarge">
        <span class="user"><a href="<?= $tutoriel?>"><svg class="logo-Youtube" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M549.7 124.1c-6.3-23.7-24.8-42.3-48.3-48.6C458.8 64 288 64 288 64S117.2 64 74.6 75.5c-23.5 6.3-42 24.9-48.3 48.6-11.4 42.9-11.4 132.3-11.4 132.3s0 89.4 11.4 132.3c6.3 23.7 24.8 41.5 48.3 47.8C117.2 448 288 448 288 448s170.8 0 213.4-11.5c23.5-6.3 42-24.2 48.3-47.8 11.4-42.9 11.4-132.3 11.4-132.3s0-89.4-11.4-132.3zm-317.5 213.5V175.2l142.7 81.2-142.7 81.2z"/></svg> &nbsp;&nbsp;Tutoriels</a></span>
    </header>
    <main class="container espacement">
        <div class="cheminTutoriel">
            <a href="<?= $tutoriel?>">Tutoriels</a>
            <svg xmlns="http://www.w3.org/2000/svg" class="delimiteurChemin" viewBox="0 0 320 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M278.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L210.7 256 73.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z"/></svg>
            <a href="<?= $tutoriel?>"><?=$video->matiere?></a>
            <svg xmlns="http://www.w3.org/2000/svg" class="delimiteurChemin" viewBox="0 0 320 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M278.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L210.7 256 73.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z"/></svg>
            <a href="#"><?=$video->titre?></a>            
        </div>
        <h1><?=$video->titre?></h1>
        <div class="container-tutoriel">
                <video class="player"  playsinline controls>
                    <source src="../<?=$video->chemin?>" type="video/mp4" />    
                </video>
                <div class="chapitre">
                <?php foreach($matiere  as $mat):?>
                    <h2><?=$mat->nomMat?></h2>
                    <ul>
                        <?php foreach (getEntityById($pdo,"tutoriel",$mat->idMat,"matiere") as $tuto):?>
                        <?php if(isset($_SESSION['instructeur']) && $tuto->instructeur !=  $_SESSION['instructeur'] || empty($tuto)){
                            continue;
                        }
                        ?>
                        <a href="tutoriel.php?tuto=<?=$tuto->id_tuto?>">
                            <li <?= ($tuto->id_tuto == $_GET['tuto'])?'class="videoARegarder"':""?>>
                                <div class="progressButton">
                                    <svg class="play" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M15 12.3301L9 16.6603L9 8L15 12.3301Z" fill="currentColor"/></svg>
                                    <svg viewBox="0 0 100 100">
                                        <circle cx="50" cy="50" r="45" stroke-width="5" stroke-dasharray="283" stroke-dashoffset="283" />
                                    </svg>
                                </div>
                                <span class="titre"><?=$tuto->titre?></span> 
                                <span class="duree"><?=$tuto->duree?></span>
                            </li>
                        </a>
                        <?php endforeach?>
                <?php endforeach?>
                </ul>
            </div>
        </div>
        <div class="info">
            <div class="<?=$video->niveau?>"><?=$video->niveau?></div>
            <a href="../<?=$video->chemin?>"  download="video.mp4">
                <div class="telechargement">
                        <svg class="logo-Youtube" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M549.7 124.1c-6.3-23.7-24.8-42.3-48.3-48.6C458.8 64 288 64 288 64S117.2 64 74.6 75.5c-23.5 6.3-42 24.9-48.3 48.6-11.4 42.9-11.4 132.3-11.4 132.3s0 89.4 11.4 132.3c6.3 23.7 24.8 41.5 48.3 47.8C117.2 448 288 448 288 448s170.8 0 213.4-11.5c23.5-6.3 42-24.2 48.3-47.8 11.4-42.9 11.4-132.3 11.4-132.3s0-89.4-11.4-132.3zm-317.5 213.5V175.2l142.7 81.2-142.7 81.2z"/></svg> 
                        telecharger la video
                </div>
            </a>
        </div>
    </main>
    <div class="aProposDuTuto">
        <h1>À propos de ce tutoriel</h1>
        <p><?=$video->description?></p>
    </div>
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
    <script src="script/script.js"></script>
    <script src="https://cdn.plyr.io/3.7.8/plyr.js"></script>
    <script>
            const player = new Plyr('.player');
            player.on('play', function() {
                document.querySelector('.plyr__controls').style.display = 'flex';
            })

            player.on('pause', function() {
                document.querySelector('.plyr__controls').style.display = 'none';
            });
    </script>
</body>
</html>