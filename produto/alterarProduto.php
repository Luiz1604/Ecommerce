<html>

<body>
    <?php

    include "../util.php";
    include "../_cabecalho.php";

    SaiSeHacker();

    $conn = conecta();

    $id = $_GET["id"];

    $varSQL = "SELECT *
                FROM produto
                WHERE id_produto = :id";

    $select = $conn->prepare($varSQL);
    $select->bindParam(":id", $id);
    $select->execute();

    $linha = $select->fetch();

    $id = $linha['id_produto'];
    $nome = $linha['nome'];
    $descricao = $linha['descricao'];
    $valor = $linha['valor_unitario'];
    $imagem = $linha['imagem'];

    ?>

    <div class="container-form">
        <form action="updateProduto.php" method="post" enctype="multipart/form-data" class="form-usuario">

            <input type="hidden" name="id" value="<?= $id ?>">

            <div class="form-grupo">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" name="nome" id="nome" value="<?= $nome ?>" class="form-input">
            </div>

            <div class="form-grupo">
                <label for="descricao" class="form-label">Descrição</label>
                <input type="text" name="descricao" id="descricao" value="<?= $descricao ?>" class="form-input">
            </div>

            <div class="form-grupo">
                <label for="valor" class="form-label">Valor Unitário</label>
                <input type="number" step="0.01" name="valor" id="valor" value="<?= $valor ?>" class="form-input">
            </div>

            <div class="form-grupo">
                <label for="arquivo" class="form-label">Imagem do Produto</label>

                <?php if (!empty($imagem) && file_exists($imagem)): ?>
                    <div class="preview-imagem">
                        <img src="<?= $imagem ?>" alt="Foto de <?= $nome ?>" class="img-preview">
                    </div>
                <?php endif; ?>

                <input type="file" name="arquivo" id="arquivo" class="form-file">
            </div>

            <div class="form-grupo">
                <input type="submit" value="Salvar Alterações" class="btn-submit">
            </div>
            <a href="produto.php" class="btn-voltar">voltar</a>
        </form>
    </div>
</body>

</html>