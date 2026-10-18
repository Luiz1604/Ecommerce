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

    $varSQL = "SELECT *
                FROM produto
                WHERE excluido = FALSE
                AND nome ilike :filtro
                AND categoria ilike :categoria
                ORDER BY id_produto ASC
                ";

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
                   <div class="img-prod">
                       <img src="<?= $produto['imagem'] ?>" alt="<?= $produto['nome'] ?>">
                   </div>
                   <h3 class="nome-prod"><?= $produto['nome'] ?></h3>
                   <p class="preco-prod"><?= number_format($produto['valor_unitario'], 2, ',', '.') ?></p>
                   <a href="produtCompra.php?id=<?= $produto['id_produto'] ?>"
                    class="btn-detalhes">VER DETALHES</a>
                </div>
                
            <?php } ?> 

        </div>
    </section>

    <?php
        include "_rodape.php";
    ?>
</body>
</html>