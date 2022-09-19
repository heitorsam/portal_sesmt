
<?php

    include '../../conexao.php';

    $var_usu = $_GET['CD_USUARIO'];


    $consulta_oracle = "SELECT      usu.NM_USUARIO,
                                    usu.DS_OBSERVACAO AS DS_FUNCAO
                                    FROM dbasgu.USUARIOS usu
                                    WHERE usu.SN_ATIVO = 'S'
                                    AND usu.CD_USUARIO = '$var_usu'";


    $resultado_con_oracle = oci_parse($conn_ora, $consulta_oracle);

    oci_execute($resultado_con_oracle);

    $row = oci_fetch_array($resultado_con_oracle);

?>

<div class="row">


    <div class="col-md-3">
        Colaborador:
        <div class='espaco_vertical'></div>
        <input type="text" readonly value = "<?php echo $row['NM_USUARIO'] ?>" class="form-control">
    </div>

    <div class="col-md-3">
        Função:
        <div class='espaco_vertical'></div>
        <input type="text" readonly value = "<?php echo $row['DS_FUNCAO'] ?>" class="form-control">
    </div>

</div>