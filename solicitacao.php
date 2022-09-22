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

                <div class='col-md-2'>
            
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

            <div class="div_br"></div>
            <h11><i class="fa-solid fa-check"></i> Realizadas</h11>

            <div class="div_br"></div>

            <table class="table table-striped" style="text-align: center">

                <thead>

                    <th>Produto </th>
                    <th>Descrição</th>
                    <th>C.A</th>
                    <th>Entrega</th>
                    <th>Funcionario</th>

                </thead>


            </table>

    <script>

        function pesquisar_usuario(){

            var_beep = document.getElementById('valor_beep').value;
            
            //alert(var_beep);

            $('#solicitacoes').load('funcoes/sesmt/ajax_solicitacoes.php?CD_USUARIO='+ var_beep)

        }

        function ajax_adicionar_sol(){

                var var_beep = document.getElementById('valor_beep').value;
                var centro_c = document.getElementById('frm_id_cc').value;
                var cd_produto = document.getElementById('frm_id_produtos').value;
                var quantidade = document.getElementById('frm_qtd_sol').value;

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

                    
                    //$('#tabela_permissoes').load('funcoes/permissoes/ajax_tabela_permissoes.php?cd_usuario='+ usuario);
                }
            });                    

        }























  
        
        //function atualiza_ca(){

            //var_ca = document.getElementsByName('frm_cd_produtos').value;

            //var select = document.getElementById("frm_id_produtos");
            //var opcaoTexto = select.options[select.selectedIndex].text; -- NÃO ESTAVA USANDO.
            //var opcaoValor = select.options[select.selectedIndex].value;

            //alert(opcaoValor);

            //document.getElementById("campo_ca"). value = opcaoValor.substring(3, 10);

        //}

    </script>


<?php
    //RODAPE
    include 'rodape.php';
?>

