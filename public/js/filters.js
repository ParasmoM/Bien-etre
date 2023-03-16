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
        fetch(currentURL.pathname + "?" + PARAMS.toString(), {
            headers: {
                "X-Requested-With": "XMLHttpRequest"
            }
        }).then(response => {
            console.log(response);
        }).catch(e => alert(e));
    });
};
