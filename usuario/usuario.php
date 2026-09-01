<html>

<body>
    <?php
    include "./util.php";

    $conn = conecta();

    $varSQL = "SELECT * 
                FROM usuario 
                WHERE excluido = FALSE
                ORDER BY nome";

    $select = $conn->prepare($varSQL);
    $select->execute();
    ?>

    <table>
        <tr>
            <td>ID</td>
            <td>Nome</td>
            <td>Email</td>
            <td>Senha</td>
            <td>Telefone</td>
            <td>Admin</td>
            <td>Imagem</td>
            <td></td>
            <td></td>

        </tr>

    <?php
    while($linha = $select->fetch()){
        $id = $linha['id_usuario'];
        $nome = $linha['nome'];
        $email = $linha['email'];
        $telefone = $linha['telefone'];
        $admin = $linha['admin'];
        $imagem = $linha['imagem'];

        echo "<tr>
        <td>$id</td>
        <td>$nome</td>
        <td>$email</td>
        <td>$telefone</td>
        <td>".($admin ? "Sim" : "Não") ."</td><td>";

        if(!empty($imagem) && file_exists($imagem))
            echo "<img src='$imagem'>";
        else
            echo "Não há imagem";

        echo "</td>
            <td><a href='alterarUsuario.php?id=$id'>Alterar</a></td>
            <td><a href='excuirUsuario.php?id=$id'>Excluir</a></td>
            </tr>";
    }
    ?>
    </table>

</body>

</html>