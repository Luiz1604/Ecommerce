<?php

// Inicia a sessão com segurança apenas se ainda não foi iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function conecta($paramStringConexao = "")
{
  $seu_usuario = "loja5b";
  $seu_banco = "loja5b";
  $sua_senha = "kv03iZ5EWkBUUhI";

  if ($paramStringConexao == "") {
    $paramStringConexao = "pgsql:host=projetoscti.com.br; port=54432;
        dbname=$seu_banco; user=$seu_usuario; password=$sua_senha";
  }

  try {
    $c = new PDO($paramStringConexao);
  } catch (PDOException $e) {
    echo ">> Nao conectado ! <br>" .
      "<b>Erro:</b> " . $e->getMessage();
    exit;
  }

  return $c;
}

/* Página 404 para dados/registros inexistentes do Banco */
function verificaExiste($dado) {
    if (!$dado || empty($dado)) {
        http_response_code(404);
        
        // Garante a inclusão da página 404 a partir da raiz do projeto
        include __DIR__ . "/404.php";
        
        exit; // Interrompe a execução para não carregar o resto da página
    }
}
function ExecutaSQL($paramConn, $paramSQL)
{
  // exec eh usado para update, delete, insert
  // retorna TRUE se houve linhas afetadas
  $linhas = $paramConn->exec($paramSQL);
  return ($linhas > 0); // TRUE se o comando funciounou !!
}

function Raiz()
{
  return str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']);
}

// agosto 2026 - Marcelo C Peres 
function ImagemJaExiste($paramImagem)
{
  $caminhoFisico = Raiz() . "/$paramImagem";
  return file_exists($caminhoFisico);
}

// ValorSQL 
// retorna o valor de um campo de um select
// Set 2023 - Marcelo C Peres 
function ValorSQL($pConn, $pSQL)
{
  $linha = $pConn->query($pSQL)->fetch();
  if ($linha) {
    return $linha[0]; // equivale a retornar o valor do campo
  } else {
    return "0";
  }
}

/**
 * Funcao para gerar senhas aleatorias
 *
 * @author    Thiago Belem <contato@thiagobelem.net>
 *
 * @param integer $tamanho Tamanho da senha a ser gerada
 * @param boolean $maiusculas Se ter� letras mai�sculas
 * @param boolean $numeros Se ter� n�meros
 * @param boolean $simbolos Se ter� s�mbolos
 *
 * @return string A senha gerada
 */

function GeraSenha($tamanho = 8, $maiusculas = true, $numeros = true, $simbolos = false)
{
  //$lmin = 'abcdefghijklmnopqrstuvwxyz';
  $lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $num = '1234567890';
  $simb = '!@#$%*-';
  $retorno = '';
  $caracteres = '';

  //$caracteres .= $lmin;
  if ($maiusculas)
    $caracteres .= $lmai;
  if ($numeros)
    $caracteres .= $num;
  if ($simbolos)
    $caracteres .= $simb;

  $len = strlen($caracteres);

  for ($n = 1; $n <= $tamanho; $n++) {
    $rand = mt_rand(1, $len);
    $retorno .= $caracteres[$rand - 1];
  }

  return $retorno;
}

//////  funcao de login

function ValidaLogin(
  $paramLogin,
  $paramSenha,
  &$paramNome,
  &$paramFoto,
  &$paramAdmin,
  &$paramTel
) {
  $conn = conecta();
  $varSQL = " select nome,senha,telefone,admin,imagem from usuario 
               where (not excluido) and email = :paramLogin ";
  $select = $conn->prepare($varSQL);
  $select->bindParam(':paramLogin', $paramLogin);
  $select->execute();
  $linha = $select->fetch();

  $paramAdmin = false;
  $paramNome = "";
  $paramFoto = "";
  $paramTel = "";
  $autenticado = false;

  if ($linha) {
    $autenticado = password_verify($paramSenha, $linha['senha']);
    if ($autenticado) {
      $paramAdmin = $linha['admin'];
      $paramNome = $linha['nome'];
      $paramFoto = $linha['imagem'];
      $paramTel = $linha['telefone'];
    }
  }

  return $autenticado;

}

 function SaiSeHacker() 
  {
    $autorizadoAdmin = 
       ( ( isset( $_SESSION['sessaoAdmin'] ) ) and 
         ( $_SESSION['sessaoAdmin'] == true ) );

    // se nao for
    if ( !$autorizadoAdmin ) {
       header ("location: /index.php");
       exit;   //// encerra a pagina e qquer conteudo lido 
    }     
    
    

  }

