<?php

include '../../conexao.php';

$var_prod_unidade = $_GET['cd_produto'];

$consulta_unidade_produto = "SELECT uni_pro.CD_UNI_PRO,
                                    uni_pro.DS_UNIDADE
                             FROM dbamv.uni_pro uni_pro  
                             WHERE cd_produto = $var_prod_unidade 
                             AND uni_pro.sn_ativo = 'S'";

$resultado_unidade_produto = @oci_parse($conn_ora,$consulta_unidade_produto);

@oci_execute(@$resultado_unidade_produto);

?>

Unidade:
<select name="frm_unid_pro" id="frm_id_unid_pro" class='form-control'>

    <?php 

        while($row_unid_prod  = oci_fetch_array($resultado_unidade_produto)){

            echo '<option value="' . $row_unid_prod['CD_UNI_PRO'] . '" >' .  $row_unid_prod['DS_UNIDADE'] . '</option>';

        }

    ?>

</select>

<script>

        document.getElementById('unidade').style.display = 'block';


</script>



