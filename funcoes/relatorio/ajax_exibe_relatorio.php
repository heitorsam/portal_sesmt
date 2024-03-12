  
<?php 

include '../../conexao.php';

$cd_centro_custo = $_GET['get_var_centro'];
$data_inial =  $_GET['get_dt_ini'];
$data_final =  $_GET['get_dt_fim'];
$cd_usuario_relatorio = $_GET['get_usu_rel'];
$tp_rel = $_GET['get_tp_rel'];

//VARIAVEL fontawesome
$varfontawaeson = '<i class="fa-solid fa-triangle-exclamation"></i>';
$fontawaeson = '<i class="fa-solid fa-triangle-exclamation"></i>';

 $consulta_tabela_rel = "SELECT sol.CD_SOLICITACAO,
                                    CASE 
                                        WHEN (SELECT usu.TP_SITUACAO FROM dbamv.STA_TB_FUNCIONARIO usu WHERE RPAD(('00000' || TO_CHAR(CHAPA)), 11, 0) = LPAD(sol.CD_USUARIO_MV,11)) = 'A'
                                        THEN (SELECT usu.NM_FUNCIONARIO FROM dbamv.STA_TB_FUNCIONARIO usu WHERE RPAD(('00000' || TO_CHAR(CHAPA)), 11, 0) = LPAD(sol.CD_USUARIO_MV,11)) || ' <i class=\"fa-solid fa-circle-user\" style=\"color: green;\"></i>'
                                        ELSE (SELECT usu.NM_FUNCIONARIO FROM dbamv.STA_TB_FUNCIONARIO usu WHERE RPAD(('00000' || TO_CHAR(CHAPA)), 11, 0) = LPAD(sol.CD_USUARIO_MV,11))
                                    END AS NM_USU,
                                    TO_CHAR(sol.HR_CADASTRO, 'DD/MM/YYYY') AS HR_CADASTRO,
                                    sol.CD_SETOR_MV,
                                    (SELECT st.NM_SETOR
                                    FROM dbamv.SETOR st
                                    WHERE st.SN_ATIVO = 'S'
                                        AND st.CD_SETOR = sol.CD_SETOR_MV) AS NM_SETOR,
                                    sol.CD_PRODUTO_MV,
                                    pro.DS_PRODUTO,
                                    CASE 
                            
                                        WHEN 
                                            (SELECT dur.DIAS
                                            FROM portal_sesmt.DURABILIDADE dur
                                            WHERE dur.CD_DURABILIDADE = sol.CD_DURABILIDADE
                                            
                                            UNION ALL
                                            
                                            SELECT ldur.DIAS
                                            FROM portal_sesmt.LOG_DURABILIDADE ldur
                                            WHERE ldur.CD_DURABILIDADE = sol.CD_DURABILIDADE) IS NULL THEN '-'

                                        WHEN 
                                            (SELECT dur.DIAS
                                            FROM portal_sesmt.DURABILIDADE dur
                                            WHERE dur.CD_DURABILIDADE = sol.CD_DURABILIDADE
                                            
                                            UNION ALL
                                            
                                            SELECT ldur.DIAS
                                            FROM portal_sesmt.LOG_DURABILIDADE ldur
                                            WHERE ldur.CD_DURABILIDADE = sol.CD_DURABILIDADE) IS NULL THEN '-'

                                        ELSE 

                                            (SELECT dur.DIAS
                                            FROM portal_sesmt.DURABILIDADE dur
                                            WHERE dur.CD_DURABILIDADE = sol.CD_DURABILIDADE
                                            
                                            UNION ALL
                                            
                                            SELECT ldur.DIAS
                                            FROM portal_sesmt.LOG_DURABILIDADE ldur
                                            WHERE ldur.CD_DURABILIDADE = sol.CD_DURABILIDADE)                               
                                            
                                            || ' dia(s)' 
                                            
                                        END AS DT_DURABILIDADE,
                                    (SELECT csa.CA_SOL FROM portal_sesmt.VW_CA_SOL_ATUAL csa WHERE csa.CD_SOLICITACAO = sol.CD_SOLICITACAO
                                    ) AS CA_MV,

                                    CASE
             
                                        WHEN COUNT(sol.DS_JUST_DUR) > 0 THEN '$varfontawaeson'
                                        ELSE '-'

                                    END AS EX_SOL,
                                    sol.DS_JUST_DUR,
                                    sol.QUANTIDADE,
                                    (SELECT usu.NM_FUNCIONARIO FROM dbamv.STA_TB_FUNCIONARIO usu WHERE RPAD(('00000' || TO_CHAR(CHAPA)), 11, 0) = LPAD(sol.CD_USUARIO_CADASTRO,11)) NM_USUARIO_CADASTRO,
                                    (SELECT edc.EDITADO_SN FROM portal_sesmt.EDITAR_CA edc WHERE edc.CD_SOLICITACAO = sol.CD_SOLICITACAO
                                    ) AS EDITADO_SN,
                                    (SELECT ass.BLOB_ASS 
                                     FROM portal_sesmt.ASSINATURA ass
                                     INNER JOIN portal_sesmt.SOLICITACAO_MV sm
                                     ON sm.CD_SOLSAI_PRO = ass.CD_SOLICITACAO_MV
                                     WHERE sm.CD_SOLICITACAO = sol.CD_SOLICITACAO ) AS BLOB_ASS  
                                    FROM portal_sesmt.SOLICITACAO sol
                                    INNER JOIN dbamv.PRODUTO pro
                                    ON pro.CD_PRODUTO = sol.CD_PRODUTO_MV
                                    WHERE TRUNC(sol.HR_CADASTRO) BETWEEN
                                    TRUNC(TO_DATE('$data_inial', 'YYYY-MM-DD')) AND
                                    TRUNC(TO_DATE('$data_final', 'YYYY-MM-DD'))";

