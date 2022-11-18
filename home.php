<?php 
    //CABECALHO
    include 'cabecalho.php';

    //ACESSO ADM
    //include 'acesso_restrito_adm.php';
?>

    <div class="div_br"> </div>

    <!--MENSAGENS-->
    <?php
        include 'js/mensagens.php';
        include 'js/mensagens_usuario.php';
    ?>

    <h11><i class="fa fa-address-book-o efeito-zoom" aria-hidden="true"></i> SESMT</h11>

    <div class="div_br"> </div>

    <!--SESMT-->
    <?php if(@$_SESSION['papel_sesmt'] == 'S'){ ?>
        <a href="solicitacao.php" class="botao_home" type="submit"><i class="fas fa-file-import"></i>  Solicitações</a></td></tr>
        
        <span class="espaco_pequeno"></span>
        
        <a href="relatorio.php" class="botao_home" type="submit"><i class="fa-solid fa-file"></i>  Relatórios</a></td></tr>
        
        <span class="espaco_pequeno"></span>

    <?php } ?> 

    <div class='espaco_vertical_medio'></div>

    <div class='row'>

        <div class='col-md-3'>

            <!--SESMT ADM-->
                <?php if(@$_SESSION['papel_sesmt_adm'] == 'S'){ ?>
                <a href="durabilidade.php" class="botao_home_adm" type="submit"><i class="fa-solid fa-square-plus"></i> Durabilidade</a></td></tr>
                
                <span class="espaco_pequeno"></span>

            <?php } ?>

        </div>

    </div>

    </br>
    <h11><i class="fas fa-chart-line efeito-zoom"></i> Dashboard</h11>
    <span class="espaco_pequeno" style="width: 6px"></span>
    <div class="div_br"></div>
    <div class="row">
        <div class="col-md-12" id="div_dashboard">       
        </div>        
    </div>
    <script>
    $(document).ready(function(){
        $('#div_dashboard').load('funcoes/solicitacao/ajax_dashboard.php');

    });
    </script>

<?php
    //RODAPE
    include 'rodape.php';
?>


