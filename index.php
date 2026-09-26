<?php
include "util.php";
include "_cabecalho.php";

$_SESSION['sessaoSite'] = "index.php";

if (isset ($_SESSION['sessaoQtItens']) )
{
    $qtdItens = $_SESSION['sessaoQtItens'];
}
else
{
    $qtdItens = 0;
    $_SESSION["sessaoQtItens"] = $qtdItens;
}
?>

<body>
    <main>
        <section id="banner" class="carrossel-container">
            <div class="carrossel-slides" id="carrosselSlides">
                <div class="slide ativo">
                    <div class="banner-conteudo">
                        <h1 class="banner-titulo">Seu estilo, seu acessório!</h1>
                        <p class="banner-subtitulo">Encontre peças que combinam com você.</p>
                        <a href="feedProdutos.html" class="banner-btn">VER COLEÇÃO</a>
                    </div>
                    <div class="banner-imagem">
                        <img src="imagens/Hands - Procrastinating.png" alt="Colares da KeyStyle">
                    </div>
                </div>
                <div class="slide">
                    <div class="banner-conteudo">
                        <h1 class="banner-titulo">COMPRAS RÁPIDAS E SEGURAS</h1>
                        <p class="banner-subtitulo">A melhor experiência de compra na palma da sua mão.</p>
                        <a href="feedProdutos.html" class="banner-btn">VER COLEÇÃO</a>
                    </div>->
                    <div class="banner-imagem">
                        <img src="imagens/Hands - Phone.png" alt="Colares da KeyStyle">
                    </div>
                </div>
                <div class="slide">
                    <div class="banner-conteudo">
                        <h2 class="banner-titulo">ESTILO SEM FRONTEIRAS</h2>
                        <p class="banner-subtitulo">Coleções temáticas feitas para conectar a sua paixão ao seu dia a dia.</p>
                        <a href="feedProdutos.html" class="banner-btn">VER COLEÇÃO</a>
                    </div>
                    <div class="banner-imagem">
                        <img src="imagens/Hands - Show.png" alt="Mão a segurar o planeta Terra">
                    </div>
                </div>
                <div class="slide">
                    <div class="banner-conteudo">
                        <h2 class="banner-titulo">ENCONTRE O SEU FAVORITO</h2>
                        <p class="banner-subtitulo">Navegue pelas nossas coleções e descubra peças altamente recomendadas.</p>
                        <a href="feedProdutos.html" class="banner-btn">VER COLEÇÃO</a>
                    </div>
                    <div class="banner-imagem">
                        <img src="imagens/Allura - Online Searching.png" alt="Ilustração de pesquisa online com avaliações e estrelas">
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
            </div>

        </section>

        <h2 class="subtitulo">Categorias</h2>
        <section id="categorias">
            <div class="categoria azul-escuro">
                <img src="imagens/modalidade cursos.png" alt="tech">
            </div>
            <div class="categoria azul-claro">
                <img src="imagens/modalidade cute.png" alt="cursos">
            </div>
            <div class="categoria azul-escuro">
                <img src="imagens/modalidade religioso.png" alt="gamer">
            </div>
            <div class="categoria azul-claro">
                <img src="imagens/modalidade astronomia.png" alt="cute">
            </div>
            <div class="categoria azul-escuro">
                <img src="imagens/modalidade gamer.png" alt="religioso">
            </div>
        </section>

        <!--Produtos-->
        <section id="produtos-container">
            <div class="cabecalho-produtos">
                <h2>Mais Vendidos</h2>
                <a href="feedProdutos.html" class="link-ver-todos">
                    Ver todos
                    <span class="material-symbols-outlined">arrow_forward</span>
                </a>
            </div>

            <div class="grid-produtos">

                <div class="card-produto">
                    <div class="caixa-imagem">
                        <img src="imagens/Colar de mecânica.png" alt="Colar Engrenagem">
                    </div>
                    <h3 class="titulo-produto">Colar Mecânica</h3>
                    <p class="preco-produto">R$ 29,90</p>
                    <button class="btn-detalhes">VER DETALHES</button>
                </div>

                <div class="card-produto">
                    <div class="caixa-imagem">
                        <img src="imagens/Colar de eletrônica.png" alt="Colar Relâmpago">
                    </div>
                    <h3 class="titulo-produto">Colar Eletrônica</h3>
                    <p class="preco-produto">R$ 24,90</p>
                    <button class="btn-detalhes">VER DETALHES</button>
                </div>

                <div class="card-produto">
                    <div class="caixa-imagem">
                        <img src="imagens/Colar de informática.png" alt="Colar Código">
                    </div>
                    <h3 class="titulo-produto">Colar Infomática</h3>
                    <p class="preco-produto">R$ 29,90</p>
                    <button class="btn-detalhes">VER DETALHES</button>
                </div>

                <div class="card-produto">
                    <div class="caixa-imagem">
                        <img src="imagens/Colar de Cruz.jpeg" alt="Colar Cruz">
                    </div>
                    <h3 class="titulo-produto">Colar Cruz</h3>
                    <p class="preco-produto">R$ 19,90</p>
                    <button class="btn-detalhes">VER DETALHES</button>
                </div>

                <div class="card-produto">
                    <div class="caixa-imagem">
                        <img src="imagens/Chaveiro de informática.png" alt="Chaveiro informática">
                    </div>
                    <h3 class="titulo-produto">Chaveiro Informática</h3>
                    <p class="preco-produto">R$ 19,90</p>
                    <button class="btn-detalhes">VER DETALHES</button>
                </div>

                <div class="card-produto">
                    <div class="caixa-imagem">
                        <img src="imagens/Chaveiro de mecânica.png" alt="Chaveiro mecãnica">
                    </div>
                    <h3 class="titulo-produto">Chaveiro de Mecânica</h3>
                    <p class="preco-produto">R$ 19,90</p>
                    <button class="btn-detalhes">VER DETALHES</button>
                </div>

            </div>
        </section>

        <h2 class="subtitulo">Por que comprar a gente?</h2>
        <section id="motivos">
            <div class="motivo">
                <img src="imagens/coleção limitada.png" alt="">
            </div>
            <div class="motivo">
                <img src="imagens/design exclusivo.png" alt="">
            </div>
            <div class="motivo">
                <img src="imagens/temas universais.png" alt="">
            </div>
            <div class="motivo">
                <img src="imagens/preço justo.png" alt="">
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