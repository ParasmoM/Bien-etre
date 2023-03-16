fetch('/prestataire/test')
    .then(response => {
        const contentType = response.headers.get('content-type');
        if (contentType && contentType.includes('application/json')) {
            return response.json();
        } else {
            throw new TypeError('La réponse n\'est pas au format JSON.');
        }
    })
    .then(data => {
        console.log(data[0].content);
    })
    // .catch(error => console.error(error));
