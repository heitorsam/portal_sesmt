<?php

header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=relatorio.xls");  ///NOME DO ARQUIVO
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);

//CONEXÃO ORACLE

include 'conexao.php';

//RECEBENDO VARIAVEIS

$centro_custo_ex = $_GET['get_var_centro'];
$data_inial_ex = $_GET['get_dt_ini'] ;
$data_final_ex =  $_GET['get_dt_fim'];
$cd_usuario_relatorio_ex = $_GET['get_usu_rel'];

//FAZ O SELECT

$consulta_excel_oracle = "SELECT sol.CD_SOLICITACAO,
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
                                 TO_CHAR(TO_DATE('$data_inial_ex','YYYY-MM-DD'),'DD/MM/YYYY') AND
                                 TO_CHAR(TO_DATE('$data_final_ex','YYYY-MM-DD'),'DD/MM/YYYY')";

if($centro_custo_ex <> 'all'){

    $consulta_excel_oracle .= "AND sol.CD_SETOR_MV = '$centro_custo_ex'";

}

if($cd_usuario_relatorio_ex <> 'all'){

    $consulta_excel_oracle .= "AND sol.CD_USUARIO_MV = UPPER('$cd_usuario_relatorio_ex')";

}
$rest_cons_excel = oci_parse($conn_ora, $consulta_excel_oracle);

oci_execute($rest_cons_excel);

//ESTRUTURA DA TABELA

echo "<table>";

    echo "<tr>";

    echo "<th>Solicitação</th>";
    echo "<th>Usuario</th>";
    echo "<th>Entrega</th>";
    echo "<th>Código</th>";
    echo "<th>Produto</th>";
    echo "<th>C.A</th>";
    echo "<th>Quantidade</th>";
    echo "<th>Funcionário</th>";

    echo "</tr>";

    while($row_tabela_excel = oci_fetch_array($rest_cons_excel)){
    
     echo '<tr>';
    
        echo '<td>' .  $row_tabela_excel['CD_SOLICITACAO'] . '</td>';
        echo '<td>' .  $row_tabela_excel['CD_USUARIO_MV'] . '</td>';
        echo '<td>' .  $row_tabela_excel['HR_CADASTRO'] . '</td>';
        echo '<td>' .  $row_tabela_excel['CD_PRODUTO_MV'] . '</td>';
        echo '<td>' .  $row_tabela_excel['DS_PRODUTO'] . '</td>';
        echo '<td>' .  $row_tabela_excel['CA_MV'] . '</td>';
        echo '<td>' .  $row_tabela_excel['QUANTIDADE'] . '</td>';
        echo '<td>' .  $row_tabela_excel['CD_USUARIO_CADASTRO'] . '</td>';

    echo '</tr>';

    }
echo "</table>";

?>