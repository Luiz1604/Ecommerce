<?php
    include "./util.php";
    include "./cabecalho.php";
    SaiSeHacker();
?>

<html>

<body>
    <form action="insertUsuario.php" method="post" enctype="multipart/form-data">
        <label for="nome">Digite o nome do produto</label>
        <input type="text" name="nome" id="nome" required><br>

        <label for="descricao">Digite a descrição do produto</label>
        <input type="text" name="descricao" id="descricao" required><br>

        <label for="valor">Digite o valor unitário do produto</label>
        <input type="number" min="0" step="0.01" name="valor" id="valor" required><br>

        <label for="arquivo">Adicione uma imagem</label>
        <input type="text" name="arquivo" id="arquivo"><br>

        <input type="submit" value="Adicionar">
    </form>
</body>

</html>