//////  funcao de definir cookie
//////  11-9-2023
function DefineCookie($paramNome, $paramValor, $paramMinutos)
{
  setcookie($paramNome, $paramValor, time() + $paramMinutos * 60);
}

//////  funcao matar cookie
  //////  16-8-2026
  function MatarCookie($paramNome) 
  {
   setcookie($paramNome,"", time() - 3600); 
  }

  //Envia Email
  function EnviaEmail ( $pEmailDestino, $pAssunto, $pHtml, 
                        $pUsuario = "seu_email_aqui", 
                        $pSenha = "sua_senha_aqui", 
                        $pSMTP = "smtp.gmail.com" )   
  {   
      
   try {
 
     //cria instancia de phpmailer
     echo "<br>Tentando enviar para $pEmailDestino...";
     $mail = new PHPMailer(); 
     $mail->IsSMTP();  
  
     // servidor smtp
     $mail->Host = $pSMTP;
     $mail->SMTPAuth = true;      // requer autenticacao com o servidor                         
     $mail->SMTPSecure = 'tls';                            
      
     $mail-> SMTPOptions = array (
       'ssl' => array (
       'verificar_peer' => false,
       'verify_peer_name' => false,
       'allow_self_signed' => true ) );
      
     $mail->Port = 587;      
      
     $mail->Username = $pUsuario; 
     $mail->Password = $pSenha; 
     $mail->From = $pUsuario; 
     $mail->FromName = "Suporte de senhas"; 
  
     $mail->AddAddress($pEmailDestino, "Usuario"); 
     $mail->IsHTML(true); 
     $mail->Subject = $pAssunto; 
     $mail->Body = $pHtml;
     $enviado = $mail->Send(); 
       
     if (!$enviado) {
        echo "<br>Erro: " . $mail->ErrorInfo;
     } else {
        echo "<br><b>Enviado!</b>";
     }
     return $enviado;         
      
   } catch (phpmailerException $e) {
     echo $e->errorMessage(); // erros do phpmailer
   } catch (Exception $e) {
     echo $e->getMessage();  // erros da aplicacao - gerais
   }      
  }

  //Função de salvar imagem

function salvaUploadProdutos($paramFiles,$paramCampo)
  {   
    // obtem a extensão do arquivo
    $ext = pathinfo($paramFiles[$paramCampo]['name'],PATHINFO_EXTENSION);
    // cria o novo nome do arquivo
    $novoNome = uniqid('', true);
    $arquivoNovo = "/imagens/produto/$novoNome.$ext";
    
    try {
        if ( move_uploaded_file($paramFiles[$paramCampo]['tmp_name'], 
            Raiz().$arquivoNovo) ) {
            echo "<br>Arquivo $arquivoNovo criado com sucesso.\n";
        } else { echo "erro"; }
    } catch (PDOException $e) { // se der erro ...
        $arquivoNovo = "";
        echo "Erro, verifique o arquivo se a pasta imagens existe<br>
              (Motivo ".$e->getMessage().")";
    }   
    return $arquivoNovo;  
  }

function salvaUploadUsuarios($paramFiles,$paramCampo)
  {   
    // obtem a extensão do arquivo
    $ext = pathinfo($paramFiles[$paramCampo]['name'],PATHINFO_EXTENSION);
    // cria o novo nome do arquivo
    $novoNome = uniqid('', true);
    $arquivoNovo = "/imagens/usuarios/$novoNome.$ext";
    
    try {
        if ( move_uploaded_file($paramFiles[$paramCampo]['tmp_name'], 
            Raiz().$arquivoNovo) ) {
            echo "<br>Arquivo $arquivoNovo criado com sucesso.\n";
        } else { echo "erro"; }
    } catch (PDOException $e) { // se der erro ...
        $arquivoNovo = "";
        echo "Erro, verifique o arquivo se a pasta imagens existe<br>
              (Motivo ".$e->getMessage().")";
    }   
    return $arquivoNovo;  
  }

?>