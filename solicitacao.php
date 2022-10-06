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

            <!--DIV TABELA-->
            <table class="table table-striped" style="text-align: center">

                <thead>

                    <th>Solicitação</th>
                    <th>Usuário </th>
                    <th>Setor </th>
                    <th>Entrega</th>
                    <th>Código </th>
                    <th>Produto </th>
                    <th>C.A.</th>
                    <th>Durabilidade</th>
                    <th>Quantidade</th>
                    <th>Funcionário</th>
                    <th>Opções</th>

                </thead>

                <tbody id="corpo_tabela_realizadas"></tbody>

            </table>

    
<?php

    //RODAPE
    include 'rodape.php';
    include 'funcoes/js_editar_campos.php';
?>

<!--FUNÇÕES AJAX E JAVASCRIPT-->

<script>

    /*FUNÇÃO PESQUISA USUARIO PELO BEEP*/

    function pesquisar_usuario(){

        var_beep = document.getElementById('valor_beep').value;

        if('S' == '<?php echo $_SESSION['papel_sesmt_adm'] ?>'){
            if(var_beep != ''){

                document.getElementById('valor_beep').value =  var_beep.toUpperCase();

                tp = document.getElementById('slt_tipo').value

                $('#solicitacoes').load('funcoes/solicitacao/ajax_solicitacoes.php?cd_usuario='+ var_beep+'&tipo='+ tp);        

        
                corpo_tabela_realizadas();

                
            }else{

                document.getElementById('valor_beep').focus()
            }
        }else{

            document.getElementById('valor_beep').value =  var_beep.toUpperCase();


            $('#solicitacoes').load('funcoes/solicitacao/ajax_solicitacoes.php?cd_usuario='+ var_beep +'&tipo=N');        

            corpo_tabela_realizadas();
        }
    }

    /*FUNÇÃO ADICIONAR SOLICITAÇÕES*/

    function ajax_adicionar_sol(tipo){

        var var_beep = document.getElementById('valor_beep').value;
        var centro_c = document.getElementById('frm_id_cc').value;
        var cd_produto = document.getElementById('frm_id_produtos').value;
        var quantidade = document.getElementById('frm_qtd_sol').value;

        if(tipo == 'S'){
            data = document.getElementById('data').value
        }else{
            data = 'SYSDATE'
        }
        if(quantidade == '' || centro_c == '' || cd_produto == '' || data == '' ){

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
                    tipo: tipo
                    },
                cache: false,
                success: function(dataResult){

                    console.log(dataResult)

                    if(dataResult == 'Sucesso'){

                        //MENSAGEM            
                        var_ds_msg = 'Solicitacao%20cadastrada%20com%20sucesso!';
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


                    //$('#div_permissoes').load('funcoes/permissoes/ajax_permissoes.php?cd_usuario='+ usuario);
                    //$('#tabela_permissoes').load('funcoes/permissoes/ajax_tabela_permissoes.php?cd_usuario='+ usuario);
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

</script>
