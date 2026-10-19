<?php
include "util.php";

$produtos = []; //produtos deve começar como um array vazio

$operacao = $_GET['operacao'] ?? null;
$idProduto = $_GET['id_produto'] ?? null;
$quantidade = $_POST['quantidade'] ?? 1;

//tipo B (usuario logado)
if (isset($_SESSION['sessaoLogin'])) {

    $conn = conecta();

    //descobre o id_usuario atravez do email
    $email = $_SESSION['sessaoLogin'];

    $varSQL = "SELECT id_usuario
                        FROM usuario
                        WHERE email = :email";

    $select = $conn->prepare($varSQL);
    $select->bindParam(":email", $email);
    $select->execute();

    $usuario = $select->fetch();

    //descobre a compra que está funcionando no carrinho atravez do id_usuario
    $idUsuario = $usuario['id_usuario'];
    $sessao = session_id();

    $varSQL = "SELECT id_compra
                        FROM compra
                        WHERE fk_usuario = :id_usuario
                        AND status = 'carrinho'
                        ORDER BY id_compra DESC
                        LIMIT 1";

    $select = $conn->prepare($varSQL);
    $select->bindParam(":id_usuario", $idUsuario);
    $select->execute();

    $compra = $select->fetch();

    //se ainda não existir uma compra
    if (!$compra) {
        $varSQL = "INSERT INTO compra (status, fk_usuario, sessao)
                        VALUES ('carrinho', :id_usuario, :sessao)
                        RETURNING id_compra";

        $insert = $conn->prepare($varSQL);
        $insert->bindParam(":id_usuario", $idUsuario);
        $insert->bindParam(":sessao", $sessao);
        $insert->execute();

        $compra = $insert->fetch();
    }

    if ($operacao == 'incluir') {

        // busca o produto e seu estoque
        $varSQL = "SELECT
                produto.id_produto,
                COALESCE(
                    (SELECT SUM(e.quantidade)
                     FROM entrada e
                     WHERE e.fk_produto = produto.id_produto),
                    0
                )
                -
                COALESCE(
                    (SELECT SUM(cp.quantidade)
                     FROM compra_produto cp
                     INNER JOIN compra c
                         ON c.id_compra = cp.fk_compra
                     WHERE cp.fk_produto = produto.id_produto
                       AND c.status IN ('reservado', 'entregue')),
                    0
                ) AS estoque
            FROM produto
            WHERE produto.id_produto = :id_produto
              AND produto.excluido = FALSE";

        $select = $conn->prepare($varSQL);
        $select->bindParam(":id_produto", $idProduto);
        $select->execute();

        $produto = $select->fetch();

        // verifica se o produto existe e está disponível
        $quantidade = filter_var(
            $quantidade,
            FILTER_VALIDATE_INT,
            ["options" => ["min_range" => 1]]
        );

        if ($produto && $quantidade !== false) {
            $estoque = (int) $produto['estoque'];

            // descobre a quantidade que já está no carrinho
            $varSQL = "SELECT quantidade
                            FROM compra_produto
                            WHERE fk_compra = :id_compra
                            AND fk_produto = :id_produto";

            $select = $conn->prepare($varSQL);
            $select->bindParam(":id_compra", $compra['id_compra']);
            $select->bindParam(":id_produto", $idProduto);
            $select->execute();

            $produtoCarrinho = $select->fetch();

            $quantidadeAtual = $produtoCarrinho ? (int) $produtoCarrinho['quantidade'] : 0;

            // só adiciona se houver estoque suficiente
            if ($quantidadeAtual + $quantidade <= $estoque) {

                if ($produtoCarrinho) {

                    $varSQL = "UPDATE compra_produto
                                SET quantidade = quantidade + :quantidade
                                WHERE fk_compra = :id_compra
                                AND fk_produto = :id_produto";

                    $update = $conn->prepare($varSQL);
                    $update->bindParam(":quantidade", $quantidade);
                    $update->bindParam(":id_compra", $compra['id_compra']);
                    $update->bindParam(":id_produto", $idProduto);
                    $update->execute();
                } else {
                    $varSQL = "INSERT INTO compra_produto
                                    (fk_produto, fk_compra, quantidade, valor_unitario)
                                    SELECT id_produto, :id_compra, :quantidade, valor_unitario
                                    FROM produto
                                    WHERE id_produto = :id_produto
                                    AND excluido = false";

                    $insert = $conn->prepare($varSQL);
                    $insert->bindParam(":id_compra", $compra['id_compra']);
                    $insert->bindParam(":quantidade", $quantidade);
                    $insert->bindParam(":id_produto", $idProduto);
                    $insert->execute();
                }
            }
        }

        header("location: carrinho.php");
        exit;
    } elseif ($operacao == 'mais') {

        // descobre a quantidade atual e o estoque
        $varSQL = "SELECT
                compra_produto.quantidade,
                COALESCE(
                    (SELECT SUM(e.quantidade)
                     FROM entrada e
                     WHERE e.fk_produto = produto.id_produto),
                    0
                )
                -
                COALESCE(
                    (SELECT SUM(cp.quantidade)
                     FROM compra_produto cp
                     INNER JOIN compra c
                         ON c.id_compra = cp.fk_compra
                     WHERE cp.fk_produto = produto.id_produto
                       AND c.status IN ('reservado', 'entregue')),
                    0
                ) AS estoque
            FROM compra_produto
            INNER JOIN produto
                ON produto.id_produto = compra_produto.fk_produto
            WHERE compra_produto.fk_compra = :id_compra
              AND compra_produto.fk_produto = :id_produto
              AND produto.excluido = FALSE";

        $select = $conn->prepare($varSQL);
        $select->bindParam(":id_compra", $compra['id_compra']);
        $select->bindParam(":id_produto", $idProduto);
        $select->execute();

        $produtoCarrinho = $select->fetch();

        // aumente só se ouver estoque disponível
        if ($produtoCarrinho && $produtoCarrinho['quantidade'] < $produtoCarrinho['estoque']) {

            $varSQL = "UPDATE compra_produto
                       SET quantidade = quantidade + 1
                       WHERE fk_compra = :id_compra
                       AND fk_produto = :id_produto
                       AND EXISTS (
                            SELECT 1
                            FROM produto
                            WHERE produto.id_produto = compra_produto.fk_produto
                            AND produto.excluido = false
                        )";

            $update = $conn->prepare($varSQL);
            $update->bindParam(":id_compra", $compra['id_compra']);
            $update->bindParam(":id_produto", $idProduto);
            $update->execute();
        }

        header("location: carrinho.php");
        exit;
    } elseif ($operacao == 'menos') {
        $varSQL = "UPDATE compra_produto
                       SET quantidade = quantidade - 1
                       WHERE fk_compra = :id_compra
                       AND fk_produto = :id_produto
                       AND quantidade > 1";

        $update = $conn->prepare($varSQL);
        $update->bindParam(":id_compra", $compra['id_compra']);
        $update->bindParam(":id_produto", $idProduto);
        $update->execute();

        header("location: carrinho.php");
        exit;
    } elseif ($operacao == 'excluir') {
        $varSQL = "DELETE FROM compra_produto
                       WHERE fk_compra = :id_compra
                       AND fk_produto = :id_produto";

        $delete = $conn->prepare($varSQL);
        $delete->bindParam(":id_compra", $compra['id_compra']);
        $delete->bindParam(":id_produto", $idProduto);
        $delete->execute();

        header("location: carrinho.php");
        exit;
    }

    //busca os produtos da compra
    $varSQL = "SELECT 
                    produto.id_produto,
                    produto.nome,
                    produto.descricao,
                    produto.imagem,
                    compra_produto.quantidade,
                    compra_produto.valor_unitario,
                    COALESCE(
                        (SELECT SUM(e.quantidade)
                        FROM entrada e
                        WHERE e.fk_produto = produto.id_produto),
                        0
                    )
                    -
                    COALESCE(
                        (SELECT SUM(cp.quantidade)
                        FROM compra_produto cp
                        INNER JOIN compra c
                            ON c.id_compra = cp.fk_compra
                        WHERE cp.fk_produto = produto.id_produto
                        AND c.status IN ('reservado', 'entregue')),
                        0
                    ) AS estoque
                FROM compra_produto
                INNER JOIN produto
                    ON produto.id_produto = compra_produto.fk_produto
                WHERE compra_produto.fk_compra = :id_compra
                AND produto.excluido = FALSE";

    $select = $conn->prepare($varSQL);
    $select->bindParam(":id_compra", $compra['id_compra']);
    $select->execute();

    $produtos = $select->fetchAll();
} else //tipo A (visitante)
{
    if (!isset($_SESSION['carrinho'])) {
        $_SESSION['carrinho'] = [];
    }

    if ($operacao == 'incluir') {

        // busca o produto e seu estoque
        $varSQL = "SELECT
                produto.id_produto,
                COALESCE(
                    (SELECT SUM(e.quantidade)
                     FROM entrada e
                     WHERE e.fk_produto = produto.id_produto),
                    0
                )
                -
                COALESCE(
                    (SELECT SUM(cp.quantidade)
                     FROM compra_produto cp
                     INNER JOIN compra c
                         ON c.id_compra = cp.fk_compra
                     WHERE cp.fk_produto = produto.id_produto
                       AND c.status IN ('reservado', 'entregue')),
                    0
                ) AS estoque
            FROM produto
            WHERE produto.id_produto = :id_produto
              AND produto.excluido = FALSE";

        $conn = conecta();

        $select = $conn->prepare($varSQL);
        $select->bindParam(":id_produto", $idProduto);
        $select->execute();

        $produto = $select->fetch();

        // Valida a quantidade recebida
        $quantidadeValida = filter_var(
            $quantidade,
            FILTER_VALIDATE_INT,
            ["options" => ["min_range" => 1]]
        );

        if ($produto && $quantidadeValida !== false) {

            $idProduto = (int) $produto['id_produto'];
            $estoque = (int) $produto['estoque'];

            $quantidadeAtual = $_SESSION['carrinho'][$idProduto] ?? 0;

            // Adiciona somente se houver estoque suficiente
            if ($quantidadeAtual + $quantidadeValida <= $estoque) {
                $_SESSION['carrinho'][$idProduto] =
                    $quantidadeAtual + $quantidadeValida;
            }
        }

        header("location: carrinho.php");
        exit;
    } elseif ($operacao == 'mais') {
        $idProduto = (int) $idProduto;

        if (isset($_SESSION['carrinho'][$idProduto])) {

            $conn = conecta();

            $varSQL = "SELECT
                produto.id_produto,
                COALESCE(
                    (SELECT SUM(e.quantidade)
                     FROM entrada e
                     WHERE e.fk_produto = produto.id_produto),
                    0
                )
                -
                COALESCE(
                    (SELECT SUM(cp.quantidade)
                     FROM compra_produto cp
                     INNER JOIN compra c
                         ON c.id_compra = cp.fk_compra
                     WHERE cp.fk_produto = produto.id_produto
                       AND c.status IN ('reservado', 'entregue')),
                    0
                ) AS estoque
            FROM produto
            WHERE produto.id_produto = :id_produto
              AND produto.excluido = FALSE";

            $select = $conn->prepare($varSQL);
            $select->bindParam(":id_produto", $idProduto);
            $select->execute();

            $produto = $select->fetch();

            if ($produto && $_SESSION['carrinho'][$idProduto] < (int) $produto['estoque']) {
                $_SESSION['carrinho'][$idProduto]++;
            }
        }

        header("location: carrinho.php");
        exit;
    } elseif ($operacao == 'menos') {

        $idProduto = (int) $idProduto;

        if (isset($_SESSION['carrinho'][$idProduto])) {

            if ($_SESSION['carrinho'][$idProduto] > 1) {
                $_SESSION['carrinho'][$idProduto]--;
            }
        }

        header("location: carrinho.php");
        exit;
    } elseif ($operacao == 'excluir') {

        $idProduto = (int) $idProduto;

        unset($_SESSION['carrinho'][$idProduto]);

        header("location: carrinho.php");
        exit;
    }


    if (!empty($_SESSION['carrinho'])) {
        $conn = conecta();

        $ids = array_keys($_SESSION['carrinho']);
        $marcadores = implode(',', array_fill(0, count($ids), '?'));

        $varSQL = "SELECT
                            produto.id_produto,
                            produto.nome,
                            produto.descricao,
                            produto.imagem,
                            produto.valor_unitario,
                            COALESCE(
                                (SELECT SUM(e.quantidade)
                                FROM entrada e
                                WHERE e.fk_produto = produto.id_produto),
                                0
                            )
                            -
                            COALESCE(
                                (SELECT SUM(cp.quantidade)
                                FROM compra_produto cp
                                INNER JOIN compra c
                                    ON c.id_compra = cp.fk_compra
                                WHERE cp.fk_produto = produto.id_produto
                                AND c.status IN ('reservado', 'entregue')),
                                0
                            ) AS estoque
                        FROM produto
                        WHERE produto.id_produto IN ($marcadores)
                        AND produto.excluido = false";

        $select = $conn->prepare($varSQL);
        $select->execute($ids);

        $produtosBanco = $select->fetchAll();

        foreach ($produtosBanco as &$produto) {
            $id = $produto['id_produto'];
            $produto['quantidade'] = $_SESSION['carrinho'][$id];
        }
        unset($produto);

        $produtos = $produtosBanco;
    }
}
?>

