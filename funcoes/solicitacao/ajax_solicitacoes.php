<?php

include '../../conexao.php';

$var_usu = $_GET['cd_usuario'];

/*$consulta_oracle = "SELECT usu.NM_USUARIO,
                               usu.DS_OBSERVACAO AS DS_FUNCAO
                        FROM dbasgu.USUARIOS usu
                        WHERE usu.SN_ATIVO = 'S'
                        AND usu.CD_USUARIO = UPPER('$var_usu')";*/

$consulta_oracle = "SELECT * 
                       FROM (SELECT 
                                (SELECT
                                    CASE 
                                    WHEN LENGTH (func.CHAPA) = 5 THEN '00000' || func.CHAPA || '00'
                                    ELSE '000000' || func.CHAPA || '00'
                                    END AS CD_USUARIO
                                FROM dbamv.STA_TB_FUNCIONARIO aux
                                WHERE aux.TP_SITUACAO IN ('A','F','Z')
                                AND aux.CD_FUNCIONARIO = func.CD_FUNCIONARIO) AS CD_USUARIO,
                            func.NM_FUNCIONARIO,
                            func.DS_FUNCAO
                            FROM dbamv.STA_TB_FUNCIONARIO func
                            WHERE func.TP_SITUACAO IN ('A','F','Z')) res
                        WHERE res.CD_USUARIO = $var_usu";

$resultado_con_oracle = oci_parse($conn_ora, $consulta_oracle);

@$valida = oci_execute(@$resultado_con_oracle);

@$row = oci_fetch_array(@$resultado_con_oracle);

// VERIFICA SE O USUÁRIO JÁ POSSUI ASSINATURA DO TERMO
$cons_assinatura = "SELECT *
                    FROM portal_sesmt.ASSINATURA_TERMO term
                    WHERE term.CRACHA_SOLICITANTE = '$var_usu'";

$res_cons_assinatura = oci_parse($conn_ora, $cons_assinatura);
oci_execute($res_cons_assinatura);

$res_verifica_assinatura = oci_fetch_array($res_cons_assinatura);

?>

<!--MODAL TERMO-->
<div class="modal fade" id="modal_termo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered" role="document">

        <div class="modal-content" id="modal_content" style="width: 75%; margin: 0 auto;">

            <div class="modal-header">

                <h5 class="modal-title" id="titulo_modal">Termo de Responsabilidade para Uso de E.P.I</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>

            <div id="conteudo_modal" class="modal-body">

                <div class="row">

                    <div class="col-md-8" style="margin: 0 auto; margin-top: 40px; margin-bottom: 40px; font-size: 17px;">

                        <p style="display: block; margin: 0 auto; width: 100%; font-size: 18px; font-family: Georgia, serif; color: #1f1f1f;">
                            <b>Declaro para os devidos fins, que:</b> <br> <br> <br>

                            &nbsp &nbsp &nbsp &nbsp - Recebi da Irmandade da Santa Casa de SJCampos, gratuitamente, os EPIs e/ou Uniformes relacionados neste controle, em perfeito estado de conservação e funcionamento; <br> <br>

                            &nbsp &nbsp &nbsp &nbsp - Recebi informações e treinamento sobre o uso adequado e obrigatório; <br> <br>

                            &nbsp &nbsp &nbsp &nbsp - Comprometo-me a usá-los apenas para a finalidade a que se destinam; <br> <br>

                            &nbsp &nbsp &nbsp &nbsp - Responsabilizo-me pela guarda e conservação comunicando à minha chefia imediata qualquer alteração que os torne impróprios para o uso, de conformidade com a Norma Regulamentadora NR 6, da Portaria nº 3214, de 08/06/78, do MTB e com o artigo 158, incisos I e II e parágrafo único, letras “A” e “B” da CLT. <br> <br>

                            <br>
                            <b>Fico também ciente de que:</b>

                            <br>
                            <br>

                            &nbsp &nbsp &nbsp &nbsp - Devo devolver os EPIs sob minha guarda quando, por qualquer razão, terminar meu contrato de trabalho com a Santa Casa de Mis. de SJCampos; <br> <br>

                            &nbsp &nbsp &nbsp &nbsp - Em caso de dano ou perda por uso inadequado ou negligência, obrigo-me a indenizar a Santa Casa de Mis. de SJCampos, pelo valor apurado na ocasião, segundo o parágrafo único do artigo 462 da CLT; <br> <br>

                            Assim, estando de acordo, assino o presente,

                        </p>

                    </div>

                </div>

                <?php if(!empty($res_verifica_assinatura)) {?>

                    <img id="mostra_assinatura" style="width: 90%;">

                <?php } else { ?>

                    <button onclick="abrir_modal_assinatura()" style="float: right;" class="btn btn-primary">Assinar</button>

                <?php } ?>

            </div>

        </div>

    </div>

