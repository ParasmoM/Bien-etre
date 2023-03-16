// La fonction scrollFunction sera appelée chaque fois que l'utilisateur scrollera la page
window.onscroll = function() {
    scrollFunction();
}

// On récupère l'élément avec l'ID "searchBar" dans une variable searchBar
let searchBar = document.querySelector('#searchBar');

// On initialise une variable isTriggered à false, qui sera utilisée pour savoir si l'effet a déjà été déclenché
let isTriggered = false;

function scrollFunction() {
    // Si l'effet n'a pas encore été déclenché et que l'utilisateur a scrollé à plus de 890px du haut de la page
    if (!isTriggered && (document.body.scrollTop > 890 || document.documentElement.scrollTop > 890)) {
        // On applique un flou et on rend le background de la searchBar "inherit" (on utilise "inherit" pour conserver la couleur de fond définie dans le parent)
        searchBar.style.backdropFilter = "blur(30px)";
        searchBar.style.backgroundColor = "inherit";
        // On met isTriggered à true pour indiquer que l'effet a été déclenché
        isTriggered = true;
    }
    // Si l'effet a été déclenché et que l'utilisateur est à moins de 890px du haut de la page
    else if (isTriggered && (document.body.scrollTop <= 890 && document.documentElement.scrollTop <= 890)) {
        // On enlève le flou et on redéfinit le background de la searchBar à la couleur de fond par défaut (ici #DFE9F5)
        searchBar.style.backdropFilter = "none";
        searchBar.style.backgroundColor = "#e8eef8";
        // On met isTriggered à false pour indiquer que l'effet n'est plus actif
        isTriggered = false;
    }
}

const PROFIL_BTN = document.querySelector('#profil-btn');
const PROFIL_CONTENT = document.querySelector('#profil-content');

// Fonction pour fermer le contenu du profil lorsqu'un clic est effectué à l'extérieur
const closeProfilContent = (event) => {
    if (!PROFIL_CONTENT.contains(event.target)) {
        PROFIL_CONTENT.classList.remove('active');
        document.removeEventListener('click', closeProfilContent);
    }
};

PROFIL_BTN.addEventListener('click', (event) => {
    event.stopPropagation();
    PROFIL_CONTENT.classList.toggle('active');
    document.addEventListener('click', closeProfilContent);
});



/* Formulaires */
let uploadInput = document.getElementById('upload-input');
uploadInput.addEventListener('change', function() {
    this.form.submit();
});

















// const url = window.location.href;
// console.log(url);

// let xhr = new XMLHttpRequest();

// xhr.onreadystatechange = function() {
//     if (xhr.readyState === 4 && (xhr.status === 200 || xhr.status === 0)) {
//         console.log(xhr);
//         const response = JSON.parse(xhr.responseText);
//         const test = response.test;
//         console.log(test);
//     } else if (xhr.readyState < 4) {
//         console.log(xhr.readyState);
//     }
// }

// xhr.open('GET', '/test', true);
// xhr.send();

// console.log(xhr.response);
