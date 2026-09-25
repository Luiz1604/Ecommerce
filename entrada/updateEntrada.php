<?php
    include "../util.php";
    $conn = conecta();

    $id = $_POST["id"];
    $qtd = $_POST["qtd"];
    $custo = $_POST["custo"];
    $obs = $_POST["obs"];
    $idProd = $_POST["idProd"];

    $varSQL = "UPDATE entrada
            SET quantidade = :qtd,
            custo_unitario = :custo,
            obs = :obs,
            fk_produto = :idProd
            WHERE id_entrada = :id";
            
    $update = $conn->prepare($varSQL);

    $update->bindParam(":qtd", $qtd);
    $update->bindParam(":custo", $custo);
    $update->bindParam(":obs", $obs);
    $update->bindParam(":idProd", $idProd);

    $update->execute();

    header("Location: entrada.php");
?>