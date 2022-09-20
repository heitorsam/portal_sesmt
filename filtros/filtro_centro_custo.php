<?php

include '../../conexao.php';

$cons_cc= "SELECT st.CD_SETOR,
                  st.NM_SETOR
           FROM dbamv.SETOR st
           WHERE st.SN_ATIVO = 'S'
           ORDER BY st.NM_SETOR ASC";

$rest_cons_cc = oci_parse($conn_ora, $cons_cc);

oci_execute($rest_cons_cc);

$row_cc = oci_fetch_array($rest_cons_cc);

?>

Centro de Custo:
<select name="frm_cc" id="frm_id_cc" class='form-control' onchange="atualiza_cc()">>

        <?php while($row_cc = oci_fetch_array($rest_cons_cc)){

            echo '<option value="' . $row_cc['CD_SETOR'] . '" >' .  $row_cc['NM_SETOR'] . '</option>';

        }
        ?>

</select>
