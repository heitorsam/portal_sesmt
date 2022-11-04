<?php 

session_start();
include '../../conexao.php';

print_r($_POST);

$var_usu_ass = $_SESSION['usuarioLogin'];
$image = $_POST['escond'];

$consulta_nextval = $_POST['cons_next'];

 // get the dataURL
 $dataURL = $_POST['escond'];  

 // the dataURL has a prefix (mimetype+datatype) 
 // that we don't want, so strip that prefix off
 $parts = explode(',', $dataURL);  
 $data = $parts[1];  

  // Decode base64 data, resulting in an image
  $image = base64_decode($data); 

$cons_insert_blob_ass = "INSERT INTO portal_sesmt.ASSINATURA 
                        (CD_ASSINATURA, CD_SOLICITACAO_MV, BLOB_ASS, CD_USUARIO_CADASTRO, HR_CADASTRO, CD_USUARIO_ULT_ALT, HR_ULT_ALT
                        )
                        VALUES 
                        (portal_sesmt.SEQ_CD_ASSINATURA.NEXTVAL, $consulta_nextval, empty_blob(), '$var_usu_ass', SYSDATE, NULL, SYSDATE
                        ) 
                        RETURNING BLOB_ASS INTO :image";

$res_insert_blob_ass = oci_parse($conn_ora, $cons_insert_blob_ass);

$blob = oci_new_descriptor($conn_ora, OCI_D_LOB);
oci_bind_by_name($res_insert_blob_ass, ":image", $blob, -1, OCI_B_BLOB);

$valida_blob = oci_execute($res_insert_blob_ass, OCI_DEFAULT);

if(!$blob->save($image)) {
    oci_rollback($conn_ora);
}
else {
    oci_commit($conn_ora);
}

oci_free_statement($res_insert_blob_ass);
$blob->free();


if(!$valida_blob){

    $erro = oci_error($res_insert_blob_ass);																							
    $msg_erro = htmlentities($erro['message']);
    //header("Location: $pag_login");
    echo $msg_erro;

  } else{
    
      echo '1' ;
  }


?>

<?php
/*
@$var_cd_documento_requerente = $_POST['cd_documento_requerente'];

$image = $_POST['escondidinho'];

$var_user_logado = $_SESSION['usuarioLogin'];

//echo $_POST['escondidinho'];

 // get the dataURL
 $dataURL = $_POST["escondidinho"];  

 // the dataURL has a prefix (mimetype+datatype) 
 // that we don't want, so strip that prefix off
 $parts = explode(',', $dataURL);  
 $data = $parts[1];  

 // Decode base64 data, resulting in an image
 $image = base64_decode($data); 

///////////////////////
//Inserindo no banco///
///////////////////////
$consulta_insert = 
"INSERT INTO portal_same.ASSINATURA_PACIENTE
(CD_DOCUMENTO_REQUERENTE, DT_COLETA, CD_USUARIO_COLETA, ASSINATURA_PACIENTE)
VALUES 
($var_cd_documento_requerente, SYSDATE,'$var_user_logado', empty_blob()) 
RETURNING ASSINATURA_PACIENTE INTO :image";

//echo $consulta_insert;
$insere_dados = oci_parse($conn_ora, $consulta_insert);
$blob = oci_new_descriptor($conn_ora, OCI_D_LOB);
oci_bind_by_name($insere_dados, ":image", $blob, -1, OCI_B_BLOB);

oci_execute($insere_dados, OCI_DEFAULT);

if(!$blob->save($image)) {
    oci_rollback($conn_ora);
}
else {
    oci_commit($conn_ora);
}

oci_free_statement($insere_dados);
$blob->free();

*/
?>
