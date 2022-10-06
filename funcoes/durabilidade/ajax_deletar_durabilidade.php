<?php

session_start();

include '../../conexao.php';

$var_usu_del_dur = $_SESSION['usuarioLogin'];
$var_del_durabilidade = $_POST['durabilidade'];


echo $con_delete_durabilidade="BEGIN portal_sesmt.PRC_ACOES_DURABILIDADE($var_del_durabilidade ,'$var_usu_del_dur'); END;";


                                //"DELETE portal_sesmt.DURABILIDADE dur 
                                //WHERE dur.CD_DURABILIDADE = $var_del_durabilidade ";

    $result_del_durabilidade = oci_parse($conn_ora,$con_delete_durabilidade);

    oci_execute($result_del_durabilidade);

?>