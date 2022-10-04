<?php

include '../../conexao.php';

$produto_enc_dur = $_POST['produto'];


$consulta_encontrar_durabilidade = "SELECT CASE 
                                                WHEN  dur.DIAS < 2 THEN   dur.DIAS  || ' Dia'
                                                WHEN  dur.DIAS >= 2 THEN  dur.DIAS  || ' Dias'
                                                
                                                ELSE ''
                                            END AS DIAS
                                         FROM portal_sesmt.DURABILIDADE dur 
                                         WHERE dur.CD_PRODUTO_MV = '$produto_enc_dur'";

$resultado_con_encontrar_durabilidade = oci_parse($conn_ora, $consulta_encontrar_durabilidade);

oci_execute($resultado_con_encontrar_durabilidade);

$row_dur_prod = oci_fetch_array($resultado_con_encontrar_durabilidade);

echo $row_dur_prod['DIAS'];

?>