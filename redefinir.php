<?php
    include "util.php";

    $conn = conecta();
    $email = $_SESSION['emailGuardado'];
    $senhaEnviada = $_GET['senha'];

    $varSQL = "SELECT senha 
            FROM usuario
            WHERE email = :email";

    $select = $conn -> prepare($varSQL);
    $select->bindParam(":email", $email);
    $select->execute();
    $linha = $select->fetch();

    if($senhaEnviada === $linha['senha']){
        $senhaNova = $_POST['senha'];
        $senhaNovaCripto = password_hash($senhaNova, PASSWORD_DEFAULT);
        $alter = "UPDATE usuario
                SET senha = :senha
                WHERE email = :email";

        $select = $conn->prepare($alter);
        $select->bindParam(":email", $email);
        $select->bindParam(":senha", $senhaNova);
        $select->execute();

        echo"O procedimento foi bem sucedido";
    } else {
        echo "houve algum erro no caminho, tente novamente";
    }
?>

<main class="pagina-esqueci">
    <form class="form-esqueci" action="redefinir.php" method="POST">
        <span class="material-symbols-outlined icone-esqueci"
              aria-hidden="true">lock_reset</span>
        <h1>Redefinir senha</h1>
        <p class="descricao-esqueci">
            Crie uma nova senha para voltar a acessar sua conta KeyStyle.
        </p>
        <div class="campo-esqueci">
            <label for="senha">Nova senha</label>

            <input
                type="password"
                name="senha"
                id="senha"
                placeholder="Digite sua nova senha"
                autocomplete="new-password"
                required
            >
        </div>
        <button type="submit" class="btn-esqueci">
            Redefinir senha

            <span class="material-symbols-outlined"
                  aria-hidden="true">arrow_forward</span>
        </button>

        <a href="login.php" class="voltar-login">
            Voltar para o login
        </a>
    </form>
</main>