</div>

<!--MODAL ASSINATURA TERMO-->
<div class="modal fade" id="modal_assinatura_termo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered" role="document">

        <div class="modal-content" id="modal_content">

            <div class="modal-header">

                <h5 class="modal-title" id="titulo_modal">Assinatura Termo</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                    <span aria-hidden="true">&times;</span>

                </button>

            </div>

            <div id="conteudo_modal_assinatura" class="modal-body" style="width: 100%;">

                <canvas id="canvas" width="800" height="200" style="width: 100%; height: auto;"></canvas>

                <div class="div_br"></div>

                <button style="float: right;" onclick="insert_tabela_assinatura_termo()" class="btn btn-primary"><i class="fa-solid fa-check"></i> Concluir</button>

                <button style="float: right; margin-right: 10px;" class="btn btn-primary" id="btn_limpar"><i class="fa-solid fa-broom"></i> Limpar</button>

            </div>

        </div>

    </div>

</div>


<div class="row">

    <!--COLABORADOR-->
    <div class="col-md-3">
        Colaborador:
        </br>
        <input type="text" id="frm_colab_sol" readonly value="<?php echo @$row['NM_FUNCIONARIO'] ?>" class="form-control"></input>
    </div>

    <!--FUNÇÃO-->
    <div class="col-md-4">
        Função:
        </br>
        <input type="text" id="frm_func_sol" readonly value="<?php echo @$row['DS_FUNCAO'] ?>" class="form-control"></input>
    </div>

    <!--CENTRO DE CUSTO-->
    <div class="col-md-3">

        <?php

        include '../../filtros/filtro_centro_custo.php';

        ?>

    </div>

</div>

<div class="div_br"> </div>

<div class="row">

    <!--PRODUTOS-->
    <div class="col-md-5">
        <?php

        include '../../filtros/filtro_produtos.php';

        ?>
    </div>

    <!--DURABILIDADE-->
    <div class="col-md-2">
        Durabilidade:
        </br>
        <input type="text" id="frm_id_durabilidade" class="form-control" autocomplete="off" disabled></input>
    </div>


    <!--UNIDADE-->
    <div class="col-md-2" id="unidade" style="display: none;"></div>


    <!--ESTOQUE-->
    <div class="col-md-1">
        Estoque:
        </br>
        <input type="text" id="frm_id_estoque" class="form-control" autocomplete="off" disabled></input>
    </div>

    <!--QUANTIDADE-->
    <div class="col-md-1">
        Quantidade:
        </br>
        <input type="number" type="number" min="0" id="frm_qtd_sol" class="form-control" autocomplete="off"></input>
    </div>


</div>

<div class="div_br"> </div>

