<?php

    include "../util.php";
    SaiSeHacker();

    $conn = conecta();

    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $admin = $_POST['admin'];

    $varSQL = "UPDATE usuario
        SET nome = :nome,
        email = :email,
        telefone = :telefone,
        admin = :admin
        WHERE id_usuario = :id";
        
    $update = $conn->prepare($varSQL);

    $update->bindParam(":nome", $nome);
    $update->bindParam(":email", $email);
    $update->bindParam(":telefone", $telefone);
    $update->bindParam(":admin", $admin);
    $update->bindParam(":id", $id);

    if ($update->execute()) {
        if(isset($_FILES['arquivo']) &&
         $_FILES['arquivo']['error'] == 0 ) {

         $ext = pathinfo($_FILES["arquivo"]["name"], PATHINFO_EXTENSION);

         $caminho = "imagens/usuarios/$id.$ext";

         if(move_uploaded_file(
            $_FILES['arquivo']['tmp_name'],$caminho
            ))
            {
                $varSQL = "UPDATE usuario
                        SET imagem = :imagem
                        WHERE id_usuario = :id";

                $updateImagem = $conn->prepare($varSQL);

                $updateImagem->bindParam(":imagem", $caminho);
                $updateImagem->bindParam(":id", $id);

                $updateImagem->execute();
            }
        }   
    }
    
    header("Location: usuario.php")

?>