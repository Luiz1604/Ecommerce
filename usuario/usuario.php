<html>

<body>
    <?php


    include "../util.php";

    $conn = conecta();

    $varSQL = "SELECT * 
                FROM usuario 
                WHERE excluido = FALSE
                ORDER BY nome";

    $select = $conn->prepare($varSQL);
    $select->execute();
    ?>

    <table border="1">
        <tr>
            <td>ID</td>
            <td>Nome</td>
            <td>Email</td>
            <td>Telefone</td>
            <td>Admin</td>
            <td>Imagem</td>
            <td></td>
            <td></td>

        </tr>

        <?php
        while ($linha = $select->fetch()) {
            $id = $linha['id_usuario'];
            $nome = $linha['nome'];
            $email = $linha['email'];
            $telefone = $linha['telefone'];
            $admin = $linha['admin'];
            $imagem = $linha['imagem'];
            ?>
            <tr>
                <td><?= $id ?></td>
                <td><?= $nome ?></td>
                <td><?= $email ?></td>
                <td><?= $telefone ?></td>
                <td><?= ($admin ? "Sim" : "Não") ?></td>
                <td>
                    <?php
                    if (!empty($imagem) && file_exists($imagem))
                        echo "<img src='$imagem'>";
                    else
                        echo "Não há imagem";
        
        ?>
            </td>
            <td><a href='alterarUsuario.php?id=<?=$id?>'>Alterar</a></td>
            <td><a href='excluirUsuario.php?id=<?=$id?>'>Excluir</a></td>
        </tr>
        <?php
            }
        ?>
        <button><a href="adicionarUsuario.php">Adicionar</a></button>
    </table>

</body>

</html>