<?php 

//include 'conexao.php';

$var_centro_cust = $_GET['get_var_cc'];

$con_usu_oracle=   "SELECT  DISTINCT usu.CHAPA AS CD_USUARIO, usu.NM_FUNCIONARIO AS NM_USUARIO
                    FROM portal_sesmt.SOLICITACAO sol
                    INNER JOIN dbamv.STA_TB_FUNCIONARIO usu
                      ON RPAD(('00000' || TO_CHAR(CHAPA)), 11, 0) = LPAD(sol.CD_USUARIO_MV,11)
                    WHERE 1 = 1";

                    if($var_centro_cust <> 'all'){

                        $con_usu_oracle .= "AND sol.CD_SETOR_MV = '$var_centro_cust'";                   

                    }

                    $con_usu_oracle .= " ORDER BY usu.NM_FUNCIONARIO ASC";


$resultado_usu_oracle = oci_parse($conn_ora, $con_usu_oracle);

oci_execute($resultado_usu_oracle);

?>

Usuário:
<select name="frm_usu_rel" id="frm_id_usu_rel" class='form-control'>

    <?php echo '<option value="all">Todos</option>';?>

    <?php 

        while($row_usu_rel = oci_fetch_array($resultado_usu_oracle)){

            echo '<option value="' . $row_usu_rel['CD_USUARIO'] . '" >' .  $row_usu_rel['NM_USUARIO'] . '</option>';

        }  
    
    ?>

</select>
