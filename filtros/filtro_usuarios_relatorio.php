<?php 

//include 'conexao.php';

$var_centro_cust = $_GET['get_var_cc'];

$con_usu_oracle= "SELECT sol.CD_SETOR_MV,
                 usu.CD_USUARIO,
                 usu.NM_USUARIO
                 FROM dbasgu.USUARIOS usu
                 INNER JOIN portal_sesmt.SOLICITACAO sol
                    ON sol.CD_USUARIO_MV = usu.CD_USUARIO
                 WHERE usu.SN_ATIVO = 'S'
                 AND sol.CD_SETOR_MV = '$var_centro_cust'
                 ORDER BY usu.NM_USUARIO ASC";

                    
$resultado_usu_oracle = oci_parse($conn_ora, $con_usu_oracle);

oci_execute($resultado_usu_oracle);

$row_usu_rel = oci_fetch_array($resultado_usu_oracle);

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
