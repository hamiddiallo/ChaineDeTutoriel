const bouttonTheme = document.querySelector(".champ")

if(bouttonTheme){
    document.addEventListener("DOMContentLoaded",()=>{
        
    })

    bouttonTheme.addEventListener("click",()=>{
        const bouttonArrondie = document.querySelector(".bouttonRond")
        const date = new Date()
        date.setTime(date.getTime() + (30 * 24 * 60 * 60 * 1000))
        expires = "; expires=" + date.toUTCString();
        let value = " "
        if(document.cookie.slice(0,16) == "theme=theme-dark"){
            gsap.to(bouttonArrondie, {duration: .2,x:0,ease: "power1.out"})
            bouttonArrondie.firstElementChild.className = "fa-regular fa-sun"
            bouttonArrondie.firstElementChild.style.color = "#d2921c"
            bouttonArrondie.style.background = "#fff"
        }else{
            gsap.to(bouttonArrondie, {duration: .2,x: 40,ease: "power1.out"})
            bouttonArrondie.firstElementChild.className = "fa-regular fa-moon"
            bouttonArrondie.firstElementChild.style.color = "#d4dcff"
            bouttonArrondie.style.background = "#5396e7"
            value = "theme-dark"
        }
        document.body.classList.toggle("theme-dark")
        document.cookie = "theme=" + value + expires;
    })
    
}

const fonctionnalite = document.querySelector("#user-name")

if(fonctionnalite != null){
    const cadreFonctionnalite = document.querySelector(".fonctionnalite")
    fonctionnalite.addEventListener("click",function(){
            cadreFonctionnalite.style.display = "block"
            gsap.fromTo(cadreFonctionnalite,{
                y:0,
                opacity:0
            },{
                y:13,
                opacity:1,
                duration:.3
            })
    })

    cadreFonctionnalite.addEventListener("mouseleave",function (){
        gsap.fromTo(cadreFonctionnalite,{
            y:13,
            opacity:1
        },{
            y:0,
            opacity:0,
            duration:.3
        })  
        setTimeout(()=>{cadreFonctionnalite.style.display = "none"},300)
    })
    
}

const afficherPopup =  function (){
    document.body.style.overflow = 'hidden'
    popupOverlay.style.display = 'block'
    

}

const pens = document.querySelectorAll('.edit-btn');
const popupOverlay = document.querySelector('.popup-overlay');
const editForm = document.getElementById('editForm');

if (pens != null) {
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
        // const videoElements = document.querySelectorAll('#editForm .video');
        // videoElements.forEach(element => {
        // element.style.display = 'none';
        // })

        afficherPopup();
    }));
}

if(popupOverlay != null){
    popupOverlay.addEventListener('click',event=>{
        if (event.target.dataset.close) {
            document.body.style.overflow = 'visible'
            popupOverlay.style.display = 'none';
    }})
    
}

const popup = document.querySelector('.popup');

if(popup != null){
    popup.addEventListener('click', event =>event.stopPropagation())
}

const bouttonAjouter = document.querySelector(".ajouter")

if(bouttonAjouter != null){
        bouttonAjouter.addEventListener("click",()=>{   
            console.log(editForm.id_tuto.value,editForm.titre.value,editForm.description.value,editForm.matiere.value,editForm.niveau.value)
            if(editForm.id_tuto.value != ' '  && editForm.titre.value != ' ' && editForm.description.value != ' ' && editForm.matiere.value != ' ' && editForm.niveau.value != ' '){
                editForm.id_tuto.value = ' '
                editForm.titre.value = ' '
                editForm.description.value = ' '
                editForm.matiere.value = ' '
                editForm.niveau.value = ' '
            }
        document.querySelector(".fonctionnalites").name="ajouter"
        document.querySelector(".popup span").textContent = "ajouter un tutoriel"
        document.querySelector("form input:last-child").value = "ajouter"
        afficherPopup()
    })
}

const video = document.querySelector('.player');
const progressButton = document.querySelector('.videoARegarder  .progressButton');
const progressCircle = progressButton!= null ? progressButton.querySelector('circle'): null

if(video != null && progressButton != null && progressCircle != null){
    video.addEventListener('timeupdate', function () {
        const percentage = video.currentTime / video.duration;
        const offset = 283 * (1 - percentage);
        progressCircle.style.strokeDashoffset = offset.toString();
    });
    
    progressButton.addEventListener('click', function () {
        if (video.paused) {
            video.play();
        } else {
            video.pause();
        }
    });
}

const icons = document.querySelectorAll(".fa-solid.fa-eye-slash")

if(icons != null){
    icons.forEach(icon =>{
        icon.addEventListener("click",function (){
            if(this.className == 'fa-solid fa-eye-slash'){
                this.className = 'fa-solid fa-eye'
                this.nextElementSibling.type = "text"
            }else{
                this.className = 'fa-solid fa-eye-slash'
                this.nextElementSibling.type = "password"
            }
        })
    })
}

window.addEventListener("load",()=>{
    gsap.fromTo(
        document.querySelector('.containerFormulaire'),
        {
            y:130   ,
            opacity:0
        },
        {
            y:0,
            opacity:1,
            duration:.8
        }
    )
})


document.addEventListener('DOMContentLoaded', function() {
    const tooltipContainers = document.querySelectorAll('.tooltip-container')
    if(tooltipContainers){
        tooltipContainers.forEach(container => {
            const tooltipText = container.getAttribute('data-tooltip')
            const tooltipElement = document.createElement('div')
            tooltipElement.classList.add('tooltip-text')
            tooltipElement.innerText = tooltipText
            container.appendChild(tooltipElement)
        
            container.addEventListener('mouseenter', function() {
              tooltipElement.style.visibility = 'visible'
              tooltipElement.style.opacity = '1'
            })
        
            container.addEventListener('mouseleave', function() {
              tooltipElement.style.visibility = 'hidden'
              tooltipElement.style.opacity = '0'
            })
          })
    }
  })


const buttonSoumission = document.querySelector('.ajouterSupprimer button')

if(buttonSoumission){
    buttonSoumission.addEventListener('click',()=>{
        suppression.submit()
    })
}