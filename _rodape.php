<?php
    $prefixo = file_exists("style.css") ? "" : "../";

    $logo2 = $prefixo."imagens/logo2.png";
?>

<footer>
        <section id="rodape">
            <div class="final">
                <a href="<?=home("index.php")?>" class="logo_rodape">
                    <img src=<?=$logo2?> alt="">
                </a>
                
            </div>

            <div class="final">
                <h3>Navegação</h3>
                <br>
                <a href="index.php">Home</a><br>
                <a href="feedProdutos.php">Produtos</a><br>
                <a href="feedProdutos.php">Coleções</a><br>
                <a href="sobreNos.php">Sobre Nós</a><br>
                <a href="MVV.php">Missão, Visão e Valores</a><br>
            </div>
            <div class="final">
                <h3>Ajuda</h3>
                <br>
                <a href="comoComprar.php">Como comprar?</a><br>
                <a href="perguntasFrequentes.php">Perguntas Frequentes</a><br>
            </div>
            <div class="final">
                <h3>Coleções</h3>
                <br>
                <a href="feedProdutos.php?categoria=astronomia" class="categoria">Astronomia</a>
                <a href="feedProdutos.php?categoria=geek" class="categoria">Geek</a><br>
                <a href="feedProdutos.php?categoria=cute" class="categoria">Cute</a><br>
                <a href="feedProdutos.php?categoria=religioso" class="categoria">Religioso</a>
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