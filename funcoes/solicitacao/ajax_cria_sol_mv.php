<?php

Session_start();
include '../../conexao.php';

$var_usu_sol = $_SESSION['usuarioLogin'];
$var_usu = $_POST['usuario'];


$con_seq_solsai = "SELECT dbamv.SEQ_SOLSAI_PRO.NEXTVAL AS CD_SOLSAI_PRO FROM DUAL";

$res_con_seq_solsai = oci_parse($conn_ora,$con_seq_solsai);

$valida_ss = oci_execute($res_con_seq_solsai);

if(!$valida_ss){

    $erro = oci_error($res_con_seq_solsai);																							
    $msg_erro = htmlentities($erro['message']);
    //header("Location: $pag_login");
    //echo $erro;
    echo $msg_erro;


}else{

    echo 'Sucesso!';

}

$row_cd_solsai = oci_fetch_array($res_con_seq_solsai);

$var_ss_nextval = $row_cd_solsai['CD_SOLSAI_PRO'];

//////////////////

$cria_sol_mv = "BEGIN portal_sesmt.PRC_ACOES_PRE_SOL($var_usu_sol, $var_usu, $var_ss_nextval) END";

$res_cria_sol_mv = oci_parse($conn_ora,$cria_sol_mv);

oci_execute($res_cria_sol_mv);


?>


