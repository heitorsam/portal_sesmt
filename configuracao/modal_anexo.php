<?php

  $id = $row_oracle['TP_DOCUMENTO'];


?>

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#edit_modal<?php echo $id; ?>">
<i class="fa-solid fa-pencil"></i>
</button>

<!-- Modal -->
<div class="modal fade" id="edit_modal<?php echo $id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body" style='margin: 0 auto !important;'>

            <form method='POST' action='configuracao/anexo_editar.php'>

              <div class='row'>

                <div class='col-md-2' style='text-align:left'>

                  Doc. </br>
                  <input class="form-control" name='frm_tpdoc' value="<?php echo $id;?>" type="text" readonly>

                </div>

                <div class='col-md-4' style='text-align:left'>

                  Descrição:
                  <input class='form-control' name='frm_desc' value="<?php echo $row_oracle['DS_DOCUMENTO'];?>" type='text' placeholder= 'Descrição' readonly> 

                </div>

                <div class='col-md-3' style='text-align:left'>

                  Obrigatório:
                  <select class='form-control' name='frm_obg' value="<?php echo $row_oracle['TP_OBRIGATORIO'];?>" type='text'> 

                  <option value="S"> Sim </option>
                  <option value="N"> Não </option>
                  <option value="O"> Outros </option>

                  </select>

                </div>
              

                  <div class='col-md-3' style='text-align:left'>

                    Motivo:
                    <select class='form-control' name='frm_mot' value="<?php echo $row_oracle['TP_PARENTE_MOTIVO'];?>" type='text' placeholder= 'Obrigatorio?'> 

                    <option value=""> Nenhum </option>
                    <option value="O"> Óbito </option>
                    <option value="J"> Judicial </option>

                    </select>

                  </div>
              </div>

              <br><hr>

              <div class='row'>

                <div class='col-md-3' style='text-align:left'>

                  Parentesco:
                  <select class='form-control' name='frm_par' value="<?php echo $row_oracle['TP_PARENTE_PARENTESCO'];?>" type='text' placeholder= 'Obrigatorio?'> 

                  <option value=""> Nenhum </option>
                  <option value="C"> Casamento </option>
                  <option value="D"> Descendente </option>
                  <option value="A"> Ascendente </option>
                  <option value="I"> Irmão </option>
                  <option value="T"> 3° Grau </option>
                  <option value="Q"> 4° Grau </option>

                  </select>

                </div>

                <div class='col-md-3' style='text-align:left'>

                  Distância:
                  <select class='form-control' name='frm_dist' value="<?php echo $row_oracle['TP_DISTANCIA'];?>" type='text' placeholder= 'Obrigatorio?'> 

                  <option value="P"> Presencial </option>
                  <option value="D"> Distancia </option>
                  <option value="A"> Ambos </option>

                  </select>

                </div>  

                <div class='col-md-3' style='text-align:left'>

                Requerente:
                <select class='form-control' name='frm_req' value="<?php echo $row_oracle['TP_REQUERENTE'];?>" type='text' placeholder= 'Obrigatorio?'> 

                <option value=""> Nenhum </option>
                <option value="A"> Paciente </option>
                <option value="R"> Representante Legal </option>
                <option value="T"> Tutor/Curador </option>
                <option value="P"> Parente </option>

                </select>

                </div> 

              </div>

            <br>

            <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa-solid fa-xmark"></i> Fechar</button>
                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Salvar</button>
            </div>
          
  
          </form>


        </div>
    </div>
  </div>
</div>