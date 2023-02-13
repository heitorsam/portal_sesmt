
<?php

    include '../../conexao.php';
    
    $var_usu = $_GET['cd_usuario'];

    /*$consulta_oracle = "SELECT usu.NM_USUARIO,
                               usu.DS_OBSERVACAO AS DS_FUNCAO
                        FROM dbasgu.USUARIOS usu
                        WHERE usu.SN_ATIVO = 'S'
                        AND usu.CD_USUARIO = UPPER('$var_usu')";*/

    $consulta_oracle ="SELECT * 
                       FROM (SELECT 
                                (SELECT
                                    CASE 
                                    WHEN LENGTH (func.CHAPA) = 5 THEN '00000' || func.CHAPA || '00'
                                    ELSE '000000' || func.CHAPA || '00'
                                    END AS CD_USUARIO
                                FROM dbamv.STA_TB_FUNCIONARIO aux
                                WHERE aux.TP_SITUACAO IN ('A','F')
                                AND aux.CD_FUNCIONARIO = func.CD_FUNCIONARIO) AS CD_USUARIO,
                            func.NM_FUNCIONARIO,
                            func.DS_FUNCAO
                            FROM dbamv.STA_TB_FUNCIONARIO func
                            WHERE func.TP_SITUACAO IN ('A','F','Z')) res
                        WHERE res.CD_USUARIO = $var_usu";


    $resultado_con_oracle = oci_parse($conn_ora, $consulta_oracle);

    @$valida = oci_execute(@$resultado_con_oracle);

    @$row = oci_fetch_array(@$resultado_con_oracle);
    
?>

<div class="row">

    <!--COLABORADOR-->
    <div class="col-md-3">
        Colaborador:
        </br>
        <input type="text" id="frm_colab_sol" readonly value = "<?php echo @$row['NM_FUNCIONARIO'] ?>" class="form-control"></input>
    </div>

    <!--FUNÇÃO-->
    <div class="col-md-4">
        Função:
        </br>
        <input type="text" id="frm_func_sol" readonly value = "<?php echo @$row['DS_FUNCAO'] ?>" class="form-control"></input>
    </div>

    <!--CENTRO DE CUSTO-->
    <div class = "col-md-3">
 
        <?php
            
            include '../../filtros/filtro_centro_custo.php';
            
        ?>

    </div>

</div>

    <div class="div_br"> </div>

<div class = "row">

        <!--PRODUTOS-->
        <div class = "col-md-5">
            <?php

            include '../../filtros/filtro_produtos.php';

            ?>
        </div>

        <!--DURABILIDADE-->
        <div class = "col-md-2">
            Durabilidade:
            </br>
            <input type ="text" id="frm_id_durabilidade" class="form-control" autocomplete="off" disabled></input>
        </div>
       
      
         <!--UNIDADE-->
        <div class="col-md-2" id="unidade" style="display: none;"></div>     
        

         <!--ESTOQUE-->
         <div class ="col-md-1">
            Estoque:
            </br>
            <input type ="text" id="frm_id_estoque" class="form-control" autocomplete="off" disabled></input>
        </div>

        <!--QUANTIDADE-->
        <div class = "col-md-1">
            Quantidade:
            </br>
            <input type ="number" type="number" min="0" id="frm_qtd_sol" class="form-control" autocomplete="off"></input>
        </div>


    </div>

    <div class="div_br"> </div>

    <div class = "row">
    
    <?php if(@$_GET['tipo'] == 'S'){ ?>
            <div class="col-md-4">
                Data Histórica:
                </br>
                <input type="datetime-local" id="data" class="form-control">
            </div>
        <?php } ?>
        
        <!--BOTÃO + -->
        <div class = "col-md-2" >

            </br>
            <button type = "submit" class="btn btn-primary" onclick="ajax_adicionar_sol('<?php echo $_GET['tipo'] ?>')" ><i class="fa-solid fa-plus"></i> Solicitar</button>

        </div>

