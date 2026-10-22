<?php
    include "util.php";
    include "_cabecalho.php";

    $conn = conecta();

    if (isset($_POST['procura']))
        $filtro = "%" . $_POST['procura'] . "%";
    else if (isset($_GET['tipo']))
        $filtro = "%" . $_GET['tipo'] . "%";
    else 
        $filtro = "%%";

    $categoria = "%" . ($_GET['categoria'] ?? "") . "%";

    $varSQL = "SELECT
                produto.*,
                COALESCE(
                    (SELECT SUM(entrada.quantidade)
                     FROM entrada
                     WHERE entrada.fk_produto = produto.id_produto),
                    0
                )
                -
                COALESCE(
                    (SELECT SUM(compra_produto.quantidade)
                     FROM compra_produto
                     INNER JOIN compra
                        ON compra.id_compra = compra_produto.fk_compra
                     WHERE compra_produto.fk_produto = produto.id_produto
                       AND compra.status IN ('reservado', 'entregue')),
                    0
                ) AS estoque
            FROM produto
            WHERE produto.excluido = FALSE
              AND produto.nome ILIKE :filtro
              AND produto.categoria ILIKE :categoria
            ORDER BY produto.id_produto ASC";

    $select = $conn->prepare($varSQL);
    $select->bindParam(":filtro", $filtro);
    $select->bindParam(":categoria", $categoria);
    $select->execute();

    $produtos = $select->fetchAll();
?>

    <section class="secao-prod">
        <h2 class="titulo-secao">Todos os Produtos</h2>
        <div class="grid-prod">

            <?php foreach($produtos as $produto) { ?>

                <div class="card-prod">
                    <div class="img-prod <?= $produto['estoque'] <= 0 ? 'esgotado' : '' ?>">
                        <img src="<?= htmlspecialchars($produto['imagem']) ?>"
                            alt="<?= htmlspecialchars($produto['nome']) ?>">
                    </div>
                    <h3 class="nome-prod">
                        <?= htmlspecialchars($produto['nome']) ?>
                    </h3>
                    <p class="preco-prod">
                        R$ <?= number_format($produto['valor_unitario'], 2, ',', '.') ?>
                    </p>
                    <?php if ($produto['estoque'] > 0) { ?>
                        <a href="produtCompra.php?id=<?= $produto['id_produto'] ?>"
                        class="btn-detalhes">
                            VER DETALHES
                        </a>
                    <?php } else { ?>
                        <span class="btn-esgotado">
                            PRODUTO ESGOTADO
                        </span>
                    <?php } ?>
                </div>
            <?php } ?> 
        </div>
    </section>

    <?php
        include "_rodape.php";
    ?>
</body>
</html>