<?php
include "util.php";
include "_cabecalho.php";

$conn = conecta();
$token = $_POST['token'] ?? $_GET['token'] ?? '';
$tokenHash = hash('sha256', $token);

$sql = "SELECT id, id_usuario
        FROM recuperacao_senha
        WHERE token_hash = :token
          AND usado = FALSE
          AND expira_em > CURRENT_TIMESTAMP";

$select = $conn->prepare($sql);
$select->bindParam(":token", $tokenHash);
$select->execute();

$recuperacao = $select->fetch();

if ($recuperacao && isset($_POST['senha'])) {
    $senhaNovaCripto = password_hash($_POST['senha'], PASSWORD_DEFAULT);

    $alter = "UPDATE usuario
                SET senha = :senha
                WHERE id_usuario = :id";

    $select = $conn->prepare($alter);
    $select->bindParam(":email", $email);
    $select->bindParam(":senha", $recuperacao['id_usuario']);
    $select->execute();

    echo "O procedimento foi bem sucedido";
} else {
    echo "houve algum erro no caminho, tente novamente";
}
?>

<main class="pagina-esqueci">
    <form class="form-esqueci" action="redefinir.php" method="POST">
        <span class="material-symbols-outlined icone-esqueci" aria-hidden="true">lock_reset</span>
        <h1>Redefinir senha</h1>
        <p class="descricao-esqueci">
            Crie uma nova senha para voltar a acessar sua conta KeyStyle.
        </p>
        <div class="campo-esqueci">
            <label for="senha">Nova senha</label>

            <input type="password" name="senha" id="senha" placeholder="Digite sua nova senha"
                autocomplete="new-password" required>
        </div>
        <button type="submit" class="btn-esqueci">
            Redefinir senha

            <span class="material-symbols-outlined" aria-hidden="true">arrow_forward</span>
        </button>

        <a href="login.php" class="voltar-login">
            Voltar para o login
        </a>
    </form>
</main>