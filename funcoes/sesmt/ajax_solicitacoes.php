
<?php

    include '../../conexao.php';
    
    $var_usu = $_GET['cd_usuario'];

    $consulta_oracle = "SELECT usu.NM_USUARIO,
                               usu.DS_OBSERVACAO AS DS_FUNCAO
                        FROM dbasgu.USUARIOS usu
                        WHERE usu.SN_ATIVO = 'S'
                        AND usu.CD_USUARIO = UPPER('$var_usu')";


    $resultado_con_oracle = oci_parse($conn_ora, $consulta_oracle);

    oci_execute($resultado_con_oracle);

    $row = oci_fetch_array($resultado_con_oracle);

?>

<div class="row">

    <!--COLABORADOR-->
    <div class="col-md-3">
        Colaborador:
        </br>
        <input type="text" id="frm_colab_sol" readonly value = "<?php echo $row['NM_USUARIO'] ?>" class="form-control"></input>
    </div>

    <!--FUNÇÃO-->
    <div class="col-md-4">
        Função:
        </br>
        <input type="text" id="frm_func_sol" readonly value = "<?php echo $row['DS_FUNCAO'] ?>" class="form-control"></input>
    </div>

    <!--CENTRO DE CUSTO-->
    <div class = "col-md-3">
 
        <?php
            
            include '../../filtros/filtro_centro_custo.php';
            
        ?>

    </div>

</div>

    <div class="div_br"> </div>

<div class = "row">

        <!--PRODUTOS-->
        <div class = "col-md-5">
            <?php

            include '../../filtros/filtro_produtos.php';

            ?>
        </div>
        
        <!--QUANTIDADE-->
        <div class = "col-md-2">
            Quantidade:
            </br>
            <input type = "text" id="frm_qtd_sol" class="form-control" autocomplete="off"></input>
        </div>

        <!--BOTÃO + -->
        <div class = "col-md-1" >

            </br>
            <button type = "submit" class="btn btn-primary" onclick="ajax_adicionar_sol()" ><i class="fa-solid fa-plus"></i></button>

        </div>

</div>
    
