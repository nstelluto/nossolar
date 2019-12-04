<header>
    <h1>Nosso Lar</h1>
</header>
<nav>
    <ul>
        <li class="topo">
            <a class="nav_link" href="#perfil_section">
                <i class="material-icons">account_circle</i>
            </a>
        </li>
        <li>
            <a class="nav_link" href="#home_section">
                <i class="material-icons">home</i>
            </a>
        </li>
        <li>
            <a class="nav_link" href="#carrinho_section">
                <i class="material-icons">shopping_cart</i>
            </a>
        </li>
        <li>
            <a class="nav_link" href="#busca_section">
                <i class="material-icons">search</i>
            </a>
        </li>
        <li class="fundo">
            <a class="nav_link" href="#sair">
                <i class="material-icons">exit_to_app</i>
            </a>
        </li>
    </ul>
</nav>
<main>
    <section data-titulo="Perfil" class="usuario" id="perfil_section">
        <div id="perfil_usuario">
            <div id="nome_usuario">
                <h2>nome: <span>Fulano de Tal</span></h2>
                <a href="#" class="editar_usuario"><i class="material-icons">edit</i></a>
            </div>
            <div id="usuario_usuario">
                <p>usuario: <span>fulano</span></p>
                <a href="#" class="editar_usuario"><i class="material-icons">edit</i></a>
            </div>
            <div id="email_usuario">
                <p>e-mail: <span>fulano@exemplo.com</span></p>
                <a href="#" class="editar_usuario"><i class="material-icons">edit</i></a>
            </div>
        </div>
        <hr>
        <section id="produtos_usuario">
            <h4>Produtos</h4>
            <div id="estoque_usuario">
                <a href="#novo_produto" id="add_novo_produto">
                    <i class="material-icons">add_box</i>
                    <span>Adicionar novo produto</span>
                </a>
                <a href="#1" class="produto_usuario">
                    <i class="material-icons">delete_outline</i>
                    <span class="estoque_nome">Alma de um sujeito comum</span>
                    <span class="estoque_ml">10ml</span>
                    <span class="estoque_preco">$ 0,00</span>
                </a>
                <a href="#2" class="produto_usuario">
                    <i class="material-icons">delete_outline</i>
                    <span class="estoque_nome">Alma de um sujeito comum</span>
                    <span class="estoque_ml">10ml</span>
                    <span class="estoque_preco">$ 0,00</span>
                </a>
                <a href="#3" class="produto_usuario">
                    <i class="material-icons">delete_outline</i>
                    <span class="estoque_nome">Alma de um sujeito comum</span>
                    <span class="estoque_ml">10ml</span>
                    <span class="estoque_preco">$ 0,00</span>
                </a> 
                <a href="#4" class="produto_usuario">
                    <i class="material-icons">delete_outline</i>
                    <span class="estoque_nome">Alma de um sujeito comum</span>
                    <span class="estoque_ml">10ml</span>
                    <span class="estoque_preco">$ 0,00</span>
                </a> 
                <a href="#5" class="produto_usuario">
                    <i class="material-icons">delete_outline</i>
                    <span class="estoque_nome">Alma de um sujeito comum</span>
                    <span class="estoque_ml">10ml</span>
                    <span class="estoque_preco">$ 0,00</span>
                </a> 
                <a href="#6" class="produto_usuario">
                    <i class="material-icons">delete_outline</i>
                    <span class="estoque_nome">Alma de um sujeito comum</span>
                    <span class="estoque_ml">10ml</span>
                    <span class="estoque_preco">$ 0,00</span>
                </a> 
                <a href="#7" class="produto_usuario">
                    <i class="material-icons">delete_outline</i>
                    <span class="estoque_nome">Alma de um sujeito comum</span>
                    <span class="estoque_ml">10ml</span>
                    <span class="estoque_preco">$ 0,00</span>
                </a> 
                <a href="#8" class="produto_usuario">
                    <i class="material-icons">delete_outline</i>
                    <span class="estoque_nome">Alma de um sujeito comum</span>
                    <span class="estoque_ml">10ml</span>
                    <span class="estoque_preco">$ 0,00</span>
                </a> 
                <a href="#9" class="produto_usuario">
                    <i class="material-icons">delete_outline</i>
                    <span class="estoque_nome">Alma de um sujeito comum</span>
                    <span class="estoque_ml">10ml</span>
                    <span class="estoque_preco">$ 0,00</span>
                </a>
            </div>
        </section>
    </section>
    <section data-titulo="Nosso Lar" id="home_section">
		<div>
			<h2>Destaques</h2>
			<div id="destaques">
				<div id="slide">
					<?php
					for ($i = 0; $i < 10; $i++) {
					?>
					<a href="1" class="card_produto <?php if ($i == 0) {echo "visivel";}?>">
						<div class="card_icone">
							<i class="material-icons icone_alma">delete_outline</i>
						</div>
						<h3 class="card_nome">Alma de um sujeito comum</h3>
						<table class="detalhes_produto">
							<tr>
								<td>Nível</td>
								<td>. . .</td>
							</tr>
							<tr>
								<td>Quantia</td>
								<td>. . .</td>
							</tr>
							<tr>
								<td>Faixa</td>
								<td>. . .</td>
							</tr>
							<tr>
								<td>Preço</td>
								<td>. . .</td>
							</tr>
							<tr>
								<td>Desconto</td>
								<td>. . .</td>
							</tr>
						</table>
					</a>
					<?php
					}
					?>
				</div>
				<div id="controle">
					<a href="#" class="proximo">
						<i class="material-icons">navigate_next</i>
					</a>
					<a href="#" class="anterior">
						<i class="material-icons">navigate_before</i>
					</a>
				</div>
			</div>
			<h2>Outros produtos</h2>
			<div id="home_produtos">
				<?php
				for ($i = 0; $i < 10; $i++) {
				?>
				<a href="2" class="card_produto">
					<div class="card_icone">
						<i class="material-icons icone_alma">delete_outline</i>
					</div>
					<h3 class="card_nome">Alma de um sujeito comum</h3>
					<table class="detalhes_produto">
						<tr>
							<td>Nível</td>
							<td>. . .</td>
						</tr>
						<tr>
							<td>Quantia</td>
							<td>. . .</td>
						</tr>
						<tr>
							<td>Faixa</td>
							<td>. . .</td>
						</tr>
						<tr>
							<td>Preço</td>
							<td>. . .</td>
						</tr>
						<tr>
							<td>Desconto</td>
							<td>. . .</td>
						</tr>
					</table>
				</a>
				<?php 
				}
				?>
			</div>
        </div>
    </section>
    <section data-titulo="Carrinho" id="carrinho_section">
		<div id="carrinho_produtos">
			<a href="#1" class="produto_usuario">
				<i class="material-icons">delete_outline</i>
				<span class="estoque_nome">Alma de um sujeito comum</span>
				<span class="estoque_ml">10ml</span>
				<span class="estoque_preco">$ 0,00</span>
			</a>
			<a href="#2" class="produto_usuario">
				<i class="material-icons">delete_outline</i>
				<span class="estoque_nome">Alma de um sujeito comum</span>
				<span class="estoque_ml">10ml</span>
				<span class="estoque_preco">$ 0,00</span>
			</a>
			<a href="#3" class="produto_usuario">
				<i class="material-icons">delete_outline</i>
				<span class="estoque_nome">Alma de um sujeito comum</span>
				<span class="estoque_ml">10ml</span>
				<span class="estoque_preco">$ 0,00</span>
			</a> 
			<a href="#4" class="produto_usuario">
				<i class="material-icons">delete_outline</i>
				<span class="estoque_nome">Alma de um sujeito comum</span>
				<span class="estoque_ml">10ml</span>
				<span class="estoque_preco">$ 0,00</span>
			</a> 
			<a href="#5" class="produto_usuario">
				<i class="material-icons">delete_outline</i>
				<span class="estoque_nome">Alma de um sujeito comum</span>
				<span class="estoque_ml">10ml</span>
				<span class="estoque_preco">$ 0,00</span>
			</a> 
			<a href="#6" class="produto_usuario">
				<i class="material-icons">delete_outline</i>
				<span class="estoque_nome">Alma de um sujeito comum</span>
				<span class="estoque_ml">10ml</span>
				<span class="estoque_preco">$ 0,00</span>
			</a> 
			<a href="#7" class="produto_usuario">
				<i class="material-icons">delete_outline</i>
				<span class="estoque_nome">Alma de um sujeito comum</span>
				<span class="estoque_ml">10ml</span>
				<span class="estoque_preco">$ 0,00</span>
			</a> 
			<a href="#8" class="produto_usuario">
				<i class="material-icons">delete_outline</i>
				<span class="estoque_nome">Alma de um sujeito comum</span>
				<span class="estoque_ml">10ml</span>
				<span class="estoque_preco">$ 0,00</span>
			</a> 
			<a href="#9" class="produto_usuario">
				<i class="material-icons">delete_outline</i>
				<span class="estoque_nome">Alma de um sujeito comum</span>
				<span class="estoque_ml">10ml</span>
				<span class="estoque_preco">$ 0,00</span>
			</a>
		</div>
    </section>
    <section data-titulo="Buscar" id="busca_section">
		<div>
			<div class="form_control">
				<input type="search" id="input_busca" placeholder="Ex.: Alma de um sujeito comum">
				<i class="material-icons">search</i>
			</div>
			<h2 id="busca_resultado" class="visivel">Resultado:</h2>
			<div id="resultado_produtos">
				<?php
				for ($i = 0; $i < 10; $i++) {
				?>
				<a href="2" class="card_produto">
					<div class="card_icone">
						<i class="material-icons icone_alma">delete_outline</i>
					</div>
					<h3 class="card_nome">Alma de um sujeito comum</h3>
					<table class="detalhes_produto">
						<tr>
							<td>Nível</td>
							<td>. . .</td>
						</tr>
						<tr>
							<td>Quantia</td>
							<td>. . .</td>
						</tr>
						<tr>
							<td>Faixa</td>
							<td>. . .</td>
						</tr>
						<tr>
							<td>Preço</td>
							<td>. . .</td>
						</tr>
						<tr>
							<td>Desconto</td>
							<td>. . .</td>
						</tr>
					</table>
				</a>
				<?php 
				}
				?>
			</div>
		</div>
    </section>
