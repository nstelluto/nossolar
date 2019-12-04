<header>
    <h1>Login</h1>
</header>
<nav>
    <ul>
        <li>
            <a class="nav_link ativo" href="#login_section">
                <i class="material-icons">input</i>
            </a>
        </li>
        <li>
            <a class="nav_link" href="#cadastro_section">
                <i class="material-icons">person_add</i>
            </a>
        </li>
    </ul>
</nav>
<main>
    <section id="login_section" data-titulo="Login">
        <form id="login_form">
            <div class="form_group">
                <label for="login_usuario">Usuário</label>
                <div class="form_control">
                    <input type="text" name="login_usuario" id="login_usuario">
                </div>
            </div>
            <div class="form_group">
                <label for="login_senha">Senha</label>
                <div class="form_control">
                    <input type="password" name="login_senha" id="login_senha">
                    <input type="checkbox" class="mostrar_senha">
                    <i class="material-icons">remove_red_eye</i>
                </div>
            </div>
            <button>Enviar</button>
        </form>
    </section>
    <section id="cadastro_section" data-titulo="Cadastro">
        <form id="cadastro_form">
            <div class="form_group">
                <label for="cadastro_nome">Nome</label>
                <div class="form_control">
                    <input type="text" name="cadastro_nome" id="cadastro_nome">
                </div>
            </div>
            <div class="form_group">
                <label for="cadastro_usuario">Usuário</label>
                <div class="form_control">
                    <input type="text" name="cadastro_usuario" id="cadastro_usuario">
                </div>
            </div>
            <div class="form_group">
                <label for="cadastro_email">E-mail</label>
                <div class="form_control">
                    <input type="text" name="cadastro_email" id="cadastro_email">
                </div>
            </div>
            <div class="form_group">
                <label for="cadastro_senha">Senha</label>
                <div class="form_control">
                    <input type="password" name="cadastro_senha" id="cadastro_senha">
                    <input type="checkbox" class="mostrar_senha">
                    <i class="material-icons">remove_red_eye</i>
                </div>
            </div>
            <div class="form_group">
                <label for="confirmar_senha">Confirmar senha</label>
                <div class="form_control">
                    <input type="password" name="confirmar_senha" id="confirmar_senha">
                    <input type="checkbox" class="mostrar_senha">
                    <i class="material-icons">remove_red_eye</i>
                </div>
            </div>
            <button>Enviar</button>
        </form>
    </section>
</main>
<aside id="propaganda">
</aside>