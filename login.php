<?php
include "util.php";
include "_cabecalho.php";

if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $nome = "";
    $foto = "";
    $admin = "";

    if (ValidaLogin($email, $senha, $nome, $foto, $admin)) {
        $_SESSION['sessaoConectado'] = true;
        $_SESSION['sessaoLogin'] = $email;
        $_SESSION['sessaoNome'] = $nome;
        $_SESSION['sessaoFoto'] = $foto;
        $_SESSION['sessaoAdmin'] = $admin;

        DefineCookie('email', $_SESSION['sessaoLogin'], 1440);
    } else {
        echo "Verifique se a senha está correta ou se
                você já está cadastrado";
    }
}
?>

<body>


    <!--Cadastro-->
    <main class="main-login">
        <div class="esquerda-login">
            <h1>Entre e encontre a coleção certa<br>para completar o seu estilo.</h1>
            <img src="login-animate.svg" class="esquerda-login-image" alt="login animação">
        </div>

        <div class="direita-login">
            <div class="card-login">
                <h2>Login</h2>

                <form action="login.php" method="POST">
                    <div class="textfield">
                        <label for="email">E-mail ou Usuário</label>
                        <input type="text" id="email" name="email" placeholder="Digite seu e-mail" required autocomplete="username">
                    </div>

                    <div class="textfield">
                        <label for="senha">Senha</label>
                        <input type="password" id="senha" name="senha" placeholder="Digite sua senha" required autocomplete="current-password">
                    </div>

                    <button type="submit" class="btn-login">Entrar</button>
                </form>
            </div>
        </div>
    </main>

    <?php
        include "_rodape.php";
    ?>
</body>

</html>