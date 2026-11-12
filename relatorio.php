
<?php
include "util.php";
include "_cabecalho.php";
?>
<link rel="stylesheet" href="monitorVendas.css">

<div class="monitor-vendas-page">

    <h1 class="monitor-titulo">Monitor de vendas</h1>

    <form class="monitor-formulario" action="" method="post">
        <div class="monitor-campo">
            <label for="datai">Data inicial</label>
            <input type="date" id="datai" name="datai" value="<?= date('Y-m-d') ?>">
        </div>

        <div class="monitor-campo">
            <label for="dataf">Data final</label>
            <input type="date" id="dataf" name="dataf" value="<?= date('Y-m-d') ?>">
        </div>

        <div class="monitor-checkbox">
            <input type="checkbox" id="cancelados" name="cancelados" value="checked" checked>
            <label for="cancelados">Omitir cancelados</label>
        </div>

        <input type="submit" class="monitor-botao" value="Enviar">
    </form>

    <?php
    if ($_POST) {
        $conn = conecta();
        $datai = $_POST['datai'];
        $dataf = $_POST['dataf'];
        $cancelados = isset($_POST['cancelados']) ? $_POST['cancelados'] : "";

        $sql = "SELECT id_compra, status, data, usuario.nome
                FROM compra
                LEFT JOIN usuario ON compra.fk_usuario = usuario.id_usuario
                WHERE data BETWEEN :datai AND :dataf " .
                ($cancelados == "checked" ? " AND status != 'cancelado' " : "") .
                " ORDER BY data DESC";

        $select = $conn->prepare($sql);
        $select->bindParam(':datai', $datai);
        $select->bindParam(':dataf', $dataf);
        $select->execute();
    ?>

    <h3 class="monitor-periodo">
        Período de <?= date('d/m', strtotime($datai)) ?> a <?= date('d/m', strtotime($dataf)) ?>
    </h3>

    <div class="monitor-tabela-container">
        <table class="monitor-tabela">
            <thead>
                <tr>
                    <th class="col-id">ID</th>
                    <th class="col-status">Sit</th>
                    <th class="col-data">Data</th>
                    <th class="col-produto">Usuário / Produto</th>
                    <th class="col-qtd">Qtd</th>
                    <th class="col-valor">$ Unit</th>
                    <th class="col-sub">$ Sub</th>
                    <th class="col-total">$ Tot</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($linha = $select->fetch()) {
                    $id_compra = $linha['id_compra'];
                    $status = $linha['status'];
                    $data = $linha['data'];
                    $nome = $linha['nome'];
                ?>

                <tr class="monitor-linha-compra">
                    <td class="col-id texto-direita"><?= $id_compra ?></td>
                    <td class="col-status"><?= $status ?></td>
                    <td class="col-data"><?= date('d/m', strtotime($data)) ?></td>
                    <td class="col-identificacao" colspan="5"><?= $nome ?></td>
                </tr>

                <?php
                $sqlItens = "SELECT compra_produto.fk_produto, produto.nome,
                                    compra_produto.quantidade,
                                    compra_produto.valor_unitario,
                                    compra_produto.valor_unitario * compra_produto.quantidade AS sub
                             FROM compra_produto
                             INNER JOIN produto ON compra_produto.fk_produto = produto.id_produto
                             WHERE compra_produto.fk_compra = $id_compra
                             ORDER BY produto.nome";

                $selectItens = $conn->prepare($sqlItens);
                $selectItens->execute();
                $tot = 0;

                while ($linhaItens = $selectItens->fetch()) {
                    $nome = $linhaItens['nome'];
                    $quantidade = $linhaItens['quantidade'];
                    $valor_unitario = number_format($linhaItens['valor_unitario'], 2);
                    $sub = number_format($linhaItens['sub'], 2);
                    $tot += $linhaItens['sub'];
                ?>

                <tr class="monitor-linha-produto">
                    <td colspan="3"></td>
                    <td class="monitor-nome-produto"><b><?= $nome ?></b></td>
                    <td class="texto-direita"><?= $quantidade ?></td>
                    <td class="texto-direita"><?= $valor_unitario ?></td>
                    <td class="texto-direita"><?= $sub ?></td>
                    <td></td>
                </tr>

                <?php } ?>

                <tr class="monitor-linha-total">
                    <td colspan="7"></td>
                    <td class="texto-direita">R$ <?= number_format($tot, 2) ?></td>
                </tr>

                <?php
                $selectItens = null;
                }
                ?>
            </tbody>
        </table>
    </div>

    <?php } ?>

</div>

<?php include "_rodape.php"; ?>
