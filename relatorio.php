<?php 
    //CABECALHO
    include 'cabecalho.php';

    //ACESSO ADM
    include 'acesso_restrito_sesmt.php';

    //CONEXÃO ORACLE
    include 'conexao.php';
?>

    <div class="div_br"> </div>

    <!--MENSAGENS-->
    <?php
        include 'js/mensagens.php';
        include 'js/mensagens_usuario.php';
    ?>

    <h11><i class="fa-solid fa-file"></i> Relatorios</h11>
    <div class='espaco_pequeno'></div>
    <h27><a href="home.php" style="color: #444444; text-decoration: none;"><i class="fa fa-reply" aria-hidden="true"></i> Voltar</a></h27>

    <div class="div_br"> </div>

    <!-- CONTEUDO -->
    <div class='espaco_vertical'></div>


    <div class='row'>

        <!-- CENTRO DE CUSTO -->
        <div class='col-md-3'>

            <?php

            include 'filtros/filtro_centro_custo_relatorio.php';

            ?>

        </div>
       
        
        <!-- DATA INICIO -->
        <div class='col-md-3'>
             Data Inicio:
            <input type = "date" id="frm_dt_ini"class="form-control"></input>

        </div>

        
        <!-- DATA FIM -->
        <div class='col-md-3'>
             Data Fim:
            <input type = "date" id="frm_dt_fim"class="form-control"></input>

        </div>

    </div>

    <div class="div_br"></div>


    <div class='row'>

        <div class='col-md-3'>

            <?php include 'filtros/filtro_usuarios_relatorio.php';?>

        </div>


        
        <div class = "col-md-2" >

            </br>
            <button type="submit" class="btn btn-primary" onclick="corpo_tabela_relatorio()"><i class="fa-solid fa-magnifying-glass"></i> Pesquisar</button>

        </div>

    </div>

    <div class="div_br"> </div>

      <!--DIV TITULO REALIZADAS-->
      <div class="div_br"></div>
      <h11><i class="fa-solid fa-list"></i> Histórico</h11>

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

        </thead>

        <tbody id="tabela_relatorio"></tbody>

    </table>


    <script>
        
        /*FUNÇÃO CRIAR CORPO DA TABELA*/

        function corpo_tabela_relatorio(){

            var_rel_cc= document.getElementById('frm_rel_id_cc').value;
            var_dt_inicial= document.getElementById('frm_dt_ini').value;
            var_dt_final= document.getElementById('frm_dt_fim').value;
            var_usu_reletorio= document.getElementById('frm_id_usu_rel').value;

            //alert(var_rel_cc);
            //alert(var_dt_inicial);
            //alert(var_dt_final);
            //alert(var_usu_reletorio);

            var_link = 'funcoes/sesmt/ajax_exibe_relatorio.php?get_var_centro='+var_rel_cc+'&get_dt_ini='+var_dt_inicial+'&get_dt_fim='+var_dt_final+'&get_usu_rel='+var_usu_reletorio;

            //alert(var_link);


            $('#tabela_relatorio').load(var_link);

        }

    </script> 

<?php
    //RODAPE
    include 'rodape.php';
?>