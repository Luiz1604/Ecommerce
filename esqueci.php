<?php 
    include "util.php";
    include "_cabecalho.php";

    $conn = conecta();

    $email = $_POST['email'];

    $varSQL = "SELECT email, senha
            FROM usuario
            WHERE email = :email";

    $select = $conn->prepare($varSQL);
    $select->bindParam(":email", $email);
    $select->execute();

    if($select->fetch())
        $_SESSION['emailGuardado'] = $email;
    else
        echo "email incorreto";

    
?>

<form action="esqueci.php" method="post">
    <label for="email">Digite seu endereço de email</label>
    <input type="email" name="email">

    <input type="submit">
</form>