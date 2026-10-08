<?php
    include "util.php";
    include "_cabecalho.php";

    $operacao = $_GET['operacao'] ?? null;
    $idProduto = $_GET['id_produto'] ?? null;
    $quantidade = $_POST['quantidade'] ?? 1;

   //tipo B (usuario logado)
    if (isset($_SESSION['sessaoLogin'])){

        $conn = conecta();

        //descobre o id_usuario atravez do email
        $email = $_SESSION['sessaoLogin'];

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
        if (!$compra){
            $varSQL = "INSERT INTO compra (status, fk_usuario, sessao)
                        VALUES ('carrinho', :id_usuario, :sessao)
                        RETURNING id_compra";

            $insert = $conn->prepare($varSQL);
            $insert->bindParam(":id_usuario", $idUsuario);
            $insert->bindParam(":sessao", $sessao);
            $insert->execute();

            $compra = $insert->fetch();
        }

        if($operacao == 'incluir'){

            //verifica se o produto enviado já existe em compra_produto
            $varSQL = "SELECT *
                FROM compra_produto
                WHERE fk_compra = :id_compra
                AND fk_produto = :id_produto";

            $select = $conn->prepare($varSQL);
            $select->bindParam(":id_compra", $compra['id_compra']);
            $select->bindParam(":id_produto", $idProduto);
            $select->execute();

            $produtoCarrinho = $select->fetch();

            if($produtoCarrinho){
                $varSQL = "UPDATE compra_produto
                    SET quantidade = quantidade + :quantidade
                    WHERE fk_compra = :id_compra
                    AND fk_produto = :id_produto";

                $update = $conn->prepare($varSQL);
                $update->bindParam(":quantidade", $quantidade);
                $update->bindParam(":id_compra", $compra['id_compra']);
                $update->bindParam(":id_produto", $idProduto);
                $update->execute();
            }else{
                $varSQL = "INSERT INTO compra_produto
                            (fk_produto, fk_compra, quantidade, valor_unitario)
                            SELECT id_produto, :id_compra, :quantidade, valor_unitario
                            FROM produto
                            WHERE id_produto = :id_produto";

                $insert = $conn->prepare($varSQL);
                $insert->bindParam(":id_compra", $compra['id_compra']);
                $insert->bindParam(":quantidade", $quantidade);
                $insert->bindParam(":id_produto", $idProduto);
                $insert->execute();
            }

            //busca os produtos da compra
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
        }

        $produtos = $select->fetchAll();
    }
    else //tipo A (visitante)
    {
        if(!isset($_SESSION['carrinho'])) {   //TERMINAR!!
                $_SESSION['carrinho'] = [];
        }
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