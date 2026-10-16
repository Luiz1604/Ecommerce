<?php
include "util.php";

if (isset($_SESSION['sessaoConectado']) && $_SESSION['sessaoConectado'] == true)
    redirecionar("index.php");

$erroLogin = false;



if (isset($_SESSION['sessaoConectado']) && $_SESSION['sessaoConectado'] == true)
    redirecionar("index.php");

if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $nome = "";
    $foto = "";
    $admin = "";
    $telefone = "";

    if (ValidaLogin($email, $senha, $nome, $foto, $admin, $telefone)) {
        $_SESSION['sessaoConectado'] = true;
        $_SESSION['sessaoLogin'] = $email;
        $_SESSION['sessaoNome'] = $nome;
        $_SESSION['sessaoFoto'] = $foto;
        $_SESSION['sessaoAdmin'] = $admin;
        $_SESSION['sessaoTel'] = $telefone;

    // Transfere o carrinho de visitante para o banco
    if (!empty($_SESSION['carrinho'])) {
        try {
            $conn = conecta();
            $conn->beginTransaction();

            // 1. Busca o ID do usuario
            $varSQL = "SELECT id_usuario
                    FROM usuario
                    WHERE email = :email";

            $select = $conn->prepare($varSQL);
            $select->bindParam(':email', $email);
            $select->execute();

            $idUsuario = $select->fetchColumn();

            if (!$idUsuario) {
                throw new Exception("Usuario nao encontrado.");
            }

             // 2. Procura ou cria o carrinho do usuario
            $varSQL = "SELECT id_compra
                       FROM compra
                       WHERE fk_usuario = :id_usuario
                       AND status = 'carrinho'
                       ORDER BY id_compra DESC
                       LIMIT 1";

            $select = $conn->prepare($varSQL);
            $select->bindParam(':id_usuario', $idUsuario);
            $select->execute();

            $idCompra = $select->fetchColumn();

            if (!$idCompra) {
                $sessao = session_id();

                $varSQL = "INSERT INTO compra
                               (status, fk_usuario, sessao)
                           VALUES
                               ('carrinho', :id_usuario, :sessao)
                           RETURNING id_compra";

                $insert = $conn->prepare($varSQL);
                $insert->bindParam(':id_usuario', $idUsuario);
                $insert->bindParam(':sessao', $sessao);
                $insert->execute();

                $idCompra = $insert->fetchColumn();
            }

            // 3. Percorre os produtos do carrinho temporario
            foreach ($_SESSION['carrinho'] as $idProduto => $qtdSessao) {
                $idProduto = (int) $idProduto;
                $qtdSessao = filter_var(
                    $qtdSessao,
                    FILTER_VALIDATE_INT,
                    ["options" => ["min_range" => 1]]
                );

                if ($qtdSessao === false) {
                    throw new Exception("Quantidade invalida.");
                }

                // Busca o produto e o estoque atual
                $varSQL = "SELECT
                               produto.id_produto,
                               produto.valor_unitario,
                               COALESCE(
                                   (SELECT SUM(entrada.quantidade)
                                    FROM entrada
                                    WHERE entrada.fk_produto =
                                          produto.id_produto),
                                   0
                               ) AS estoque
                           FROM produto
                           WHERE produto.id_produto = :id_produto
                           AND produto.excluido = false";

                $select = $conn->prepare($varSQL);
                $select->bindParam(':id_produto', $idProduto);
                $select->execute();

                $produto = $select->fetch();

                if (!$produto) {
                    throw new Exception("Produto indisponivel.");
                }

                // Verifica se o produto ja esta no carrinho do usuario
                $varSQL = "SELECT quantidade
                           FROM compra_produto
                           WHERE fk_compra = :id_compra
                           AND fk_produto = :id_produto";

                $select = $conn->prepare($varSQL);
                $select->bindParam(':id_compra', $idCompra);
                $select->bindParam(':id_produto', $idProduto);
                $select->execute();

                $produtoExistente = $select->fetch();

                $qtdAtual = $produtoExistente
                    ? (int) $produtoExistente['quantidade']
                    : 0;

                // Confere o estoque antes de somar as quantidades
                if ($qtdAtual + $qtdSessao > (int) $produto['estoque']) {
                    throw new Exception("Estoque insuficiente.");
                }

                if ($produtoExistente) {
                    // Soma a quantidade ao produto existente
                    $varSQL = "UPDATE compra_produto
                               SET quantidade = quantidade + :quantidade
                               WHERE fk_compra = :id_compra
                               AND fk_produto = :id_produto";

                    $update = $conn->prepare($varSQL);
                    $update->bindParam(':quantidade', $qtdSessao);
                    $update->bindParam(':id_compra', $idCompra);
                    $update->bindParam(':id_produto', $idProduto);
                    $update->execute();

                } else {
                    // Insere o produto no carrinho do usuario
                    $varSQL = "INSERT INTO compra_produto
                                   (fk_produto, fk_compra,
                                    quantidade, valor_unitario)
                               VALUES
                                   (:id_produto, :id_compra,
                                    :quantidade, :valor_unitario)";

                    $insert = $conn->prepare($varSQL);
                    $insert->bindParam(':id_produto', $idProduto);
                    $insert->bindParam(':id_compra', $idCompra);
                    $insert->bindParam(':quantidade', $qtdSessao);
                    $insert->bindParam(
                        ':valor_unitario',
                        $produto['valor_unitario']
                    );
                    $insert->execute();
                }
            }

            // 4. Confirma a transferencia no banco
            $conn->commit();

            // Limpa o carrinho temporario somente apos o sucesso
            unset($_SESSION['carrinho']);

            $conn->commit();

        }catch (Exception $e) {
            if (isset($conn) && $conn->inTransaction()) {
                $conn->rollBack();
            }

              $_SESSION['erroTransferenciaCarrinho'] = true;
        }
    }

    DefineCookie('email', $_SESSION['sessaoLogin'], 1440);

    redirecionar("index.php");
    exit;
    

        } else {
            /*echo "Verifique se a senha está correta ou se
                    você já está cadastrado";*/
            $erroLogin = true;
        }
}

