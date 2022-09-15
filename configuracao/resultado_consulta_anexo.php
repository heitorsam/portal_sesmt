<?php

    include 'conexao.php';


?>

<?php

    $consulta_oracle = "SELECT TP_DOCUMENTO,
                               DS_DOCUMENTO,
                               TP_OBRIGATORIO,
                               TP_PARENTE_MOTIVO,
                               TP_PARENTE_PARENTESCO,
                               TP_DISTANCIA,
                               TP_REQUERENTE,
                               CD_USUARIO_CADASTRO,
                               TO_CHAR(HR_CADASTRO,'DD/MM/YYYY HH24:MI') AS HR_CADASTRO,
                               CD_USUARIO_ULT_ALT,
                               TO_CHAR(HR_ULT_ALT,'DD/MM/YYYY HH24:MI') AS HR_ULT_ALT   
                        FROM portal_same.tp_documento_anexo
                        ORDER BY TP_DOCUMENTO DESC";

    $result_oracle = oci_parse($conn_ora,$consulta_oracle);

    oci_execute($result_oracle);

?>

<!--TABELA-->
<div class="table-responsive col-md-12" style="padding: 0px !important;">

    <table class="table table-striped" cellspacing="0" cellpadding="0">

        <thead>

            <tr> <!--TITULOS DA TABELA-->

                <th style="text-align: center;">Doc.</th>
                <th style="text-align: center;">Descrição</th>
                <th style="text-align: center;">Obrigatório</th>
                <th style="text-align: center;">Motivo</th>
                <th style="text-align: center;">Parentesco</th>
                <th style="text-align: center;">Distância</th>
                <th style="text-align: center;">Requerente</th>
                <th style="text-align: center;">Usuário</th>
                <th style="text-align: center;">Hora</th>
                <th style="text-align: center;">Ultima Alteração</th>
                <th style="text-align: center;">Opcões</th>

            </tr>

        </thead>

        <tbody>
        
            <?php

                while($row_oracle = oci_fetch_array($result_oracle)){

                    echo '</tr>';

                        echo '<td class="align-middle" style="text-align: center;">' . $row_oracle['TP_DOCUMENTO'] . '</td>';
                        echo '<td class="align-middle" style="text-align: center;">' . $row_oracle['DS_DOCUMENTO'] . '</td>';
                        echo '<td class="align-middle" style="text-align: center;">' . $row_oracle['TP_OBRIGATORIO'] . '</td>';
                        echo '<td class="align-middle" style="text-align: center;">' . $row_oracle['TP_PARENTE_MOTIVO'] . '</td>';
                        echo '<td class="align-middle" style="text-align: center;">' . $row_oracle['TP_PARENTE_PARENTESCO'] . '</td>';
                        echo '<td class="align-middle" style="text-align: center;">' . $row_oracle['TP_DISTANCIA'] . '</td>';
                        echo '<td class="align-middle" style="text-align: center;">' . $row_oracle['TP_REQUERENTE'] . '</td>';
                        echo '<td class="align-middle" style="text-align: center;">' . $row_oracle['CD_USUARIO_CADASTRO'] . '</td>';
                        echo '<td class="align-middle" style="text-align: center;">' . $row_oracle['HR_CADASTRO'] . '</td>';
                        echo '<td class="align-middle" style="text-align: center;">' . $row_oracle['HR_ULT_ALT'] . '</td>';
                        echo '<td class="align-middle" style="text-align: center;">';
                        
                            echo '<a type="button" class="btn btn-adm"
                            href="configuracao/deletar_anexo.php?codigo='. $row_oracle['TP_DOCUMENTO'] . '">'. ' 
                            <i class="fa-solid fa-trash-can"></i></a>';  
                            
                            include 'configuracao/modal_anexo.php';

                        echo '</td>';
                        
                    echo '</tr>';


                }
            ?>

        </tbody>

    </table>

</div>