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

    <h11><i class="fa-solid fa-file efeito-zoom"></i> Relatórios</h11>
    <div class='espaco_pequeno'></div>
    <h27><a href="home.php" style="color: #444444; text-decoration: none;"><i class="fa fa-reply efeito-zoom" aria-hidden="true"></i> Voltar</a></h27>

    <div class="div_br"> </div>

    <!-- CONTEUDO -->
    <div class='espaco_vertical'></div>


    <div class='row'>

        <!-- CENTRO DE CUSTO -->
        <div class='col-md-3'>

            <?php

                include 'filtros/filtro_centro_custo.php';

            ?>

        </div>

        <div class='col-md-3' id="constroi_usu_setor"></div>

        <div class= 'col-md-2'>

            Tipo Relatório:
            <select class='form form-control' id="tp_relatorio">

                <option value = 'N'>  Geral</option>
                <option value = 'S'>  Excesso</option>

            </select>

        </div>

    </div>

    <div class="div_br"></div>


    <div class='row'>
        
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

        
        <div class=row>

            <!-- BOTÃO SUBMIT DOWNLOAD -->
            <div class = "col-md-5" >

                </br>
                <button type="submit" class="btn btn-primary efeito-zoom" onclick="corpo_tabela_relatorio()"><i class="fa-solid fa-magnifying-glass"></i></button>

            </div>

            <!-- BOTÃO PDF DOWNLOAD -->
            <div class = "col-md-2" >

                </br>
                <button id="btn_excel" type="submit" class="btn btn-primary" style="display: none;" onclick="down_pdf()"><i class="fa-solid fa-file-pdf"></i></button>

            </div>
        </div>

    </div>

    <!--DIV MENSAGEM ACOES-->
    <div id="mensagem_acoes_relatorio"></div>

    <div class="div_br"> </div>

      <!--DIV TITULO REALIZADAS-->
      <div class="div_br"></div>
      <h11><i class="fa-solid fa-bars efeito-zoom"></i> Histórico</h11>

    <div class="div_br"></div>


    <!--DIV TABELA-->
    <table class="table table-striped" style="text-align: center">

        <thead>

            <th>Solicitação</th>
            <th>Usuário </th>
            <th>Setor</th>
            <th>Entrega</th>
            <th>Código </th>
            <th>Produto </th>
            <th>Durabilidade </th>
            <th>            C.A.            </th>
            <th>Excesso  </th>
            <th>Justificativa</th>
            <th> Quantidade</th>
            <th>Funcionário</th>
            <th>   Assinatura  </th>

        </thead>

        <tbody id="tabela_relatorio"></tbody>

    </table>

    <script>


        /*AO TERMINAR DE CARREGAR A PAGINA*/
        $(document).ready(function(){
            constroi_usu_setor();
        });

        /*FUNÇÃO CRIAR CORPO DA TABELA*/

        function corpo_tabela_relatorio(){

            var_rel_cc= document.getElementById('frm_id_cc').value;
            var_dt_inicial= document.getElementById('frm_dt_ini').value;
            var_dt_final= document.getElementById('frm_dt_fim').value;
            var_usu_reletorio= document.getElementById('frm_id_usu_rel').value;
            var_tp_relatorio= document.getElementById('tp_relatorio').value;

            //alert(var_rel_cc);
            //alert(var_dt_inicial);
            //alert(var_dt_final);
            //alert(var_usu_reletorio);

            if(var_dt_inicial == ''){
                document.getElementById('frm_dt_ini').focus();               
            }else{
                if(var_dt_final == ''){
                    document.getElementById('frm_dt_fim').focus();                    
                }else{
                    document.getElementById('btn_excel').style.display = 'block';
                }
            }

            var_link = 'funcoes/relatorio/ajax_exibe_relatorio.php?get_var_centro='+var_rel_cc+'&get_dt_ini='+var_dt_inicial+'&get_dt_fim='+var_dt_final+'&get_usu_rel='+var_usu_reletorio+'&get_tp_rel='+var_tp_relatorio;

            //alert(var_link);

            $('#tabela_relatorio').load(var_link);

        }

        function constroi_usu_setor(){

            var_select_centro = document.getElementById('frm_id_cc').value;

            //alert(var_beep);

            $('#constroi_usu_setor').load('funcoes/relatorio/ajax_constroi_usu_setor.php?get_var_cc='+ var_select_centro)

        }

        function down_pdf(){

            var_rel_ex= document.getElementById('frm_id_cc').value;
            var_dt_inicial_ex= document.getElementById('frm_dt_ini').value;
            var_dt_final_ex= document.getElementById('frm_dt_fim').value;
            var_usu_reletorio_ex= document.getElementById('frm_id_usu_rel').value;
            var_parametro_pdf= document.getElementById('tp_relatorio').value;

            down_ex = 'pdf.php?get_var_centro='+var_rel_ex+'&get_dt_ini='+var_dt_inicial_ex+'&get_dt_fim='+var_dt_final_ex+'&get_usu_rel='+var_usu_reletorio_ex+'&get_parametro_pdf='+var_parametro_pdf;

            window.location.replace(down_ex);

        }

    </script> 

<?php

    //RODAPE
    include 'rodape.php';
    
?>