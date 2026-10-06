<?php

include "util.php";
include "_cabecalho.php";

if (!isset($_SESSION['sessaoConectado']) || $_SESSION['sessaoConectado'] !== true) {
    header("Location: login.php");
    exit;
}

$nome     = $_SESSION['sessaoNome'] ?? "";
$telefone = $_SESSION['sessaoTel'] ?? "";
$foto     = !empty($_SESSION['sessaoFoto']) ? $_SESSION['sessaoFoto'] : "imagens/default-avatar.png";

if (isset($_POST['nome'])){
    $conn = conecta();

    $email = $_SESSION['sessaoLogin'];
    $nome = $_POST['nome'];
    $telefone = $_POST['telefone'];

    $varSQL = "UPDATE usuario
        SET nome = :nome,
        telefone = :telefone
        WHERE email = :email";
        
    $update = $conn->prepare($varSQL);

    $update->bindParam(":nome", $nome);
    $update->bindParam(":telefone", $telefone);
    $update->bindParam(":email", $email);

    if ($update->execute()) {
        if(isset($_FILES['arquivo']) &&
         $_FILES['arquivo']['error'] == 0 ) {

         $caminho = salvaUploadUsuarios($_FILES, "arquivo");

         if ($caminho != ""){
            $varSQL = "UPDATE usuario
                        SET imagem = :imagem
                        WHERE email = :email";

                $updateImagem = $conn->prepare($varSQL);

                $updateImagem->bindParam(":imagem", $caminho);
                $updateImagem->bindParam(":email", $email);

                $updateImagem->execute();

                $_SESSION['sessaoFoto'] = $caminho;
         }
        } 
    }

    $_SESSION['sessaoNome'] = $nome;
    $_SESSION['sessaoTel'] = $telefone;
    
    header("Location: index.php");
}
?>

<body>
    <div class="caixa-conteudo">
        <div class="cartao-edicao">
            <div class="cabecalho-edicao">
                <h2><i class="fa-solid fa-user-pen"></i> Editar Perfil <i class="fa-solid fa-user-pen"></i></h2>
                <p class="subtitulo-edicao">Aqui você pode alterar as suas informações pessoais</p>
            </div>

            <form action="editarPerfil.php" method="POST" enctype="multipart/form-data">
                <div class="previa-foto">
                    <img id="imagemPrevia" src="<?= $foto ?>" alt="Foto de perfil">
                </div>

                <div class="campo-formulario campo-upload-foto">
                    <label for="arquivo" class="botao-upload-foto">
                        <i class="fa-solid fa-camera"></i>
                        <span>Mudar foto de perfil</span>
                    </label>
                    <input type="file" name="arquivo" id="arquivo" accept="image/*" onchange="atualizarPreviaFoto(this)">
                </div>

                <div class="campo-formulario">
                    <label for="nome"><i class="fa-regular fa-id-card"></i> Nome</label>
                    <input type="text" name="nome" id="nome" value="<?= htmlspecialchars($nome) ?>" required>
                </div>

                <div class="campo-formulario">
                    <label for="telefone"><i class="fa-solid fa-phone"></i> Telefone</label>
                    <input type="text" name="telefone" id="telefone"  oninput="mascaraTelefone(this)" maxlength="15" value="<?=$telefone ?>">
                </div>

                <div class="grupo-botoes">
                    <a href="minhaConta.php" class="botao-cancelar">
                        <i class="fa-solid fa-arrow-left"></i> Cancelar
                    </a>
                    <button type="submit" class="botao-salvar">
                       <i class="fa-solid fa-check"></i> Salvar alterações
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
<?php
include "_rodape.php";
?>