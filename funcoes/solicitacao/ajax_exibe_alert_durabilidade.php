<?php

    include '../../conexao.php';
    
        $tipo = $_GET['tipo'];

        if($tipo == 'N'){
        $var_prodto_alert = $_GET['id_prod'];
        $var_usu_alert = $_GET['cd_usuario'];

        $cons_alert_prod= "SELECT 
                        CASE
                        WHEN TRUNC(TO_DATE(res.ATUAL,'DD/MM/YYYY'))
                        BETWEEN TRUNC(TO_DATE(res.INICIO,'DD/MM/YYYY'))
                        AND TRUNC(TO_DATE(res.FIM,'DD/MM/YYYY')) THEN 1
                        ELSE 0
                        END SN_ALERTA_DUR
                        FROM(
                        SELECT
                        TO_CHAR(SYSDATE, 'DD/MM/YYYY') AS ATUAL,
                        (SELECT TO_CHAR(MAX(sol.HR_CADASTRO), 'DD/MM/YYYY') AS ULT_SOL
                        FROM portal_sesmt.SOLICITACAO sol
                        WHERE sol.CD_PRODUTO_MV = $var_prodto_alert
                        AND sol.CD_USUARIO_MV = '$var_usu_alert') AS INICIO,
                        TO_CHAR((SELECT MAX(sol.HR_CADASTRO) AS ULT_SOL
                                FROM portal_sesmt.SOLICITACAO sol
                                WHERE sol.CD_PRODUTO_MV = $var_prodto_alert
                                AND sol.CD_USUARIO_MV = '$var_usu_alert') +
                                (SELECT lgdur.DIAS
                                FROM portal_sesmt.LOG_DURABILIDADE lgdur
                                WHERE lgdur.CD_DURABILIDADE IN
                                    (SELECT so.CD_DURABILIDADE
                                        FROM portal_sesmt.SOLICITACAO so
                                        WHERE so.CD_SOLICITACAO IN
                                            (SELECT MAX(sol.CD_SOLICITACAO) AS ULT_SOL
                                                FROM portal_sesmt.SOLICITACAO sol
                                                WHERE sol.CD_PRODUTO_MV = $var_prodto_alert
                                                AND sol.CD_USUARIO_MV = '$var_usu_alert'))
                            UNION ALL
                            SELECT dur.DIAS
                                FROM portal_sesmt.DURABILIDADE dur
                                WHERE dur.CD_DURABILIDADE IN
                                    (SELECT so.CD_DURABILIDADE
                                        FROM portal_sesmt.SOLICITACAO so
                                        WHERE so.CD_SOLICITACAO IN
                                            (SELECT MAX(sol.CD_SOLICITACAO) AS ULT_SOL
                                                FROM portal_sesmt.SOLICITACAO sol
                                                WHERE sol.CD_PRODUTO_MV = $var_prodto_alert
                                                AND sol.CD_USUARIO_MV = '$var_usu_alert'))),
                            'DD/MM/YYYY') AS FIM                
                        FROM DUAL) res";

        $rest_alert_prod = oci_parse($conn_ora, $cons_alert_prod);

        @oci_execute($rest_alert_prod);

        @$row_alert_d = oci_fetch_array($rest_alert_prod);

        @$sn_dur = $row_alert_d['SN_ALERTA_DUR'];

?>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        <?php
                            echo "<div class='alert_pers_amarelo'>
                            <strong><i class='fa-solid fa-triangle-exclamation'></i></strong> 
                            Atenção, este usuário já possui um EPI dentro da durabilidade, informe uma justificativa!
                            </div>";
                        ?>
                    </h5>
                    <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>-->
                </div>
                <div class="modal-body">

                <div class="col-md-12" style="background-color: #f9f9f9 !important;">

                    <div class="div_br"> </div>
                    Justificativa:
                    <div class="div_br"> </div>             
                 <input type="text" class="form form-control" id="frm_Justificativa" name='Justificativa'></input>
                    
                </div>

                </div>
                <div class="modal-footer">
                    <!--<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>-->
                    <button type="button" disabled id="habilita"class="btn btn-primary" onclick="salva_just()">Salvar</button>

                </div>
                </div>
            </div>
        </div>

<?php       

        if($sn_dur == 1 && $tipo == 'N'){
?> 
            <script>

             $('#exampleModal').modal('show');

            </script>
<?php
            
        }
    }
?>


<script>

    document.body.querySelector("#frm_Justificativa").addEventListener("input", function(){
    
    var botao_salvar = document.body.querySelector("#habilita");

    // habilita o botão com 5 ou mais caracteres digitados
    botao_salvar.disabled = this.value.length >= 5 ? false : true;

    });

</script>
