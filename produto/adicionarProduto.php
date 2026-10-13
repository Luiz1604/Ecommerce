<?php
include "../util.php";
include "../_cabecalho.php";
SaiSeHacker();
?>

<html>

<body>
    <main class="main-login">
        <div class="container-direita">
            <div class="login-card">
                <h2>Cadastro de Produto</h2>

                <form action="insertProduto.php" method="post" enctype="multipart/form-data">

                    <label for="nome">Digite o nome do produto</label>
                    <div class="input-box">
                        <span class="icon"><i class="fa-solid fa-tag"></i></span>
                        <input type="text" name="nome" id="nome" placeholder="Nome do produto" required>
                    </div>

                    <label for="descricao">Digite a descrição do produto</label>
                    <div class="input-box">
                        <span class="icon"><i class="fa-solid fa-align-left"></i></span>
                        <input type="text" name="descricao" id="descricao" placeholder="Descrição do produto" required>
                    </div>

                    <label for="valor">Digite o valor unitário do produto</label>
                    <div class="input-box">
                        <span class="icon"><i class="fa-solid fa-dollar-sign"></i></span>
                        <input type="number" min="0" step="0.01" name="valor" id="valor" placeholder="0,00" required>
                    </div>

                    <label for="arquivo">Adicione uma imagem</label>
                    <div class="input-box">
                        <span class="icon"><i class="fa-solid fa-image"></i></span>
                        <input type="text" name="arquivo" id="arquivo" placeholder="Nome do arquivo da imagem">
                    </div>

                    <button type="submit" class="btn">Adicionar</button>
                    <a href="produto.php" class="btn-voltar">voltar</a>
                </form>
            </div>
        </div>

    </main>
</body>

</html>