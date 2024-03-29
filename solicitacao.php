<?php 
    //CABECALHO
    include 'cabecalho.php';

    //ACESSO ADM
    include 'acesso_restrito_sesmt.php';

?>




    <div class="div_br"> </div>

    <!--MENSAGENS-->
    <?php
        include 'js/mensagens.php';
        include 'js/mensagens_usuario.php';
    ?>  

    <h11><i class="fas fa-file-import efeito-zoom"></i> Solicitações</h11>
    <div class='espaco_pequeno'></div>
    <h27><a href="home.php" style="color: #444444; text-decoration: none;"><i class="fa fa-reply efeito-zoom" aria-hidden="true"></i> Voltar</a></h27>

    <div class="div_br"> </div>    

    <!-- CONTEUDO -->
            <div class='row'>

                <div class='col-md-3'>
            
                    Usuário:
                    </br>
                    <input type="text" name="frm_usu_sol" id="valor_beep" class="form-control" onchange = "pesquisar_usuario()" autocomplete = "off" maxlength="12">  

                </div>

                <?php if($_SESSION['papel_sesmt_adm'] == 'S'){ ?>
                <div class="col-md-2">

                    Tipo:
                    </br>
                    <select class="form-control" onchange="pesquisar_usuario()" id="slt_tipo">
                        <option value="N">Solicitação</option>
                        <option value="S">Histórico</option>
                    </select>

                </div>
                <?php } ?>

            </div>
                
            <div class="div_br"></div>
                
            <div id="solicitacoes"></div>

            <div class="div_br"></div>
               
            <!--CAIXA PARA VALIDACAO DO AJAX -->
            <input id='msg' style='width: 100%' hidden>

            <!--DIV MENSAGEM ACOES-->
            <div id="mensagem_acoes"></div>

            <!--DIV DURABILIDADE-->
            <div id="mensagem_durabilidade"></div>

             <!--DIV TITULO REALIZADAS-->
            <div class="div_br"></div>
            <h11><i class="fa-solid fa-bars efeito-zoom"></i> Realizadas</h11>

            <div class="div_br"></div>
            
                <!--BOTÃO SOLICITAR MV -->
               <button id="btn_mv" type="submit" style='float:right; display: none;'class="btn btn-primary" onclick="solicitar_mv_ass()"><i style="padding-top: 4px; padding-right:5px;" class="fa-solid fa-paper-plane "></i>Solicitar MV</button>
               <div class="div_br"></div>
               <div class="div_br"></div>
               <div class="div_br"></div>
     

            <!--DIV TABELA-->
            <table class="table table-striped" style="text-align: center">

                <thead>

                    <th> Solicitação </th>
                    <th>Usuário </th>
                    <th>Setor </th>
                    <th>Entrega</th>
                    <th>Código </th>
                    <th>Produto </th>
                    <th>            C.A.            </th>
                    <th>Durabilidade</th>
                    <th>Quantidade</th>
                    <th>Unidade</th>
                    <th>Funcionário</th>
                    <th>Opções</th>
                    <th>      MV      </th>

                </thead>

                <tbody id="corpo_tabela_realizadas"></tbody>

            </table>

    
<?php

    //RODAPE
    include 'rodape.php';
    include 'funcoes/js_editar_campos.php';
?>

<!--MODAL-->
<div class="modal fade bd-example-modal-sm" id="exibe_solsai" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
 
    <div class="modal-dialog modal-dialog-centered modal-sm">

        <div class="modal-content">

                <div style="margin: 0 auto;" class="modal-header">

                    <h5 style="font-size: 60px !important; padding: 20px;" class="modal-title" id="div_cd_solsai_pro"></h5>

                </div>
        </div>

    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exibe_modal_img" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">

                        <?php
                            echo "<div class='alert_pers_amarelo' style='width: 165%; align: center !important;'>
                            <strong><i class='fa-solid fa-triangle-exclamation'></i></strong> 
                            ATENÇÃO, ZACALAURO NA SUA TELA!
                            </div>";
                        ?>

                </h5>
                <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>-->
            </div>
        <div class="modal-body">

        <?php

            echo '<div style=" width: 50%; margin: 0 auto !important;"><img alt="imagem" src="img/outros/ZACALAURO.jpeg"</div>';

        ?>

        </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <!--<button type="button" class="btn btn-primary">Fechar</button>-->

            </div>
        </div>
    </div>
