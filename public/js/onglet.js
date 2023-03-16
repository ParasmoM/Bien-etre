// Sélectionner les éléments avec la classe "btn-onglet"
const BTN_ONGLET = document.querySelectorAll('#btn-onglet');

BTN_ONGLET.forEach(button => {
    button.addEventListener('click', (e) => {
        // Retirer la classe "active"
        BTN_ONGLET.forEach(element => {
            element.classList.remove('active');
        });
        
        // Ajouter la classe "active"
        e.currentTarget.classList.add('active');
        
    })
});


const CARD_SERVICES = document.querySelector('.service');
const CARD_STAGES = document.querySelector('.stage');

BTN_ONGLET[0].addEventListener('click', (e) => {
    CARD_SERVICES.classList.remove('no-show')
    CARD_STAGES.classList.add('no-show');
});
BTN_ONGLET[1].addEventListener('click', (e) => {
    CARD_SERVICES.classList.add('no-show');
    CARD_STAGES.classList.remove('no-show')
});