
<?php 
    session_start();
    
    include '../conexao.php';

    $var_id = $_GET['codigo'];    

    $consulta_deletar = "DELETE FROM portal_same.tp_documento_anexo tda
                         WHERE tda.TP_DOCUMENTO = '$var_id'";

    echo $consulta_deletar;


    $result_oracle = oci_parse($conn_ora,$consulta_deletar);

    $valida = oci_execute($result_oracle);
    
    if(!$valida){
    
        $erro =  oci_error($result_oracle);
        $_SESSION['msgerro'] = htmlentities($erro['message']);
    
    }else{
    
        $_SESSION['msg'] = 'Apagado com Sucesso!';
    }
    
    
    header("Location:../estrutura_configuracoes.php");
    


?>