</div>


<!--FUNÇÕES AJAX E JAVASCRIPT-->

<script>

    var_contador = 0;
    var_contador_menu = 0;

    function conta_click(opc){

        if(opc == '1'){

            var_contador = var_contador + 1;

        } else if(opc == '2'){

            var_contador_menu = var_contador_menu + 1;

        }

        if(var_contador >= '10' && var_contador_menu >= 3 ){

            var_promt = prompt('Digite o valor!');

            if(var_promt =='ZACALAURO'){

                //alert('ZACALAURO');
                
                $('#exibe_modal_img').modal('show');

            } else if(var_promt =='PIUI'){

                alert('PIUI');
                
                $('#exibe_modal_img').modal('show');
            }

        }

    }


    /*FUNÇÃO PESQUISA USUARIO PELO BEEP*/

    function pesquisar_usuario(){

        var_beep = document.getElementById('valor_beep').value;

        if(var_beep != ''){

            document.getElementById('valor_beep').value =  var_beep.toUpperCase();

            tp = document.getElementById('slt_tipo').value

            $('#solicitacoes').load('funcoes/solicitacao/ajax_solicitacoes.php?cd_usuario='+ var_beep+'&tipo='+ tp);        

            limpar_pre_sol_mv();
    
            corpo_tabela_realizadas();               

        }else{

            document.getElementById('valor_beep').focus()
        }

    }


    /*FUNÇÃO ADICIONAR SOLICITAÇÕES*/

    function ajax_adicionar_sol(tipo){

        var var_beep = document.getElementById('valor_beep').value;
        var centro_c = document.getElementById('frm_id_cc').value;
        var cd_produto = document.getElementById('frm_id_produtos').value;
        var quantidade = document.getElementById('frm_qtd_sol').value;
        var uni_pro = document.getElementById('frm_id_unid_pro').value;
        var qt_est = document.getElementById('frm_id_estoque').value;

        if(tipo == 'N'){

            var ds_justificativa = document.getElementById('frm_Justificativa').value;

        }

        if(tipo == 'S'){
            data = document.getElementById('data').value
        }else{
            data = 'SYSDATE'
        }
        if(quantidade == '' || centro_c == '' || centro_c == 'all' || cd_produto == '' || data == '' ){

            var_ds_msg = 'Necessário%20preencher%20os%20campos!';
            var_tp_msg = 'alert-danger';
            $('#mensagem_acoes').load('funcoes/ajax_mensagem_acoes.php?ds_msg='+var_ds_msg+'&tp_msg='+var_tp_msg);

        }else{

            //alert(cd_produto);

            $.ajax({
                url: "funcoes/solicitacao/ajax_cad_sol.php",
                type: "POST",
                data: {
                    cd_setor: centro_c,
                    cd_produto: cd_produto,
                    quantidade: quantidade,
                    cd_usuario: var_beep,
                    data: data,
                    tipo: tipo,
                    cd_uni_pro: uni_pro,
                    ds_just: ds_justificativa,
                    qtd_estoque: qt_est
                    },
                cache: false,
                success: function(dataResult){

                    console.log(dataResult)

                    if(dataResult == 'Sucesso'){

                        //MENSAGEM            
                        var_ds_msg = 'Solicitação%20cadastrada%20com%20sucesso!';
                        var_tp_msg = 'alert-success';
                        //var_tp_msg = 'alert-danger';
                        //var_tp_msg = 'alert-primary';
                        $('#mensagem_acoes').load('funcoes/ajax_mensagem_acoes.php?ds_msg='+var_ds_msg+'&tp_msg='+var_tp_msg); 

                    }else{

                    //MENSAGEM            
                    var_ds_msg = dataResult.replace(/\s+/g, '-');
                    //var_tp_msg = 'alert-success';
                    var_tp_msg = 'alert-danger';
                    //var_tp_msg = 'alert-primary';
                    $('#mensagem_acoes').load('funcoes/ajax_mensagem_acoes.php?ds_msg='+var_ds_msg+'&tp_msg='+var_tp_msg); 

                    }

                    //alert(dataResult);
                    
                    //console.log(dataResult)

                    //ALIMENTANDO INPUT MSG
                    //document.getElementById('msg').value = dataResult;                 

                    corpo_tabela_realizadas();

                }
            }); 
        
        }

    };

    function salva_just(){

     $('#exampleModal').modal('hide');

    }

    /*FUNÇÃO CRIAR CORPO DA TABELA*/

    function corpo_tabela_realizadas(){

        var_beep = document.getElementById('valor_beep').value;

        //alert(var_beep);

        $('#corpo_tabela_realizadas').load('funcoes/solicitacao/ajax_corpo_tabela_realizadas.php?cd_usuario='+ var_beep)

    }

    /*FUNÇÃO DELETAR ITEM DA TABELA*/
    function ajax_deletar_realizadas(cd_solicitacao){

        //var usuario = document.getElementById('input').value;

        resultado = confirm("Deseja excluir a solicitação?");

        if(resultado == true){
            $.ajax({
                url: "funcoes/solicitacao/ajax_deletar_realizadas.php",
                type: "POST",
                data: {
                    solicitacao: cd_solicitacao
                    },
                cache: false,
                success: function(dataResult){

                    var_beep = document.getElementById('valor_beep').value;

                    //alert(dataResult);

                    console.log(dataResult)

                    //alert(var_beep);
                    //MENSAGEM            
                    var_ds_msg = 'Solicitação%20excluída%20com%20sucesso!';
                    var_tp_msg = 'alert-success';
                    //var_tp_msg = 'alert-danger';
                    //var_tp_msg = 'alert-primary';
                    $('#mensagem_acoes').load('funcoes/ajax_mensagem_acoes.php?ds_msg='+var_ds_msg+'&tp_msg='+var_tp_msg);

                    $('#corpo_tabela_realizadas').load('funcoes/solicitacao/ajax_corpo_tabela_realizadas.php?cd_usuario='+ var_beep)

                }

            });  

        }
    }


    function ajax_encontrar_durabilidade(){

        var select_prod = document.getElementById('frm_id_produtos').value;
        var campo_durabilidade = document.getElementById('frm_id_durabilidade').value;


            $.ajax({
                url: "funcoes/solicitacao/ajax_encontrar_durabilidade.php",
                type: "POST",
                data: {
                    produto: select_prod,
                    campo: campo_durabilidade
                
                    },
                cache: false,
                success: function(dataResult){

                    document.getElementById('frm_id_durabilidade').value = dataResult;
                    
                }
            }); 

            ajax_exibe_alert_durabilidade(); 
            ajax_selecionar_unidade();

            //Chama encontra estoque
            ajax_encontrar_estoque();
           
    }

    function ajax_exibe_alert_durabilidade(){

        tipo = document.getElementById('slt_tipo').value
        
        if(tipo == 'N'){

            var_alert_prod = document.getElementById('frm_id_produtos').value;
            var_beep = document.getElementById('valor_beep').value;
            
            //alert(var_beep);

            $('#mensagem_durabilidade').load('funcoes/solicitacao/ajax_exibe_alert_durabilidade.php?cd_usuario='+ var_beep+'&id_prod='+var_alert_prod+'&tipo='+ tipo)
        }else{
            
            $('#mensagem_durabilidade').load('funcoes/solicitacao/ajax_exibe_alert_durabilidade.php?tipo='+ tipo)
        }
    }

    function ajax_reset_ca(cd_solicitacao){
        resultado = confirm("Deseja excluir o C.A.?");

        if(resultado == true){
            $.ajax({
                url: "funcoes/solicitacao/ajax_reset_ca.php",
                type: "POST",
                data: {
                    cd_solicitacao: cd_solicitacao
                
                    },
                cache: false,
                success: function(dataResult){
                    document.getElementById('MV_CA'+ cd_solicitacao).innerHTML = dataResult;

                    
                }
            }); 
        }
    }

    function ajax_selecionar_unidade(){

        var_produto_unid = document.getElementById('frm_id_produtos').value;

        $('#unidade').load('funcoes/solicitacao/ajax_selecionar_unidade.php?cd_produto='+var_produto_unid)

    }

    var ult_cd_setor = 0;

    function ajax_pre_sol_mv(cd_solicitacao,cd_setor){

        //DESCHECANDO
        id_check = 'check_' + cd_solicitacao;        

        if(ult_cd_setor != cd_setor && ult_cd_setor != 0){

            //ADICIONAR AQUELA FUNCAO QUE DA MENSAGEM NO MEIO
            
            //MENSAGEM            
            var_ds_msg = 'Não%20é%20possivel%20cadastrar%20uma%20solicitação%20com%20setores%20divergentes!';
            //var_tp_msg = 'alert-success';
            var_tp_msg = 'alert-danger';
            //var_tp_msg = 'alert-primary';
            $('#mensagem_acoes').load('funcoes/ajax_mensagem_acoes.php?ds_msg='+var_ds_msg+'&tp_msg='+var_tp_msg);

            $('#corpo_tabela_realizadas').load('funcoes/solicitacao/ajax_corpo_tabela_realizadas.php?cd_usuario='+ var_beep)

            $('#'+id_check).prop("checked", false);

            count_exibe_btn_mv = 0;
            exibe_btn_mv('');

        }else{

            ult_cd_setor = cd_setor;

            var usu_pre_sol_mv  = document.getElementById('valor_beep').value;

            if (!document.getElementById(id_check).checked) {

                tp_acao = 'D';
                //alert(tp_acao);
                exibe_btn_mv('subtrair');

            }else{

                tp_acao = 'I';
                //alert(tp_acao);
                exibe_btn_mv('somar');
            }
           
            $.ajax({

                url: "funcoes/solicitacao/ajax_cadastrar_pre_sol_mv.php",
                type: "POST",
                data: {
                    usuario : usu_pre_sol_mv,
                    cd_sol: cd_solicitacao,
                    tp_acao: tp_acao
       
                    },
                cache: false,
                success: function(dataResult){
                    
                }

            });

        }

    }    
    
    function solicitar_mv_ass(){

        $('#exampleModalCenter').modal('show');
        
    }

    function limpar_pre_sol_mv(){

    var usu_limpa_mv  = document.getElementById('valor_beep').value;

        $.ajax({
            url: "funcoes/solicitacao/ajax_limpa_sol_mv.php",
            type: "POST",
            data: {
                usuario_limpa: usu_limpa_mv
            
                },
            cache: false,
            success: function(dataResult){

                //alert(dataResult);

                corpo_tabela_realizadas();
                
            }
        }); 
    }


    function ajax_modal_solsai(cd_sol_sai_pro){


        document.getElementById("div_cd_solsai_pro").innerHTML = cd_sol_sai_pro;

    }

    var count_exibe_btn_mv = 0;

    function exibe_btn_mv(acao){

        if(acao == 'somar'){

            count_exibe_btn_mv = count_exibe_btn_mv + 1;

        }

        if(acao == 'subtrair'){

            count_exibe_btn_mv = count_exibe_btn_mv - 1;
        }

        if(count_exibe_btn_mv >= 1){

            document.getElementById('btn_mv').style.display = 'flex';

        }else{

            document.getElementById('btn_mv').style.display = 'none';

        }

    }

    function ajax_encontrar_estoque(){

            var select_prod = document.getElementById('frm_id_produtos').value;

            //alert(select_prod);
        
            $.ajax({
                url: "funcoes/solicitacao/ajax_encontrar_estoque.php",
                type: "POST",
                data: {
                    produto: select_prod
                
                    },
                cache: false,
                success: function(dataResult){

                    document.getElementById('frm_id_estoque').value = dataResult;
                    
                }
            }); 

        
    }

</script>
