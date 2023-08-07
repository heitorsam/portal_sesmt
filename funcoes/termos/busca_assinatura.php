<?php

    include '../../conexao.php';

    $usuario_busca = $_GET['usuario_busca'];

    $cons_buscar_assinatura = "SELECT term.BLOB_ASSIN_TERMO
                               FROM portal_sesmt.ASSINATURA_TERMO term
                               WHERE term.CRACHA_SOLICITANTE = '$usuario_busca'";

    $res_busca_assinatura = oci_parse($conn_ora, $cons_buscar_assinatura);
    $valida = oci_execute($res_busca_assinatura);

    if (!$valida) {

        echo $cons_buscar_assinatura;

    } else {

        $row = oci_fetch_assoc($res_busca_assinatura);

        // Obtenha o conteúdo do BLOB usando o método read do OCI-Lob
        $assinaturaBlob = $row['BLOB_ASSIN_TERMO']->load();
    
        // Converta o conteúdo do BLOB em uma string base64
        $assinaturaBase64 = base64_encode($assinaturaBlob);
    
        echo $assinaturaBase64;
    }

?>