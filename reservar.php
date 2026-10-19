<?php
include "util.php";

if (!isset($_SESSION['sessaoLogin'])) {
    header("Location: login.php");
    exit;
}

// identifica a origem da solicitacao
$origem = $_POST['origem'] ?? null;

// verifica se a origem e valida
if ($origem != 'produto' && $origem != 'carrinho') {
    header("Location: carrinho.php");
    exit;
}

$conn = conecta();

// descobre o id do usuario pelo email da sessao
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

if ($origem == 'produto') {
    $produtoId = $_POST['produto_id'] ?? null;
    $quantidade = $_POST['quantidade'] ?? null;

    // valida o id do produto
    if (filter_var($produtoId, FILTER_VALIDATE_INT, ["options" => ["min_range" => 1]]) === false) {
        redirecionar("index.php");
        exit;
    }

    // valida a quantidade
    if (filter_var($quantidade, FILTER_VALIDATE_INT, ["options" => ["min_range" => 1, "max_range" => 10]]) === false) {
        header("Location: produtoCompra.php?id=" . $produtoId);
        exit;
    }

    // consulta o produto e o estoque disponivel
    $varSQL = "SELECT
                       produto.id_produto,
                       produto.valor_unitario,
                       COALESCE((
                           SELECT SUM(entrada.quantidade)
                           FROM entrada
                           WHERE entrada.fk_produto = produto.id_produto
                       ), 0)
                       -
                       COALESCE((
                           SELECT SUM(compra_produto.quantidade)
                           FROM compra_produto
                           INNER JOIN compra
                               ON compra.id_compra = compra_produto.fk_compra
                           WHERE compra_produto.fk_produto = produto.id_produto
                             AND compra.status IN ('reservado', 'entregue')
                       ), 0) AS estoque_disponivel
                   FROM produto
                   WHERE produto.id_produto = :id_produto
                     AND produto.excluido = FALSE";

    $select = $conn->prepare($varSQL);
    $select->bindParam(":id_produto", $produtoId);
    $select->execute();

    $produto = $select->fetch();

    // verifica se o produto existe
    if (!$produto) {
        redirecionar("index.php");
        exit;
    }

    // verifica se existe estoque suficiente
    if ($quantidade > $produto['estoque_disponivel']) {
        header("Location: produtoCompra.php?id=" . $produtoId);
        exit;
    }

    // inicia uma transacao
    $conn->beginTransaction();

    try {
        // cria uma compra diretamente como reservada
        $varSQL = "INSERT INTO compra
                           (status, fk_usuario, sessao)
                       VALUES
                           ('reservado', :id_usuario, :sessao)
                       RETURNING id_compra";

        $insert = $conn->prepare($varSQL);
        $insert->bindParam(":id_usuario", $idUsuario);

        $sessao = session_id();
        $insert->bindParam(":sessao", $sessao);

        $insert->execute();

        $idCompra = $insert->fetchColumn();

        // registra o produto e a quantidade reservada
        $varSQL = "INSERT INTO compra_produto
                           (fk_compra, fk_produto, quantidade, valor_unitario)
                       VALUES
                           (:id_compra, :id_produto, :quantidade, :valor_unitario)";

        $insert = $conn->prepare($varSQL);
        $insert->bindParam(":id_compra", $idCompra);
        $insert->bindParam(":id_produto", $produtoId);
        $insert->bindParam(":quantidade", $quantidade);
        $insert->bindParam(":valor_unitario", $produto['valor_unitario']);

        $insert->execute();

        // confirma as operacoes no banco
        $conn->commit();
    } catch (PDOException $e) {

        // desfaz as operacoes se ocorrer algum erro
        if ($conn->inTransaction()) {
            $conn->rollBack();
        }

        error_log($e->getMessage());

        header("Location: produtoCompra.php?id=" . $produtoId);
        exit;
    }

    header("Location: minhasReservas.php");
    exit;
}

