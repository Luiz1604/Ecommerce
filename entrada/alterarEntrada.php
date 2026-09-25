<html>

    <body>
        <?php
            include "../util.php";

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

        <form action="updateEntrada.php" method="post" enctype="multipart/form-data">
    
    <input type="hidden" name="id" value="<?=$id ?>">

    <label for="qtd">Quantidade</label>
    <input type="number" min="0" step="1" name="qtd" id="qtd" value="<?=$qtd ?>" required><br>

    <label for="custo">Custo Unitário</label>
    <input type="number" min="0" step="0.01" name="custo" id="custo" value="<?=$custo ?>" required><br>

    <label for="obs">Observação</label>
    <input type="text" name="obs" id="obs" value="<?=$obs ?>"><br>

    <label for="idProd">ID do Produto</label>
    <input type="number" min="1" step="1" name="idProd" id="idProd" value=" <?=$idProd ?>" required><br>

    <input type="submit" value="Alterar">

    </body>

</html>