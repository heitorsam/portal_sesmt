<?php

    session_start();

    include '../../conexao.php';

    $var_usu_cad = $_SESSION['usuarioLogin'];
    $var_delete = $_POST['solicitacao']; 

    echo $con_delete_realizadas = "BEGIN portal_sesmt.PRC_ACOES_SOL($var_delete ,'$var_usu_cad'); END;";

    $result_del_realizadas = oci_parse($conn_ora,$con_delete_realizadas);

    oci_execute($result_del_realizadas);

?>




