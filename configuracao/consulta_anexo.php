<?php

session_start();
$var_user_logado = $_SESSION['usuarioLogin'];

include '../conexao.php';

$var_tpdoc= $_POST['frm_tpdoc'];
$var_desc= $_POST['frm_desc'];
$var_obg= $_POST['frm_obg'];
$var_mot= $_POST['frm_mot'];
$var_par= $_POST['frm_par'];
$var_dist= $_POST['frm_dist'];
$var_req= $_POST['frm_req'];


echo $consulta_oracle = "INSERT INTO portal_same.tp_documento_anexo
                         SELECT
                         UPPER('$var_tpdoc')AS TP_DOCUMENTO,
                         '$var_desc' AS DS_DOCUMENTO,
                         '$var_obg' AS TP_OBRIGATORIO,
                         '$var_mot' AS TP_PARENTE_MOTIVO,
                         '$var_par' AS TP_PARENTE_PARENTESCO,
                         '$var_dist' AS TP_DISTANCIA,
                         '$var_req' AS TP_REQUERENTE,
                         '$var_user_logado' AS CD_USUARIO_CADASTRO,
                         SYSDATE AS HR_CADASTRO,
                         NULL CD_USUARIO_ULT_ALT,
                         SYSDATE HR_ULT_ALT
                         FROM DUAL";

$result_oracle = oci_parse($conn_ora,$consulta_oracle);

$valida = oci_execute($result_oracle);

if(!$valida){

    $erro =  oci_error($result_oracle);
    $_SESSION['msgerro'] = htmlentities($erro['message']);

}else{

    $_SESSION['msg'] = 'Cadastrado com sucesso!';
}


header("Location:../estrutura_configuracoes.php");


?>