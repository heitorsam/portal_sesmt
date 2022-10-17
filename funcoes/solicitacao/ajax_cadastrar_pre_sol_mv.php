<?php

session_start();

include '../../conexao.php';

$var_usu_psm = $_POST['usuario'];
$var_sol_psm = $_POST['cd_sol'];
$var_tp_acao = $_POST['tp_acao'];
$var_session_psm = $_SESSION['usuarioLogin'];

if($var_tp_acao == 'I'){

$consulta_pre_sol_mv = "INSERT INTO portal_sesmt.PRE_SOL_MV

                            SELECT 
                            portal_sesmt.SEQ_CD_PRE_SOL_MV.NEXTVAL AS CD_PRE_SOL_MV,
                            '$var_usu_psm'        AS CD_USUARIO_MV,
                             $var_sol_psm         AS CD_SOLICITACAO,
                            '$var_session_psm'     AS CD_USUARIO_CADASTRO,
                             SYSDATE              AS HR_CADASTRO,
                             NULL                 AS CD_USUARIO_ULT_ALT,
                             SYSDATE              AS HR_ULT_ALT

                        FROM DUAL";

}else{

$consulta_pre_sol_mv = "  DELETE FROM portal_sesmt.PRE_SOL_MV psm
                          WHERE psm.CD_SOLICITACAO = $var_sol_psm";

}

$result_consulta_pre_sol_mv = oci_parse($conn_ora,$consulta_pre_sol_mv);

$valida_pre_sol_mv = oci_execute($result_consulta_pre_sol_mv);

if(!$valida_pre_sol_mv){

    $erro = oci_error($result_consulta_pre_sol_mv);																							
    $msg_erro = htmlentities($erro['message']);
    //header("Location: $pag_login");
    //echo $erro;
    echo $msg_erro;

}else{

    echo 'Sucesso!';
}















?>
