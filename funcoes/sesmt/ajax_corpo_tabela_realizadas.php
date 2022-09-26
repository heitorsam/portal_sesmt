<?php   

    include '../../conexao.php';

    $var_cd_usu = $_GET['cd_usuario'];


    $consulta_tabela = "SELECT sol.CD_SOLICITACAO,
                            sol.CD_USUARIO_MV,
                            TO_CHAR(sol.HR_CADASTRO,'DD/MM/YYYY HH24:MI:SS') AS DT_ENTREGA,
                            sol.CD_PRODUTO_MV,
                            pro.DS_PRODUTO,
                            sol.CA_MV,
                            sol.QUANTIDADE,
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
    
    echo '<td>' .  $row_tabela['CD_SOLICITACAO'] . '</td>';
    echo '<td>' .  $row_tabela['CD_USUARIO_MV'] . '</td>';
    echo '<td>' .  $row_tabela['DT_ENTREGA'] . '</td>';
    echo '<td>' .  $row_tabela['CD_PRODUTO_MV'] . '</td>';
    echo '<td>' .  $row_tabela['DS_PRODUTO'] . '</td>';
    echo '<td>' .  $row_tabela['CA_MV'] . '</td>';
    echo '<td>' .  $row_tabela['QUANTIDADE'] . '</td>';
    echo '<td>' .  $row_tabela['CD_USUARIO_CADASTRO'] . '</td>';
    echo '<td>' ?>

    <a type="button" class="btn btn-adm" onclick="ajax_deletar_realizadas(<?php echo $row_tabela['CD_SOLICITACAO']; ?>)" > 
    <i class="fa-solid fa-trash-can"></i></a><?php

    echo '</td>';

    echo '</tr>';

    }

    ?>


