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

    <h11><i class="fa fa-address-book-o" aria-hidden="true"></i> SESMT</h11>

    <div class="div_br"> </div>

    <!--SESMT-->
    <?php if(@$_SESSION['papel_sesmt'] == 'S'){ ?>
        <a href="solicitacao.php" class="botao_home" type="submit"><i class="fas fa-file-import"></i>  Solicitações</a></td></tr>
        
        <span class="espaco_pequeno"></span>
        
        <a href="relatorio.php" class="botao_home" type="submit"><i class="fa-sharp fa-solid fa-folder-open"></i>  Relatórios</a></td></tr>
        
        <span class="espaco_pequeno"></span>

    <?php } ?> 

    <div class='espaco_vertical_medio'></div>

    <div class='row'>

        <div class='col-md-3'>

            <!--SESMT ADM-->
                <?php if(@$_SESSION['papel_sesmt_adm'] == 'S'){ ?>
                <a href="durabilidade.php" class="botao_home_adm" type="submit"><i class="fa-solid fa-pen-to-square"></i> Durabilidade</a></td></tr>
                
                <span class="espaco_pequeno"></span>

            <?php } ?>

        </div>

    </div>

<?php
    //RODAPE
    include 'rodape.php';
?>