<?php


if(basename($_SERVER['PHP_SELF']) == 'relatorio.php'){
        include 'conexao.php';
}else{
    include '../../conexao.php';
}


$cons_cc_relatorio= "SELECT st.CD_SETOR,
                            st.NM_SETOR
                     FROM dbamv.SETOR st
                     WHERE st.SN_ATIVO = 'S'
                     AND st.CD_MULTI_EMPRESA = 1    
                     ORDER BY st.NM_SETOR ASC";

$rest_cons_cc_relatorio = oci_parse($conn_ora, $cons_cc_relatorio);

oci_execute($rest_cons_cc_relatorio);

//$row_cc_relatorio = oci_fetch_array($rest_cons_cc_relatorio);

?>

Centro de Custo:
<select name="frm_cc" id="frm_id_cc" class='form-control' <?php if(basename($_SERVER['PHP_SELF']) == 'relatorio.php'){ ?> onchange="constroi_usu_setor()" <?php } ?>>

    <?php echo '<option value="all">Todos</option>';?>

    <?php 

        while($row_cc_relatorio = oci_fetch_array($rest_cons_cc_relatorio)){

            echo '<option value="' . $row_cc_relatorio['CD_SETOR'] . '" >' .  $row_cc_relatorio['NM_SETOR'] . '</option>';

        }

    
    ?>

</select>