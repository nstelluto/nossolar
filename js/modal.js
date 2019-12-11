const mensagem_modal = document.querySelector('#mensagem_modal');
const controle_modal = document.querySelector('#controle_modal');
const confirmar_modal = document.querySelector('#confirmar_modal');
const cancelar_modal = document.querySelector('#cancelar_modal');

const modal = {
    visivel: false,
    estilo: 0,
    mensagem: mensagem_modal,
    controle: controle_modal,
    valor_controle: 0,
    argumentos: null,
    executar: function (arguments) {
        alert('Teste');
    },
    iniciar: function () {
        const self = this;
        [...self.controle.querySelectorAll('a')].forEach(function(a) {
            a.addEventListener('click', function (evento) {
                evento.preventDefault();
                self.fechar();
                if (parseInt(a.getAttribute('href')) === 1) {
                    self.executar(self.argumentos);
                } else {
                    return false;
                }
            });
        });
        setInterval(() => {
            if (self.visivel) {
                document.body.classList.add('modal_visivel');
            } else {
                document.body.classList.remove('modal_visivel');
            }
            if (self.estilo === 1) {
                self.controle.classList.remove('estado');
                self.controle.classList.add('alerta');
            } else if (self.estilo === 2) {
                self.controle.classList.remove('alerta');
                self.controle.classList.add('estado');
            } else {
                self.controle.classList.remove('estado');
                self.controle.classList.remove('alerta');
            }
        }, 100)
    },
    abrir: function (string) {
        this.mensagem.innerHTML = string;
        this.visivel = true;
    },
    fechar: function () {
        this.visivel = false;
        this.resposta = false;
    }
}

function alertar (string) {
    modal.estilo = 1;
    modal.executar = function () {
        console.log('Confirmado');
    };
    modal.abrir(string);
}

function carregando () {
    const div = document.createElement('div');
    const p = document.createElement('p');
    div.setAttribute('class', 'carregando');
    p.innerHTML = "Carregando";
    div.appendChild(p);
    return div.outerHTML;
}