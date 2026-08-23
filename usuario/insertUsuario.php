<?php
    include "./util.php";

    $conn = conecta();

    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $senha = $_POST["senha"];
    $telefone = $_POST["telefone"];

    $varSQL = "INSERT INTO usuario (nome, email, senha, telefone)
            VALUES (:nome, :email, :senha, :telefone)";

    $insert = $conn->prepare($varSQL);

    $insert->bindParam(":nome", $nome);
    $insert->bindParam(":email", $email);
    $insert->bindParam(":senha", $senha);
    $insert->bindParam(":telefone", $telefone);

    if($insert->execute()){
        $id = $conn->lastInsertId();

        if (isset($_FILES["arquivo"]) && 
            $_FILES['arquivo']['error'] == 0){
                $ext = pathinfo($_FILES['arquivo']['name'], PATHINFO_EXTENSION);
            }

            $caminho = "imagens/usuarios/$id.$ext";

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

    header("Location: usuario.php");
?>