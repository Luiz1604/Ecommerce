<?php

    include "util.php";

    if (!isset($_SESSION['sessaoLogin'])){
        header("Location: login.php");
        exit;
    }

    $conn = conecta();

    $email = $_SESSION['sessaoLogin'];

    $varSQL = "SELECT id_usuario
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

    <h1>Minhas Reservas</h1>

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
                </tr>
            </thead>

            <tbody>
                <?php
                $total = 0;

                foreach ($reservas as $reserva) {
                    $subtotal = $reserva['valor_unitario'] * $reserva['quantidade'];
                    $total += $subtotal;
                ?>
                    <tr>
                        <td class="celula-imagem-carrinho">
                            <img
                            class="imagem-carrinho"
                                src="<?= htmlspecialchars($reserva['imagem']) ?>"
                                alt="<?= htmlspecialchars($reserva['nome']) ?>"
                            >
                        </td>

                        <td>
                            <?= htmlspecialchars($reserva['nome']) ?>
                        </td>

                        <td>
                            <?= $reserva['quantidade'] ?>
                        </td>

                        <td>
                            R$ <?= number_format(
                                $reserva['valor_unitario'],
                                2,
                                ',',
                                '.'
                            ) ?>
                        </td>

                        <td>
                            R$ <?= number_format(
                                $subtotal,
                                2,
                                ',',
                                '.'
                            ) ?>
                        </td>

                        <td>
                            <span>Reservado</span>
                            <form action="cancelarReserva.php" method="POST"
                                onsubmit="return confirm('Deseja cancelar esta reserva?');">
                                <input
                                    type="hidden"
                                    name="id_compra"
                                    value="<?= $reserva['id_compra'] ?>"
                                >
                                <button type="submit" class="btn-cancelar">
                                    Cancelar reserva
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <div class="total-carrinho">
            <h2>
                Total reservado: R$ <?= number_format($total, 2, ',', '.') ?>
            </h2>
        </div>

        <?php if (empty($reservas)) { ?>
            <p>Você ainda não possui reservas.</p>
        <?php } ?>
    </div>
</main>

<?php include "_rodape.php"; ?>
</body>
</html>