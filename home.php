<?php 
    //CABECALHO
    include 'cabecalho.php';
?>

    <div class="div_br"> </div>

    <!--MENSAGENS-->
    <?php
        include 'js/mensagens.php';
        include 'js/mensagens_usuario.php';
    ?>


  

    <h11><i class="fa fa-address-book-o" aria-hidden="true"></i> SAME</h11>

    <div class="div_br"> </div>

    <!--Recepcao-->
    <?php if(@$_SESSION['sn_usuario_same_recepcao'] == 'S'){ ?>
        <a href="estrutura_requisicao.php" class="botao_home" type="submit"><i class="fa-solid fa-file"></i> Documento</a></td></tr>
        
        <span class="espaco_pequeno"></span>

        <a href="estrutura_recepcao.php" class="botao_home" type="submit"><i class="fas fa-file-import"></i> Recepção</a></td></tr>
        
        <span class="espaco_pequeno"></span>

    <?php } ?> 
    
    <!--SECRETARIA DA DIRETORIA CLINICA-->  
    <?php if(@$_SESSION['sn_usuario_same_secretaria'] == 'S'){ ?>
        
        <a href="estrutura_secretaria.php" class="botao_home" type="submit"><i class="fas fa-address-book"></i> Secretaria</a></td></tr>
        
        <span class="espaco_pequeno"></span>
    <?php } ?>

    <!--DIRETORIA CLINICA-->  
    <?php if(@$_SESSION['sn_usuario_same_diretor'] == 'S'){ ?>
        <a href="estrutura_diretor.php" class="botao_home" type="submit"><i class="fa-solid fa-hospital-user"></i> Diretor</a></td></tr>
        
        <span class="espaco_pequeno"></span>
    <?php } ?>
    
    <!--SAME-->  
    <?php if(@$_SESSION['sn_usuario_same'] == 'S'){ ?>
        <a href="estrutura_same.php" class="botao_home" type="submit"><i class="fas fa-file-alt"></i> SAME</a></td></tr>
        
        <span class="espaco_pequeno"></span>
    <?php } ?>

    <!--RELATORIOS--> 
    <?php if(@$_SESSION['sn_usuario_same_secretaria'] == 'S' || @$_SESSION['sn_usuario_same_diretor'] == 'S' || @$_SESSION['sn_usuario_same_recepcao'] == 'S'){ ?>
        <a href="estrutura_relatorio.php" class="botao_home" type="submit"><i class="fa-solid fa-file"></i> Relatórios</a></td></tr>
        <span class="espaco_pequeno"></span>
    <?php } ?>

    <div class="div_br"> </div>
    <div class="div_br"> </div>  

    <div class="div_br"> </div>

    <?php if(@$_SESSION['sn_administrador_same'] == 'S'){ ?>
        <h11><i class="fa-solid fa-user-gear"></i> Administrador</h11>

        <div class="div_br"> </div>

        <a href="estrutura_configuracoes.php" class="botao_home_adm" type="submit"><i class="fa-solid fa-user-gear"></i> Configurações</a></td></tr>
            
            <span class="espaco_pequeno"></span>
    <?php } ?>


    <div class="div_br"> </div>
    <div class="div_br"> </div>

    <?php include 'assinatura_SAME/Relatorios/grafico_home_dashboard.php'; ?>


<?php
    //RODAPE
    include 'rodape.php';
?>