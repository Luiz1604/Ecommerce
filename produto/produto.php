<html>

<body>
    <?php
    include "../util.php";
    include "../_cabecalho.php";
    SaiSeHacker();

    $conn = conecta();

    $varSQL = "SELECT *
                FROM produto
                WHERE excluido = FALSE
                ORDER BY nome";

    $select = $conn->prepare($varSQL);
    $select->execute();
    ?>
<!--mesmo nome de classes da tabela usuarios, para manter o estilo padronizado e economizar css-->
    <div class="container-tabela">
        <table class="tabela-usuarios">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Valor Unitário</th>
                    <th>Imagem</th>
                    <th>Ações</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                <?php
                while ($linha = $select->fetch()) {
                    $id = $linha["id_produto"];
                    $nome = $linha["nome"];
                    $descricao = $linha["descricao"];
                    $valor = $linha["valor_unitario"];
                    $imagem = $linha["imagem"];
                ?>
                    <tr>
                        <td><?= $id ?></td>
                        <td><?= $nome ?></td>
                        <td><?= $descricao ?></td>
                        <td><?= $valor ?></td>
                        
                        <td class="coluna-imagem">
                            <?php
                            if (!empty($imagem) && file_exists($imagem))
                                echo "<img src='$imagem' class='img-usuario'>";
                            else
                                echo "Não há imagem";
                            ?>
                        </td>
                        
                        <td><a href='alterarProduto.php?id=<?= $id ?>' class="btn-acao btn-alterar">Alterar</a></td>
                        <td><a href='excluirProduto.php?id=<?= $id ?>' class="btn-acao btn-excluir">Excluir</a></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>

        <div class="container-botao">
            <a href="adicionarProduto.php" class="btn-adicionar">Adicionar Produto</a>
        </div>
        <a href="../index.php" class="btn-voltar">voltar</a>
    </div>

</body>
</html>