if($cd_centro_custo <> 'all'){
     $consulta_tabela_rel .= " AND sol.CD_SETOR_MV = '$cd_centro_custo'";
}
     
if($cd_usuario_relatorio <> 'all'){
     $consulta_tabela_rel .= " AND sol.CD_USUARIO_MV = $cd_usuario_relatorio";
}

if($tp_rel == 'S'){

   $consulta_tabela_rel .= "AND sol.DS_JUST_DUR IS NOT NULL";

}

$consulta_tabela_rel .= " GROUP BY sol.CD_SOLICITACAO, sol.CD_SETOR_MV, sol.CD_PRODUTO_MV, pro.DS_PRODUTO, sol.QUANTIDADE, sol.HR_CADASTRO, sol.CD_USUARIO_MV, sol.CD_DURABILIDADE,
                           sol.CD_USUARIO_CADASTRO, sol.DS_JUST_DUR
                           ORDER BY 1 DESC";

$consulta_tabela_rel;

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
        echo '<td class="align-middle">' .  $row_tabela_relatorio['EX_SOL'] . '</td>';
        echo '<td class="align-middle">' .  $row_tabela_relatorio['DS_JUST_DUR'] . '</td>';
        echo '<td class="align-middle">' .  $row_tabela_relatorio['QUANTIDADE'] . '</td>';
        echo '<td class="align-middle">' .  $row_tabela_relatorio['NM_USUARIO_CADASTRO'] . '</td>';

        if(isset($row_tabela_relatorio['BLOB_ASS'])){

            $img = $row_tabela_relatorio['BLOB_ASS']->load();
            $imagem = base64_encode($img);
            echo '<td class="align-middle"> <img class="assinatura" src="data:image;base64,' . $imagem . '"/></td>';
        ?>
           <!-- <td class="align-middle"> <img class="assinatura" src="data:image;base64,<?php //echo $imagem;?>"/></td>-->

        <?php

        }else{
            
         echo '<td class="align-middle">' . $fontawaeson . '</td>';         

        }

    ?>
       

<?php

    echo '</tr>';
    
}

?>

