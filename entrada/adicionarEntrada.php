<?php
    include "../util.php";
    include "../_cabecalho.php";

    SaiSeHacker();
?>

<html>

<body>
    <div class="container-form">
        <form action="insertEntrada.php" method="post" enctype="multipart/form-data" class="form-usuario">

            <div class="form-grupo">
                <label for="qtd" class="form-label">Insira a quantidade</label>
                <input type="number" min="0" step="1" name="qtd" id="qtd" class="form-input" required>
            </div>

            <div class="form-grupo">
                <label for="custo" class="form-label">Digite o custo unitário</label>
                <input type="number" min="0" step="0.01" name="custo" id="custo" class="form-input" required>
            </div>

            <div class="form-grupo">
                <label for="obs" class="form-label">Observação</label>
                <input type="text" name="obs" id="obs" class="form-input">
            </div>

            <div class="form-grupo">
                <label for="idProd" class="form-label">Digite o ID do Produto</label>
                <input type="number" min="0" step="1" name="idProd" id="idProd" class="form-input" required>
            </div>

            <div class="form-grupo">
                <input type="submit" value="Adicionar" class="btn-submit">
            </div>

            <a href="entrada.php" class="btn-voltar">Voltar</a>

        </form>
    </div>
</body>

</html>