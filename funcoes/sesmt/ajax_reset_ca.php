<?php 

    include '../../conexao.php';

    $cd_solicitacao = $_POST['cd_solicitacao'];

    $update = "UPDATE portal_sesmt.editar_ca
    SET MV_CA =
        (SELECT  (SELECT SUBSTR(SUBSTR(prod.DS_PRODUTO,
                                     INSTR(prod.DS_PRODUTO, '(CA') + 1,
                                     INSTR(prod.DS_PRODUTO, ')') -
                                     INSTR(prod.DS_PRODUTO, '(CA') - 1),3,10) AS CA
                                     FROM dbamv.PRODUTO prod
                                     WHERE prod.DS_PRODUTO LIKE '%(CA %'
                                     AND prod.CD_PRODUTO = sol.CD_PRODUTO_MV
                                     ) AS CA_MV
           FROM portal_sesmt.solicitacao sol
          WHERE sol.cd_solicitacao =  $cd_solicitacao),
          EDITADO_SN = 'N'
          WHERE cd_solicitacao =  $cd_solicitacao
          ";

    $result_update = oci_parse($conn_ora,$update);

    oci_execute($result_update);

    $consulta_ca = "SELECT MV_CA FROM portal_sesmt.EDITAR_CA WHERE CD_SOLICITACAO = $cd_solicitacao";

    $result_ca = oci_parse($conn_ora, $consulta_ca);

    oci_execute($result_ca);

    $row_ca = oci_fetch_array($result_ca);

    echo $ca = $row_ca['MV_CA'];

?>