include "_cabecalho.php"

?>



<body>


    <!--Cadastro-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.3.1/css/all.css" integrity="sha512-x9WwyMYBnlXMNQ6kQ/Lyzu1NqIhLQKL5Oq6xByfXuRj7s9CskyCbLv/1IjqzJmXwFXWr0ov6jBV7Qbc0hh9nHg==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <main class="main-login">
        <div class="esquerda-login">
            <h1>Entre e encontre a coleção certa<br>para completar o seu estilo.</h1>

            <picture>
                <source media="(max-width: 768px)" srcset="mobile-login-animate.svg">
                <img src="login-animate.svg" class="esquerda-login-image" alt="login animação">

            </picture>
        </div>

        <div class="container-direita">
            <div class="login-card">
                <h2>Login</h2>

                <form action="login.php" method="post" class="form-login <?= $erroLogin ? 'login-erro' : '' ?>">

                    <input type="hidden" name="origem" value="login">

                    <?php if ($erroLogin): ?>
                        <div class="alerta-erro">
                            <span class="material-symbols-outlined">error</span>
                            <span>E-mail ou senha incorretos. Tente novamente.</span>
                        </div>
                    <?php endif; ?>

                    <label for="email">E-mail</label>
                    <div class="input-box">
                        <span class="icon"><i class="fa-solid fa-user"></i></span>
                        <input type="text" id="email" placeholder="seuemail@exemplo.com" oninput="mascaraEmail(this)" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" name="email" placeholder="Digite seu e-mail" required autocomplete="username">
                    </div>

                    <label for="senha">Senha</label>
                    <div class="input-box">
                        <span class="icon">
                            <i class="fa-solid fa-lock"></i>
                        </span>
                        <input type="password" id="senha" name="senha" placeholder="Digite sua senha" required autocomplete="current-password">
                        <button type="button" class="senha-toggle" id="senha-toggle" aria-label="Mostrar senha" aria-pressed="false">
                            <i class="fa-solid fa-eye" aria-hidden="true"></i>
                        </button>
                    </div>

                    <div class="options">
                        <label>
                            <input type="checkbox"> Lembrar-me
                        </label>
                        <a href="esqueci.php" class="link"> Esqueceu a senha? </a>
                    </div>

                    <button class="btn"> Entrar </button>
                    <br>
                    <hr class="hr-login">

                    <p class="link-p">
                        <a href="cadastro.php" class="link"> Não tem uma conta</a>
                    </p>

                </form>

            </div>

        </div>
    </main>

    <?php
    include "_rodape.php";
    ?>
</body>

</html>