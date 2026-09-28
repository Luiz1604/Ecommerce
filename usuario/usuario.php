<html>

<body>
    <?php


    include "../util.php";
    include "../_cabecalho.php";
    SaiSeHacker();

    $conn = conecta();

    $varSQL = "SELECT * 
                FROM usuario 
                WHERE excluido = FALSE
                ORDER BY nome";

    $select = $conn->prepare($varSQL);
    $select->execute();
    ?>

   
    <div class="container-tabela">
        <table class="tabela-usuarios">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Telefone</th>
                    <th>Admin</th>
                    <th>Imagem</th>
                    <th>Ações</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
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
                        
                        <td class="coluna-imagem">
                            <?php
                            if (!empty($imagem) && file_exists($imagem))
                                
                                echo "<img src='$imagem' class='img-usuario'>";
                            else
                                echo "Não há imagem";

                            ?>
                        </td>
                        
                        <td><a href='alterarUsuario.php?id=<?= $id ?>' class="btn-acao btn-alterar">Alterar</a></td>
                        
                        <td><a href='excluirUsuario.php?id=<?= $id ?>' class="btn-acao btn-excluir">Excluir</a></td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>

        <div class="container-botao">
            <a href="adicionarUsuario.php" class="btn-adicionar">Adicionar Usuário</a>
        </div>
        <a href="../index.php" class="btn-voltar">voltar</a>
    </div>

</body>

</html>