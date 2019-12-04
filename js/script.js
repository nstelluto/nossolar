function main () {
const main = document.querySelector('main');
const nav = document.querySelector('nav');
const header = document.querySelector('header');
const nav_links = [...document.querySelectorAll('.nav_link')];
const inputs_texto = [...document.querySelectorAll('input[type="text"], input[type="email"], input[type="password"]')];
const mostrar_senha = [...document.querySelectorAll('.mostrar_senha')];
const produto_usuario = [...document.querySelectorAll('.produto_usuario')];

nav_links.forEach(function (elemento) {
    elemento.addEventListener('click', function (evento) {
        evento.preventDefault();
        const destino = main.querySelector(elemento.getAttribute('href'));
        destino.scrollIntoView({
            block: 'start',
            behavior: 'smooth'
        });
        header.querySelector('h1').innerHTML = destino.getAttribute('data-titulo');
        nav_links.forEach(function (elemento) {
            elemento.classList.remove('ativo');
        });
        elemento.classList.add('ativo');
    })
});

produto_usuario.forEach(function (elemento) {
    elemento.addEventListener('click', function (evento) {
        evento.preventDefault();
        alert('teste');
    })
});

inputs_texto.forEach(function (elemento) {
    const label = document.querySelector('label[for="' + elemento.getAttribute('id') +'"');
    elemento.addEventListener('focus', function () {
        label.classList.add('ativo');
    });
    elemento.addEventListener('blur', function () {
        label.classList.remove('ativo');
    });
});

mostrar_senha.forEach(function (elemento) {
    const senha = elemento.previousElementSibling;
    elemento.addEventListener('change', function () {
        if (elemento.checked) {
            senha.setAttribute('type', 'text');
        } else {
            senha.setAttribute('type', 'password');
        }
    });
});
}
window.onload = main();
