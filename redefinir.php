<?php
    include "util.php";

    $conn = conecta();
    $email = $_SESSION['emailGuardado'];
    $senhaEnviada = $_GET['senha'];

    $varSQL = "SELECT senha 
            FROM usuario
            WHERE email = :email";

    $select = $conn -> prepare($varSQL);
    $select->bindParam(":email", $email);
    $select->execute();
    $linha = $select->fetch();

    if($senhaEnviada === $linha['senha']){
        $senhaNova = $_POST['senha'];
        $alter = "UPDATE usuario
                SET senha = :senha
                WHERE email = :email";

        $alter = $conn->prepare();
        $alter->bindParam(":email", $email);
        $alter->bindParam(":senha", $senhaNova);
        $alter->execute();

        echo"O procedimento foi bem sucedido";
    } else {
        echo "houve algum erro no caminho, tente novamente";
    }
?>

<form action="redefinir.php" method="POST">
    <label for="senha">Confirme sua nova senha</label>
    <input type="text" name="senha" id="senha">

    <input type="submit">
</form>