<?php

include '../../conexao.php';

$cons_produtos= "SELECT prod.CD_PRODUTO, 
                        prod.DS_PRODUTO, 
                        SUBSTR( prod.DS_PRODUTO,
                        INSTR( prod.DS_PRODUTO, '(CA') + 1,
                        INSTR( prod.DS_PRODUTO, ')') - INSTR( prod.DS_PRODUTO, '(CA') - 1) AS CA
                FROM dbamv.PRODUTO prod
                WHERE prod.DS_PRODUTO LIKE '%(CA %'
                AND prod.TP_ATIVO = 'S'
                ORDER BY 2 ASC";

$rest_cons_produtos = oci_parse($conn_ora, $cons_produtos);

oci_execute($rest_cons_produtos);

$row_prod = oci_fetch_array($rest_cons_produtos);

?>

Produto:
<select name = "frm_cd_'produtos" class='form-control'>

        <?php while($row_prod = oci_fetch_array($rest_cons_produtos)){

            echo '<option value="' . $row_prod['CD_PRODUTO'] . '" >' .  $row_prod['DS_PRODUTO'] . '</option>';

        }
        ?>

</select>