</div>


    <!--MODAL ASSINATURA-->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static">

        <div class="modal-dialog modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Assinatura</h5>
                    <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>-->
                </div>

                <div class="modal-body" style="margin: 0 auto;">
                    <canvas id="sig-canvas" width="620" height="160" style="border: solid 1px black; 
                            margin-top: 20px;
                            width: 600px; height: 150px;">
                    </canvas>
                    <input type="hidden" name="escondidinho" id="escondidinho"></input>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="sig-clearBtn" onClick="redraw()"><i class="fas fa-eraser"></i> Limpar</button>
                    <button type="button" type="submit" class="btn btn-primary" id="sig-submitBtn" onclick="solicitar_mv()"><i class="fas fa-paper-plane"></i> Enviar</button>
                </div>

            </div>
        </div>

    </div>

<script>

function solicitar_mv(){

    var usu_mv  = document.getElementById('valor_beep').value;
    var canvas = document.getElementById("sig-canvas");
    var escondidinho =  document.getElementById('escondidinho').value = canvas.toDataURL('image/png');

    console.log(escondidinho);
    resultado = confirm("Realmente deseja criar a solicitação no MV?");

    if(resultado == true){

        $('#exampleModalCenter').modal('hide');

       

        $.ajax({
            url: "funcoes/solicitacao/ajax_cria_sol_mv.php",
            type: "POST",
            data: {
                usuario_solicitacao: usu_mv
            
                },
            cache: false,
            success: function(dataResult){

                //alert(dataResult);

                corpo_tabela_realizadas();

                $('#exibe_solsai').modal('show');

                ajax_cadastra_assinatura(escondidinho, dataResult);

                ajax_modal_solsai(dataResult);                
                
            }
        }); 

    }

};

function ajax_cadastra_assinatura(var_escondi,var_cd_sol_mv){

    console.log(var_escondi);

    //CADASTRAR ASSINATURA
    $.ajax({
            url: "funcoes/solicitacao/cadastrar_assinatura.php",
            type: "POST",
            dataType: 'html',
            data: {

                escond: var_escondi,
                cons_next: var_cd_sol_mv
            
                },
            cache: false,
            success: function(dataResult){

                //console.log(dataResult);

                if(dataResult == 'Sucesso'){

                    //MENSAGEM            
                    var_ds_msg = 'Assinatura%20cadastrada%20com%20sucesso!';
                    var_tp_msg = 'alert-success';
                    //var_tp_msg = 'alert-danger';
                    //var_tp_msg = 'alert-primary';
                    $('#mensagem_acoes').load('config/mensagem/ajax_mensagem_acoes.php?ds_msg='+var_ds_msg+'&tp_msg='+var_tp_msg); 

                }else{

                    console.log(dataResult);

                    /*//MENSAGEM            
                    var_ds_msg = 'Erro%20ao%20cadastrar%20assinatura!';
                    //var_tp_msg = 'alert-success';
                    var_tp_msg = 'alert-danger';
                    //var_tp_msg = 'alert-primary';
                    $('#mensagem_acoes').load('config/mensagem/ajax_mensagem_acoes.php?ds_msg='+var_ds_msg+'&tp_msg='+var_tp_msg); 
                    */
                }

                
            }
        }); 

};


