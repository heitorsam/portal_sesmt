<?php   

    include '../../conexao.php';

    $var_cd_usu = $_GET['cd_usuario'];


    $consulta_tabela = "SELECT sol.CD_SOLICITACAO,
                            (SELECT usu.nm_usuario FROM dbasgu.usuarios usu WHERE usu.cd_usuario = sol.CD_USUARIO_MV) AS NM_USU,

                            (SELECT st.CD_SETOR
                             FROM dbamv.SETOR st
                             WHERE st.SN_ATIVO = 'S'
                             AND st.CD_SETOR = sol.CD_SETOR_MV) AS CD_SETOR,

                            (SELECT st.NM_SETOR
                             FROM dbamv.SETOR st
                             WHERE st.SN_ATIVO = 'S'
                             AND st.CD_SETOR = sol.CD_SETOR_MV) AS NM_SETOR,

                            TO_CHAR(sol.HR_CADASTRO,'DD/MM/YYYY HH24:MI:SS') AS DT_ENTREGA,
                            sol.CD_PRODUTO_MV,
                            pro.DS_PRODUTO,
                            (SELECT csa.CA_SOL FROM portal_sesmt.VW_CA_SOL_ATUAL csa WHERE csa.CD_SOLICITACAO = sol.CD_SOLICITACAO
                            ) AS CA_MV,
                            sol.QUANTIDADE,

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
                                
                            END AS DIAS,

                             (SELECT usu.nm_usuario FROM dbasgu.usuarios usu WHERE usu.cd_usuario = sol.CD_USUARIO_CADASTRO) NM_USUARIO_CADASTRO,
                            (SELECT edc.EDITADO_SN FROM portal_sesmt.EDITAR_CA edc WHERE edc.CD_SOLICITACAO = sol.CD_SOLICITACAO
                            ) AS EDITADO,

                            (SELECT uni_pro.DS_UNIDADE
                             FROM dbamv.uni_pro uni_pro  
                             WHERE cd_produto = sol.CD_PRODUTO_MV
                             AND uni_pro.sn_ativo = 'S') AS DS_UNIDADE,
                            
                            sm.CD_SOLSAI_PRO,
                            sol.SN_HISTORICO
                        FROM portal_sesmt.SOLICITACAO sol
                        INNER JOIN dbamv.PRODUTO pro
                           ON pro.CD_PRODUTO = sol.CD_PRODUTO_MV
                        LEFT JOIN SOLICITACAO_MV sm
                           ON sm.CD_SOLICITACAO = sol.CD_SOLICITACAO
                        WHERE sol.CD_USUARIO_MV = UPPER('$var_cd_usu')
                        ORDER BY TO_DATE(TO_CHAR(sol.HR_CADASTRO,'DD/MM/YYYY HH24:MI:SS'),'DD/MM/YYYY HH24:MI:SS') DESC";

    $resultado_con_tabela = oci_parse($conn_ora, $consulta_tabela);

    oci_execute($resultado_con_tabela);

?>

<?php while($row_tabela = oci_fetch_array($resultado_con_tabela)){

    echo '<tr>';
    
        echo '<td class="align-middle">' .  $row_tabela['CD_SOLICITACAO'] . '</td>';
        echo '<td class="align-middle">' .  $row_tabela['NM_USU'] . '</td>';
        echo '<td class="align-middle">' .  $row_tabela['NM_SETOR'] . '</td>';
        echo '<td class="align-middle">' .  $row_tabela['DT_ENTREGA'] . '</td>';
        echo '<td class="align-middle">' .  $row_tabela['CD_PRODUTO_MV'] . '</td>';
        echo '<td class="align-middle">' .  $row_tabela['DS_PRODUTO'] . '</td>';?>
        <td class="align-middle" id="MV_CA<?php echo $row_tabela['CD_SOLICITACAO'] ?>"
        ondblclick="fnc_editar_campo('portal_sesmt.EDITAR_CA', 'MV_CA', '<?php echo @$row_tabela['CA_MV']; ?>', 'CD_SOLICITACAO', '<?php echo @$row_tabela['CD_SOLICITACAO']; ?>', '')"> 
        
        <?php 
        if($row_tabela['EDITADO'] == 'S'){
            echo '<i class="fa-sharp fa-solid fa-keyboard"></i> ';
            echo $row_tabela['CA_MV'];
        ?>
            <i style="color: #e05757; font-size: 10px;" class="fa-solid fa-xmark" onclick="ajax_reset_ca('<?php echo $row_tabela['CD_SOLICITACAO'] ?>')"></i>
        <?php    
        }else{
            echo $row_tabela['CA_MV'];
        }

        
        
        echo'</td>';

            echo '<td class="align-middle">' .  $row_tabela['DIAS'] . '</td>';
            echo '<td class="align-middle">' .  $row_tabela['QUANTIDADE'] . '</td>';
            echo '<td class="align-middle">' .  $row_tabela['DS_UNIDADE'] . '</td>';
            echo '<td class="align-middle">' .  $row_tabela['NM_USUARIO_CADASTRO'] . '</td>';
            echo '<td class="align-middle">';
            ?>


            <?php 

            if(!isset($row_tabela['CD_SOLSAI_PRO'])){

            ?>

            <a type="button" class="btn btn-adm" onclick="ajax_deletar_realizadas(<?php echo $row_tabela['CD_SOLICITACAO']; ?>)" > 
            <i class="fa-solid fa-trash-can"></i></a><?php

            }else{

                echo '<a style="background-color: #a6a6a6 !important; border-color: #a6a6a6 !important;" type="button" class="btn btn-adm"> 
                      <i class="fa-solid fa-trash-can"></i></a>';

               
            }

            echo '</td>';

            echo '<td class="align-middle">';

            if(isset($row_tabela['CD_SOLSAI_PRO'])){
                
                echo  $row_tabela['CD_SOLSAI_PRO'];
            ?>

                   
            <?php

            }elseif($row_tabela['SN_HISTORICO'] == 'S'){

                echo '<i style="color: #444444 !important" class="fa-solid fa-hourglass-end"></i>';

            }else{ 
                
            ?>

            <input id="check_<?php echo $row_tabela['CD_SOLICITACAO'];?>" type="checkbox" onclick="ajax_pre_sol_mv(<?php echo $row_tabela['CD_SOLICITACAO']; ?>,<?php echo $row_tabela['CD_SETOR'];?>)"></input>

            <?php

            }
            echo '</td>';
    
    

    echo '</tr>';

    }

    ?>


