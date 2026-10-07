<?php
include "util.php";
include "_cabecalho.php";


$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: index.php");
    exit;
}

$conn = conecta();
$varSQL = "SELECT * 
            FROM produto 
            WHERE id_produto = :id AND excluido = FALSE";

$select = $conn->prepare($varSQL);
$select->bindValue(':id', $id, PDO::PARAM_INT);
$select->execute();

$produto = $select->fetch();

if (!$produto) {
    header("Location: index.php");
    exit;
}
?>

<main class="secao-detalhe-prod">

    <div class="container-detalhe">


        <div class="coluna-imagem">
            <div class="caixa-foto-grande">
                <img src="<?= $produto['imagem'] ?>" alt="<?= htmlspecialchars($produto['nome']) ?>">
            </div>
        </div>

        <div class="coluna-info">
            <h1 class="titulo-detalhe"><?= htmlspecialchars($produto['nome']) ?></h1>

            <div class="bloco-preco">
                <span class="preco-detalhe">R$ <?= number_format($produto['valor_unitario'], 2, ',', '.') ?></span>
            </div>

            <div class="bloco-descricao">
                <h3>Descrição do Produto</h3>
                <p>
                    <?= nl2br(htmlspecialchars($produto['descricao'] ?? 'Sem descrição disponível.')) ?>
                </p>
            </div>

            <form action="reservar.php" method="POST" class="form-reserva">

                <input type="hidden" name="produto_id" value="<?= $produto['id_produto'] ?>">

                <div class="campo-qtd">
                    <label for="quantidade">Quantidade:</label>
                    <input type="number" id="quantidade" name="quantidade" value="1" min="1" max="10">
                </div>

                <button type="submit" class="btn-reservar">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect width="18" height="18" x="3" y="4" rx="2" />
                        <line x1="16" x2="16" y1="2" y2="6" />
                        <line x1="8" x2="8" y1="2" y2="6" />
                        <line x1="3" x2="21" y1="10" y2="10" />
                        <path d="m9 16 2 2 4-4" />
                    </svg>
                    RESERVAR PRODUTO
                </button>

                <button type="submit"
                    formaction="carrinho.php?operacao=incluir&id_produto=<?= $produto['id_produto'] ?>" class="btn-carrinho">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect width="18" height="18" x="3" y="4" rx="2" />
                        <line x1="16" x2="16" y1="2" y2="6" />
                        <line x1="8" x2="8" y1="2" y2="6" />
                        <line x1="3" x2="21" y1="10" y2="10" />
                        <path d="m9 16 2 2 4-4" />
                    </svg>
                    COLOCAR NO CARRINHO
                </button>

            </form>


            <a href="feedProdutos.php" class="btn-voltar">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Continuar comprando</span>
            </a>
        </div>

    </div>
</main>

<?php
include "_rodape.php";
?>
</body>

</html>