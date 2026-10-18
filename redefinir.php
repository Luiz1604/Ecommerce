<?php
include "util.php";
include "_cabecalho.php";

$conn = conecta();

if(isset($_GET['token'])){
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
            <label for="senha">Digite sua nova senha</label>
            <div class="input-box">
                <span class="icon"><i class="fa-solid fa-lock"></i></span>

                <input
                    type="password"
                    name="senha"
                    id="senha"
                    placeholder="Sua senha"
                    required
                    autocomplete="new-password">

                <button
                    type="button"
                    class="senha-toggle"
                    id="senha-toggle"
                    aria-label="Mostrar senha"
                    aria-pressed="false">
                    <i class="fa-solid fa-eye" aria-hidden="true"></i>
                </button>
            </div>
        </div>

        <label for="confirma_senha">Confirme sua senha</label>
        <div class="input-box">
            <span class="icon"><i class="fa-solid fa-lock"></i></span>

            <input
                type="password"
                name="confirma_senha"
                id="confirma_senha"
                placeholder="Repita a senha"
                required
                autocomplete="new-password">

            <button
                type="button"
                class="senha-toggle"
                id="confirma-senha-toggle"
                aria-label="Mostrar senha"
                aria-pressed="false">
                <i class="fa-solid fa-eye" aria-hidden="true"></i>
            </button>
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