<?php
    include "../util.php";
    if($_SESSION['sessaoConectado'])
        header ("Location: ../index.php");

    $conn = conecta();

    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $senha = $_POST["senha"];
    $telefone = $_POST["telefone"];

    $senhaCripto = password_hash($senha, PASSWORD_DEFAULT);

    $varSQL = "INSERT INTO usuario (nome, email, senha, telefone)
            VALUES (:nome, :email, :senha, :telefone)";

    $insert = $conn->prepare($varSQL);

    $insert->bindParam(":nome", $nome);
    $insert->bindParam(":email", $email);
    $insert->bindParam(":senha", $senhaCripto);
    $insert->bindParam(":telefone", $telefone);

    if($insert->execute()){
        $id = $conn->lastInsertId();

        if (isset($_FILES["arquivo"]) && 
            $_FILES['arquivo']['error'] == 0){
                $ext = pathinfo($_FILES['arquivo']['name'], PATHINFO_EXTENSION);
            }

            $caminho = "../imagens/usuarios/$id.$ext";

            if(move_uploaded_file($_FILES["arquivo"]["tmp_name"], $caminho)){
                $varSQL = "UPDATE usuario
                        SET imagem = :imagem
                        WHERE id_usuario = :id";
                        
                $updateImagem = $conn->prepare($varSQL);

                $updateImagem->bindParam(":imagem", $caminho);
                $updateImagem->bindParam(":id", $id);

                $updateImagem->execute();
            }
    }

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
?>