
<?php

    include '../../conexao.php';
    
    $var_usu = $_GET['cd_usuario'];

    $consulta_oracle = "SELECT usu.NM_USUARIO,
                               usu.DS_OBSERVACAO AS DS_FUNCAO
                        FROM dbasgu.USUARIOS usu
                        WHERE usu.SN_ATIVO = 'S'
                        AND usu.CD_USUARIO = UPPER('$var_usu')";


    $resultado_con_oracle = oci_parse($conn_ora, $consulta_oracle);

    $valida = oci_execute($resultado_con_oracle);

    $row = oci_fetch_array($resultado_con_oracle);
    
?>

<div class="row">

    <!--COLABORADOR-->
    <div class="col-md-3">
        Colaborador:
        </br>
        <input type="text" id="frm_colab_sol" readonly value = "<?php echo @$row['NM_USUARIO'] ?>" class="form-control"></input>
    </div>

    <!--FUNÇÃO-->
    <div class="col-md-4">
        Função:
        </br>
        <input type="text" id="frm_func_sol" readonly value = "<?php echo @$row['DS_FUNCAO'] ?>" class="form-control"></input>
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

        <!--DURABILIDADE-->
        <div class = "col-md-2">
            Durabilidade:
            </br>
            <input type = "text" id="frm_id_durabilidade" class="form-control" autocomplete="off" disabled></input>
        </div>
        
        <!--QUANTIDADE-->
        <div class = "col-md-2">
            Quantidade:
            </br>
            <input type = "number" type="number" min="0" id="frm_qtd_sol" class="form-control" autocomplete="off"></input>
        </div>

        <?php if(@$_GET['tipo'] == 'S'){ ?>
            <div class="col-md-2">
                Dia:
                </br>
                <input type="datetime-local" id="data" class="form-control">
            </div>
        <?php } ?>
        <!--BOTÃO + -->
        <div class = "col-md-1" >

            </br>
            <button type = "submit" class="btn btn-primary" onclick="ajax_adicionar_sol('<?php echo $_GET['tipo'] ?>')" ><i class="fa-solid fa-plus"></i></button>

        </div>

</div>
    

<script>
    
    var_usu_sol = document.getElementById('frm_colab_sol').value;     

    if(var_usu_sol != ''){

        //MENSAGEM            
        var_ds_msg = 'Usuario%20encontrado!';
        var_tp_msg = 'alert-success';
        //var_tp_msg = 'alert-danger';
        //var_tp_msg = 'alert-primary';
        $('#mensagem_acoes').load('funcoes/sesmt/ajax_mensagem_acoes.php?ds_msg='+var_ds_msg+'&tp_msg='+var_tp_msg); 
    
    }else{

            //MENSAGEM            
            var_ds_msg = 'Usuario%20não%20encontrado!';
        //var_tp_msg = 'alert-success';
        var_tp_msg = 'alert-danger';
        //var_tp_msg = 'alert-primary';
        $('#mensagem_acoes').load('funcoes/sesmt/ajax_mensagem_acoes.php?ds_msg='+var_ds_msg+'&tp_msg='+var_tp_msg); 

    }        


</script>