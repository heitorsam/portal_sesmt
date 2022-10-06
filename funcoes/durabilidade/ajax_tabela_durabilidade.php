<?php

include '../../conexao.php';

$var_produto_durabilidade = $_GET['cd_produto'];

$consulta_exibe_tabela_durabilidade = "SELECT dur.CD_DURABILIDADE,
                                              dur.CD_PRODUTO_MV,
                                              prod.DS_PRODUTO,
                                              (SELECT SUBSTR(SUBSTR(prod_aux.DS_PRODUTO,
                                                INSTR(prod_aux.DS_PRODUTO, '(CA') + 1,
                                                INSTR(prod_aux.DS_PRODUTO, ')') -
                                                INSTR(prod_aux.DS_PRODUTO, '(CA') - 1),3,10) AS CA
                                                FROM dbamv.PRODUTO prod_aux
                                                WHERE prod.DS_PRODUTO LIKE '%(CA %'
                                                AND prod_aux.CD_PRODUTO = prod.CD_PRODUTO
                                                ) AS CA_MV,                                                                             
                                                CASE 
                                                    WHEN  dur.DIAS < 2 THEN   dur.DIAS  || ' Dia'
                                                    WHEN  dur.DIAS >= 2 THEN  dur.DIAS  || ' Dias'
                                                    ELSE ''
                                                END AS DIAS
                                              --dur.DIAS || ' Dias' AS DIAS
                                              FROM portal_sesmt.DURABILIDADE dur
                                              INNER JOIN dbamv.PRODUTO prod
                                                 ON prod.CD_PRODUTO = dur.CD_PRODUTO_MV
                                             ORDER BY dur.CD_DURABILIDADE DESC";
                                                 
                                       
$resultado_exibe_tabela = oci_parse($conn_ora, $consulta_exibe_tabela_durabilidade);

$valida = oci_execute($resultado_exibe_tabela);


    //VALIDACAO
    if (!$valida) {   
        
      $erro = oci_error($resultado_exibe_tabela);																							
      //$_SESSION['msgerro'] = htmlentities($erro['message']);
      //header("Location: $pag_login");
      //echo $erro;
      echo $consulta_exibe_tabela_durabilidade;


  }else{

      //echo 'exibido com sucesso!';
      
  }

?>

<?php

while($row_durabilidade = oci_fetch_array($resultado_exibe_tabela)){

    echo '<tr>';

    echo '<td class="align-middle">' .  $row_durabilidade['CD_DURABILIDADE'] . '</td>';
    echo '<td class="align-middle">' .  $row_durabilidade['CD_PRODUTO_MV'] . '</td>';
    echo '<td class="align-middle">' .  $row_durabilidade['DS_PRODUTO'] . '</td>';
    echo '<td class="align-middle">' .  $row_durabilidade['CA_MV'] . '</td>';
    echo '<td class="align-middle">' .  $row_durabilidade['DIAS'] . '</td>';
    echo '<td class="align-middle">' ?>

    <a type="button" class="btn btn-adm" onclick="ajax_deletar_realizadas('<?php echo $row_durabilidade['CD_DURABILIDADE'];?>')"> 
    <i class="fa-solid fa-trash-can"></i></a><?php

    echo '</td>';

    echo '</tr>';

}

?>