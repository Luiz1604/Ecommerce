<?php
    include "./util.php";
    SaiSeHacker();
    
    $conn = conecta();

    $qtd = $_POST["qtd"];
    $custo = $_POST["custo"];
    $obs = $_POST["obs"];
    $idProd = $_POST["idProd"];

    $varSQL = "INSERT INTO entrada (quantidade, custo_unitario, obs, fk_produto)
            VALUES (:qtd, :custo, :obs, :idProd)";

    $insert = $conn->prepare($varSQL);

    $insert->bindParam(":qtd", $qtd);
    $insert->bindParam(":custo", $custo);
    $insert->bindParam(":obs", $obs);
    $insert->bindParam(":idProd", $idProd);

    $insert->execute();

    header("Location: entrada.php");
?>