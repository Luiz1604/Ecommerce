<?php
    include "./util.php";
    include "./cabecalho.php";
    SaiSeHacker();

    $conn = conecta();

    $nome = $_POST["nome"];
    $descricao = $_POST["descricao"];
    $valor = $_POST["valor"];

    $varSQL = "INSERT INTO produto (nome, descricao, valor_unitario)
            VALUES (:nome, :descricao, :valor)";

    $insert = $conn->prepare($varSQL);

    $insert->bindParam(":nome", $nome);
    $insert->bindParam(":descricao", $descricao);
    $insert->bindParam(":valor", $valor);

    if($insert->execute()){
        $id = $conn->lastInsertId();

        if (isset($_FILES["arquivo"]) && 
            $_FILES['arquivo']['error'] == 0){
                $ext = pathinfo($_FILES['arquivo']['name'], PATHINFO_EXTENSION);
            }

            $caminho = "imagens/produtos/$id.$ext";

            if(move_uploaded_file($_FILES["arquivo"]["tmp_name"], $caminho)){
                $varSQL = "UPDATE produto
                        SET imagem = :imagem
                        WHERE id_produto = :id";
                        
                $updateImagem = $conn->prepare($varSQL);

                $updateImagem->bindParam(":imagem", $caminho);
                $updateImagem->bindParam(":id", $id);

                $updateImagem->execute();
            }
    }

    header("Location: produto.php");
?>