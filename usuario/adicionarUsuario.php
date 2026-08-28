<html>
    <body>
        <form action="insertUsuario" method="post"
        enctype="multipart/form-data">
            <label for="nome">Digite seu Nome</label>
            <input type="text" name="nome" id="nome" required><br>

            <label for="email">Digite seu email</label>
            <input type="text" name="email" id="email" required><br>

            <label for="senha">Digite sua senha</label>
            <input type="text" name="senha" id="senha" required><br>

            <input type="hidden" name="admin" value="false">
            
            <label for="telefone">Digite seu telefone</label>
            <input type="text" name="telefone" id="telefone"><br>

            <label for="arquivo">Adicione uma imagem</label>
            <input type="text" name="arquivo" id="arquivo"><br>
        
            <input type="submit" value="Adicionar">
        </form>
    </body>
</html>