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
            <input type="text" id="valor_beep" class="form-control" onchange = "pesquisar_usuario()" autocomplete = "off" maxlength="12">  

        </div>

        

    </div>
    
    <div class="div_br">
        
        <div id="solicitacoes"></div>

    </div>





    <script>

        function pesquisar_usuario(){

            var_beep = document.getElementById('valor_beep').value;
            
            //alert(var_beep);

            $('#solicitacoes').load('funcoes/sesmt/ajax_solicitacoes.php?CD_USUARIO='+ var_beep)

        }

        function exibe_qtd_CA(){

            var_exibe_qtd_CA = document.getElementById('frm_id_produtos').value;
            $('#ex_qtd_CA').load('funcoes/sesmt/ajax_exibir_qtd_CA.php?ex_qtd_CA='+ var_exibe_qtd_CA)

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

