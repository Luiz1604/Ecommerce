<?php
include "../util.php";
if (isset($_SESSION['sessaoConectado']) && $_SESSION['sessaoConectado' ]== true){
    header("Location: ../index.php");
    exit;
}
$conn = conecta();

$nome = $_POST["nome"];
$email = $_POST["email"];
$senha = $_POST["senha"];
$confirma_senha = $_POST['confirma_senha'];
$telefone = $_POST["telefone"];

/*if ($senha !== $confirma_senha) {
        header("Location: cadastro.php?erro=senhas_diferentes");
        exit;
    }*/

$origem = isset($_POST['origem']) ? $_POST['origem'] : 'cadastro';

if ($senha !== $confirma_senha) {
    if ($origem === 'login') {
        header("Location: ../login.php?erro=senhas_diferentes");
    } else {
        header("Location: adicionarUsuario.php?erro=senhas_diferentes");
    }
    exit;
}

$senhaCripto = password_hash($senha, PASSWORD_DEFAULT);

$varSQL = "INSERT INTO usuario (nome, email, senha, telefone)
            VALUES (:nome, :email, :senha, :telefone)";

$insert = $conn->prepare($varSQL);

$insert->bindParam(":nome", $nome);
$insert->bindParam(":email", $email);
$insert->bindParam(":senha", $senhaCripto);
$insert->bindParam(":telefone", $telefone);

$foto = null;

/*verificação de e-mail igual no banco de dados (IMPORTANTE ESSA VERIFICAÇÃO)*/

try {
    $insert->execute();
} catch (PDOException $e) {
    // Pega o código SQLSTATE direto do objeto do erro (funciona em qualquer ambiente PostgreSQL)
    $sqlState = $e->errorInfo[0] ?? $e->getCode();
    
    // 23505 = Unique Violation (E-mail já existente no banco)
    if ($sqlState == '23505' || (isset($e->errorInfo[1]) && $e->errorInfo[1] == 23505)) {
        header("Location: adicionarUsuario.php?erro=email_cadastrado");
        exit;
    } else {
        // Se for outro erro de banco (ex: servidor fora do ar, falta de memória), lança o erro
        throw $e;
    }
}

/* Se a inserção funcionou, continua com o upload da imagem*/
$id = $conn->lastInsertId();

if (isset($_FILES["arquivo"]) && $_FILES['arquivo']['error'] == 0) {
    $ext = pathinfo($_FILES['arquivo']['name'], PATHINFO_EXTENSION);
    $caminho = "../imagens/usuarios/$id.$ext";

    if (move_uploaded_file($_FILES["arquivo"]["tmp_name"], $caminho)) {
        $varSQL = "UPDATE usuario
                    SET imagem = :imagem
                    WHERE id_usuario = :id";

        $updateImagem = $conn->prepare($varSQL);
        $updateImagem->bindParam(":imagem", $caminho);
        $updateImagem->bindParam(":id", $id);
        $updateImagem->execute();

        $foto = $caminho;
    }
}

$admin = false;

if (ValidaLogin($email, $senha, $nome, $foto, $admin)) {
    $_SESSION['sessaoConectado'] = true;
    $_SESSION['sessaoLogin'] = $email;
    $_SESSION['sessaoNome'] = $nome;
    $_SESSION['sessaoFoto'] = $foto;
    $_SESSION['sessaoAdmin'] = $admin;

    header("Location: index.php");

    DefineCookie('email', $_SESSION['sessaoLogin'], 1440);
}

header("Location: usuario.php");
