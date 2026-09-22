<html>

<body>
    <?php
        include "../util.php";
        include "../_cabecalho.php";

        $conn = conecta();

        $varSQL = "SELECT *
                FROM produto
                WHERE excluido = FALSE
                ORDER BY nome";

        $select = $conn->prepare($varSQL);
        $select->execute();
    ?>
    <table>
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
                while ($linha = $select->fetch())
                $id = $linha["id_produto"];
                $nome = $linha["nome"];
                $descricao = $linha["descricao"];
                $valor = $linha["valor_unitario"];
                $imagem = $linha["imagem"];
            ?>

                <td><?=$ID?></td>
                    <td><?=$nome?></td>
                    <td><?=$descricao?></td>
                    <td><?=$valor?></td>";
                <?php
                if(!empty($imagem) && file_exists($imagem))
                    echo "<img src='$imagem'>";
                else
                    ?>
                    </td>
                    <td><a href='alterarProduto.php?id=$id'>Alterar</a></td>
                    <td><a href='excuirProduto.php?id=$id'>Excluir</a></td>
                    </tr>";
        
    </table>
</body>

</html>