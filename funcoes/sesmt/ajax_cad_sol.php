<?php

    session_start();

    include '../../conexao.php';

    $var_qtd = $_POST['quantidade']; 
    $var_set = $_POST ['cd_setor'];
    $var_pro = $_POST ['cd_produto'];
    $var_usuario = $_POST['cd_usuario'];
    $var_usu_cad = $_SESSION['usuarioLogin'];

    if($var_qtd <= 0){

        echo 'Informe%20um%20Valor%20Valido!';

    }else{

        $insert_oracle = "INSERT INTO portal_sesmt.SOLICITACAO
        SELECT portal_sesmt.SEQ_CD_SOLICITACAO.NEXTVAL AS CD_SOLICITACAO,
        UPPER('$var_usuario') AS CD_USUARIO_MV,
        '$var_set' AS CD_SETOR_MV,
        '$var_pro' AS CD_PRODUTO_MV,
        (SELECT SUBSTR(SUBSTR(prod.DS_PRODUTO,
        INSTR(prod.DS_PRODUTO, '(CA') + 1,
        INSTR(prod.DS_PRODUTO, ')') -
        INSTR(prod.DS_PRODUTO, '(CA') - 1),3,10) AS CA
        FROM dbamv.PRODUTO prod
        WHERE prod.DS_PRODUTO LIKE '%(CA %'
        AND prod.CD_PRODUTO = '$var_pro'
        ) AS CA_MV, 
        (SELECT dur.CD_DURABILIDADE
             FROM portal_sesmt.DURABILIDADE dur 
          WHERE dur.CD_PRODUTO_MV = '$var_pro') AS CD_DURABILIDADE,
        '$var_qtd' AS QUANTIDADE, 
        UPPER('$var_usu_cad') AS CD_USUARIO_CADASTRO, 
        SYSDATE AS HR_CADASTRO, 
        NULL AS CD_USUARIO_ULT_ALT, 
        NULL AS HR_ULT_ALT         
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

            echo 'Sucesso';

        }

    }    

?>