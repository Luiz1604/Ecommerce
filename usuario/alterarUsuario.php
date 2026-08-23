<html>

<body>
    <?php

    include "./util.php";

    $conn = conecta();

    $id = $_GET["id"];

    $varSQL = "SELECT *
                    FROM usuario
                    WHERE id_usuario = :id";

    $select = $conn->prepare($varSQL);
    $select->bindParam(":id", $id);
    $select->execute();

    $linha = $select->fetch();

    $id = $linha['id_usuario'];
    $nome = $linha['nome'];
    $email = $linha['email'];
    $telefone = $linha['telefone'];
    $admin = $linha['admin'];
    $imagem = $linha['imagem'];

    ?>

    <form action="updateUsuario.php" method="post" enctype="multipart/form-data">
    
    <input type="hidden" name="id" value="<?=$id ?>">

    <label for="nome">Nome</label>
    <input type="text" name="nome" id="nome" value="<?=$nome ?>"><br>

    <label for="email">Email</label>
    <input type="text" name="email" id="email" value="<?=$email ?>"><br>

    <label for="telefone">Telefone</label>
    <input type="text" name="telefone" id="telefone" value="<?=$telefone ?>"><br>

    <label for="admin">Administrador</label>
    <input type="text" name="admin" id="admin" value="true" <?=$admin ? 'checked' : '' ?>><br>

    <?php
    
        if(!empty($imagem) && file_exists($imagem))
            echo "<img src='$imagem' alt=''><br>";

    ?>

    <label for="arquivo">Imagem</label>
    <input type="file" name="arquivo"><br>

    <input type="submit" value="Alterar">

    </form>
</body>

</html>