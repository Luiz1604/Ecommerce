<html>
    <body>
        <form action="insertEntrada" method="post"
        enctype="multipart/form-data">
            <label for="qtd">Insira a quantidade:</label><br>
            <input type="number" min="0" step="1" name="qtd" id="qtd">

            <label for="email">Digite seu email</label><br>
            <input type="text" name="email" id="email">

            <label for="senha">Digite sua senha</label><br>
            <input type="text" name="senha" id="senha">

            <label for="telefone">Digite seu telefone</label><br>
            <input type="text" name="telefone" id="telefone">
        
            <input type="submit" value="Adicionar">
        </form>
    </body>
</html>