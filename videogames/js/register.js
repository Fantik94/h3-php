//cibler les éléments HTML
const form = document.querySelector("form");

//événements
form.addEventListener('submit', e => {
    //bloquer la soumission du formulaire
    e.preventDefault();

    const formData = new FormData()
});