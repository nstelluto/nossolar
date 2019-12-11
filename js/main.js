const main = document.querySelector('main');
const aside = document.querySelector('aside');
const aside_produto = document.querySelector('#produto');
const novo_produto = document.querySelector('#novo_produto');
const nav = document.querySelector('nav');
const header = document.querySelector('header');
const nav_links = [...document.querySelectorAll('.nav_link')];

let contador = 0;

function trocar_slide (slide, direcao) {
    contador += (direcao === 'esquerda')? -1: 1;
    const quantia = slide.length - 1;
    if (contador > quantia) {
        contador = 0;
    } else if (contador < 0) {
        contador = quantia;
    }
    slide.forEach(function (elemento) {
        elemento.classList.remove('visivel');
    });
    setTimeout(function () {
        slide[contador].classList.add('visivel');
    },500);
}

function loadSection (href) {
    console.log(href);
    if (href == 'perfil_section') {
        const section_produtos = document.querySelector('#produtos_usuario');
        const estoque_usuario = document.querySelector('#estoque_usuario');
        const produtos_usuario = [...estoque_usuario.querySelectorAll('a:not(#add_novo_produto)')];
        const editar_usuario = document.querySelector('#editar_usuario');
        const add_novo_produto = document.querySelector('#add_novo_produto');
        const nome_usuario = document.querySelector('#nome_usuario').querySelector('span');

        if (!editar_usuario) {
            console.log(nome_usuario.innerText)
        } else {
            editar_usuario.addEventListener('click', function (event) {
                event.preventDefault();
                const xhr = new XMLHttpRequest();
                const solicitacao = new FormData();
                solicitacao.append('solicitar_edicao', editar_usuario.getAttribute('href'));
                xhr.open('POST', 'crud.php');
                xhr.onloadend = function () {
                    modal.executar = function () {
                        const segundo_xhr = new XMLHttpRequest();
                        const formdata = new FormData(modal.mensagem.querySelector('form'));
                        segundo_xhr.open('POST', 'crud.php');
                        segundo_xhr.onloadstart = function () {
                            modal.executar = function () {
                                console.log('Enviando');
                            }
                            modal.estilo = 2;
                            modal.abrir(carregando());
                        }
                        segundo_xhr.onloadend = function () {
                            modal.abrir(segundo_xhr.response);
                            const form = modal.mensagem.querySelector('form');

                            if (!form) {
                                modal.estilo = 1;
                                modal.executar = function () {
                                    console.log('Concluído');
                                }
                            } else {
                                modal.estilo = 0;
                                modal.executar = function () {
                                    const terceiro_xhr = new XMLHttpRequest();
                                    const formulario = new FormData(form);
                                    terceiro_xhr.open('POST', 'crud.php');
                                    terceiro_xhr.onloadstart = function () {
                                        modal.executar = function () {
                                            console.log('Enviando');
                                        }
                                        modal.estilo = 2;
                                        modal.abrir(carregando());
                                    }
                                    terceiro_xhr.onloadend = function () {
                                        const resposta = JSON.parse(terceiro_xhr.response);
                                        if (resposta.codigo === 1) {
                                            modal.executar = function () {
                                                nav_links[0].click();
                                            }
                                        } else {
                                            modal.executar = function () {
                                                console.log('Concluído');
                                            }
                                        }
                                        modal.estilo = 1;
                                        modal.abrir(resposta.texto);
                                    }
                                    terceiro_xhr.send(formulario);
                                }
                            }
                        }
                        segundo_xhr.send(formdata);
                    }
                    modal.estilo = 0;
                    modal.abrir(xhr.response);
                }
                xhr.send(solicitacao);
            });
            add_novo_produto.addEventListener('click', function (event) {
                event.preventDefault();
                const xhr = new XMLHttpRequest();
                const solicitacao = new FormData();
                solicitacao.append('solicitar_adicao', editar_usuario.getAttribute('href'));
                xhr.open('POST', 'crud.php');
                xhr.onloadend = function () {
                    modal.estilo = 0;
                    modal.abrir(xhr.response);
                    const formulario = modal.mensagem.querySelector('form');
                    const nivel = formulario.querySelector('select');
                    const {0:nome, 1:quantia, 2:preco} = formulario.querySelectorAll('input');
                    const limite = 32;

                    function sugerir () {
                        const nv = parseInt(nivel.value);
                        const ml = parseInt(quantia.value);
                        const rpm = nv * 50;
                        const sugerido = !nv || !ml? 50: rpm * ml;

                        preco.setAttribute('placeholder', 'Sugerido: $ ' + sugerido.toFixed(2));
                    }

                    nome.addEventListener('input', function () {
                        if (nome.value.length > limite) {
                            nome.value = nome.value.substr(0, limite);
                        }
                    });

                    [nivel, quantia].forEach(function (elemento) {
                        elemento.addEventListener('change', function () {
                            sugerir();
                        });
                    });

                    [preco, quantia].forEach(function (elemento) {
                        elemento.addEventListener('input', function () {
                            elemento.value = elemento.value.replace(/[^0-9.]/g, '');
                        });
                    });

                    quantia.addEventListener('input', function () {
                        if (parseInt(quantia.value) > 100) {
                            quantia.value = 100;
                        }
                        if (parseInt(quantia.value) < 1) {
                            quantia.value = 1;
                        }
                        sugerir();
                    });

                    preco.addEventListener('focus', function () {
                        if (preco.value.length === 0) {
                            preco.value = preco.getAttribute('placeholder').replace(/[^0-9.]/g, '');
                        }
                    });

                    modal.executar = function () {
                        const xhr = new XMLHttpRequest();
                        const formdata = new FormData(formulario);
                        formdata.append('adicionar_produto', editar_usuario.getAttribute('href'));
                        xhr.open('POST', 'crud.php');
                        xhr.onloadstart = function () {
                            modal.executar = function () {
                                console.log('Enviando');
                            }
                            modal.estilo = 2;
                            modal.abrir(carregando());
                        }
                        xhr.onloadend = function () {
                            const resposta = JSON.parse(xhr.response);
                            if (resposta.codigo === 1) {
                                modal.executar = function () {
                                    nav_links[0].click();
                                }
                            } else {
                                modal.executar = function () {
                                    console.log('Concluído');
                                }
                            }
                            modal.estilo = 1;
                            modal.abrir(resposta.texto);
                        }
                        xhr.send(formdata);
                    }
                    
                }
                xhr.send(solicitacao);
            });
        }
        
        if (produtos_usuario.length === 0) {
            if (!editar_usuario) {
                section_produtos.style.display = 'none';            
            }
        } else {
            produtos_usuario.forEach(function (elemento) {
                elemento.addEventListener('click', function (event) {
                    event.preventDefault();
                    mostrar_produto(elemento.getAttribute('href'));
                });
            });
        }
    }
    if (href == 'home_section') {
        const section = document.getElementById(href);
        const anterior = section.querySelector('a.anterior');
        const proximo = section.querySelector('a.proximo');
        const slide = [...section.querySelector('#slide').children];
        const restantes = [...section.querySelector('#home_produtos').children];

        slide.forEach(function (elemento) {
            elemento.addEventListener('click', function (event) {
                event.preventDefault();
                mostrar_produto(elemento.getAttribute('href'));
            });
        });
        
        restantes.forEach(function (elemento) {
            elemento.addEventListener('click', function (event) {
                event.preventDefault();
                mostrar_produto(elemento.getAttribute('href'));
            });
        });

        slide[0].classList.add('visivel');
        let temporizador = setInterval(function () {
            trocar_slide(slide);
        }, 5000);

        anterior.addEventListener('click', function () {
            clearInterval(temporizador);
            trocar_slide(slide, 'esquerda');
            temporizador = setInterval(function () {
                trocar_slide(slide);
            }, 5000);
        });
        proximo.addEventListener('click', function () {
            clearInterval(temporizador);
            trocar_slide(slide);
            temporizador = setInterval(function () {
                trocar_slide(slide);
            }, 5000);
        });
    }
    if (href == 'carrinho_section') {
        const section = document.getElementById(href);
        const carrinho_produtos = [...section.querySelector('#carrinho_produtos').children];
        
        carrinho_produtos.forEach(function (elemento) {
            elemento.addEventListener('click', function (event) {
                event.preventDefault();
                console.log('teste');
                mostrar_produto(elemento.getAttribute('href'));
            });
        });
    }
    if (href == 'busca_section') {
        const input_busca = document.querySelector('#input_busca');
        const resultado_busca = document.querySelector('#resultado_busca');
        let temporizador = 0;
        const limite = 80;

        function ResetarBusca (busca) {
            window.clearTimeout(temporizador);
            temporizador = setTimeout(function () {
                Buscar(busca);
            }, 2000);
        }

        function Buscar (busca) {
            const xhr = new XMLHttpRequest();
            xhr.open('GET', 'crud.php?busca=' + busca);
            xhr.onloadstart = function () {
                resultado_busca.innerHTML = carregando();
            }
            xhr.onloadend = function () {
                resultado_busca.innerHTML = xhr.response;
                const {
                    0:produtos,
                    1:usuarios
                } = resultado_busca.querySelectorAll('#resultado_busca > div');
                [...produtos.querySelectorAll('a')].forEach(function (a) {
                    a.addEventListener('click', function (event) {
                        event.preventDefault();
                        mostrar_produto(a.getAttribute('href'));
                    });
                });
                [...usuarios.querySelectorAll('a')].forEach(function (a) {
                    a.addEventListener('click', function (event) {
                        event.preventDefault();
                        loadPerfil(a.getAttribute('href'));
                    });
                });
            }
            xhr.send();
        }

        input_busca.addEventListener('keyup', function (event) {
            if (input_busca.value.length > 1) {
                ResetarBusca(input_busca.value);
            }
            if (event.key == 'Enter') {
                window.clearTimeout(temporizador);
                Buscar(input_busca.value);
            }
            if (input_busca.value.length > limite) {
                window.clearTimeout(temporizador);
                input_busca.value = input_busca.value.substr(0, limite);
            }
        });
    }
}

