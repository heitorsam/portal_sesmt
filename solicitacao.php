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
    <div class='espaco_vertical'></div>
    <div class='row'>

        <div class='col-md-3'>
       
             Usuario
            <div class='espaco_vertical'></div>
            <input type="text" id="valor_beep" class="form-control" onchange = "pesquisar_usuario()">   

            <a class="botao_home" onclick = "pesquisar_usuario()" type="submit"><i class="fa-solid fa-search"></i></a>

        </div>

    </div>

        <div id="solicitacoes"></div>

    </div>



    <script>

        function pesquisar_usuario(){

            var_beep = document.getElementById('valor_beep').value;
            
            //alert(var_beep);

            $('#solicitacoes').load('funcoes/sesmt/solicitacoes.php?CD_USUARIO='+ var_beep)

        }

    </script>


<?php
    //RODAPE
    include 'rodape.php';
?>

