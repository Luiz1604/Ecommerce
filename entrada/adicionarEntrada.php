<?php
    include "../util.php";
?>
<html>

<body>
    <form action="insertEntrada.php" method="post" enctype="multipart/form-data">
        <label for="qtd">Insira a quantidade:</label>
        <input type="number" min="0" step="1" name="qtd" id="qtd" required><br>

        <label for="custo">Digite o custo unitário</label>
        <input type="number" min="0" step="0.01" name="custo" id="custo" required><br>

        <label for="obs">Observação</label>
        <input type="text" name="obs" id="obs"><br>

        <label for="idProd">Digite o id do Produto</label>
        <input type="number" min="0" step="1" name="idProd" id="idProd" required><br>

        <input type="submit" value="Adicionar">
    </form>
</body>

</html>