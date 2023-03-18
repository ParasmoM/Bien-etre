window.onload = () => {
    const SEARCH_BAR_FORM = document.querySelector('#search_bar');
    const SELECT = document.querySelector('#select_category');

    SELECT.addEventListener('change', () => {
        const FORM = new FormData(SEARCH_BAR_FORM);

        // On fabrique la "queryString"
        const PARAMS = new URLSearchParams();

        FORM.forEach((value, key) => {
            PARAMS.append(key, value);
        })

        // On récupère l'url active
        const currentURL = new URL(window.location.href);

        // On lance la requête ajax
        fetch(currentURL.pathname + "?" + PARAMS.toString() + "&ajax=1", {
            headers: {
                "X-Requested-With": "XMLHttpRequest"
            }
        }).then(response => 
            response.json()
        ).then(data => {
            console.log(data.content);

            // On va chercher la zone de contenu 
            const CONTENT = document.querySelector("#prestataire_card");

            // ON remplace le contenu
            CONTENT.innerHTML = data.content;

            // On met à jour l'url
            history.pushState({}, null, currentURL.pathname + "?" + PARAMS.toString());
        })
    });
};
