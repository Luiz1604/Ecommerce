<?php

include "util.php";
include "_cabecalho.php";

if (!isset($_SESSION['sessaoConectado']) || $_SESSION['sessaoConectado'] !== true) {
    header("Location: login.php");
    exit;
}

$conn = conecta();
$emailSessao = $_SESSION['sessaoLogin'] ?? '';

// Procura os dados atualizados do utilizador na base de dados
$varSQL = "SELECT id_usuario, nome, email, telefone, imagem, admin FROM usuario WHERE email = :email";
$stmt = $conn->prepare($varSQL);
$stmt->bindParam(":email", $emailSessao);
$stmt->execute();
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if ($usuario) {
    $id_usuario = $usuario['id_usuario'];
    $nome = $usuario['nome'];
    $email = $usuario['email'];
    $telefone = !empty($usuario['telefone']) ? $usuario['telefone'] : "Não informado";
    $foto = !empty($usuario['imagem']) ? $usuario['imagem'] : "imagens/default-avatar.png";
    $eAdmin = $usuario['admin'];
    $tipoConta = $eAdmin ? "Administrador" : "Cliente";
} else {
    header("Location: login.php");
    exit;
}

// Consulta o total de compras efetuadas pelo utilizador
$totalCompras = 0;
try {
    $sqlCompras = "SELECT COUNT(*) FROM venda WHERE id_usuario = :id";
    $stmtCompras = $conn->prepare($sqlCompras);
    $stmtCompras->bindParam(":id", $id_usuario);
    $stmtCompras->execute();
    $totalCompras = $stmtCompras->fetchColumn();
} catch (PDOException $e) {
    $totalCompras = 0;
}


?>

<body>
    <div class="caixa-conteudo">
        <div class="cartao-perfil">
            <div class="banner-perfil" style="background-image: url('<?= $foto ?>');"></div>

            <div class="cabecalho-perfil">
                <div class="espaco-foto">
                    <img src="<?= $foto ?>" alt="Foto de perfil">
                    <a href="editarPerfil.php" class="botao-foto-lapis" title="Editar foto">
                        <i class="fa-solid fa-pen"></i>
                    </a>
                </div>
                <div class="dados-usuario-cabecalho">
                    <h2>Olá, <?= htmlspecialchars($nome) ?> !</h2>
                    <span class="etiqueta-tipo <?= $eAdmin ? 'admin' : '' ?>">
                        <?= $tipoConta ?>
                    </span>
                </div>
            </div>

            <div class="corpo-perfil">
                <div class="grade-informacoes">
                    <div class="caixa-info">
                        <div class="icone-info">
                            <i class="fa-regular fa-envelope"></i>
                        </div>
                        <div class="texto-info">
                            <span>E-MAIL</span>
                            <strong><?= htmlspecialchars($email) ?></strong>
                        </div>
                    </div>

                    <div class="caixa-info">
                        <div class="icone-info">
                            <i class="fa-solid fa-phone"></i>
                        </div>
                        <div class="texto-info">
                            <span>TELEFONE</span>
                            <strong><?= htmlspecialchars($telefone) ?></strong>
                        </div>
                    </div>

                    <div class="caixa-info">
                        <div class="icone-info">
                            <i class="fa-regular fa-user"></i>
                        </div>
                        <div class="texto-info">
                            <span>TIPO DE CONTA</span>
                            <strong><?= $tipoConta ?></strong>
                        </div>
                    </div>

                    <div class="caixa-info">
                        <div class="icone-info">
                            <i class="fa-solid fa-bag-shopping"></i>
                        </div>
                        <div class="texto-info">
                            <span>TOTAL DE COMPRAS</span>
                            <strong><?= $totalCompras ?> <?= $totalCompras == 1 ? 'compra' : 'compras' ?></strong>
                        </div>
                    </div>
                </div>

                <a href="editarPerfil.php" class="botao-editar-perfil">
                    <i class="fa-solid fa-pen"></i> Editar perfil
                </a>
            </div>
        </div>
    </div>
</body>
<?php
include "_rodape.php";
?>