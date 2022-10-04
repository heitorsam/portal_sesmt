<?php 
    //CABECALHO
    include 'cabecalho.php';

    //ACESSO ADM
    include 'acesso_restrito_sesmt.php';

    //CONEXÃO
    include 'conexao.php';
?>

    <div class="div_br"> </div>

    <!--MENSAGENS-->
    <?php
        include 'js/mensagens.php';
        include 'js/mensagens_usuario.php';
    ?>

    <h11><i class="fa-solid fa-square-plus efeito-zoom"></i> Durabilidade</h11>
    <div class='espaco_pequeno'></div>
    <h27><a href="home.php" style="color: #444444; text-decoration: none;"><i class="fa fa-reply efeito-zoom" aria-hidden="true"></i> Voltar</a></h27>


    <div class="div_br"> </div>

    <!-- CONTEUDO -->
    <div class='espaco_vertical'></div>


    <div class='row'>

        <div class='col-md-3'>

            <?php
            
             include 'filtros/filtro_produtos_durabilidade.php';
            
            ?>

        </div>

        <div class='col-md-2'>

            Durabilidade:
            <input type='text' id='frm_dias_dur'class='form-control' placeholder='Dias'></input>

        </div>

        <div class='col-md-1'>

         </br>
         <button type='submit' class='btn btn-primary' onclick= "ajax_adicionar_durabilidade()"><i class="fa-solid fa-plus"></i></button>

        </div>

    </div>

    <!--CAIXA PARA VALIDACAO DO AJAX -->
    <input id='msg' style='width: 100%' hidden>

     <!--DIV MENSAGEM ACOES-->
     <div id="mensagem_acoes"></div>

    <div class="div_br"></div>
    <h11><i class="fa-solid fa-bars efeito-zoom"></i> Produtos</h11>

    <div class="div_br"></div>
    <table class="table table-striped" style="text-align: center">

        <thead>

            <th>Código Durabilidade</th>
            <th>Código Produto</th>
            <th>Nome Produto</th>
            <th>C.A </th>
            <th>Durabilidade</th>
            <th>Opções </th>
    
        </thead>

        <tbody id="tabela_durabilidade"></tbody>

    </table>
    
    <script>

        /*AO TERMINAR DE CARREGAR A PAGINA*/
        $(document).ready(function(){
            ajax_tabela_durabilidade();
        });


        // FUNÇÃO ADICIONAR DURABILIDADE ( CADASTRO ) //
        function ajax_adicionar_durabilidade(){

            var var_produto_dur = document.getElementById('frm_id_produtos_dur').value;
            var var_dias_dur = document.getElementById('frm_dias_dur').value;

            if (var_produto_dur == '' || var_dias_dur == ''){

                var_ds_msg = 'Necessário%20preencher%20os%20campos!';
                var_tp_msg = 'alert-danger';
                $('#mensagem_acoes').load('funcoes/sesmt/ajax_mensagem_acoes.php?ds_msg='+var_ds_msg+'&tp_msg='+var_tp_msg);

            }else{

                $.ajax({

                    url: "funcoes/sesmt/ajax_cad_durabilidade.php",
                    type: "POST",
                    data: {
                    
                        produto_durabilidade: var_produto_dur,
                        dias_durabilidade:    var_dias_dur

                    },
                    cache: false,
                    success: function(dataResult){

                        if(dataResult == 'Sucesso'){                           
                            
                            //MENSAGEM            
                            var_ds_msg = 'Durabilidade%20cadastrada%20com%20sucesso!';
                            var_tp_msg = 'alert-success';
                            //var_tp_msg = 'alert-danger';
                            //var_tp_msg = 'alert-primary';
                            $('#mensagem_acoes').load('funcoes/sesmt/ajax_mensagem_acoes.php?ds_msg='+var_ds_msg+'&tp_msg='+var_tp_msg); 

                                                
                        }else{

                            //MENSAGEM            
                            var_ds_msg = dataResult.replace(/\s+/g, '-');
                            var_tp_msg = 'alert-danger';
                            //var_tp_msg = 'alert-primary';
                            $('#mensagem_acoes').load('funcoes/sesmt/ajax_mensagem_acoes.php?ds_msg='+var_ds_msg+'&tp_msg='+var_tp_msg); 

                            
                        }

                        //ALIMENTANDO INPUT MSG
                        //document.getElementById('msg').value = dataResult;   

                        ajax_tabela_durabilidade();


                    }
                });
            }
        }

        // FUNÇÃO EXIBIR CADASTRO DURABILIDADE //

        function ajax_tabela_durabilidade(){

            var_produto = document.getElementById('frm_id_produtos_dur').value

            $('#tabela_durabilidade').load('funcoes/sesmt/ajax_tabela_durabilidade.php?cd_produto='+ var_produto)

        }

         // FUNÇÃO DELETAR CADASTRO DURABILIDADE //

         
        function ajax_deletar_realizadas(cd_durabilidade){

            //var usuario = document.getElementById('input').value;
            resultado = confirm("Deseja excluir a observação?");

            if(resultado == true){
                $.ajax({
                    url: "funcoes/sesmt/ajax_deletar_durabilidade.php",
                    type: "POST",
                    data: {
                        durabilidade: cd_durabilidade
                        },
                    cache: false,
                    success: function(dataResult){

                        console.log(dataResult)

                        var_produto_dur = document.getElementById('frm_id_produtos_dur').value;

                        //alert(dataResult);

                        //alert(var_beep);
                        //MENSAGEM            
                        var_ds_msg = 'Durabilidade%20excluída%20com%20sucesso!';
                        var_tp_msg = 'alert-success';
                        //var_tp_msg = 'alert-danger';
                        //var_tp_msg = 'alert-primary';
                        $('#mensagem_acoes').load('funcoes/sesmt/ajax_mensagem_acoes.php?ds_msg='+var_ds_msg+'&tp_msg='+var_tp_msg);


                        $('#tabela_durabilidade').load('funcoes/sesmt/ajax_tabela_durabilidade.php?cd_produto='+ var_produto)


                    }
                });   
            }
            }



    </script>


<?php
    //RODAPE
    include 'rodape.php';
?>