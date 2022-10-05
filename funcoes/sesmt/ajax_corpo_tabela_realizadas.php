<?php   

    include '../../conexao.php';

    $var_cd_usu = $_GET['cd_usuario'];


    $consulta_tabela = "SELECT sol.CD_SOLICITACAO,
                            sol.CD_USUARIO_MV,

                            (SELECT st.NM_SETOR
                             FROM dbamv.SETOR st
                             WHERE st.SN_ATIVO = 'S'
                             AND st.CD_SETOR = sol.CD_SETOR_MV) AS NM_SETOR,

                            TO_CHAR(sol.HR_CADASTRO,'DD/MM/YYYY HH24:MI:SS') AS DT_ENTREGA,
                            sol.CD_PRODUTO_MV,
                            pro.DS_PRODUTO,
                            sol.QUANTIDADE,

                            (SELECT dur.DIAS
                             FROM portal_sesmt.DURABILIDADE dur
                             WHERE dur.CD_DURABILIDADE = sol.CD_DURABILIDADE
                            
                             UNION ALL
                            
                             SELECT ldur.DIAS
                             FROM portal_sesmt.LOG_DURABILIDADE ldur
                             WHERE ldur.CD_DURABILIDADE = sol.CD_DURABILIDADE) || ' dias' AS DIAS,

                            sol.CD_USUARIO_CADASTRO
                        FROM portal_sesmt.SOLICITACAO sol
                        INNER JOIN dbamv.PRODUTO pro
                           ON pro.CD_PRODUTO = sol.CD_PRODUTO_MV
                        WHERE sol.CD_USUARIO_MV = UPPER('$var_cd_usu')";

    $resultado_con_tabela = oci_parse($conn_ora, $consulta_tabela);

    oci_execute($resultado_con_tabela);

?>

<?php while($row_tabela = oci_fetch_array($resultado_con_tabela)){

    echo '<tr>';
    
    echo '<td class="align-middle">' .  $row_tabela['CD_SOLICITACAO'] . '</td>';
    echo '<td class="align-middle">' .  $row_tabela['CD_USUARIO_MV'] . '</td>';
    echo '<td class="align-middle">' .  $row_tabela['NM_SETOR'] . '</td>';
    echo '<td class="align-middle">' .  $row_tabela['DT_ENTREGA'] . '</td>';
    echo '<td class="align-middle">' .  $row_tabela['CD_PRODUTO_MV'] . '</td>';
    echo '<td class="align-middle">' .  $row_tabela['DS_PRODUTO'] . '</td>';
    echo '<td class="align-middle">' .  $row_tabela['DIAS'] . '</td>';
    echo '<td class="align-middle">' .  $row_tabela['QUANTIDADE'] . '</td>';
    echo '<td class="align-middle">' .  $row_tabela['CD_USUARIO_CADASTRO'] . '</td>';
    echo '<td>' ?>

    <a type="button" class="btn btn-adm" onclick="ajax_deletar_realizadas(<?php echo $row_tabela['CD_SOLICITACAO']; ?>)" > 
    <i class="fa-solid fa-trash-can"></i></a><?php

    echo '</td>';

    echo '</tr>';

    }

    ?>


