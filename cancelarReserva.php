<?php
    include "util.php";

    // verifica se o usuario esta conectado
    if (!isset($_SESSION['sessaoLogin'])) {
        header("Location: login.php");
        exit;
    }

    // verifica se o id da compra foi enviado
    $idCompra = $_POST['id_compra'] ?? null;

    if (filter_var($idCompra, FILTER_VALIDATE_INT, ["options" => ["min_range" => 1]]) === false) {
        header("Location: minhasReservas.php");
        exit;
    }

    $conn = conecta();

    // descobre o id do usuario conectado
    $email = $_SESSION['sessaoLogin'];

    $varSQL = "SELECT id_usuario
               FROM usuario
               WHERE email = :email";

    $select = $conn->prepare($varSQL);
    $select->bindParam(":email", $email);
    $select->execute();

    $usuario = $select->fetch(PDO::FETCH_ASSOC);

    if (!$usuario) {
        header("Location: login.php");
        exit;
    }

    $idUsuario = $usuario['id_usuario'];

    // cancela somente uma reserva do proprio usuario
    $varSQL = "UPDATE compra
               SET status = 'cancelado',
                   data = CURRENT_TIMESTAMP
               WHERE id_compra = :id_compra
                 AND fk_usuario = :id_usuario
                 AND status = 'reservado'";

    $update = $conn->prepare($varSQL);
    $update->bindParam(":id_compra", $idCompra);
    $update->bindParam(":id_usuario", $idUsuario);
    $update->execute();

    // retorna para a pagina de reservas
    header("Location: minhasReservas.php");
    exit;
?>