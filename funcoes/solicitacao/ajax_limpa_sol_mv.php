<?php

Session_start();
include '../../conexao.php';

$var_usu_sol = $_SESSION['usuarioLogin'];
$var_usu = $_POST['usuario_limpa'];


$cons_limpa_nome = "DELETE FROM portal_sesmt.PRE_SOL_MV psm WHERE psm.CD_USUARIO_MV = '$var_usu'";

$res_limpa_nome = oci_parse($conn_ora, $cons_limpa_nome);

$valida_limpa_nome = oci_execute($res_limpa_nome);


if(!$valida_limpa_nome){

    $erro = oci_erro($res_limpa_nome);
    $msg_erro = htmlentities($erro['message']);

    echo $msg_erro;

}else{

    echo 'Sucesso!';
}

?>


