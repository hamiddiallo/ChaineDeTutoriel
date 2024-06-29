<?php
session_start();
require "../include/bdd.php";
require "../Fonction/fonction.php";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if($_POST['profil'] == 'etudiant'){
            $_SESSION['etudiant'] = [
                'nom' => $_POST['nom'],
                'prenom' => $_POST['prenom'],
                'password' => $_POST['password'],
                'email' => $_POST['email']
            ];
            header('Location: choisirCours.php');
    }else{
            $_SESSION['instructeur'] = [
                'nom' => $_POST['nom'],
                'prenom' => $_POST['prenom'],
                'password' => $_POST['password'],
                'email' => $_POST['email']
            ];
            header('Location: choisirSpecialite.php');
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>inscription</title>
    <script src="https://kit.fontawesome.com/01cba61c97.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.5.1/gsap.min.js"></script>
    <link rel="stylesheet" href="style/style.css">
    <style>
        /* Vos styles CSS */
        .error {
            color: red;
            display: none;
        }
    </style>

</head>
<body <?= isset($_COOKIE['theme'])?'class='.$_COOKIE['theme']:''?>>
    <header class="header-user diminuerMarge">
        <span class="user"><a href="index.php"><svg class="logo-Youtube" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M549.7 124.1c-6.3-23.7-24.8-42.3-48.3-48.6C458.8 64 288 64 288 64S117.2 64 74.6 75.5c-23.5 6.3-42 24.9-48.3 48.6-11.4 42.9-11.4 132.3-11.4 132.3s0 89.4 11.4 132.3c6.3 23.7 24.8 41.5 48.3 47.8C117.2 448 288 448 288 448s170.8 0 213.4-11.5c23.5-6.3 42-24.2 48.3-47.8 11.4-42.9 11.4-132.3 11.4-132.3s0-89.4-11.4-132.3zm-317.5 213.5V175.2l142.7 81.2-142.7 81.2z"/></svg> &nbsp;&nbsp;Tutoriels</a></span>
    </header>
    <main class="container">
        <div class="containerFormulaire">
            <span class="erreur">
                <i class="fa-solid fa-circle-exclamation"></i>
                cet email existe déja
            </span>
            <span>inscription</span>
            <form class="formInscription" method="post" action="#">
                <label for="nom">nom</label>
                <input type="text" id="nom" name="nom" required> 
                <label for="prenom">prenom</label>
                <input type="text" id="prenom" name="prenom" required>
                <label for="email">email</label>
                <input type="mail" id="email" name="email" required>
                <label for="password">mot de passe</label>
                <div>
                    <i class="fa-solid fa-eye-slash"></i>
                    <input type="password" id="password" name="password" required>
                    <span></span>
                </div>
                <label for="confirmerPassword">confirmer le mot de passe</label>
                <div>
                    <i class="fa-solid fa-eye-slash"></i>
                    <input type="password" id="confirmPassword" name="confirmPassword" required>
                </div>
                <label for="profil">profil</label>
                <div class="profil">
                    <input type="radio" name="profil" value="etudiant" id="etudiant" required>
                    <label class="customRadio" for="etudiant"></label>
                    etudiant
                    <input type="radio" name="profil" value="instructeur" id="instructeur" required>
                    <label class="customRadio" for="instructeur"></label>
                    instructeur
                </div>
                <input name = "inscription"type="submit" value="S'inscrire">
            </form> 
        </div>
    </main>
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
        <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.querySelector('.formInscription')
            const password = document.getElementById('password')
            const confirmPassword = document.getElementById('confirmPassword')
            let messageErreur = document.querySelector('.erreur')
            form.addEventListener('submit', function (event) {
                if (password.value !== confirmPassword.value) {
                    messageErreur.innerHTML = '<i class="fa-solid fa-circle-exclamation"></i>les mots de passe ne correspondent pas'
                    messageErreur.classList.toggle('afficherErreur')
                    event.preventDefault()
                    return setTimeout(()=>{messageErreur.classList.toggle('afficherErreur')},4000)
                    
                }
                let xhr = new XMLHttpRequest();
                let data,url,mail,trouveMail = false;
                let radio = document.querySelector('input[type="radio"]')
                mail = document.querySelector('#email').value
                if(radio.checked == true){
                    url = 'etudiantDonnee.php'
                }else{
                    url = 'instructeurDonnee.php'
                }
                xhr.open('GET', url,true)
                xhr.onreadystatechange = function() {
                    if (this.readyState === XMLHttpRequest.DONE) {
                        if (this.status === 200) {
                            data = JSON.parse(xhr.responseText)
                            for(user of data){
                                console.log(user.mail)
                                if(mail == user.mail){
                                    trouveMail = true;
                                }
                            }

                            if(trouveMail){
                                messageErreur.innerHTML = '<i class="fa-solid fa-circle-exclamation"></i>cet email existe déja'
                                messageErreur.classList.toggle('afficherErreur')
                                setTimeout(()=>{
                                    messageErreur.classList.toggle('afficherErreur')
                                },4000)
                            }else{
                                form.submit()
                            }
                        } else {
                            console.error('Erreur de requête.')
                        }
                    }           
                }
                xhr.send()
                event.preventDefault()
            })
        })
    </script>
</body>
</html>