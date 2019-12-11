const main = document.querySelector('main');
const header = document.querySelector('header');
const campos_form = [...document.querySelectorAll('input[type="text"], input[type="email"], input[type="password"]')];
const mostrar_senha = [...document.querySelectorAll('.mostrar_senha')];
const nav_links = [...document.querySelectorAll('.nav_link')];
const login_form = document.querySelector('#login_form');
const cadastro_form = document.querySelector('#cadastro_form');

function validarForm (formulario) {
    const formdata = new FormData(formulario);
    let validado = true;
    for (let campo of formdata.keys()) {
        const input = formulario.querySelector('[name=' + campo + ']');
        const id = input.getAttribute('id');
        const label = formulario.querySelector('[for='+ id +']');
        label.classList.remove('invalido');
        if (campo === 'confirmar_senha') {
            const senha = formulario.querySelector('#cadastro_senha');
            if (input.value !== senha.value) {
                label.classList.add('invalido');
                validado = false;
            }
        }
        if (campo === 'cadastro_email') {
            if (input.value.indexOf('@') === -1) {
                label.classList.add('invalido');
                validado = false;
            }
        }
        if (!formdata.get(campo)) {
            label.classList.add('invalido');
            validado = false;
        }
    }
    if (validado) {
        formdata.append('envio', formulario.getAttribute('data-tipo'));
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'crud.php');
        xhr.onloadstart = () => {
            header.innerHTML = carregando();
        }
        xhr.onloadend = () => {
            const resposta = JSON.parse(xhr.response);
            modal.abrir(resposta.texto);
            if (resposta.codigo == 1) {
                const url = window.location.origin + window.location.pathname;
    
                modal.estilo = 1;
                modal.executar = function () {
                    window.location.assign(url);
                };
                modal.abrir(resposta.texto);
            } else if (resposta.codigo == 2) {
                modal.estilo = 1;
                modal.executar = function () {
                    nav_links[0].click();
                    nav_links[0].classList.add('ativo');
                    nav_links[1].classList.remove('ativo');
                    header.innerHTML = '<h1>Login</h1>';
                };
                modal.abrir(resposta.texto);
            } else {
                alertar(resposta.texto);
                header.innerHTML = '<h1>Nosso Lar</h1>';
            }
        }
        xhr.send(formdata);
    } else {
        alertar('Campos inválidos!');
    }
}

login_form.addEventListener('submit', function (event) {
    event.preventDefault();
    validarForm(login_form);
});

cadastro_form.addEventListener('submit', function (event) {
    event.preventDefault();
    validarForm(cadastro_form);
});

nav_links.forEach(function (elemento) {
    elemento.addEventListener('click', function (evento) {
        evento.preventDefault();
        document.body.classList.add('inteiro');
        const href = elemento.getAttribute('href');
        const destino = main.querySelector('#' + href);
        const xhr = new XMLHttpRequest();
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

campos_form.forEach(function (elemento) {
    let limite = 32;
    const label = document.querySelector('label[for="' + elemento.getAttribute('id') +'"');
    if (elemento.getAttribute('name').indexOf('senha') !== -1) {
        limite = 40;
        if (elemento.getAttribute('name') == 'confirmar_senha') {
            const cadastro_senha = document.querySelector('#cadastro_senha');
            elemento.addEventListener('input', function () {
                if (elemento.value !== cadastro_senha.value) {
                    label.classList.add('invalido');
                } else {
                    label.classList.remove('invalido');
                    label.classList.add('valido');
                }
            });
        }
    } else if (elemento.getAttribute('name').indexOf('usuario') !== -1) {
        limite = 16;
    }
    elemento.addEventListener('input', function () {
        elemento.value = (elemento.value.length < limite) ? elemento.value: elemento.value.substr(0, limite);
    });
    elemento.addEventListener('focus', function () {
        label.classList.add('ativo');
        label.classList.remove('invalido');
    });
    elemento.addEventListener('blur', function () {
        label.classList.remove('ativo');
        label.classList.remove('invalido');
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

if (window.location.search !== '') {
    console.log(window.location.search);
    window.location.assign(window.location.origin + window.location.pathname);
}

modal.iniciar();

localStorage.setItem('carrinho_de_almas', '{}');