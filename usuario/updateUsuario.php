<?php

    include "../util.php";

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

?>