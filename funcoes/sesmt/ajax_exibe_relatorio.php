<?php 

session_start();

include '../../conexao.php';

$cd_centro_custo = $_GET['get_var_centro'];
$data_inial =  $_GET['get_dt_ini'];
$data_final =  $_GET['get_dt_fim'];
$cd_usuario_relatorio = $_GET['get_usu_rel'];

$consulta_tabela_rel = "SELECT sol.CD_SOLICITACAO,
                               sol.CD_USUARIO_MV,
                               TO_CHAR(sol.HR_CADASTRO, 'DD/MM/YYYY') AS HR_CADASTRO,
                               sol.CD_SETOR_MV,
                               sol.CD_PRODUTO_MV,
                               pro.DS_PRODUTO,
                               sol.CA_MV,
                               sol.QUANTIDADE,
                               sol.CD_USUARIO_CADASTRO
                             FROM portal_sesmt.SOLICITACAO sol
                             INNER JOIN dbamv.PRODUTO pro
                                ON pro.CD_PRODUTO = sol.CD_PRODUTO_MV
                             WHERE TO_CHAR(sol.HR_CADASTRO,'DD/MM/YYYY') BETWEEN 
                             TO_CHAR(TO_DATE('$data_inial','YYYY-MM-DD')) AND
                             TO_CHAR(TO_DATE('$data_final','YYYY-MM-DD'))";

if($cd_centro_custo <> 'all'){
    $consulta_tabela_rel .= "AND sol.CD_SETOR_MV = '$cd_centro_custo'";
}
     
if($cd_usuario_relatorio <> 'all'){
    $consulta_tabela_rel .= "AND sol.CD_USUARIO_MV = UPPER('$cd_usuario_relatorio')";
}

$resultado_tabela_relatorio = oci_parse($conn_ora, $consulta_tabela_rel);

oci_execute($resultado_tabela_relatorio);

 while($row_tabela_relatorio = oci_fetch_array($resultado_tabela_relatorio)){

    echo '<tr>';
    
        echo '<td>' .  $row_tabela_relatorio['CD_SOLICITACAO'] . '</td>';
        echo '<td>' .  $row_tabela_relatorio['CD_USUARIO_MV'] . '</td>';
        echo '<td>' .  $row_tabela_relatorio['HR_CADASTRO'] . '</td>';
        echo '<td>' .  $row_tabela_relatorio['CD_PRODUTO_MV'] . '</td>';
        echo '<td>' .  $row_tabela_relatorio['DS_PRODUTO'] . '</td>';
        echo '<td>' .  $row_tabela_relatorio['CA_MV'] . '</td>';
        echo '<td>' .  $row_tabela_relatorio['QUANTIDADE'] . '</td>';
        echo '<td>' .  $row_tabela_relatorio['CD_USUARIO_CADASTRO'] . '</td>';

    echo '</tr>';

}

?>