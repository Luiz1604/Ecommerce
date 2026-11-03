<?php 
  include   "util.php";
  include   "_cabecalho.php";
?>

  <center><h1>Monitor de vendas</h1></center>  
  <form action='' method='post'>
     Data inicial<br>
     <input type='date' name='datai' value = '<?= date('Y/m/d') ?>'><br><br>
     Data final<br>
     <input type='date' name='dataf' value value = '<?= date('Y/m/d') ?>'><br><br>
     <input type='checkbox' name="cancelados" value="checked" checked>
     <label for="cancelados">omitir cancelados</label><br><br>
     <input type='submit' value='Enviar'><br>  
  </form>

  <?php 

  if ($_POST ) {

      $conn = conecta();

      $datai = $_POST['datai'];
      $dataf = $_POST['dataf'];
      if (!isset($_POST['cancelados']))  {
         $cancelados= ""; 
      } else {
         $cancelados = $_POST['cancelados'];
      }

      $sql = " select id_compra, status, data, usuario.nome 
               from compra left join usuario on compra.fk_usuario = usuario.id_usuario
               where data between :datai and :dataf ". 
               ($cancelados == "checked" ? " and ( status!='cancelado') " : ""). 
             " order by data desc ";

      $select = $conn->prepare($sql);
      $select->bindParam(':datai',$datai);
      $select->bindParam(':dataf',$dataf);
      $select->execute();

      ?>
      <h3>Periodo de <?= date('d/m', strtotime($datai)) ?> a <?= date('d/m', strtotime($dataf)) ?></h3>
      <table id='tabela'>
         <tr>
           <th>Id</th>
           <th style='width: 100px;'>Sit</th>
           <th style='width: 50px;' Data></th>
           <th style='width: 100px;'>Usuario<br>Prod</th>
           <th>Qtd</th>
           <th style='width: 70px;'>$ unit</th>
           <th style='width: 70px;'>$ Sub</th>                      
           <th style='width: 70px;'>$ Tot</th>                      
         </tr>

      <?php 

      while ( $linha = $select->fetch() ) {

          $id_compra = $linha['id_compra'];
          $status    = $linha['status'];
          $data      = $linha['data'];        
          $nome      = $linha['nome'];
          ?>

          <tr>
              <td align='right'><?= $id_compra ?></td>
              <td><?= $status ?></td>
              <td><?= date('d/m', strtotime($data)) ?></td>
              <td style='width: 300px;' colspan='5'><?= $nome ?></td>
          </tr>

          <?php 
          //////// SELECIONA E IMPRIME OS ITENS DA COMPRA //////////////// 
          $sqlItens =
                  "select compra_produto.fk_produto, produto.nome, compra_produto.quantidade, 
                          compra_produto.valor_unitario, 
                          compra_produto.valor_unitario * compra_produto.quantidade as sub
                   from compra_produto inner join produto on compra_produto.fk_produto = 
                        produto.id_produto
                   where compra_produto.fk_compra = $id_compra 
                   order by produto.nome";

          $selectItens = $conn->prepare($sqlItens);

          $selectItens->execute();
          
          $tot = 0;
          while ( $linhaItens = $selectItens->fetch() ) {

                  $id_produto     = $linhaItens['fk_produto']; 
                  $nome           = $linhaItens['nome'];  
                  $quantidade     = $linhaItens['quantidade'];  
                  $valor_unitario = number_format($linhaItens['valor_unitario'],2);  
                  $sub            = number_format($linhaItens['sub'],2); 
                  $tot += $linhaItens['sub'];
                  ?>

                  <tr>
                    <td colspan='3'></td>
                    <td><b><?= $nome ?></b></td>
                    <td align='right'><?= $quantidade ?></td>                    
                    <td align='right'><?= $valor_unitario ?></td>
                    <td align='right'><?= $sub ?></td>
                    <td></td>
                  </tr>

                <?php
                      
          }
          ?>
          <tr>
            <td colspan="7"></td>
            <td align='right'>R$ <?= $tot ?></td>
          </tr>
          <?php
          //////// FIM DE IMPRIME OS ITENS DA COMPRA //////////////// 
          
          $selectItens = null;
      }     

      echo "</table>";

  }   
  include "_rodape.php";
?>