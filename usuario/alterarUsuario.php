<html>

<body>
    <?php

    include "../util.php";
    include "../_cabecalho.php";

    SaiSeHacker();

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

    <div class="container-form">
        <form action="updateUsuarioDev.php" method="post" enctype="multipart/form-data" class="form-usuario">

            <input type="hidden" name="id" value="<?= $id ?>">

            <div class="form-grupo">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" name="nome" id="nome" value="<?= $nome ?>" class="form-input">
            </div>

            <div class="form-grupo">
                <label for="email" class="form-label">Email</label>
                <input type="text" name="email" id="email" value="<?= $email ?>" class="form-input">
            </div>

            <div class="form-grupo">
                <label for="telefone" class="form-label">Telefone</label>
                <input type="tel" name="telefone" id="telefone" value="<?= $telefone ?>" class="form-input">
            </div>

            <div class="form-grupo">
                <label class="form-label">Administrador</label>
                <div class="radio-grupo">
                    <label for="admin_sim" class="radio-label">
                        <input type="radio" name="admin" id="admin_sim" value="true" <?= $admin ? 'checked' : '' ?>>
                        <span>Sim</span>
                    </label>

                    <label for="admin_nao" class="radio-label">
                        <input type="radio" name="admin" id="admin_nao" value="false" <?= $admin ? '' : 'checked' ?>>
                        <span>Não</span>
                    </label>
                </div>
            </div>

            <div class="form-grupo">
                <label for="arquivo" class="form-label">Imagem de Perfil</label>

                <?php if (!empty($imagem) && file_exists($imagem)): ?>
                    <div class="preview-imagem">
                        <img src="<?= $imagem ?>" alt="Foto de <?= $nome ?>" class="img-preview">
                    </div>
                <?php endif; ?>

                <input type="file" name="arquivo" id="arquivo" class="form-file">
            </div>

            <div class="form-grupo">
                <input type="submit" value="Salvar Alterações" class="btn-submit">

            </div>
            <a href="usuario.php" class="btn-voltar">voltar</a>
        </form>
    </div>
</body>

</html>