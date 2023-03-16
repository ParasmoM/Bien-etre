const url = window.location.href;
console.log(url);

let xhr = new XMLHttpRequest();

xhr.onreadystatechange = function() {
    if (xhr.readyState === 4 && (xhr.status === 200 || xhr.status === 0)) {
        console.log(xhr);
        const response = JSON.parse(xhr.responseText);
        const test = response.data;
        console.log(test);
    } else if (xhr.readyState < 4) {
        console.log(xhr.readyState);
    }
}

xhr.open('GET', '/prestataire/test', true);
xhr.send();

console.log(xhr.response);