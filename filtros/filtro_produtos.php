<?php

if(basename($_SERVER['PHP_SELF']) != 'durabilidade.php'){
        include '../../conexao.php';
}else{
        include 'conexao.php';
}


$cons_produtos= "SELECT prod.CD_PRODUTO, 
                        prod.DS_PRODUTO, 
                        SUBSTR( prod.DS_PRODUTO,
                        INSTR( prod.DS_PRODUTO, '(CA') + 1,
                        INSTR( prod.DS_PRODUTO, ')') - INSTR( prod.DS_PRODUTO, '(CA') - 1) AS CA
                FROM dbamv.PRODUTO prod
                WHERE prod.DS_PRODUTO LIKE '%(CA %'
                AND prod.TP_ATIVO = 'S'";

if(basename($_SERVER['PHP_SELF']) == 'durabilidade.php'){
        $cons_produtos .= "AND prod.CD_PRODUTO NOT IN (SELECT CD_PRODUTO_MV FROM portal_sesmt.DURABILIDADE)";
}

$cons_produtos .= "ORDER BY prod.DS_PRODUTO ASC";

$rest_cons_produtos = oci_parse($conn_ora, $cons_produtos);

oci_execute($rest_cons_produtos);

$row_prod = oci_fetch_array($rest_cons_produtos);

//INCLUIR VALIDA

?>


Produto:
<select name="frm_cd_produtos" id="frm_id_produtos" class='form-control' <?php if(basename($_SERVER['PHP_SELF']) != 'durabilidade.php'){ ?> onchange="ajax_encontrar_durabilidade()" <?php } ?>>

<?php echo '<option value="">Selecione</option>';?>

<?php 
        while($row_prod = oci_fetch_array($rest_cons_produtos)){

                echo '<option value="' . $row_prod['CD_PRODUTO'] . '" >' .  $row_prod['DS_PRODUTO'] . '</option>';

        }
?>

</select>