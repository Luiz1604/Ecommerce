<?php 
    include "util.php";
    include "_cabecalho.php";
    
    if (isset($_POST['email'])){
        $email = $_POST['email'];
        $senha = $_POST['senha'];

        $nome = "";
        $foto = "";
        $admin = "";

        if(ValidaLogin($email, $senha, $nome, $foto, $admin)){
            $_SESSION['sessionConectado'] = TRUE;
            $_SESSION['sessionEmail'] = $email; 
            $_SESSION['sessionNome'] = $nome;
            $_SESSION['sessionFoto'] = $foto;
            $_SESSION['sessaoAdmin'] = $admin;
            DefineCookie('email', $_SESSION['sessionEmail'], 1440);
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
                
                <div class="textfield">
                    <label for="email">E-mail ou Usuário</label>
                    <input type="text" id="email" name="email" placeholder="Digite seu e-mail">
                </div>

                <div class="textfield">
                    <label for="senha">Senha</label>
                    <input type="password" id="senha" name="senha" placeholder="Digite sua senha">
                </div>

                <button class="btn-login">Entrar</button>
            </div>
        </div>
    </main>

</body>
</html>