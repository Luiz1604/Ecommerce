<html>

<body>
    <?php
    include "../util.php";

    $conn = conecta();

    $varSQL = "SELECT *
                    FROM entrada
                    ORDER BY data_entrada";

    $select = $conn->prepare($varSQL);
    $select->execute();
    ?>

    <table border="1">
        <tr>
            <td>ID</td>
            <td>ID Produto</td>
            <td>Quantidade</td>
            <td>Custo Unitario</td>
            <td>Observação</td>
            <td>Data da Entrada</td>
            <td></td>
            <td></td>
        </tr>

        <?php
        while ($linha = $select->fetch()) {
            $id = $linha['id_entrada'];
            $idProd = $linha['fk_produto'];
            $qtd = $linha['quantidade'];
            $custo = $linha['custo_unitario'];
            $obs = $linha['obs'];
            $data = $linha['data_entrada'];


        }

        ?>
        <tr>
            <td><?= $id ?></td>
            <td><?= $idProd ?></td>
            <td><?= $qtd ?></td>
            <td><?= $custo ?></td>
            <td><?= $obs ?></td>
            <td><?= $data ?></td>
            <td><a href='alterarEntrada.php?id=<?=$id?>'>Alterar</a></td>
            <td><a href='excluirEntrada.php?id=<?=$id?>'>Excluir</a></td>
        </tr>
        <button><a href="adicionarEntrada.php">Adicionar</a></button>
    </table>
</body>

</html>