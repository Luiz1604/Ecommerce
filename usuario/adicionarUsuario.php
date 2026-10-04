<?php
// Recua uma pasta para encontrar os arquivos de inclusão // verigicar dps
include "../util.php";
include "../_cabecalho.php";
if (isset($_SESSION['sessaoConectado']) && $_SESSION['sessaoConectado'] == true)
    header("Location: ../index.php");

$erroSenha = false;
$erro = $_GET['erro'] ?? false;
if (isset($_GET['erro']) && $_GET['erro'] == 'senhas_diferentes') {
    $erroSenha = true;
}
?>

<body>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <main class="main-login">
        <div class="container-direita">
            <div class="login-card">
                <h2>Cadastro</h2>

                <form action="insertUsuario.php" method="post" enctype="multipart/form-data" class="form-login <?= $erroSenha ? 'login-erro' : '' ?>">

                <input type="hidden" name="origem" value="cadastro">

                    <?php if ($erroSenha): ?>
                        <div class="alerta-erro">
                            <span class="material-symbols-outlined">error</span>
                            <span>As senhas digitadas não coincidem. Tente novamente.</span>
                        </div>
                    

                    <?php elseif ($erro === 'email_cadastrado'): ?>
                        <div class="alerta-erro">
                            <span class="material-symbols-outlined">error</span>
                            <span>Este e-mail já está cadastrado. Tente fazer login.</span>
                        </div>
                    <?php endif; ?>

                    <!-- Campo de foto -->
                    <div class="avatar-upload">
                        <div class="avatar-preview">
                            <img id="imagePreview"
                                src="https://cdn-icons-png.flaticon.com/512/149/149071.png"
                                alt="Foto de Perfil">
                        </div>
                        <label for="foto" class="btn-upload">
                            <i class="fa-solid fa-camera"></i>
                        </label>

                        <!--alterado foto-->
                        <input type="file"
                            id="foto"
                            name="arquivo"
                            accept="image/*"
                            onchange="previewImagem(event)">


                    </div>
                    <small class="imagem-opcional">
                        Foto opcional (sinta-se à vontade para enviar)
                    </small>

                    <label for="nome">Digite seu Nome</label>
                    <div class="input-box">
                        <span class="icon"><i class="fa-solid fa-user"></i></span>
                        <input type="text" name="nome" id="nome" placeholder="Seu nome" required>
                    </div>

                    <label for="email">Digite seu e-mail</label>
                    <div class="input-box">
                        <span class="icon"><i class="fa-solid fa-envelope"></i></span>
                        <input type="email" name="email" id="email" placeholder="seuemail@exemplo.com" oninput="mascaraEmail(this)" required>
                    </div>

                    <label for="senha">Digite sua senha</label>
                    <div class="input-box">
                        <span class="icon"><i class="fa-solid fa-lock"></i></span>
                        <input type="password" name="senha" id="senha" placeholder="Sua senha" required>
                    </div>

                    <label for="confirma_senha">Confirme sua senha</label>
                    <div class="input-box">
                        <span class="icon"><i class="fa-solid fa-lock"></i></span>
                        <input type="password" name="confirma_senha" id="confirma_senha" placeholder="Repita a senha" required>
                    </div>

                    <input type="hidden" name="admin" value="false">

                    <label for="telefone">Digite seu telefone (opcional)</label>
                    <div class="input-box">
                        <span class="icon"><i class="fa-solid fa-phone"></i></span>
                        <input type="tel" name="telefone" id="telefone" placeholder="(00) 00000-0000" oninput="mascaraTelefone(this)" maxlength="15">
                    </div>

                    <button type="submit" class="btn">Cadastrar</button>

                    <p class="link-p-usuario">
                        Já tem uma conta? <a href="../login.php" class="link">Entrar</a>
                    </p>

                </form>
            </div>
        </div>
    </main>


    <?php
    include "../_rodape.php";
    ?>
</body>

</html>