<?php 
    include "util.php";
    include "_cabecalho.php";

    $conn = conecta();

    if(isset($_POST['email'])){

    $email = $_POST['email'];

    $varSQL = "SELECT email, senha
            FROM usuario
            WHERE email = :email";

    $select = $conn->prepare($varSQL);
    $select->bindParam(":email", $email);
    $select->execute();

    if($linha = $select->fetch()){
        $_SESSION['emailGuardado'] = $email;
        $senha = $linha['senha'];
        $mensagem = '<a href='.home("redefinir.php?senha=$senha").'></a>';
        EnviaEmail($email, "redefinição de senha", $mensagem);
    }
    else{
        echo "email incorreto";
    }
    }


    
?>

<form action="esqueci.php" method="post">
    <label for="email">Digite seu endereço de email</label>
    <input type="email" name="email">

    <input type="submit">
</form>

