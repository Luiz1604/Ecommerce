<?php

    include "util.php";

    if (!isset($_SESSION['sessaoLogin'])){
        header("Location: login.php");
        exit;
    }

    $conn = conecta();

    $email = $_SESSION['sessaoLogin'];

    $varSQL = "SELECT id_usuario, telefone
           FROM usuario
           WHERE email = :email";
    $select = $conn->prepare($varSQL);
    $select->bindParam(":email", $email);
    $select->execute();

    $usuario = $select->fetch();

    if (!$usuario) {
        header("Location: login.php");
        exit;
    }

    $idUsuario = $usuario['id_usuario'];
    $telefone = preg_replace('/\D/', '', $usuario['telefone']);
    $codigoReserva = substr($telefone, -5);
?>

<?php include "_cabecalho.php";?>

<?php
     // busca as reservas do usuario
    $varSQL = "SELECT
               compra.id_compra,
               compra.data,
               produto.id_produto,
               produto.nome,
               produto.imagem,
               compra_produto.quantidade,
               compra_produto.valor_unitario
           FROM compra
           INNER JOIN compra_produto
               ON compra_produto.fk_compra = compra.id_compra
           INNER JOIN produto
               ON produto.id_produto = compra_produto.fk_produto
           WHERE compra.fk_usuario = :id_usuario
             AND compra.status = 'reservado'
           ORDER BY compra.data DESC, produto.nome";
    
    $select = $conn->prepare($varSQL);
    $select->bindParam(":id_usuario", $idUsuario);
    $select->execute();

    $reservas = $select->fetchAll(PDO::FETCH_ASSOC);
?>

<main class="secao-carrinho">

    <h1 class="h1-carrinho">MINHAS RESERVAS</h1>

    <?php if (empty($reservas)) { ?>

        <div class="carrinho-vazio-quadro">
            <div class="carrinho-vazio">
                <h2>Você ainda não possui reservas</h2>
                <p>Expresse quem você é</p>
                <a href="feedProdutos.php" class="btn-ver-produtos">
                    Ver produtos
                </a>
            </div>
        </div>

    <?php } else { ?>

        <p class="codigo-reserva">
            Código da reserva:
            <strong><?= htmlspecialchars($codigoReserva) ?></strong>
        </p>

        <?php
        $total = 0;
        $quantidadeItens = 0;

        foreach ($reservas as $reserva) {
            $total += $reserva['valor_unitario'] * $reserva['quantidade'];
            $quantidadeItens += $reserva['quantidade'];
        }
        ?>

        <div class="layout-carrinho">

            <div class="container-tabela">

                <div class="lista-produtos">

                    <?php foreach ($reservas as $reserva) {
                        $subtotal = $reserva['valor_unitario'] * $reserva['quantidade'];
                    ?>

                        <article class="card-produto-carrinho">

                            <div class="info-produto-carrinho">

                                <img
                                    class="img-prod-carrinho"
                                    src="<?= htmlspecialchars($reserva['imagem']) ?>"
                                    alt="<?= htmlspecialchars($reserva['nome']) ?>"
                                >

                                <div class="dados-produto-carrinho">

                                    <h3>
                                        <?= htmlspecialchars($reserva['nome']) ?>
                                    </h3>

                                    <div class="controle-quantidade">
                                        <span>Quantidade reservada:</span>

                                        <div class="botoes-quantidade">
                                            <span class="valor-quantidade">
                                                <?= $reserva['quantidade'] ?>
                                            </span>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="preco-produto-carrinho">
                                <span class="rotulo-mobile">Preço Unitário</span>

                                <span>
                                    R$ <?= number_format(
                                        $reserva['valor_unitario'],
                                        2,
                                        ',',
                                        '.'
                                    ) ?>
                                </span>
                            </div>

                            <div class="subtotal-produto-carrinho">
                                <span class="rotulo-mobile">Subtotal</span>

                                <strong>
                                    R$ <?= number_format(
                                        $subtotal,
                                        2,
                                        ',',
                                        '.'
                                    ) ?>
                                </strong>
                            </div>

                            <div class="acoes-produto-carrinho">

                                <span class="status-reservado">
                                    Reservado
                                </span>

                                <form
                                    action="cancelarReserva.php"
                                    method="POST"
                                    onsubmit="return confirm('Deseja cancelar esta reserva?');"
                                >
                                    <input
                                        type="hidden"
                                        name="id_compra"
                                        value="<?= $reserva['id_compra'] ?>"
                                    >

                                    <button
                                        type="submit"
                                        class="btn-acao btn-excluir"
                                    >
                                        <span class="material-symbols-outlined">
                                            cancel
                                        </span>
                                        Cancelar reserva
                                    </button>
                                </form>

                            </div>

                        </article>

                    <?php } ?>

                </div>

                <a href="feedProdutos.php" class="btn-voltar">
                    <i class="fa-solid fa-arrow-left"></i>
                    <span>Continuar comprando</span>
                </a>

            </div>

            <aside class="resumo-carrinho">

                <h2>Resumo da reserva</h2>

                <div class="linha-resumo">
                    <span>Quantidade de itens:</span>

                    <strong>
                        <?= $quantidadeItens ?>
                    </strong>
                </div>

                <div class="lista-subtotais">

                    <h3>Subtotal por produto</h3>

                    <?php foreach ($reservas as $reserva) { ?>
                        <div class="linha-subtotal">

                            <span>
                                <?= htmlspecialchars($reserva['nome']) ?>
                                (<?= $reserva['quantidade'] ?>x)
                            </span>

                            <strong>
                                R$ <?= number_format(
                                    $reserva['valor_unitario'] * $reserva['quantidade'],
                                    2,
                                    ',',
                                    '.'
                                ) ?>
                            </strong>

                        </div>
                    <?php } ?>

                </div>

                <div class="linha-total">
                    <span>Total reservado:</span>

                    <strong>
                        R$ <?= number_format($total, 2, ',', '.') ?>
                    </strong>
                </div>

            </aside>

        </div>

    <?php } ?>

</main>

<?php include "_rodape.php"; ?>
</body>
</html>