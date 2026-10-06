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
    header("Location: usuario.php");

?>