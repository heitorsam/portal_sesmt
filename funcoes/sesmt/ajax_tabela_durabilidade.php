<?php

include '../../conexao.php';

$var_produto_durabilidade = $_GET['cd_produto'];

$consulta_exibe_tabela_durabilidade = "SELECT dur.CD_DURABILIDADE,
                                              dur.CD_PRODUTO_MV,
                                              pro.DS_PRODUTO,
                                              sol.CA_MV,
                                              dur.DIAS
                                              FROM portal_sesmt.DURABILIDADE dur
                                              INNER JOIN dbamv.PRODUTO pro
                                                 ON pro.CD_PRODUTO = dur.CD_PRODUTO_MV
                                              INNER JOIN portal_sesmt.SOLICITACAO sol
                                                 ON sol.CD_PRODUTO_MV =  dur.CD_PRODUTO_MV
                                              WHERE dur.CD_PRODUTO_MV = $var_produto_durabilidade";

$resultado_exibe_tabela = oci_parse($conn_ora, $consulta_exibe_tabela_durabilidade);

oci_execute($resultado_exibe_tabela);

?>

<?php


while($row_durabilidade = oci_fetch_array($resultado_exibe_tabela)){

    echo '<tr>';
    
    echo '<td>' .  $row_durabilidade['CD_PRODUTO_MV'] . '</td>';
    echo '<td>' .  $row_durabilidade['DS_PRODUTO'] . '</td>';
    echo '<td>' .  $row_durabilidade['CA_MV'] . '</td>';
    echo '<td>' .  $row_durabilidade['DIAS'] . '</td>';
    echo '<td>' ?>

    <a type="button" class="btn btn-adm" onclick="ajax_deletar_durabilidade(<?php echo $row_durabilidade['CD_DURABILIDADE']; ?>)" > 
    <i class="fa-solid fa-trash-can"></i></a><?php

    echo '</td>';

    echo '</tr>';








}

?>