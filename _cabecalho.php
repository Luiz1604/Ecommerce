<?php
$prefixo = file_exists("style.css") ? "" : "../";
$estilo = $prefixo."style.css";
$script = $prefixo."script.js";
$icone = $prefixo."imagens/favicon.png";
$logo = $prefixo."imagens/logo.png";
$home = $prefixo."index.php";
$MVV = $prefixo."MVV.php";
$produtos = $prefixo."feedProdutos.php";
$login = $prefixo."login.php";
$minhaConta = $prefixo."minhaConta.php";


if (isset($_SESSION['sessaoConectado'])) {

    $nomeUsuario = $_SESSION['sessaoNome'];
    if(isset($_SESSION['sessaoFoto'])){
        $imgUsuario = $_SESSION['sessaoFoto'];
    } else {
        $imgUsuario = "imagens/padraoUser.webp";
    }

    

   //$fotoPerfil = $prefixo . "imagens/bannerEletro.jpeg";




    $login_logado = "
        <li>
            <a href='{$prefixo}usuario/$minhaConta'>
                <span>Minha conta</span>
                <img src='$imgUsuario' alt='$nomeUsuario' class='nav-avatar'>
            </a>
        </li>
        <li>
            <a href='{$prefixo}logout.php'>Sair</a>
        </li>
    ";
} else {

    $login_logado = "
        <li>
            <a href='$login'>
                <span>Entrar</span>
                <span class='material-symbols-outlined'>person</span>
            </a>
        </li>
    ";

    $nomeUsuario = "";
    $imgUsuario = "";
}


// Opções exclusivas do administrador
if (isset($_SESSION['sessaoAdmin']) && $_SESSION['sessaoAdmin']) {

    $opcoesAdmin = "
        <li><a href='usuario/usuario.php'>Usuarios</a></li>
        <li><a href='produto/produto.php'>Produtos</a></li>
        <li><a href='entrada/entrada.php'>Entradas</a></li>
    ";
} else {

    $opcoesAdmin = "";
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href=<?=$estilo?>>
    <link rel="icon" type="image/png" href=<?=$icone?>>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <script src=<?=$script?> defer></script>
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
        <li><a href=<?=$produtos?>>Todos os produtos</a></li>
        <li><a href="#">Colares</a></li>
        <li><a href="#">Chaveiros</a></li>
        <li><a href="#">Sobre Nós</a></li>
        <li><a href="#">Contato</a></li>
        <li><a href="#">Desenvolvedores</a></li>
        <li><a href=<?=$MVV?>>Missão, Visão e Valores</a></li>
        <?= $opcoesAdmin ?>
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
            <a href=<?=$home?>>
                <img src=<?=$logo?> alt="Logo da Loja">
            </a>
        </div>

        <ul class="menu-direita">
            <?= $login_logado ?>
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
                <a href=<?=$home?> aria-label="Casa">
                    <span class="material-symbols-outlined">Home</span>
                </a>
            </li>
        </ul>
    </nav>
</header>