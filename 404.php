<?php
// Define o código de resposta HTTP correto para SEO e navegadores
http_response_code(404);

include "_cabecalho.php";
?>

<main class="container-404" style="text-align: center; padding: 50px 20px;">
    <h1 style="font-size: 80px; color: var(--cor-destaque-secundario); margin: 0;">404</h1>
    <h2>Página não encontrada</h2>
    <p>O conteúdo que você está procurando não existe ou foi removido.</p>
    
    <a href="index.php" class="btn" style="display: inline-block; text-decoration: none; margin-top: 20px;">
        Voltar para o Início
    </a>
</main>

<?php
include "_rodape.php";
?>