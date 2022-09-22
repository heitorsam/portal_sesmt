<?php   

    include '../../conexao.php';

    $var_cd_usu = $_GET['cd_usuario'];


    $consulta_tabela = "SELECT sol.CD_USUARIO_MV,
                            sol.HR_CADASTRO AS DT_ENTREGA,
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

    while($row_tabela = oci_fetch_array($resultado_con_tabela)){

        echo '<tr>';

            echo '<td>' .  $row_tabela['CD_USUARIO_MV'] . '</td>';
            echo '<td>' .  $row_tabela['DT_ENTREGA'] . '</td>';
            echo '<td>' .  $row_tabela['CD_PRODUTO_MV'] . '</td>';
            echo '<td>' .  $row_tabela['DS_PRODUTO'] . '</td>';
            echo '<td>' .  $row_tabela['CA_MV'] . '</td>';
            echo '<td>' .  $row_tabela['QUANTIDADE'] . '</td>';
            echo '<td>' .  $row_tabela['CD_USUARIO_CADASTRO'] . '</td>';

        echo '</tr>';

    }

?>