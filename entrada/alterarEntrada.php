<html>

<body>
    <?php
        include "../util.php";
        include "../_cabecalho.php";

        SaiSeHacker();

        $conn = conecta();

        $id = $_GET["id"];

        $varSQL = "SELECT *
                    FROM entrada
                    WHERE id_entrada = :id";

        $select = $conn->prepare($varSQL);
        $select->bindParam(":id", $id);
        $select->execute();

        $linha = $select->fetch();

        $id = $linha["id_entrada"];
        $qtd = $linha["quantidade"];
        $custo = $linha["custo_unitario"];
        $obs = $linha["obs"];
        $idProd = $linha["fk_produto"];
    ?>

    <div class="container-form">
        <form action="updateEntrada.php" method="post" enctype="multipart/form-data" class="form-usuario">

            <input type="hidden" name="id" value="<?= $id ?>">

            <div class="form-grupo">
                <label for="qtd" class="form-label">Quantidade</label>
                <input type="number" min="0" step="1" name="qtd" id="qtd" value="<?= $qtd ?>" class="form-input" required>
            </div>

            <div class="form-grupo">
                <label for="custo" class="form-label">Custo Unitário</label>
                <input type="number" min="0" step="0.01" name="custo" id="custo" value="<?= $custo ?>" class="form-input" required>
            </div>

            <div class="form-grupo">
                <label for="obs" class="form-label">Observação</label>
                <input type="text" name="obs" id="obs" value="<?= $obs ?>" class="form-input">
            </div>

            <div class="form-grupo">
                <label for="idProd" class="form-label">ID do Produto</label>
                <input type="number" min="1" step="1" name="idProd" id="idProd" value="<?= $idProd ?>" class="form-input" required>
            </div>

            <div class="form-grupo">
                <input type="submit" value="Alterar" class="btn-submit">
            </div>

            <a href="entrada.php" class="btn-voltar">Voltar</a>

        </form>
    </div>
</body>

</html>