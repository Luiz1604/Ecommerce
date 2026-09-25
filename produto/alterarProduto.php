<html>

<body>
    <?php

    include "../util.php";
    SaiSeHacker();

    $conn = conecta();

    $id = (int) $_GET["id"];

    $varSQL = "SELECT *
                FROM produto
                WHERE id_produto = :id";

    $select = $conn->prepare($varSQL);
    $select->bindParam(":id", $id);
    $select->execute();

    $linha = $select->fetch();

    $id = $linha["id_produto"];
    $nome = $linha["nome"];
    $descricao = $linha["descricao"];
    $valor = $linha["valor_unitario"];
    $imagem = $linha["imagem"];

    ?>

    <form action="updateProduto.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?=$id?>">
    
        <label for="nome">Nome</label>
        <input type="text" name="nome" id="nome" value="<?=$nome?>" required><br><br>

        <label for="descricao">Descrição</label>
        <input type="text" name="descricao" id="descricao" value="<?=$descricao?>" required><br><br>

        <label for="valor">Valor unitário</label>
        <input type="number" min="0" step="0.01" name="valor" id="valor" value="<?=$valor?>" required><br><br>

        <?php
    
        if(!empty($imagem) && file_exists($imagem))
            echo "<img src='$imagem' alt=''><br>";

        ?>

        <label for="arquivo">Adicione uma imagem</label>
        <input type="text" name="arquivo" id="arquivo"><br><br>

        <input type="submit" value="Alterar">
    </form>
</body>

</html>