function loadPerfil (href) {
    nav_links.forEach(function (elemento) {
        elemento.classList.remove('ativo');
    });
    document.body.classList.add('inteiro');
    const destino = main.querySelector('#perfil_section');
    const xhr = new XMLHttpRequest();
    xhr.open('GET','sections/perfil_section.php' + '?perfil=' + href);
    xhr.onloadstart = function () {
        destino.innerHTML = carregando();
        destino.scrollIntoView({
            block: 'start',
            behavior: 'smooth'
        });
    }
    xhr.onloadend = function () {
        destino.innerHTML = xhr.response;
        loadSection('perfil_section');
    }
    xhr.send();
    header.querySelector('h1').innerHTML = destino.getAttribute('data-titulo');
}

function loadProduto () {
    const nome_produto = document.querySelector('#nome_produto');
    const nivel_produto = document.querySelector('#nivel_produto');
    const quatia_produto = document.querySelector('#quatia_produto');
    const preco_produto = document.querySelector('#preco_produto');
    const sugerido_produto = document.querySelector('#sugerido_produto');
    const desconto_produto = document.querySelector('#desconto_produto');
    const comprar_produto = document.querySelector('#comprar_produto');
    const deletar_produto = document.querySelector('#deletar_produto');
    const visitar_perfil = [...document.querySelectorAll('.visitar_perfil')];
    const editar_comentario = [...document.querySelectorAll('.editar_comentario')];
    const remover_comentario = [...document.querySelectorAll('.remover_comentario')];
    const responder_comentario = [...document.querySelectorAll('.responder_comentario')];
    const comentar_produto = document.querySelector('#comentar_produto');
    const alma_id = !comprar_produto? deletar_produto.getAttribute('href'): comprar_produto.getAttribute('href');

    function removerComentario (comentario_id, tipo_comentario, alma_id) {
        const formdata = new FormData();
        const xhr = new XMLHttpRequest();
        formdata.append('remover_comentario', comentario_id);
        formdata.append('tipo_comentario', tipo_comentario);
        xhr.open('POST', 'crud.php');
        xhr.onloadstart = function () {
            modal.executar = function () {
                console.log('Enviando');
            }
            modal.estilo = 2;
            modal.abrir(carregando());
        }
        xhr.onloadend = function () {
            const resposta = JSON.parse(xhr.response);
            modal.estilo = 1;
            if (resposta.codigo === 1) {
                modal.executar = function () {
                    mostrar_produto(alma_id);
                }
            }
            modal.abrir(resposta.texto);
        }
        xhr.send(formdata);
    }

    function editarComentario (comentario_id, tipo_comentario, texto, alma_id) {
        const formdata = new FormData();
        const xhr = new XMLHttpRequest();
        formdata.append('editar_comentario', comentario_id);
        formdata.append('tipo_comentario', tipo_comentario);
        formdata.append('texto', texto);
        xhr.open('POST', 'crud.php');
        xhr.onloadstart = function () {
            modal.executar = function () {
                console.log('Enviando');
            }
            modal.estilo = 2;
            modal.abrir(carregando());
        }
        xhr.onloadend = function () {
            const resposta = JSON.parse(xhr.response);
            modal.estilo = 1;
            if (resposta.codigo === 1) {
                modal.executar = function () {
                    mostrar_produto(alma_id);
                }
            }
            modal.abrir(resposta.texto);
        }
        xhr.send(formdata);
    }

    function comentarProduto (alma_id, comentario_alvo = 0, tipo_comentario = 'comentario') {
        const textarea = document.createElement('textarea');
        textarea.setAttribute('name', tipo_comentario);
        textarea.setAttribute('class', 'modal_input');
        if (tipo_comentario === 'comentario') {
            textarea.setAttribute('placeholder', 'Digite seu comentário...');
        } else {
            textarea.setAttribute('placeholder', 'Digite sua resposta...');
        }
        modal.executar = function () {
            const comentario = modal.mensagem.querySelector('textarea');
            const formdata = new FormData();
            const xhr = new XMLHttpRequest();
            formdata.append(tipo_comentario, comentario.value);
            if (tipo_comentario === 'comentario') {
                formdata.append('produto', parseInt(alma_id));
            } else {
                formdata.append('comentario_alvo', comentario_alvo);
            }
            xhr.open('POST', 'crud.php');
            xhr.onloadstart = function () {
                modal.executar = function () {
                    console.log('Enviando');
                }
                modal.estilo = 2;
                modal.abrir(carregando());
            }
            xhr.onloadend = function () {
                for (let pika of formdata.entries()) {
                    console.log(pika[0] +'='+pika[1]);
                }
                console.log(xhr.response);
                const resposta = JSON.parse(xhr.response);
                modal.estilo = 1;
                if (resposta.codigo === 1) {
                    modal.executar = function () {
                        mostrar_produto(alma_id);
                    }
                }
                modal.abrir(resposta.texto);
            }
            xhr.send(formdata);
        }
        modal.estilo = 0;
        modal.abrir(textarea.outerHTML);
    }
    
    if (!comprar_produto) {
        
        deletar_produto.addEventListener('click', function (event) {
            event.preventDefault();
            modal.executar = function () {
                const formdata = new FormData();
                formdata.append('excluir_produto', alma_id);
                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'crud.php');
                xhr.onloadstart = () => {
                    modal.executar = function () {
                        console.log("Enviando");
                    }
                    modal.estilo = 2;
                    modal.abrir(carregando());
                }
                xhr.onloadend = () => {
                    modal.estilo = 1;
                    modal.abrir(xhr.response);
                    carregar('perfil_section');
                }
                xhr.send(formdata);
            }
            modal.estilo = 0;
            modal.abrir('Deseja mesmo excluir o produto?');
        });
        
    } else {
        let carrinho = JSON.parse(localStorage.getItem('carrinho_de_almas'));
        function alterar_carrinho () {
            if (alma_id in carrinho) {
                comprar_produto.querySelector('i').innerHTML = 'remove_shopping_cart';
                comprar_produto.querySelector('span').innerHTML = 'Remover do carrinho';
                comprar_produto.classList.add('remover');
            } else {
                comprar_produto.querySelector('i').innerHTML = 'add_shopping_cart';
                comprar_produto.querySelector('span').innerHTML = 'Adicionar ao carrinho';
                comprar_produto.classList.remove('remover');
            }
        }
        alterar_carrinho();
        comprar_produto.addEventListener("click",function(event){
            event.preventDefault();
            if (comprar_produto.classList.contains('remover')) {
                delete carrinho[alma_id];
                localStorage.setItem('carrinho_de_almas', JSON.stringify(carrinho));
            } else {
                let alma = {};
                alma['id'] = alma_id;
                alma['nome'] = nome_produto.innerText;
                alma['quantia'] = quantia_produto.innerText;
                alma['preco'] = preco_produto.innerText;
                carrinho = !carrinho? {}: carrinho;
                carrinho[alma['id']] = alma;
                localStorage.setItem('carrinho_de_almas', JSON.stringify(carrinho));
            }
            carregarCarrinho();
            loadSection('carrinho_section');
            alterar_carrinho();
        });
        visitar_perfil.forEach(function (usuario) {
            usuario.addEventListener('click', function (event) {
                event.preventDefault();
                loadPerfil(usuario.getAttribute('href'));
            });
        });
        comentar_produto.addEventListener('click', function (event) {
            event.preventDefault();
            console.log('ok')
            comentarProduto(alma_id);
        });
    }
    remover_comentario.forEach(function (elemento) {
        elemento.addEventListener('click', function (event) {
            event.preventDefault();
            modal.estilo = 0;
            modal.executar = function () {
                removerComentario(elemento.getAttribute('href'), elemento.getAttribute('data-tipo'), alma_id);
            }
            modal.abrir('Confirmar ação');
        });
    });
    responder_comentario.forEach(function (elemento) {
        elemento.addEventListener('click', function (event) {
            event.preventDefault();
            comentarProduto(alma_id, elemento.getAttribute('href'), 'resposta');
        });
    });
    editar_comentario.forEach(function (elemento) {
        elemento.addEventListener('click', function (event) {
            event.preventDefault();
            const comentario_id = elemento.getAttribute('href');
            const tipo_comentario = elemento.getAttribute('data-tipo');
            const textarea = document.createElement('textarea');
            const texto = 
                document.querySelector('div[data-'+tipo_comentario+'="'+comentario_id+'"]').
                querySelector('p').
                innerText;
            textarea.setAttribute('name', 'texto');
            textarea.setAttribute('class', 'modal_input');
            if (tipo_comentario === 'comentario') {
                textarea.setAttribute('placeholder', 'Digite seu comentário...');
            } else {
                textarea.setAttribute('placeholder', 'Digite sua resposta...');
            }
            modal.executar = function () {
                const texto = modal.mensagem.querySelector('textarea');
                editarComentario(comentario_id, tipo_comentario, texto.value, alma_id);
            }
            modal.estilo = 0;
            modal.abrir(textarea.outerHTML);
            modal.mensagem.querySelector('textarea').value = texto;
        });
    });
}