if ($origem == 'carrinho') {
    // busca o carrinho atual do usuario
    $varSQL = "SELECT id_compra
                FROM compra
                WHERE fk_usuario = :id_usuario
                    AND status = 'carrinho'
                ORDER BY id_compra DESC
                LIMIT 1";

    $select = $conn->prepare($varSQL);
    $select->bindParam(":id_usuario", $idUsuario);
    $select->execute();

    $carrinho = $select->fetch(PDO::FETCH_ASSOC);

    // verifica se existe um carrinho
    if (!$carrinho) {
        header("Location: carrinho.php");
        exit;
    }

    $idCompra = $carrinho['id_compra'];

    // busca os produtos do carrinho e o estoque disponivel
    $varSQL = "SELECT
                       compra_produto.fk_produto AS id_produto,
                       compra_produto.quantidade,
                       produto.nome,
                       COALESCE((
                           SELECT SUM(entrada.quantidade)
                           FROM entrada
                           WHERE entrada.fk_produto = produto.id_produto
                       ), 0)
                       -
                       COALESCE((
                           SELECT SUM(cp.quantidade)
                           FROM compra_produto cp
                           INNER JOIN compra c
                               ON c.id_compra = cp.fk_compra
                           WHERE cp.fk_produto = produto.id_produto
                             AND c.status IN ('reservado', 'entregue')
                       ), 0) AS estoque_disponivel
                   FROM compra_produto
                   INNER JOIN produto
                       ON produto.id_produto = compra_produto.fk_produto
                   WHERE compra_produto.fk_compra = :id_compra
                     AND produto.excluido = FALSE";

    $select = $conn->prepare($varSQL);
    $select->bindParam(":id_compra", $idCompra);
    $select->execute();

    $produtosCarrinho = $select->fetchAll(PDO::FETCH_ASSOC);

    // verifica se o carrinho possui produtos
    if (empty($produtosCarrinho)) {
        header("Location: carrinho.php");
        exit;
    }

    // verifica se existe estoque suficiente para todos os produtos
    foreach ($produtosCarrinho as $produto) {
        if ((int) $produto['quantidade'] > (int) $produto['estoque_disponivel']) {

            $estoqueDisponivel = max(0, (int) $produto['estoque_disponivel']);

            $_SESSION['mensagemCarrinho'] =
                'Estoque insuficiente para reservar "' .
                $produto['nome'] . '". Você tem ' .
                $produto['quantidade'] . ' unidade(s) no carrinho, mas apenas ' .
                $estoqueDisponivel . ' unidade(s) estão disponíveis. ' .
                'Altere a quantidade para continuar.';

            header("Location: carrinho.php");
            exit;
        }
    }

    // inicia uma transacao
    $conn->beginTransaction();

    try {
        // transforma o carrinho em uma reserva
        $varSQL = "UPDATE compra
                       SET status = 'reservado',
                           data = CURRENT_TIMESTAMP
                       WHERE id_compra = :id_compra
                         AND fk_usuario = :id_usuario
                         AND status = 'carrinho'";

        $update = $conn->prepare($varSQL);
        $update->bindParam(":id_compra", $idCompra);
        $update->bindParam(":id_usuario", $idUsuario);
        $update->execute();

        // verifica se o carrinho foi atualizado
        if ($update->rowCount() != 1) {
            throw new PDOException("Nao foi possivel confirmar a reserva.");
        }

        // confirma as alteracoes no banco
        $conn->commit();
    } catch (PDOException $e) {
        // desfaz as alteracoes se ocorrer um erro
        if ($conn->inTransaction()) {
            $conn->rollBack();
        }

        error_log($e->getMessage());

        header("Location: carrinho.php");
        exit;
    }

    $_SESSION['mensagemSucesso'] =
        'Parabéns! Sua reserva do produto foi realizada com sucesso.';

    header("Location: minhasReservas.php");
    exit;
}
