<?php
include "util.php";

$conn = conecta();

$erroSenha = isset($_GET['erro'])
    && $_GET['erro'] === 'senhas_diferentes';

$token = trim($_POST['token'] ?? $_GET['token'] ?? '');
$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['senha'])) {

    $senha = $_POST['senha'];
    $confirmaSenha = $_POST['confirma_senha'] ?? '';

    // Verificar se as senhas são iguais
    if ($senha !== $confirmaSenha) {
        $erroSenha = true;
        $mensagem = "As senhas digitadas não coincidem.";
    } elseif (empty($token)) {
        $mensagem = "Token de recuperação não informado.";
    } else {
        $tokenHash = hash('sha256', $token);

        $sql = "SELECT id, id_usuario
                FROM recuperacao_senha
                WHERE token_hash = :token
                  AND usado = FALSE
                  AND expira_em > CURRENT_TIMESTAMP";

        $select = $conn->prepare($sql);
        $select->bindParam(":token", $tokenHash);
        $select->execute();

        $recuperacao = $select->fetch(PDO::FETCH_ASSOC);

        if (!$recuperacao) {
            $mensagem = "Token inválido, expirado ou já utilizado.";
        } else {
            try {
                $conn->beginTransaction();

                $senhaNovaCripto = password_hash(
                    $senha,
                    PASSWORD_DEFAULT
                );

                $alter = "UPDATE usuario
                          SET senha = :senha
                          WHERE id_usuario = :id";

                $update = $conn->prepare($alter);
                $update->bindParam(":senha", $senhaNovaCripto);
                $update->bindParam(
                    ":id",
                    $recuperacao['id_usuario']
                );
                $update->execute();

                if ($update->rowCount() === 0) {
                    throw new Exception(
                        "Nenhum usuário foi atualizado."
                    );
                }

                $sqlUsado = "UPDATE recuperacao_senha
                             SET usado = TRUE
                             WHERE id = :id";

                $updateToken = $conn->prepare($sqlUsado);
                $updateToken->bindParam(
                    ":id",
                    $recuperacao['id']
                );
                $updateToken->execute();

                $conn->commit();

                $mensagem = "Senha alterada com sucesso!";
            } catch (Throwable $e) {
                if ($conn->inTransaction()) {
                    $conn->rollBack();
                }

                error_log($e->getMessage());
                $mensagem = "Não foi possível alterar a senha.";
            }
        }
    }
}

include "_cabecalho.php";
?>

<main class="pagina-esqueci">
    <form
        class="form-esqueci <?= $erroSenha ? 'login-erro' : '' ?>"
        action="redefinir.php"
        method="POST">

        <input
            type="hidden"
            name="token"
            value="<?= htmlspecialchars($token, ENT_QUOTES, 'UTF-8') ?>">
            
        <?php if ($mensagem !== ''): ?>
            <div class="<?= $erroSenha ? 'alerta-erro' : 'alerta-sucesso' ?>">
                <span>
                    <?= htmlspecialchars($mensagem, ENT_QUOTES, 'UTF-8') ?>
                </span>
            </div>
        <?php endif; ?>

        <?php if ($mensagem === "Senha alterada com sucesso!"): ?>

            <span class="material-symbols-outlined icone-esqueci" aria-hidden="true">
                check_circle
            </span>

            <h1>Senha alterada!</h1>

            <p class="descricao-esqueci">
                Sua senha foi redefinida com sucesso.
                Agora você já pode acessar sua conta KeyStyle.
            </p>

            <a href="login.php" class="btn-esqueci">
                Ir para o login
                <span class="material-symbols-outlined" aria-hidden="true">
                    arrow_forward
                </span>
            </a>

        <?php else: ?>

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

        <?php endif; ?>
    </form>
</main>