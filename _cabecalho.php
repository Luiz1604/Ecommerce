<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/png" href="imagens/favicon.png">
    <link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <script src="script.js" defer></script>
    <title>KeyStyle</title>
</head>
<div class="fundo-escuro" id="fundoEscuro" onclick="fecharMenu()"></div>

    <aside class="menu-lateral" id="menuLateral">
        <div class="cabecalho-menu-lateral">
            <h2>Categorias</h2>
            <button class="botao-fechar" onclick="fecharMenu()">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <ul class="links-menu-lateral">
            <li><a href="feedProdutos.html">Todos os produtos</a></li>
            <li><a href="#">Colares</a></li>
            <li><a href="#">Chaveiros</a></li>
            <li><a href="#">Sobre Nós</a></li>
            <li><a href="#">Contato</a></li>
            <li><a href="#">Desenvolvedores</a></li>
            <li><a href="MVV.php">Missão, Visão e Valores</a></li>
            <li><a href="/usuario/usuario.php">Usuarios</a></li>
            <li><a href="/produto/produto.php">Produtos</a></li>
            <li><a href="/entrada/entrada.php">Entradas</a></li>
        </ul>
    </aside>

    <header>
        <nav class="menu-principal">
            <div class="menu-esquerda">
                <button class="botao-menu-lateral" onclick="abrirMenu()">
                    <span class="material-symbols-outlined">menu</span>
                    <span>Menu</span>
                </button>

                <div class="caixa-pesquisa">
                    <input type="text" placeholder="O que você está procurando?">
                    <button type="submit">
                        <span class="material-symbols-outlined">search</span>
                    </button>
                </div>
            </div>

            <div class="logo-centro">
                <a href="#">
                    <img src="imagens/logo.png" alt="Logo da Loja">
                </a>
            </div>

            <ul class="menu-direita">
                <li>
                    <a href="login.php">

                        <span>Entrar</span>
                        <span class="material-symbols-outlined">person</span>
                    </a>
                </li>
                <li>
                    <a href="#" aria-label="Sacola de compras">
                        <span class="material-symbols-outlined">shopping_bag</span>
                    </a>
                </li>
                <li>
                    <a href="#" aria-label="Carrinho de compras">
                        <span class="material-symbols-outlined">shopping_cart</span>
                    </a>
                </li>
                <li>
                    <a href="index.php" aria-label="Casa">
                        <span class="material-symbols-outlined">Home</span>
                    </a>
                </li>
            </ul>
        </nav>
    </header>