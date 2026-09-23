<?php
include "util.php";
include "_cabecalho.php";
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

    <footer>
        <section id="rodape">
            <div class="final">
                <img src="imagens/logo2.png" alt="">
            </div>

            <div class="final">
                <h3>Navegação</h3>
                <br>
                <a href="#">Home</a><br>
                <a href="feedProdutos.html">Produtos</a><br>
                <a href="#">Coleções</a><br>
                <a href="#">Sobre Nós</a><br>
                <a href="MVV.html">Missão, Visão e Valores</a><br>
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
            <div class="redes-sociais">
                <a href="https://www.instagram.com/keystyle.ltda" title="Acessar o perfil oficial da KeyStyle no Instagram" target="_blank" rel="noopener noreferrer" aria-label="Instagram da KeyStyle">
                    <!-- Ícone SVG Oficial do Instagram -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect width="20" height="20" x="2" y="2" rx="5" ry="5" />
                        <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z" />
                        <line x1="17.5" x2="17.51" y1="6.5" y2="6.5" />
                    </svg>
                </a>
            </div>
        </section>
        <hr>
        <div class="direitos">&#169 Todos os direitos reservados</div>
    </footer>
</body>

</html>