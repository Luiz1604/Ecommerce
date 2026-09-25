<html>

<body>
    <?php
    include "../util.php";
    SaiSeHacker();

    $conn = conecta();

    $varSQL = "SELECT *
                FROM produto
                WHERE excluido = FALSE
                ORDER BY nome";

    $select = $conn->prepare($varSQL);
    $select->execute();
    ?>

    <table border="1">
        <tr>
            <td>ID</td>
            <td>Nome</td>
            <td>Descrição</td>
            <td>Valor Unirário</td>
            <td>Imagem</td>
            <td></td>
            <td></td>
        </tr>


        <?php
        while ($linha = $select->fetch()) {
            $id = $linha["id_produto"];
            $nome = $linha["nome"];
            $descricao = $linha["descricao"];
            $valor = $linha["valor_unitario"];
            $imagem = $linha["imagem"];
        
        ?>

        <td><?= $id ?></td>
        <td><?= $nome ?></td>
        <td><?= $descricao ?></td>
        <td><?= $valor ?></td>
        <td>
        <?php
        if (!empty($imagem) && file_exists($imagem))
            echo "<img src='$imagem'>";
        else
            echo "Não há imagem";
        ?>
        </td>
        <td><a href='alterarProduto.php?id=<?=$id?>'>Alterar</a></td>
        <td><a href='excluirProduto.php?id=<?=$id?>'>Excluir</a></td>
        </tr>
        <?php
        }
        ?>
        <button><a href="adicionarProduto.php">Adicionar</a></button>

    </table>
</body>

</html>