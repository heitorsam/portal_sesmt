<?php

include 'conexao.php';

$cons_cc_relatorio= "SELECT st.CD_SETOR,
                            st.NM_SETOR
                     FROM dbamv.SETOR st
                     WHERE st.SN_ATIVO = 'S'
                     ORDER BY st.NM_SETOR ASC";

$rest_cons_cc_relatorio = oci_parse($conn_ora, $cons_cc_relatorio);

oci_execute($rest_cons_cc_relatorio);

//$row_cc_relatorio = oci_fetch_array($rest_cons_cc_relatorio);

?>

Centro de Custo:
<select name="frm_rel_cc" id="frm_rel_id_cc" class='form-control' onchange="constroi_usu_setor()">

    <?php echo '<option value="all">Todos</option>';?>

    <?php 

        while($row_cc_relatorio = oci_fetch_array($rest_cons_cc_relatorio)){

            echo '<option value="' . $row_cc_relatorio['CD_SETOR'] . '" >' .  $row_cc_relatorio['NM_SETOR'] . '</option>';

        }

    
    ?>

</select>