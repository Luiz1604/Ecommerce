<?php 
    include "util.php";
    include "_cabecalho.php";

    $conn = conecta();

    if(isset($_POST['email'])){

    $email = $_POST['email'];

    $varSQL = "SELECT email, senha
            FROM usuario
            WHERE email = :email";

    $select = $conn->prepare($varSQL);
    $select->bindParam(":email", $email);
    $select->execute();

    if($linha = $select->fetch()){
        $_SESSION['emailGuardado'] = $email;
        $senha = $linha['senha'];
        $mensagem = '<a href=eq.projetoscti.com.br'.home("redefinir.php?senha=$senha").'>Clique aqui para redefinir sua senha</a>';
        EnviaEmail($email, "redefinição de senha", $mensagem);
    }
    else{
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
        <div class="campo-esqueci">
            <label for="email">Endereço de e-mail</label>
            <input
                type="email"
                name="email"
                id="email"
                placeholder="seuemail@exemplo.com"
                autocomplete="email"
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

