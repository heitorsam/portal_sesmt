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

    <h11><i class="fas fa-file-import"></i> Solicitações</h11>
    <div class='espaco_pequeno'></div>
    <h27><a href="home.php" style="color: #444444; text-decoration: none;"><i class="fa fa-reply" aria-hidden="true"></i> Voltar</a></h27>

    <div class="div_br"> </div>    

    <!-- CONTEUDO -->
            <div class='row'>

                <div class='col-md-3'>
            
                    Usuário:
                    </br>
                    <input type="text" name="frm_usu_sol" id="valor_beep" class="form-control" onchange = "pesquisar_usuario()" autocomplete = "off" maxlength="12">  

                </div>

            </div>
                
            <div class="div_br"></div>
                
            <div id="solicitacoes"></div>

            <div class="div_br"></div>
               
            <!--CAIXA PARA VALIDACAO DO AJAX -->
            <input id='msg' style='width: 100%' hidden>

            <!--DIV MENSAGEM ACOES-->
            <div id="mensagem_acoes"></div>
            
             <!--DIV TITULO REALIZADAS-->
            <div class="div_br"></div>
            <h11><i class="fa-solid fa-bars"></i> Realizadas</h11>

            <div class="div_br"></div>

            <!--DIV TABELA-->
            <table class="table table-striped" style="text-align: center">

                <thead>

                    <th>Solicitação</th>
                    <th>Usuário </th>
                    <th>Entrega</th>
                    <th>Código </th>
                    <th>Produto </th>
                    <th>C.A</th>
                    <th>Quantidade</th>
                    <th>Funcionário</th>
                    <th>Opções</th>

                </thead>

                <tbody id="corpo_tabela_realizadas"></tbody>

            </table>

    <!--FUNÇÕES AJAX E JAVASCRIPT-->

    <script>

        /*FUNÇÃO PESQUISA USUARIO PELO BEEP*/
        
        function pesquisar_usuario(){

            var_beep = document.getElementById('valor_beep').value;

            document.getElementById('valor_beep').value =  var_beep.toUpperCase();

            $('#solicitacoes').load('funcoes/sesmt/ajax_solicitacoes.php?cd_usuario='+ var_beep);

            //MENSAGEM            
            var_ds_msg = 'Usuário%20encontrado!';
            var_tp_msg = 'alert-primary';
            $('#mensagem_acoes').load('funcoes/sesmt/ajax_mensagem_acoes.php?ds_msg='+var_ds_msg+'&tp_msg='+var_tp_msg);

            corpo_tabela_realizadas();          
        }

        /*FUNÇÃO ADICIONAR SOLICITAÇÕES*/

        function ajax_adicionar_sol(){

            var var_beep = document.getElementById('valor_beep').value;
            var centro_c = document.getElementById('frm_id_cc').value;
            var cd_produto = document.getElementById('frm_id_produtos').value;
            var quantidade = document.getElementById('frm_qtd_sol').value;

            if(quantidade == '' || centro_c == '' || cd_produto == '' ){

                var_ds_msg = 'Necessário%20preencher%20os%20campos!';
                var_tp_msg = 'alert-danger';
                $('#mensagem_acoes').load('funcoes/sesmt/ajax_mensagem_acoes.php?ds_msg='+var_ds_msg+'&tp_msg='+var_tp_msg);

            }else{

                //alert(cd_produto);

                $.ajax({
                    url: "funcoes/sesmt/ajax_cad_sol.php",
                    type: "POST",
                    data: {
                        cd_setor: centro_c,
                        cd_produto: cd_produto,
                        quantidade: quantidade,
                        cd_usuario: var_beep
                        },
                    cache: false,
                    success: function(dataResult){
                        //alert(dataResult);

                        //ALIMENTANDO INPUT MSG
                        document.getElementById('msg').value = dataResult;                 
                        
                        //MENSAGEM            
                        var_ds_msg = 'Solicitação%20cadastrada%20com%20sucesso!';
                        var_tp_msg = 'alert-success';
                        //var_tp_msg = 'alert-danger';
                        //var_tp_msg = 'alert-primary';
                        $('#mensagem_acoes').load('funcoes/sesmt/ajax_mensagem_acoes.php?ds_msg='+var_ds_msg+'&tp_msg='+var_tp_msg);

                        corpo_tabela_realizadas();
                    }
                }); 
            
            }

        }

        /*FUNÇÃO CRIAR CORPO DA TABELA*/

        function corpo_tabela_realizadas(){

            var_beep = document.getElementById('valor_beep').value;

            //alert(var_beep);

            $('#corpo_tabela_realizadas').load('funcoes/sesmt/ajax_corpo_tabela_realizadas.php?cd_usuario='+ var_beep)

        }
        
        /*FUNÇÃO DELETAR ITEM DA TABELA*/

        function ajax_deletar_realizadas(cd_solicitacao){

            //var usuario = document.getElementById('input').value;

            resultado = confirm("Deseja excluir a observação?");

            if(resultado == true){
                $.ajax({
                    url: "funcoes/sesmt/ajax_deletar_realizadas.php",
                    type: "POST",
                    data: {
                        solicitacao: cd_solicitacao
                        },
                    cache: false,
                    success: function(dataResult){

                        var_beep = document.getElementById('valor_beep').value;

                        //alert(dataResult);

                        //alert(var_beep);
                        //MENSAGEM            
                        var_ds_msg = 'Solicitação%20excluída%20com%20sucesso!';
                        var_tp_msg = 'alert-success';
                        //var_tp_msg = 'alert-danger';
                        //var_tp_msg = 'alert-primary';
                        $('#mensagem_acoes').load('funcoes/sesmt/ajax_mensagem_acoes.php?ds_msg='+var_ds_msg+'&tp_msg='+var_tp_msg);



                        $('#corpo_tabela_realizadas').load('funcoes/sesmt/ajax_corpo_tabela_realizadas.php?cd_usuario='+ var_beep)


                        //$('#div_permissoes').load('funcoes/permissoes/ajax_permissoes.php?cd_usuario='+ usuario);
                        //$('#tabela_permissoes').load('funcoes/permissoes/ajax_tabela_permissoes.php?cd_usuario='+ usuario);
                    }
                });   
            }
        }

    </script>

<?php
    //RODAPE
    include 'rodape.php';
?>