function mostrar_produto (href) {
    document.body.classList.remove('inteiro');
    const xhr = new XMLHttpRequest();
    xhr.open('GET','sections/produto.php?id=' + href);
    xhr.onloadstart = function () {
        aside_produto.innerHTML = carregando();
        aside_produto.scrollIntoView({
            block: 'start',
            behavior: 'smooth'
        });
    }
    xhr.onloadend = function () {
        aside_produto.innerHTML = xhr.response;
        loadProduto();
    }
    xhr.send();
}

function carregar (href) {
    document.body.classList.add('inteiro');
    const destino = main.querySelector('#' + href);
    const xhr = new XMLHttpRequest();
    xhr.open('GET','sections/' + href + '.php');
    xhr.onloadstart = function () {
        destino.innerHTML = carregando();
        destino.scrollIntoView({
            block: 'start',
            behavior: 'smooth'
        });
    }
    xhr.onloadend = function () {
        destino.innerHTML = xhr.response;
        loadSection(href);
    }
    xhr.send();
    header.querySelector('h1').innerHTML = destino.getAttribute('data-titulo');
}

function carregarCarrinho () {
    const destino = main.querySelector('#carrinho_section');
    const carrinho = JSON.parse(localStorage.getItem('carrinho_de_almas'));
    const finalizar = document.createElement('a');
    const cancelar = document.createElement('a');
    const card_f = document.createElement('i');
    const card_c = document.createElement('i');
    const div = document.createElement('div');
    const carrinho_acoes = document.createElement('div');
    finalizar.setAttribute('href', '#');
    cancelar.setAttribute('href', '#');
    finalizar.setAttribute('id', 'finalizar_compra');
    cancelar.setAttribute('id', 'cancelar_compra');
    card_f.setAttribute('class', 'material-icons');
    card_c.setAttribute('class', 'material-icons');
    card_f.innerHTML = "credit_card";
    card_c.innerHTML = "cancel_presentation";
    div.setAttribute('id', 'carrinho_produtos');
    finalizar.innerHTML = card_f.outerHTML + " Finalizar compra";
    cancelar.innerHTML = card_c.outerHTML + " Cancelar compra";
    carrinho_acoes.setAttribute('id','carrinho_acoes')
    carrinho_acoes.appendChild(finalizar);
    carrinho_acoes.appendChild(cancelar);
    
    destino.innerHTML = carregando();

    for (let produto in carrinho) {
        console.log(produto)
        const a = document.createElement('a');
        const i = document.createElement('i');
        const nome = document.createElement('span');
        const ml = document.createElement('span');
        const preco = document.createElement('span');
        
        a.setAttribute('href', carrinho[produto]['id']);
        a.setAttribute('class', 'card_produto');
        a.setAttribute('title', carrinho[produto]['nome']);
        i.setAttribute('class','material-icons');
        i.innerText = 'delete_outline';
        nome.setAttribute('class', 'estoque_nome');
        nome.innerText = carrinho[produto]['nome'];
        ml.setAttribute('class', 'estoque_ml');
        ml.innerText = carrinho[produto]['quantia'];
        preco.setAttribute('class', 'estoque_preco');
        preco.innerText = carrinho[produto]['preco'];
        a.appendChild(i);
        a.appendChild(nome);
        a.appendChild(ml);
        a.appendChild(preco);
        div.appendChild(a);
    }
    if (Object.keys(JSON.parse(localStorage.getItem('carrinho_de_almas'))).length > 0) {
        destino.innerHTML = carrinho_acoes.outerHTML + div.outerHTML;
        destino.querySelector('#finalizar_compra').addEventListener('click', function (event) {
            event.preventDefault();
            modal.executar = function () {
                modal.executar = function () {
                    console.log('Compra realizada');
                    window.location.assign('?sair=ok');
                }
                const mandado = document.createElement('div');
                const titulo = document.createElement('h2');
                const texto = document.createElement('p');
                titulo.innerText = 'FLAGRADO!';
                texto.innerText = 'Você foi flagrado efetuando uma compra de almas, ' +
                    'que é estritamente ilegal neste território. ' +
                    'As unidades da Polícia Federal mais próximas foram acionadas e devem, ' +
                    'em breve, chegar ao local com um mandado de prisão em flagrante.';
                mandado.setAttribute('id', 'mandado');
                mandado.appendChild(titulo);
                mandado.appendChild(texto);
                modal.estilo = 1;
                modal.abrir(mandado.outerHTML);
            }
            modal.estilo = 0;
            modal.abrir('Confirmar compra');
        });
        destino.querySelector('#cancelar_compra').addEventListener('click', function (event) {
            event.preventDefault();
            modal.executar = function () {
                localStorage.setItem('carrinho_de_almas', '{}');
                carregarCarrinho();
            }
            modal.estilo = 0;
            modal.abrir('Confirmar cancelamento');
        });
    } else {
        destino.innerHTML = div.outerHTML;
    }
}

nav_links.forEach(function (elemento) {
    elemento.addEventListener('click', function (evento) {
        evento.preventDefault();
        const href = elemento.getAttribute('href');
        nav_links.forEach(function (elemento) {
            elemento.classList.remove('ativo');
        });
        if (href == 'sair') {
            const url = window.location.origin + window.location.pathname;

            modal.estilo = 0;
            modal.executar = function () {
                window.location.assign(url+'?sair=ok');
            };

            modal.abrir('Deseja mesmo sair?');

            return false;
        }
        if (href == 'carrinho_section') {
            document.body.classList.add('inteiro');

            const destino = main.querySelector('#carrinho_section');

            carregarCarrinho();
            
            destino.scrollIntoView({
                block: 'start',
                behavior: 'smooth'
            });
            elemento.classList.add('ativo');
            header.querySelector('h1').innerHTML = 'Carrinho';
            loadSection(href);
            return false;
        }
        carregar(href);
        
        elemento.classList.add('ativo');
    })
});

setTimeout(function () {
    nav_links[1].click();
}, 1000);

modal.iniciar();

if (!localStorage.getItem('carrinho_de_almas')) {
    localStorage.setItem('carrinho_de_almas', '{}');
}