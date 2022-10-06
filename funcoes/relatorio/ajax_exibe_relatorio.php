<?php 

session_start();

include '../../conexao.php';

$cd_centro_custo = $_GET['get_var_centro'];
$data_inial =  $_GET['get_dt_ini'];
$data_final =  $_GET['get_dt_fim'];
$cd_usuario_relatorio = $_GET['get_usu_rel'];

$consulta_tabela_rel = "SELECT sol.CD_SOLICITACAO,
                                    (SELECT usu.nm_usuario FROM dbasgu.usuarios usu WHERE usu.cd_usuario = sol.CD_USUARIO_MV) AS NM_USU,
                                    TO_CHAR(sol.HR_CADASTRO, 'DD/MM/YYYY') AS HR_CADASTRO,
                                    sol.CD_SETOR_MV,
                                    (SELECT st.NM_SETOR
                                    FROM dbamv.SETOR st
                                    WHERE st.SN_ATIVO = 'S'
                                        AND st.CD_SETOR = sol.CD_SETOR_MV) AS NM_SETOR,
                                    sol.CD_PRODUTO_MV,
                                    pro.DS_PRODUTO,
                                    (SELECT CASE
                                            WHEN dur.DIAS < 2 THEN
                                            dur.DIAS || ' Dia'
                                            WHEN dur.DIAS >= 2 THEN
                                            dur.DIAS || ' Dias'
                                            ELSE
                                            ''
                                            END
                                    FROM portal_sesmt.DURABILIDADE dur
                                    WHERE dur.CD_PRODUTO_MV = sol.CD_PRODUTO_MV) AS DT_DURABILIDADE,
                                    (SELECT csa.CA_SOL FROM portal_sesmt.VW_CA_SOL_ATUAL csa WHERE csa.CD_SOLICITACAO = sol.CD_SOLICITACAO
                                    ) AS CA_MV,
                                    sol.QUANTIDADE,
                                    (SELECT usu.nm_usuario FROM dbasgu.usuarios usu WHERE usu.cd_usuario = sol.CD_USUARIO_CADASTRO) NM_USUARIO_CADASTRO,
                                    (SELECT edc.EDITADO_SN FROM portal_sesmt.EDITAR_CA edc WHERE edc.CD_SOLICITACAO = sol.CD_SOLICITACAO
                                    ) AS EDITADO_SN
                                    FROM portal_sesmt.SOLICITACAO sol
                                    INNER JOIN dbamv.PRODUTO pro
                                    ON pro.CD_PRODUTO = sol.CD_PRODUTO_MV
                                    WHERE TRUNC(sol.HR_CADASTRO) BETWEEN
                                    TRUNC(TO_DATE('$data_inial', 'YYYY-MM-DD')) AND
                                    TRUNC(TO_DATE('$data_final', 'YYYY-MM-DD'))";

if($cd_centro_custo <> 'all'){
    $consulta_tabela_rel .= "AND sol.CD_SETOR_MV = '$cd_centro_custo'";
}
     
if($cd_usuario_relatorio <> 'all'){
    $consulta_tabela_rel .= "AND sol.CD_USUARIO_MV = UPPER('$cd_usuario_relatorio')";
}

$consulta_tabela_rel .= "ORDER BY 1 DESC";

$resultado_tabela_relatorio = oci_parse($conn_ora, $consulta_tabela_rel);

oci_execute($resultado_tabela_relatorio);

 while($row_tabela_relatorio = oci_fetch_array($resultado_tabela_relatorio)){

    echo '<tr>';
    
        echo '<td class="align-middle">' .  $row_tabela_relatorio['CD_SOLICITACAO'] . '</td>';
        echo '<td class="align-middle">' .  $row_tabela_relatorio['NM_USU'] . '</td>';
        echo '<td class="align-middle">' .  $row_tabela_relatorio['NM_SETOR'] . '</td>';
        echo '<td class="align-middle">' .  $row_tabela_relatorio['HR_CADASTRO'] . '</td>';
        echo '<td class="align-middle">' .  $row_tabela_relatorio['CD_PRODUTO_MV'] . '</td>';
        echo '<td class="align-middle">' .  $row_tabela_relatorio['DS_PRODUTO'] . '</td>';
        echo '<td class="align-middle">' .  $row_tabela_relatorio['DT_DURABILIDADE'] . '</td>';
        echo '<td class="align-middle">' .  $row_tabela_relatorio['CA_MV'] . '</td>';
        echo '<td class="align-middle">' .  $row_tabela_relatorio['QUANTIDADE'] . '</td>';
        echo '<td class="align-middle">' .  $row_tabela_relatorio['NM_USUARIO_CADASTRO'] . '</td>';

    echo '</tr>';

}

?>