<div class="row">

    <?php if (@$_GET['tipo'] == 'S') { ?>
        <div class="col-md-4">
            Data Histórica:
            </br>
            <input type="datetime-local" id="data" class="form-control">
        </div>
    <?php } ?>

    <!--BOTÃO + -->
    <div style="width: 100%;">

        <div class="col-md-3">

            </br>

            <?php if (!empty($res_verifica_assinatura)) {?>

                <button onclick="abrir_modal_termo(), puxa_assinatura()" type="submit" class="btn btn-secondary"><i class="fa-solid fa-file"></i> Termo</button>

            <?php } else {?>

                <button onclick="abrir_modal_termo()" type="submit" class="btn btn-primary"><i class="fa-solid fa-file"></i> Termo</button>

            <?php } ?>
            
            <button type="submit" class="btn btn-primary" onclick="ajax_adicionar_sol('<?php echo $_GET['tipo'] ?>')"><i class="fa-solid fa-plus"></i> Solicitar</button>

        </div>

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

    function abrir_modal_termo() {

        $('#modal_termo').modal();

    }

    function abrir_modal_assinatura() {

        $('#modal_termo').modal('hide');

        $('#modal_assinatura_termo').modal();

        inicializar_canvas_assinatura()

    }

    function puxa_assinatura() {

        var usuario_busca = document.getElementById('valor_beep').value;
        var mostra_assinatura = document.getElementById('mostra_assinatura');

        $.ajax({
            url: "funcoes/termos/busca_assinatura.php",
            method: "GET",  
            data: {
                usuario_busca
            },
            cache: false,
            success(res) {

                mostra_assinatura.src = 'data:image;base64,' + res;

            }
        })

    }

    function insert_tabela_assinatura_termo() {

        var cracha_solicitante = document.getElementById('valor_beep').value;

        // PEGANDO A ASSINATURA
        var canvas = document.getElementById('canvas');
        var ctx = canvas.getContext('2d');

        var blob_assinatura_termo = canvas.toDataURL('image/png');

        $.ajax({
            url: "funcoes/termos/insert_assinatura_termo.php",
            method: "POST",
            cache: false,
            data: {
                cracha_solicitante,
                blob_assinatura_termo
            },
            success(res) {

                if (res == 'Sucesso') {

                    //MENSAGEM            
                    var_ds_msg = 'Termo%20salvo%20com%20sucesso!';
                    var_tp_msg = 'alert-success';
                    $('#mensagem_acoes').load('config/mensagem/ajax_mensagem_acoes.php?ds_msg=' + var_ds_msg + '&tp_msg=' + var_tp_msg);

                } else {

                    //MENSAGEM            
                    var_ds_msg = 'Erro%20ao%20inserir%20assinatura!';
                    var_tp_msg = 'alert-danger';
                    $('#mensagem_acoes').load('config/mensagem/ajax_mensagem_acoes.php?ds_msg=' + var_ds_msg + '&tp_msg=' + var_tp_msg);

                }

                console.log(res)
                $('#modal_assinatura_termo').modal('hide');

            }
        })

    }

    function inicializar_canvas_assinatura() {

        var canvas = document.getElementById("canvas");
        var context = canvas.getContext("2d");

        var isDrawing = false;
        var lastX = 0;
        var lastY = 0;

        // PEGA O TAMANHO CORRETO DA TELA PARA NÃO PERDER A QUALIDADE DO PIXEL
        var scale = window.devicePixelRatio || 1;
        canvas.width *= scale;
        canvas.height *= scale;
        //context.strokeStyle = "#5b79b4";
        context.strokeStyle = "#000000";
        context.scale(scale, scale);

        function getMousePos(canvas, event) {

            var rect = canvas.getBoundingClientRect();

            return {

                x: (event.clientX - rect.left) * (canvas.width / rect.width),
                y: (event.clientY - rect.top) * (canvas.height / rect.height)

            };

        }

        function startDrawing(event) {

            isDrawing = true;
            var pos = getMousePos(canvas, event);
            lastX = pos.x;
            lastY = pos.y;

        }

        function draw(event) {

            if (!isDrawing) return;

            var pos = getMousePos(canvas, event);
            var currentX = pos.x;
            var currentY = pos.y;

            context.beginPath();
            context.moveTo(lastX, lastY);
            context.lineTo(currentX, currentY);
            context.stroke();
            context.closePath();

            lastX = currentX;
            lastY = currentY;

        }

        function stopDrawing() {

            isDrawing = false;

        }

        function touchStart(event) {

            var touch = event.touches[0];
            var pos = getMousePos(canvas, touch);
            startDrawing(pos);

        }

        function touchMove(event) {

            var touch = event.touches[0];
            var pos = getMousePos(canvas, touch);
            draw(pos);
            event.preventDefault();

        }

        canvas.addEventListener("mousedown", startDrawing);
        canvas.addEventListener("mousemove", draw);
        canvas.addEventListener("mouseup", stopDrawing);

        canvas.addEventListener("touchstart", function(event) {

            var touch = event.touches[0];
            startDrawing(touch);

        });

        canvas.addEventListener("touchmove", function(event) {

            var touch = event.touches[0];
            draw(touch);
            event.preventDefault();

        });

        canvas.addEventListener("touchend", stopDrawing);

        document.getElementById("btn_limpar").addEventListener("click", function() {

            context.clearRect(0, 0, canvas.width, canvas.height);

        });

    }

    function solicitar_mv() {

        var usu_mv = document.getElementById('valor_beep').value;
        var canvas = document.getElementById("sig-canvas");
        var escondidinho = document.getElementById('escondidinho').value = canvas.toDataURL('image/png');

        console.log(escondidinho);
        resultado = confirm("Realmente deseja criar a solicitação no MV?");

        if (resultado == true) {

            $('#exampleModalCenter').modal('hide');



            $.ajax({
                url: "funcoes/solicitacao/ajax_cria_sol_mv.php",
                type: "POST",
                data: {
                    usuario_solicitacao: usu_mv

                },
                cache: false,
                success: function(dataResult) {

                    //alert(dataResult);

                    corpo_tabela_realizadas();

                    $('#exibe_solsai').modal('show');

                    ajax_cadastra_assinatura(escondidinho, dataResult);

                    ajax_modal_solsai(dataResult);

                }
            });

        }

    };

    function ajax_cadastra_assinatura(var_escondi, var_cd_sol_mv) {

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
            success: function(dataResult) {

                //console.log(dataResult);

                if (dataResult == 'Sucesso') {

                    //MENSAGEM            
                    var_ds_msg = 'Assinatura%20cadastrada%20com%20sucesso!';
                    var_tp_msg = 'alert-success';
                    //var_tp_msg = 'alert-danger';
                    //var_tp_msg = 'alert-primary';
                    $('#mensagem_acoes').load('config/mensagem/ajax_mensagem_acoes.php?ds_msg=' + var_ds_msg + '&tp_msg=' + var_tp_msg);

                } else {

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

    if (var_usu_sol != '') {

        //MENSAGEM            
        var_ds_msg = 'Usuario%20encontrado!';
        var_tp_msg = 'alert-success';
        //var_tp_msg = 'alert-danger';
        //var_tp_msg = 'alert-primary';
        $('#mensagem_acoes').load('funcoes/ajax_mensagem_acoes.php?ds_msg=' + var_ds_msg + '&tp_msg=' + var_tp_msg);

    } else {

        //MENSAGEM            
        var_ds_msg = 'Usuario%20não%20encontrado!';
        //var_tp_msg = 'alert-success';
        var_tp_msg = 'alert-danger';
        //var_tp_msg = 'alert-primary';
        $('#mensagem_acoes').load('funcoes/ajax_mensagem_acoes.php?ds_msg=' + var_ds_msg + '&tp_msg=' + var_tp_msg);

    }

    //SALVA A IMAGEM DA ASSINATURA

    document.getElementById("sig-submitBtn").addEventListener("click", function() {

        var canvas = document.getElementById("sig-canvas");

        document.getElementById('escondidinho').value = canvas.toDataURL('image/png');


    });
    (function() {

        // Get a regular interval for drawing to the screen
        window.requestAnimFrame = (function(callback) {
            return window.requestAnimationFrame ||
                window.webkitRequestAnimationFrame ||
                window.mozRequestAnimationFrame ||
                window.oRequestAnimationFrame ||
                window.msRequestAnimaitonFrame ||
                function(callback) {
                    window.setTimeout(callback, 1000 / 60);
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
        clearBtn.addEventListener("click", function(e) {
            clearCanvas();
            sigText.innerHTML = "Data URL for your signature will go here!";
            sigImage.setAttribute("src", "");
        }, false);

        // Set up mouse events for drawing
        var drawing = false;
        var mousePos = {
            x: 0,
            y: 0
        };
        var lastPos = mousePos;
        canvas.addEventListener("mousedown", function(e) {
            drawing = true;
            lastPos = getMousePos(canvas, e);
        }, false);
        canvas.addEventListener("mouseup", function(e) {
            drawing = false;
        }, false);
        canvas.addEventListener("mousemove", function(e) {
            mousePos = getMousePos(canvas, e);
        }, false);

        // Set up touch events for mobile, etc
        canvas.addEventListener("touchstart", function(e) {
            mousePos = getTouchPos(canvas, e);
            var touch = e.touches[0];
            var mouseEvent = new MouseEvent("mousedown", {
                clientX: touch.clientX,
                clientY: touch.clientY
            });
            canvas.dispatchEvent(mouseEvent);
        }, false);
        canvas.addEventListener("touchend", function(e) {
            var mouseEvent = new MouseEvent("mouseup", {});
            canvas.dispatchEvent(mouseEvent);
        }, false);
        canvas.addEventListener("touchmove", function(e) {
            var touch = e.touches[0];
            var mouseEvent = new MouseEvent("mousemove", {
                clientX: touch.clientX,
                clientY: touch.clientY
            });
            canvas.dispatchEvent(mouseEvent);
        }, false);

        // Prevent scrolling when touching the canvas
        document.body.addEventListener("touchstart", function(e) {
            if (e.target == canvas) {
                e.preventDefault();
            }
        }, false);
        document.body.addEventListener("touchend", function(e) {
            if (e.target == canvas) {
                e.preventDefault();
            }
        }, false);
        document.body.addEventListener("touchmove", function(e) {
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
        (function drawLoop() {
            requestAnimFrame(drawLoop);
            renderCanvas();
        })();

    })();
</script>