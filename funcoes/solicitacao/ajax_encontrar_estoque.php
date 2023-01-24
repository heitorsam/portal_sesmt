<?php

include '../../conexao.php';

$produto_enc_est = $_POST['produto'];


$consulta_encontrar_estoque = "SELECT ep.QT_ESTOQUE_ATUAL * 1 AS QT_ESTOQUE_ATUAL
                               FROM dbamv.EST_PRO ep
                               WHERE ep.CD_ESTOQUE = 1
                               AND ep.CD_PRODUTO = '$produto_enc_est'";

$resultado_con_encontrar_estoque = oci_parse($conn_ora, $consulta_encontrar_estoque);

oci_execute($resultado_con_encontrar_estoque);

$row_dur_prod = oci_fetch_array($resultado_con_encontrar_estoque);

if (!isset($row_dur_prod['QT_ESTOQUE_ATUAL'])){

    echo 0;

}else{

   echo $row_dur_prod['QT_ESTOQUE_ATUAL'];

}



?>