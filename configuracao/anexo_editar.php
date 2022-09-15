<?php

session_start();

include '../conexao.php';

echo $var_tipdoc = $_POST['frm_tpdoc'];
echo $var_descri = $_POST['frm_desc'];
echo $var_obrig= $_POST['frm_obg'];
echo $var_motiv = $_POST['frm_mot'];
echo $var_parent = $_POST['frm_par'];
echo $var_dista = $_POST['frm_dist'];
echo $var_reque = $_POST['frm_req'];


$consulta_editar = "UPDATE portal_same.tp_documento_anexo tda
                        SET tda.DS_DOCUMENTO = '$var_descri',
                            tda.TP_OBRIGATORIO = '$var_obrig',
                            tda.TP_PARENTE_MOTIVO ='$var_motiv',
                            tda.TP_PARENTE_PARENTESCO ='$var_parent',
                            tda.TP_DISTANCIA = '$var_dista',
                            tda.TP_REQUERENTE = '$var_reque'
                      WHERE tda.TP_DOCUMENTO  ='$var_tipdoc'";

echo $consulta_editar;


$result_oracle = oci_parse($conn_ora,$consulta_editar);

$valida = oci_execute($result_oracle);

if(!$valida){

    $erro =  oci_error($result_oracle);
    $_SESSION['msgerro'] = htmlentities($erro['message']);

}else{

    $_SESSION['msg'] = 'editado com Sucesso!';
}


header("Location:../estrutura_configuracoes.php");


?>
