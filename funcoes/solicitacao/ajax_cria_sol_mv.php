<?php

Session_start();
include '../../conexao.php';

$var_usu_criacao = $_SESSION['usuarioLogin'];
$var_usu_sol = $_POST['usuario_solicitacao'];


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

    //echo 'Sucesso!';

}

$row_cd_solsai = oci_fetch_array($res_con_seq_solsai);

$var_ss_nextval = $row_cd_solsai['CD_SOLSAI_PRO'];


$cria_sol_mv = "BEGIN portal_sesmt.PRC_ACOES_PRE_SOL('$var_usu_criacao', '$var_usu_sol', $var_ss_nextval); END;";

$res_cria_sol_mv = oci_parse($conn_ora,$cria_sol_mv);

$valida_prc = oci_execute($res_cria_sol_mv);


if(!$valida_prc){

    $erro = oci_error($res_cria_sol_mv);																							
    $msg_erro = htmlentities($erro['message']);
    //header("Location: $pag_login");
    //echo $erro;
    echo $msg_erro;


}else{

    echo $var_ss_nextval;


}


?>




