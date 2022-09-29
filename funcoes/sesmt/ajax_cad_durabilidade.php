<?php

session_start();

include '../../conexao.php';

$var_pr_durabilidade= $_POST['produto_durabilidade']; 
$var_dt_durabilidade= $_POST['dias_durabilidade']; 
$var_usu_cad_durabilidade = $_SESSION['usuarioLogin']; 

$consulta_insert_durabilidade = " INSERT INTO portal_sesmt.DURABILIDADE 
                                  SELECT 
                                  portal_sesmt.SEQ_CD_DURABILIDADE.NEXTVAL AS CD_DURABILIDADE,
                                  '$var_pr_durabilidade' AS CD_PRODUTO_MV,
                                  'S' AS SN_ATIVO,
                                  '$var_dt_durabilidade' AS DIAS,
                                  '$var_usu_cad_durabilidade' AS CD_USUARIO_CADASTRO,
                                  SYSDATE  AS HR_CADASTRO,
                                  NULL  AS CD_USUARIO_ULT_ALT,
                                  SYSDATE AS HR_ULT_ALT
                                  FROM DUAL";

$insert_durabilidade = oci_parse($conn_ora, $consulta_insert_durabilidade);

$valida = oci_execute($insert_durabilidade);

    //VALIDACAO
    if (!$valida) {   
        
        $erro = oci_error($insert_durabilidade);																							
        $msg_erro = htmlentities($erro['message']);
        //header("Location: $pag_login");
        //echo $erro;
        echo $msg_erro ;

    }else{

        echo 'Cadastrado com sucesso!';
        
    }


?>