$(document).ready(function() {
        ajax_exibe_alert_durabilidade()
    });
    
    var_usu_sol = document.getElementById('frm_colab_sol').value;     

    if(var_usu_sol != ''){

        //MENSAGEM            
        var_ds_msg = 'Usuario%20encontrado!';
        var_tp_msg = 'alert-success';
        //var_tp_msg = 'alert-danger';
        //var_tp_msg = 'alert-primary';
        $('#mensagem_acoes').load('funcoes/ajax_mensagem_acoes.php?ds_msg='+var_ds_msg+'&tp_msg='+var_tp_msg); 
    
    }else{

        //MENSAGEM            
        var_ds_msg = 'Usuario%20não%20encontrado!';
        //var_tp_msg = 'alert-success';
        var_tp_msg = 'alert-danger';
        //var_tp_msg = 'alert-primary';
        $('#mensagem_acoes').load('funcoes/ajax_mensagem_acoes.php?ds_msg='+var_ds_msg+'&tp_msg='+var_tp_msg); 

    }
    
     //SALVA A IMAGEM DA ASSINATURA

        document.getElementById("sig-submitBtn").addEventListener("click", function () {

        var canvas = document.getElementById("sig-canvas");

        document.getElementById('escondidinho').value = canvas.toDataURL('image/png');


    });
        (function() {
            
            // Get a regular interval for drawing to the screen
            window.requestAnimFrame = (function (callback) {
                return window.requestAnimationFrame || 
                            window.webkitRequestAnimationFrame ||
                            window.mozRequestAnimationFrame ||
                            window.oRequestAnimationFrame ||
                            window.msRequestAnimaitonFrame ||
                            function (callback) {
                                window.setTimeout(callback, 1000/60);
                            };
            })();

            // Set up the canvas
            var canvas = document.getElementById("sig-canvas");
            var ctx = canvas.getContext("2d");
            ctx.strokeStyle = "#5b79b4";
            ctx.lineWith = 2;

            // Set up the UI
            var sigText = document.getElementById("sig-dataUrl");
            var sigImage = document.getElementById("sig-image");
            var clearBtn = document.getElementById("sig-clearBtn");
            clearBtn.addEventListener("click", function (e) {
                clearCanvas();
                sigText.innerHTML = "Data URL for your signature will go here!";
                sigImage.setAttribute("src", "");
            }, false);

            // Set up mouse events for drawing
            var drawing = false;
            var mousePos = { x:0, y:0 };
            var lastPos = mousePos;
            canvas.addEventListener("mousedown", function (e) {
                drawing = true;
                lastPos = getMousePos(canvas, e);
            }, false);
            canvas.addEventListener("mouseup", function (e) {
                drawing = false;
            }, false);
            canvas.addEventListener("mousemove", function (e) {
                mousePos = getMousePos(canvas, e);
            }, false);

            // Set up touch events for mobile, etc
            canvas.addEventListener("touchstart", function (e) {
                mousePos = getTouchPos(canvas, e);
                var touch = e.touches[0];
                var mouseEvent = new MouseEvent("mousedown", {
                    clientX: touch.clientX,
                    clientY: touch.clientY
                });
                canvas.dispatchEvent(mouseEvent);
            }, false);
            canvas.addEventListener("touchend", function (e) {
                var mouseEvent = new MouseEvent("mouseup", {});
                canvas.dispatchEvent(mouseEvent);
            }, false);
            canvas.addEventListener("touchmove", function (e) {
                var touch = e.touches[0];
                var mouseEvent = new MouseEvent("mousemove", {
                    clientX: touch.clientX,
                    clientY: touch.clientY
                });
                canvas.dispatchEvent(mouseEvent);
            }, false);

            // Prevent scrolling when touching the canvas
            document.body.addEventListener("touchstart", function (e) {
                if (e.target == canvas) {
                    e.preventDefault();
                }
            }, false);
            document.body.addEventListener("touchend", function (e) {
                if (e.target == canvas) {
                    e.preventDefault();
                }
            }, false);
            document.body.addEventListener("touchmove", function (e) {
                if (e.target == canvas) {
                    e.preventDefault();
                }
            }, false);

            // Get the position of the mouse relative to the canvas
            function getMousePos(canvasDom, mouseEvent) {
                var rect = canvasDom.getBoundingClientRect();
                return {
                    x: mouseEvent.clientX - rect.left,
                    y: mouseEvent.clientY - rect.top
                };
            }

            // Get the position of a touch relative to the canvas
            function getTouchPos(canvasDom, touchEvent) {
                var rect = canvasDom.getBoundingClientRect();
                return {
                    x: touchEvent.touches[0].clientX - rect.left,
                    y: touchEvent.touches[0].clientY - rect.top
                };
            }

            // Draw to the canvas
            function renderCanvas() {
                if (drawing) {
                    ctx.moveTo(lastPos.x, lastPos.y);
                    ctx.lineTo(mousePos.x, mousePos.y);
                    ctx.stroke();
                    lastPos = mousePos;
                }
            }

            // Clear the canvas
            function clearCanvas() {
                canvas.width = canvas.width;
            }

            // Allow for animation
            (function drawLoop () {
                requestAnimFrame(drawLoop);
                renderCanvas();
            })();

        })();

</script>