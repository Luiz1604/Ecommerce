<?php
include "util.php";
include "_cabecalho.php";

$erroLogin = false;



if (isset($_SESSION['sessaoConectado']) && $_SESSION['sessaoConectado'] == true)
    header("Location: index.php");

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

        header("Location: index.php");

        DefineCookie('email', $_SESSION['sessaoLogin'], 1440);
        exit;
    } else {
        /*echo "Verifique se a senha está correta ou se
                você já está cadastrado";*/
        $erroLogin = true;
    }
}

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
                        <input type="text" id="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" name="email" placeholder="Digite seu e-mail" required autocomplete="username">
                    </div>

                    <label for="senha">Senha</label>
                    <div class="input-box">
                        <span class="icon"><i class="fa-solid fa-lock"></i></span>
                        <input type="password" id="senha" name="senha" placeholder="Digite sua senha" required autocomplete="current-password">
                    </div>

                    <div class="options">
                        <label>
                            <input type="checkbox"> Lembrar-me
                        </label>
                        <a href="" class="link"> Esqueceu a senha? </a>
                    </div>

                    <button class="btn"> Entrar </button>
                    <br>
                    <hr class="hr-login">

                    <p class="link-p">
                        <a href="usuario/adicionarUsuario.php" class="link"> Não tem uma conta</a>
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