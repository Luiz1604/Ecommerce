<?php
include "util.php";
include "_cabecalho.php";

$_SESSION['sessaoSite'] = "index.php";

if (isset($_SESSION['sessaoQtItens'])) {
    $qtdItens = $_SESSION['sessaoQtItens'];
} else {
    $qtdItens = 0;
    $_SESSION["sessaoQtItens"] = $qtdItens;
}

$conn = conecta();

$varSQL = "SELECT id_produto, nome, imagem, valor_unitario
               FROM produto
               WHERE excluido = FALSE
               ORDER BY id_produto ASC
               LIMIT 6";

$select = $conn->prepare($varSQL);
$select->execute();

$produtos = $select->fetchAll(PDO::FETCH_ASSOC);

?>

<body>
    <main>
        <section id="banner" class="carrossel-container">
            <div class="carrossel-slides" id="carrosselSlides">
                <div class="slide ativo">
                    <div class="banner-conteudo">
                        <h1 class="banner-titulo">Seu estilo, seu acessório!</h1>
                        <p class="banner-subtitulo">Encontre peças que combinam com você.</p>
                        <a href="feedProdutos.php" class="banner-btn">VER COLEÇÃO</a>
                    </div>
                    <div class="banner-imagem">
                        <img src="Review_Animation.svg" alt="Colares da KeyStyle">
                    </div>
                </div>
                <div class="slide">
                    <div class="banner-conteudo">
                        <h1 class="banner-titulo">COMPRAS RÁPIDAS E SEGURAS</h1>
                        <p class="banner-subtitulo">A melhor experiência de compra na palma da sua mão.</p>
                        <a href="feedProdutos.php" class="banner-btn">VER COLEÇÃO</a>
                    </div>
                    <div class="banner-imagem">
                        <img src="Shopping bag.svg" alt="Colares da KeyStyle">
                    </div>
                </div>
                <div class="slide">
                    <div class="banner-conteudo">
                        <h2 class="banner-titulo">ESTILO SEM FRONTEIRAS</h2>
                        <p class="banner-subtitulo">Coleções temáticas feitas para conectar a sua paixão ao seu dia a dia.</p>
                        <a href="feedProdutos.php" class="banner-btn">VER COLEÇÃO</a>
                    </div>
                    <div class="banner-imagem">
                        <img src="Sphre Click&Cars.svg" alt="Mão a segurar o planeta Terra">
                    </div>
                </div>

                <div class="slide">
                    <div class="banner-conteudo">
                        <h2 class="banner-titulo">VENHA NOS VISITAR</h2>
                        <p class="banner-subtitulo">Garanta seus produtos exclusivos durante a nossa Semana do colégio.</p>
                        <a href="feedProdutos.php" class="banner-btn">VER COLEÇÃO</a>
                    </div>
                    <div class="banner-imagem">
                        <img src="Walking.svg" alt="Mão a segurar o planeta Terra">
                    </div>
                </div>
                <div class="slide">
                    <div class="banner-conteudo">
                        <h2 class="banner-titulo">ENCONTRE O SEU FAVORITO</h2>
                        <p class="banner-subtitulo">Navegue pelas nossas coleções e descubra peças que te representam.</p>
                        <a href="usuario/adicionarUsuario.php" class="banner-btn">CRIAR CONTA</a>
                    </div>
                    <div class="banner-imagem">
                        <img src="Login Character Animation.svg" alt="Ilustração de pesquisa online com avaliações e estrelas">
                    </div>
                </div>
            </div>

            <button class="botao-carrossel anterior" onclick="mudarSlide(-1)">
                <span class="material-symbols-outlined">chevron_left</span>
            </button>
            <button class="botao-carrossel proximo" onclick="mudarSlide(1)">
                <span class="material-symbols-outlined">chevron_right</span>
            </button>

            <div class="carrossel-indicadores">
                <span class="ponto ativo" onclick="irParaSlide(0)"></span>
                <span class="ponto" onclick="irParaSlide(1)"></span>
                <span class="ponto" onclick="irParaSlide(2)"></span>
                <span class="ponto" onclick="irParaSlide(3)"></span>
                <span class="ponto" onclick="irParaSlide(4)"></span>
            </div>

        </section>
        <h2 class="subtitulo">Categorias</h2>

        <section class="categorias">
            <a href="feedProdutos.php?categoria=geek" class="categoria">
                <span class="material-symbols-outlined icone-categoria" aria-hidden="true">sports_esports</span>
                <span class="nome-categoria">Geek</span>
            </a>

            <a href="feedProdutos.php?categoria=religioso" class="categoria">
                <span class="material-symbols-outlined icone-categoria" aria-hidden="true">church</span>
                <span class="nome-categoria">Religioso</span>
            </a>

            <a href="feedProdutos.php?categoria=astronomia" class="categoria">
                <span class="material-symbols-outlined icone-categoria" aria-hidden="true">rocket_launch</span>
                <span class="nome-categoria">Astronomia</span>
            </a>

            <a href="feedProdutos.php?categoria=cute" class="categoria">
                <span class="material-symbols-outlined icone-categoria" aria-hidden="true">favorite</span>
                <span class="nome-categoria">Cute</span>
            </a>
        </section>


        <!--Produtos-->
        <section id="produtos-container">
            <div class="cabecalho-produtos">
                <h2>Mais Vendidos</h2>

                <a href="feedProdutos.php" class="link-ver-todos">
                    Ver todos
                    <span class="material-symbols-outlined">arrow_forward</span>
                </a>
            </div>

            <div class="grid-produtos">

                <?php foreach ($produtos as $produto) { ?>

                    <div class="card-produto">
                        <div class="caixa-imagem">
                            <img
                                src="<?= htmlspecialchars($produto['imagem'], ENT_QUOTES, 'UTF-8') ?>"
                                alt="<?= htmlspecialchars($produto['nome'], ENT_QUOTES, 'UTF-8') ?>">
                        </div>

                        <h3 class="titulo-produto">
                            <?= htmlspecialchars($produto['nome'], ENT_QUOTES, 'UTF-8') ?>
                        </h3>

                        <p class="preco-produto">
                            R$ <?= number_format((float) $produto['valor_unitario'], 2, ',', '.') ?>
                        </p>

                        <a
                            href="produtCompra.php?id=<?= (int) $produto['id_produto'] ?>"
                            class="btn-detalhes">
                            VER DETALHES
                        </a>
                    </div>

                <?php } ?>

                <?php if (empty($produtos)) { ?>
                    <p>Nenhum produto disponível no momento.</p>
                <?php } ?>

            </div>
        </section>

        <h2 class="subtitulo">Por que comprar a gente?</h2>
        <section class="motivos" aria-label="Por que comprar na KeyStyle">

            <div class="motivo">
                <span class="material-symbols-outlined icone-motivo"
                    aria-hidden="true">star</span>

                <div class="texto-motivo">
                    <h3>COLEÇÃO LIMITADA</h3>
                    <p>Produtos exclusivos em edições limitadas.</p>
                </div>
            </div>

            <div class="motivo">
                <span class="material-symbols-outlined icone-motivo"
                    aria-hidden="true">diamond</span>

                <div class="texto-motivo">
                    <h3>DESIGN EXCLUSIVO</h3>
                    <p>Estilo minimalista, moderno e feito para você.</p>
                </div>
            </div>

            <div class="motivo">
                <span class="material-symbols-outlined icone-motivo"
                    aria-hidden="true">public</span>

                <div class="texto-motivo">
                    <h3>TEMAS UNIVERSAIS</h3>
                    <p>Estilos que combinam com todos os momentos.</p>
                </div>
            </div>

            <div class="motivo">
                <span class="material-symbols-outlined icone-motivo"
                    aria-hidden="true">account_balance_wallet</span>

                <div class="texto-motivo">
                    <h3>PREÇO JUSTO</h3>
                    <p>Preços que cabem no seu bolso.</p>
                </div>
            </div>
        </section>

        <section id="video">
            <div class="card-video">
                <div class="video">
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/szPMhSnzBWw?si=FjV-UpQcWpMArej7"
                        title="YouTube video player" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                </div>
                <div class="legenda">
                    Somos um projeto de e-commerce desenvolvido por alunos do 2º ano de Informática do CTI Bauru
                    (UNESP)! Nosso objetivo é planejar, criar e gerenciar uma loja virtual completa para apresentar e
                    vender nossos produtos durante a Semana do Colégio.

                    Especializados em acessórios exclusivos, trazemos uma coleção especial de chaveiros temáticos para
                    representar com orgulho os cursos técnicos do CTI: Informática, Eletrônica e Mecânica. Além dos
                    símbolos dos cursos, oferecemos uma variedade de chaveiros super cute, criativos e geek para
                    personalizar mochilas, estojos e chaves com muito estilo.
                </div>
            </div>
        </section>
    </main>

    <?php
    include "_rodape.php";
    ?>
</body>

</html>