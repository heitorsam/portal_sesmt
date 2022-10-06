<?php

    session_start();

    include '../../conexao.php';

    $var_qtd = $_POST['quantidade']; 
    $var_set = $_POST ['cd_setor'];
    $var_pro = $_POST ['cd_produto'];
    $var_usuario = $_POST['cd_usuario'];
    $var_usu_cad = $_SESSION['usuarioLogin'];
    $data_soli = str_replace("T", " ",$_POST['data']);
    $tipo = $_POST['tipo'];


    if($tipo == 'S'){
        $data_hist = 'SYSDATE';
  

    }else{
        $data_hist = 'NULL';

    }

    

    if($var_qtd <= 0){

        echo 'Informe%20um%20Valor%20Valido!';

    }else{

        $consulta_nextval = "SELECT portal_sesmt.SEQ_CD_SOLICITACAO.NEXTVAL AS CD_SOLICITACAO FROM DUAL";

        $result_nextval = oci_parse($conn_ora, $consulta_nextval);

        oci_execute($result_nextval);

        $row_nextval = oci_fetch_array($result_nextval);

        $nextval = $row_nextval['CD_SOLICITACAO'];

        $insert_oracle = "INSERT INTO portal_sesmt.SOLICITACAO
        SELECT  $nextval AS CD_SOLICITACAO,
        UPPER('$var_usuario') AS CD_USUARIO_MV,
        '$var_set' AS CD_SETOR_MV,
        '$var_pro' AS CD_PRODUTO_MV,
        (SELECT dur.CD_DURABILIDADE
             FROM portal_sesmt.DURABILIDADE dur 
          WHERE dur.CD_PRODUTO_MV = '$var_pro') AS CD_DURABILIDADE,
        '$var_qtd' AS QUANTIDADE, 
        UPPER('$var_usu_cad') AS CD_USUARIO_CADASTRO, ";
        if($tipo == 'N'){
            $insert_oracle .= "SYSDATE AS HR_CADASTRO, ";
        }else{
            $insert_oracle .= "TO_DATE('$data_soli','YYYY-MM-DD HH24:MI') AS HR_CADASTRO, "; 
        }
        $tipo = "'".$tipo."'";

        $insert_oracle .= "NULL AS CD_USUARIO_ULT_ALT, 
        NULL AS HR_ULT_ALT,
        $tipo AS SN_HISTORICO,
        $data_hist AS HR_SOLICITACAO_HISTORICO         
        FROM DUAL";

        $res_insert_oracle = oci_parse($conn_ora, $insert_oracle);

        $valida = oci_execute($res_insert_oracle);

        //VALIDACAO
        if (!$valida) {   

            $erro = oci_error($res_insert_oracle);																							
            $msg_erro = htmlentities($erro['message']);
            //header("Location: $pag_login");
            //echo $erro;
            echo $msg_erro;

        }else{

            $insert_ca = "INSERT INTO portal_sesmt.EDITAR_CA 
                            SELECT  $nextval AS CD_SOLICITACAO,
                            (SELECT SUBSTR(SUBSTR(prod.DS_PRODUTO,
                            INSTR(prod.DS_PRODUTO, '(CA') + 1,
                            INSTR(prod.DS_PRODUTO, ')') -
                            INSTR(prod.DS_PRODUTO, '(CA') - 1),3,10) AS CA
                            FROM dbamv.PRODUTO prod
                            WHERE prod.DS_PRODUTO LIKE '%(CA %'
                            AND prod.CD_PRODUTO = $var_pro
                            ) AS CA,
                            'N' AS EDITADO_SN
                            FROM DUAL";
            $result_ca = oci_parse($conn_ora, $insert_ca);

            $valida_ca = oci_execute($result_ca);

            if(!$valida_ca){
                $erro = oci_error($result_ca);																							
                $msg_erro = htmlentities($erro['message']);
                //header("Location: $pag_login");
                //echo $erro;
                echo $msg_erro;
            }else{
                echo 'Sucesso';
            }

        }

    }    

?>