</main>
<aside>
    <section id="produto">
        <h2 id="nome_produto">Nome do Produto</h2>
        <div id="icone_produto">
            <i class="material-icons icone_alma">delete_outline</i>
        </div>
        <table id="detalhes_produto">
            <tr>
                <td>Nível</td>
                <td>. . .</td>
            </tr>
            <tr>
                <td>Quantia</td>
                <td>. . .</td>
            </tr>
            <tr>
                <td>Faixa</td>
                <td>. . .</td>
            </tr>
            <tr>
                <td>Preço</td>
                <td>. . .</td>
            </tr>
            <tr>
                <td>Desconto</td>
                <td>. . .</td>
            </tr>
        </table>
        <h3 id="vendedor_produto">Vendedor: <a href="#perfil_section" data-perfil="000000">Fulano de Tal</a></h3>
        <div id="acoes_produto">
            <a href="#" id="comprar_produto">
                <i class="material-icons">add_shopping_cart</i> <span>Adicionar ao carrinho</span>
            </a>
            <a href="#" id="deletar_produto">
                <i class="material-icons">delete_forever</i> <span>Remover produto</span>
            </a>
        </div>
        <section id="comentarios_produto">
            <h3>Comentários</h3>
            <div class="comentario">
                <p class="texto">Lorem ipsum magnam voluptatibus amet mollitia exercitationem temporibus accusamus excepturi quis?</p>
                <div class="detalhes">
                    <h4><a href="#perfil_section" data-perfil="000000">Ciclano de Tal</a></h4>
                    <p><small>às 00:00 de 00/00/0000</small></p>
                </div>
                <div class="respostas_comentario">
                    <div class="resposta">
                        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit.</p>
                        <div class="detalhes">
                            <h4><a href="#perfil_section" data-perfil="000000">Fulano de Tal</a></h4>
                            <p><small>às 00:00 de 00/00/0000</small></p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>
</aside>