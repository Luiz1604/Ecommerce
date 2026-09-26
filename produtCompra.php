<?php
    include "util.php";
    include "_cabecalho.php"
?>
    <main class="secao-detalhe-prod">
        <div class="container-detalhe">

            <div class="coluna-imagem">
                <div class="caixa-foto-grande">
                    <img src="imagens/Chaveiro de informática.png" alt="Chaveiro Informática">
                </div>
            </div>

            <div class="coluna-info">
                <h1 class="titulo-detalhe">Chaveiro Informática</h1>

                <div class="bloco-preco">
                    <span class="preco-detalhe">R$ 24,00</span>
                </div>

                <div class="bloco-descricao">
                    <h3>Descrição do Produto</h3>
                    <p>
                        Chaveiro temático produzido para os cursos técnicos. Feito com material resistente,
                        design exclusivo de placa mãe e acabamento de alta qualidade.

                        !!!!deve ser alterado com php!!!
                    </p>
                </div>

                <!-- Formulário de Reserva -->
                <form action="reservar.php" method="POST" class="form-reserva">
                    <input type="hidden" name="produto_id" value="1">

                    <div class="campo-qtd">
                        <label for="quantidade">Quantidade:</label>
                        <input type="number" id="quantidade" name="quantidade" value="1" min="1" max="10">
                    </div>

                    <button type="submit" class="btn-reservar">
                        <!-- Ícone de Agenda/Reserva (SVG embutido) -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect width="18" height="18" x="3" y="4" rx="2" ry="2" />
                            <line x1="16" x2="16" y1="2" y2="6" />
                            <line x1="8" x2="8" y1="2" y2="6" />
                            <line x1="3" x2="21" y1="10" y2="10" />
                            <path d="m9 16 2 2 4-4" />
                        </svg>
                        RESERVAR PRODUTO
                    </button>
                </form>
            </div>

        </div>
    </main>

    <?php
    include "_rodape.php"
    ?>
</body>

</html>