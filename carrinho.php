<?php
    include "util.php";
    include "_cabecalho.php";

    $conn = conecta();

    //descobre a sessão do usuário atravez do email
    if(isset($_SESSION['sessaoLogin']))
    {
        $email = $_SESSION['sessaoLogin'];
    }
    else
    {
        
    }

    $varSQL = "SELECT id_usuario
                    FROM usuario
                    WHERE email = :email";

    $select = $conn->prepare($varSQL);
    $select->bindParam(":email", $email);
    $select->execute();

    $usuario = $select->fetch();    
                                  
    //descobre a compra que está funcionando no carrinho atravez do id_usuario
    $idUsuario = $usuario['id_usuario'];
    $sessao = session_id();

    $varSQL = "SELECT id_compra
                    FROM compra
                    WHERE fk_usuario = :id_usuario
                    AND sessao = :sessao
                    AND status = 'carrinho'";

    $select = $conn->prepare($varSQL);
    $select->bindParam(":id_usuario", $idUsuario);
    $select->bindParam(":sessao", $sessao);
    $select->execute();

    $compra = $select->fetch();

    //se ainda não existir uma compra
    if (!$compra) {
        $varSQL = "INSERT INTO compra (status, fk_usuario, sessao)
                    VALUES ('carrinho', :id_usuario, :sessao)
                    RETURNING id_compra";

        $insert = $conn->prepare($varSQL);
        $insert->bindParam(":id_usuario", $idUsuario);
        $insert->bindParam(":sessao", $sessao);
        $insert->execute();

        $compra = $insert->fetch();
    }
?>

<main class="secao-carrinho">

    <h1>Meu Carrinho</h1>

    <?php
    
    ?>

    <div class="container-tabela">
        <table class="tabela-usuarios">
            <thead>
                <tr>
                    <th>Imagem</th>
                    <th>Nome</th>
                    <th>Quantidade</th>
                    <th>Preço</th>
                    <th>Subtotal</th>
                    <th>Ações</th>
                    <th></th>
                </tr>
            </thead>
            <?php
            $varSQL = "SELECT 
                        produto.id_produto,
                        produto.nome,
                        produto.descricao,
                        produto.imagem,
                        compra_produto.quantidade,
                        compra_produto.valor_unitario
                    FROM compra_produto
                    INNER JOIN produto
                        ON produto.id_produto = compra_produto.fk_produto
                    WHERE compra_produto.fk_compra = :id_compra";

            $select = $conn->prepare($varSQL);
            $select->bindParam(":id_compra", $compra['id_compra']);
            $select->execute();

            $produtos = $select->fetchAll();
            ?>

            <tbody>
                <?php
                    $total = 0;
                    foreach ($produtos as $produto) { 
                    $subtotal = $produto['valor_unitario'] * $produto['quantidade'];
                    $total += $subtotal;
                ?>
                    <tr>
                        <td>
                            <img src="<?= $produto['imagem'] ?>" alt="<?= $produto['nome'] ?>">
                        </td>
                        <td>
                            <?= $produto['nome'] ?>
                        </td>
                        <td>
                            <a href="#">-</a>
                            <span><?= $produto['quantidade'] ?></span>
                            <a href="#">+</a>
                        </td>
                        <td>
                            R$ <?= number_format($produto['valor_unitario'], 2, ',', '.') ?>
                        </td>
                        <td>
                            R$ <?= number_format(
                                    $produto['valor_unitario'] * $produto['quantidade'],
                                    2,
                                    ',',
                                    '.'
                                ) ?>
                        </td>
                        <td>
                            <a href="#">Excluir</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <div class="total-carrinho">
            <h2>
                Total: R$ <?= number_format($total, 2, ',', '.') ?>
            </h2>
        </div>
</main>
<?php include "_rodape.php"; ?>
</body>
</html>