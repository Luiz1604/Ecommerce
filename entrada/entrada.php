<html>

<body>
    <?php
    include "../util.php";
    include "../_cabecalho.php";
    SaiSeHacker();

    $conn = conecta();

    $varSQL = "SELECT *
                FROM entrada
                ORDER BY data_entrada";

    $select = $conn->prepare($varSQL);
    $select->execute();
    ?>

    <div class="container-tabela">
        <table class="tabela-usuarios">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>ID Produto</th>
                    <th>Quantidade</th>
                    <th>Custo Unitário</th>
                    <th>Observação</th>
                    <th>Data da Entrada</th>
                    <th>Ações</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                <?php
                while ($linha = $select->fetch()) {
                    $id = $linha['id_entrada'];
                    $idProd = $linha['fk_produto'];
                    $qtd = $linha['quantidade'];
                    $custo = $linha['custo_unitario'];
                    $obs = $linha['obs'];
                    $data = $linha['data_entrada'];
                ?>

                    <tr>
                        <td><?= $id ?></td>
                        <td><?= $idProd ?></td>
                        <td><?= $qtd ?></td>
                        <td><?= $custo ?></td>
                        <td><?= $obs ?></td>
                        <td><?= $data ?></td>

                        <td>
                            <a href='alterarEntrada.php?id=<?= $id ?>'
                               class="btn-acao btn-alterar">Alterar</a>
                        </td>

                        <td>
                            <a href='excluirEntrada.php?id=<?= $id ?>'
                               class="btn-acao btn-excluir">Excluir</a>
                        </td>
                    </tr>

                <?php
                }
                ?>
            </tbody>
        </table>

        <div class="container-botao">
            <a href="adicionarEntrada.php" class="btn-adicionar">Adicionar Entrada</a>
        </div>

        <a href="../index.php" class="btn-voltar">Voltar</a>
    </div>
</body>

</html>