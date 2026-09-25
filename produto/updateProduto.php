<?php
    include "./util.php";
    SaiSeHacker();

    $conn = conecta();

    $id = $_POST["id"];
    $nome = $_POST["nome"];
    $descricao = $_POST["descricao"];
    $valor = $_POST["valor"];

    $varSQL = "UPDATE produto
        SET nome = :nome,
        descricao = :descricao,
        valor_unitario = :valor
        WHERE id_produto = :id";

    $update = $conn->prepare($varSQL);

    $update->bindParam(":nome", $nome);
    $update->bindParam(":descricao", $descricao);
    $update->bindParam(":valor", $valor);
    $update->bindParam(":id", $id);

    if ($update->execute()) {
        if(isset($_FILES['arquivo']) &&
         $_FILES['arquivo']['error'] == 0 ) {

         $ext = pathinfo($_FILES["arquivo"]["name"], PATHINFO_EXTENSION);

         $caminho = "imagens/produtos/$id.$ext";

         if(move_uploaded_file(
            $_FILES['arquivo']['tmp_name'],$caminho
            ))
            {
                $varSQL = "UPDATE produto
                        SET imagem = :imagem
                        WHERE id_produto = :id";

                $updateImagem = $conn->prepare($varSQL);

                $updateImagem->bindParam(":imagem", $caminho);
                $updateImagem->bindParam(":id", $id);

                $updateImagem->execute();
            }
        }   
    }

    header("Location: produto.php");

?>