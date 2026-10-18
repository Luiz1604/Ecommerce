<?php
include "util.php";
include "_cabecalho.php";

$conn = conecta();

if (isset($_POST['email'])) {

    $email = trim($_POST['email']);

    $varSQL = "SELECT id_usuario, senha
            FROM usuario
            WHERE email = :email
            AND excluido = FALSE";

    $select = $conn->prepare($varSQL);
    $select->bindParam(":email", $email);
    $select->execute();

    if ($usuario = $select->fetch()) {

        $token = bin2hex(random_bytes(32));

        // Salva o hash
        $tokenHash = hash('sha256', $token);

        // Duração do tken
        $expiraEm = date('Y-m-d H:i:s', time() + 1800);

        // Garante que só haverá um token
        $sql = "DELETE FROM recuperacao_senha
                WHERE id_usuario = :id";

        $delete = $conn->prepare($sql);
        $delete->bindParam(":id", $usuario['id_usuario']);
        $delete->execute();

        // Registra o novo token
        $sql = "INSERT INTO recuperacao_senha
                (id_usuario, token_hash, expira_em)
                VALUES (:id, :token, :expira)";

        $insert = $conn->prepare($sql);
        $insert->bindParam(":id", $usuario['id_usuario']);
        $insert->bindParam(":token", $tokenHash);
        $insert->bindParam(":expira", $expiraEm);
        $insert->execute();


        $senha = $usuario['senha'];
        $mensagem = '<a href=' . linkRedefinir("redefinir.php?senha=$token") . '>Clique aqui para redefinir sua senha</a>';
        EnviaEmail($email, "redefinição de senha", $mensagem);
    } else {
        echo "email incorreto";
    }
}



?>

<main class="pagina-esqueci">
    <form class="form-esqueci" action="esqueci.php" method="post">
        <span class="material-symbols-outlined icone-esqueci">
            lock_reset
        </span>

        <h1>Recuperar senha</h1>

        <p class="descricao-esqueci">
            Informe seu e-mail para receber as instruções de redefinição
            da sua senha.
        </p>

        <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

        <div class="campo-esqueci">
            <label for="email">Endereço de e-mail</label>
            <input type="email" name="email" id="email" placeholder="seuemail@exemplo.com" autocomplete="email"
                required>
        </div>

        <button type="submit" class="btn-esqueci">
            Enviar instruções
            <span class="material-symbols-outlined">
                arrow_forward
            </span>
        </button>

        <a href="login.php" class="voltar-login">
            Voltar para o login
        </a>
    </form>
</main>