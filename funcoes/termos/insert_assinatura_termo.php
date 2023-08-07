<?php

    session_start();

    include '../../conexao.php';

    $usuario_logado = $_SESSION['usuarioLogin'];

    $cracha_solicitante = $_POST['cracha_solicitante'];
    $assinatura = $_POST['blob_assinatura_termo'];

    $dataURL = $_POST['blob_assinatura_termo']; 

    if ($assinatura != '') {

        $parts = explode(',', $dataURL);  
        $data = $parts[1];
    
        $image = base64_decode($data);

    } else {

        $image = '';

    }

    $query_insert_registro = "INSERT INTO portal_sesmt.ASSINATURA_TERMO 
    (CD_ASSINATURA_TERMO, CRACHA_SOLICITANTE, CD_USUARIO_MV_CADASTRO, HR_CADASTRO, CD_USUARIO_MV_ULT_ALT, HR_ULT_ALT, BLOB_ASSIN_TERMO)
    VALUES 
    (portal_sesmt.SEQ_ASSINATURA_TERMO.NEXTVAL, '$cracha_solicitante', '$usuario_logado', SYSDATE, NULL, NULL, EMPTY_BLOB()
    )
    RETURNING BLOB_ASSIN_TERMO INTO :image";

    $res = oci_parse($conn_ora, $query_insert_registro);

    $blob = oci_new_descriptor($conn_ora, OCI_D_LOB);
    oci_bind_by_name($res, ":image", $blob, -1, OCI_B_BLOB);

    $valida = oci_execute($res, OCI_DEFAULT);

    if(!$blob->save($image)){
    
        oci_rollback($conn_ora);

    }
    else {

        oci_commit($conn_ora);

    }

    oci_free_statement($res);
    $blob->free();

    if (!$valida) {

        echo $query_insert_registro;

    } else {

        echo "Sucesso";

    }

?>