<?php include "_cabecalho.php"; ?>

<main class="secao-carrinho">

    <h1 class="h1-carrinho">MEU CARRINHO</h1>

    <?php if (empty($produtos)) { ?>
        <div class="carrinho-vazio-quadro">
            <div class="carrinho-vazio">
                <h2>Seu carrinho está vazio</h2>
                <p>Expresse quem você é</p>
                <img src="atacado e varejo.svg" alt="carrinho vazio" class="svg-carrinho">
                <a href="feedProdutos.php" class="btn-ver-produtos">
                    Ver produtos
                </a>
            </div>
        </div>
    <?php } else { ?>
        <div class="layout-carrinho">
            <div class="container-tabela-carrinho">
                <div class="lista-produtos">
                    <?php
                    $total = 0;
                    $quantidadeItens = 0;

                    foreach ($produtos as $produto) {
                        $subtotal = $produto['valor_unitario'] * $produto['quantidade'];
                        $total += $subtotal;
                        $quantidadeItens += $produto['quantidade'];
                    ?>

                        <article class="card-produto-carrinho">

                            <div class="info-produto-carrinho">
                                <img
                                    class="img-prod-carrinho"
                                    src="<?= htmlspecialchars($produto['imagem']) ?>"
                                    alt="<?= htmlspecialchars($produto['nome']) ?>"
                                >

                                <div class="dados-produto-carrinho">
                                    <h3>
                                        <?= htmlspecialchars($produto['nome']) ?>
                                    </h3>

                                    <div class="controle-quantidade">
                                        <span>Quantidade:</span>

                                        <div class="botoes-quantidade">
                                            <?php if ($produto['quantidade'] > 1) { ?>
                                                <a
                                                    href="carrinho.php?operacao=menos&id_produto=<?= $produto['id_produto'] ?>"
                                                    class="btn-maismenos"
                                                    aria-label="Diminuir quantidade"
                                                >
                                                    <span class="material-symbols-outlined">remove</span>
                                                </a>
                                            <?php } else { ?>
                                                <span class="btn-indisponivel">
                                                    <span class="material-symbols-outlined">remove</span>
                                                </span>
                                            <?php } ?>

                                            <span class="valor-quantidade">
                                                <?= $produto['quantidade'] ?>
                                            </span>

                                            <?php if ($produto['quantidade'] < $produto['estoque']) { ?>
                                                <a
                                                    href="carrinho.php?operacao=mais&id_produto=<?= $produto['id_produto'] ?>"
                                                    class="btn-maismenos"
                                                    aria-label="Aumentar quantidade"
                                                >
                                                    <span class="material-symbols-outlined">add</span>
                                                </a>
                                            <?php } else { ?>
                                                <span class="btn-indisponivel">
                                                    <span class="material-symbols-outlined">add</span>
                                                </span>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="preco-produto-carrinho">
                                <span class="rotulo-mobile">Preço Unitário</span>
                                <span>
                                    R$ <?= number_format(
                                        $produto['valor_unitario'],
                                        2,
                                        ',',
                                        '.'
                                    ) ?>
                                </span>
                            </div>

                            <div class="subtotal-produto-carrinho">
                                <span class="rotulo-mobile">Subtotal</span>
                                <strong>
                                    R$ <?= number_format(
                                        $subtotal,
                                        2,
                                        ',',
                                        '.'
                                    ) ?>
                                </strong>
                            </div>

                            <div class="acoes-produto-carrinho">
                                <a
                                    href="carrinho.php?operacao=excluir&id_produto=<?= $produto['id_produto'] ?>"
                                    class="btn-acao btn-excluir"
                                >
                                    <span class="material-symbols-outlined">delete</span>
                                    Excluir
                                </a>

                                <a
                                    href="produtCompra.php?id=<?= $produto['id_produto'] ?>"
                                    class="btn-acao btn-alterar"
                                >
                                    <span class="material-symbols-outlined">info</span>
                                    Detalhes
                                </a>
                            </div>

                        </article>

                    <?php } ?>
                </div>

                <a href="feedProdutos.php" class="btn-voltar">
                    <i class="fa-solid fa-arrow-left"></i>
                    <span>Continuar comprando</span>
                </a>

            </div>    

            <aside class="resumo-carrinho">
                <h2>Resumo da compra</h2>

                <div class="linha-resumo">
                    <span>Quantidade de itens:</span>
                    <strong>
                        <span><?= $quantidadeItens ?></span>
                    </strong>
                </div>

                <div class="lista-subtotais">
                    <h3>Subtotal por produto</h3>

                    <?php foreach ($produtos as $produto) { ?>
                        <div class="linha-subtotal">
                            <span>
                                <?= htmlspecialchars($produto['nome']) ?>
                                (<?= $produto['quantidade'] ?>x)
                            </span>
                            <strong>
                                R$
                                <?= number_format(
                                    $produto['valor_unitario'] * $produto['quantidade'],
                                    2,
                                    ',',
                                    '.'
                                ) ?>
                            </strong>
                        </div>
                    <?php } ?>
                </div>

                <div class="linha-total">
                    <span>Total:</span>
                    <strong>
                        R$ <?= number_format($total, 2, ',', '.') ?>
                    </strong>
                </div>

                <?php if (isset($_SESSION['sessaoLogin']) && !empty($produtos)) { ?>
                    <form action="reservar.php" method="POST">
                        <input type="hidden" name="origem" value="carrinho">

                        <button type="submit" class="btn-reservar">
                            RESERVAR COMPRA
                        </button>
                    </form>
                <?php } ?>
            </aside>
        </div>
    <?php } ?>

</main>
<?php include "_rodape.php"; ?>
</body>

</html>