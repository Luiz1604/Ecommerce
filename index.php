<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/png" href="imagens/icone2.png">
    <title>Home</title>
</head>
<link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
<!--Pacote com os icones-->

<body>
    <div class="fundo-escuro" id="fundoEscuro" onclick="fecharMenu()"></div>

    <aside class="menu-lateral" id="menuLateral">
        <div class="cabecalho-menu-lateral">
            <h2>Categorias</h2>
            <button class="botao-fechar" onclick="fecharMenu()">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <ul class="links-menu-lateral">
            <li><a href="#">Todos os produtos</a></li>
            <li><a href="#">Colares</a></li>
            <li><a href="#">Chaveiros</a></li>
            <li><a href="#">Sobre Nós</a></li>
            <li><a href="#">Contato</a></li>
            <li><a href="#">Desenvolvedores</a></li>
            <li><a href="#">Missão, Visão e Valores</a></li>
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
                    <a href="#">

                        <span>Minha conta</span>
                        <span class="material-symbols-outlined">person</span>
                    </a>
                </li>
                <li>
                    <a href="#" aria-label="sacola de compras">
                        <span class="material-symbols-outlined">shopping_bag</span>
                    </a>
                </li>
                <li>
                    <a href="#" aria-label="Carrinho de compras">
                        <span class="material-symbols-outlined">shopping_cart</span>
                    </a>
                </li>
            </ul>
        </nav>
    </header>
    <main>
        <section id="banner" class="carrossel-container">
            <div class="carrossel-slides" id="carrosselSlides">
                <div class="slide ativo">
                    <img src="imagens/banner-1.png" alt="Promoção 1">
                </div>
                <div class="slide">
                    <img src="imagens/bannerInfo2.jpeg" alt="Promoção 2">
                </div>
                <div class="slide">
                    <img src="imagens/bannerEletro2.jpeg" alt="Promoção 3">
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
            </div>

        </section>

        <h2 class="subtitulo">Categorias</h2>
        <section id="categorias">
            <div class="categoria azul-escuro">
                <img src="imagens/modalidade tech.png" alt="tech">
            </div>
            <div class="categoria azul-claro">
                <img src="imagens/modalidade cursos.png" alt="cursos">
            </div>
            <div class="categoria azul-escuro">
                <img src="imagens/modalidade gamer.png" alt="gamer">
            </div>
            <div class="categoria azul-claro">
                <img src="imagens/modalidade cute.png" alt="cute">
            </div>
            <div class="categoria azul-escuro">
                <img src="imagens/modalidade religioso.png" alt="religioso">
            </div>
        </section>

        <!--Produtos-->
        <section id="produtos-container">
            <div class="cabecalho-produtos">
                <h2>Mais Vendidos</h2>
                <a href="#" class="link-ver-todos">
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

    <footer>
        <section id="rodape">
            <div class="final">
                <img src="imagens/logo2.png" alt="">
            </div>

            <div class="final">
                <h3>Navegação</h3>
                <br>
                <a href="#">Home</a><br>
                <a href="#">Produtos</a><br>
                <a href="#">Coleções</a><br>
                <a href="#">Sobre Nós</a><br>
                <a href="#">Missão, Visão e Valores</a><br>
                <a href="#">Contato</a><br>
                <a href="#">Desenvolvedores</a>
            </div>
            <div class="final">
                <h3>Ajuda</h3>
                <br>
                <a href="#">Como comprar?</a><br>
                <a href="#">Perguntas Frequentes</a><br>
                <a href="#">Política de Privacidade</a><br>
                <a href="#">Termos de uso</a>
            </div>
            <div class="final">
                <h3>Coleções</h3>
                <br>
                <a href="#">Tech</a><br>
                <a href="#">Cursos Técnicos</a><br>
                <a href="#">Gamer</a><br>
                <a href="#">Cute</a><br>
                <a href="#">Religioso</a>
            </div>
            <div class="final">
                <h3>Desenvolvedores</h3>
                <br>
                <p>Artur Xavier Cabral</p>
                <p>Dablio Piza da Silva</p>
                <p>Gustavo Ferreira Poli</p>
                <p>Luiz Miguél Piton</p>
                <p>Marcus Pietro Morelli e Souza</p>
            </div>
        </section>
        <div class="direitos">&#169 Todos os direitos reservados</div>
    </footer>
    <script src="js.js"></script>
</body>

</html>