<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<title>PDF</title>
	<head>
	<body>
<?php


/*header("Content-Type: application/vnd.ms-excel; charset=utf-8");*/
header("Content-Disposition: attachment; filename=relatorio.pdf");  ///NOME DO ARQUIVO
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);


//CONEXÃO ORACLE
include 'conexao.php';

//RECEBENDO VARIAVEIS
$centro_custo_ex = $_GET['get_var_centro'];
$data_inial_ex = $_GET['get_dt_ini'] ;
$data_final_ex =  $_GET['get_dt_fim'];
$cd_usuario_relatorio_ex = $_GET['get_usu_rel'];
$var_define_pdf = $_GET['get_parametro_pdf'];

$html = '';

//if($var_define_pdf == 'N'){

//FAZ O SELECT SEM O PARAMETRO DS_JUST IS NOT NULL
$consulta_excel_oracle = "SELECT sol.CD_SOLICITACAO,
                            (SELECT usu.NM_FUNCIONARIO FROM dbamv.STA_TB_FUNCIONARIO usu WHERE RPAD(('00000' || TO_CHAR(CHAPA)), 11, 0) = LPAD(sol.CD_USUARIO_MV,11)) AS NM_USU,
                            TO_CHAR(sol.HR_CADASTRO, 'DD/MM/YYYY') AS HR_CADASTRO,
                            sol.CD_SETOR_MV,
                            (SELECT st.NM_SETOR
                            FROM dbamv.SETOR st
                            WHERE st.SN_ATIVO = 'S'
                                AND st.CD_SETOR = sol.CD_SETOR_MV) AS NM_SETOR,
                            sol.CD_PRODUTO_MV,
                            pro.DS_PRODUTO,
                            (SELECT CASE
                                    WHEN dur.DIAS < 2 THEN
                                    dur.DIAS || ' Dia'
                                    WHEN dur.DIAS >= 2 THEN
                                    dur.DIAS || ' Dias'
                                    ELSE
                                    ''
                                    END
                            FROM portal_sesmt.DURABILIDADE dur
                            WHERE dur.CD_PRODUTO_MV = sol.CD_PRODUTO_MV) AS DT_DURABILIDADE,
                            (SELECT csa.CA_SOL FROM portal_sesmt.VW_CA_SOL_ATUAL csa WHERE csa.CD_SOLICITACAO = sol.CD_SOLICITACAO
                            ) AS CA_MV,
                            CASE
                                WHEN COUNT(sol.DS_JUST_DUR) > 0 THEN 'Excesso'
                                ELSE
                                '-'
                            END AS EX_SOL,
                            sol.QUANTIDADE,
                            (SELECT usu.nm_usuario FROM dbasgu.usuarios usu WHERE usu.cd_usuario = sol.CD_USUARIO_CADASTRO) NM_USUARIO_CADASTRO,
                            (SELECT edc.EDITADO_SN FROM portal_sesmt.EDITAR_CA edc WHERE edc.CD_SOLICITACAO = sol.CD_SOLICITACAO
                            ) AS EDITADO_SN,
                            (SELECT ass.BLOB_ASS 
                                     FROM portal_sesmt.ASSINATURA ass
                                     INNER JOIN portal_sesmt.SOLICITACAO_MV sm
                                     ON sm.CD_SOLSAI_PRO = ass.CD_SOLICITACAO_MV
                                     WHERE sm.CD_SOLICITACAO = sol.CD_SOLICITACAO ) AS BLOB_ASS 
                            FROM portal_sesmt.SOLICITACAO sol
                            INNER JOIN dbamv.PRODUTO pro
                            ON pro.CD_PRODUTO = sol.CD_PRODUTO_MV
                            WHERE TRUNC(sol.HR_CADASTRO) BETWEEN
                            TRUNC(TO_DATE('$data_inial_ex', 'YYYY-MM-DD')) AND
                            TRUNC(TO_DATE('$data_final_ex', 'YYYY-MM-DD'))";

if($centro_custo_ex <> 'all'){

    $consulta_excel_oracle .= " AND sol.CD_SETOR_MV = '$centro_custo_ex'";

}

if($cd_usuario_relatorio_ex <> 'all'){

    $consulta_tabela_rel .= " AND LPAD(sol.CD_USUARIO_MV,11) = RPAD(('00000' || TO_CHAR($cd_usuario_relatorio_ex)), 11, 0)";

}

if($var_define_pdf == 'S'){

    $consulta_excel_oracle .= " AND sol.DS_JUST_DUR IS NOT NULL";

}

$consulta_excel_oracle .= " GROUP BY sol.CD_SOLICITACAO, sol.CD_SETOR_MV, sol.CD_PRODUTO_MV, pro.DS_PRODUTO, sol.QUANTIDADE, sol.HR_CADASTRO, sol.CD_USUARIO_MV, sol.CD_DURABILIDADE,
                                    sol.CD_USUARIO_CADASTRO
                           ORDER BY sol.CD_SOLICITACAO DESC";

$rest_cons_excel = oci_parse($conn_ora, $consulta_excel_oracle);

oci_execute($rest_cons_excel);

?>

<!--ESTRUTURA DA TABELA-->

<?php

    $html .= '<style>
     table, th, td {

        border: solid 1 px black;
        border-collapse: collapse;
        font-size: 12px;
     }

     .assinatura {

        width: 80px;
        height: 25px;
        margin: 0 auto; 
        
     }
    
    </style>';
    $html .= '<table align="center">';
    $html .= '<thead align="center">';
    $html .= '<tr>';
    $html .= '<th>Solicitação</th>';
    $html .= '<th>Usuario</th>';
    $html .= '<th>Setor</th>';
    $html .= '<th>Entrega</th>';
    $html .= '<th>Codigo</th>';
    $html .= '<th>Produto</th>';
    $html .= '<th>Durabilidade</th>';
    $html .= '<th>C.A</th>';
    $html .= '<th>Excesso</th>';
    $html .= '<th>Quantidade</th>';
    //$html .= '<th>Funcionario</th>';
    $html .= '<th>Assinatura</th>';
    $html .= '</tr>';
    $html .= '</thead>';

    while($row_tabela_excel = oci_fetch_array($rest_cons_excel)){
    
        $html .= '<tbody align="center">';
        $html .= '<tr><td>' . $row_tabela_excel['CD_SOLICITACAO'] . "</td>";
        $html .= '<td>' . $row_tabela_excel['NM_USU'] . "</td>" ;
        $html .= '<td>' . $row_tabela_excel['NM_SETOR'] . "</td>" ;
        $html .= '<td>' . $row_tabela_excel['HR_CADASTRO'] . "</td>" ;
        $html .= '<td>' . $row_tabela_excel['CD_PRODUTO_MV'] . "</td>" ;
        $html .= '<td>' . $row_tabela_excel['DS_PRODUTO'] . "</td>" ;
        $html .= '<td>' . $row_tabela_excel['DT_DURABILIDADE'] . "</td>" ;
        $html .= '<td>' . $row_tabela_excel['CA_MV'] . "</td>" ;
        $html .= '<td>' . $row_tabela_excel['EX_SOL'] . "</td>" ;
        $html .= '<td>' . $row_tabela_excel['QUANTIDADE'] . "</td>" ;

        if(isset($row_tabela_excel['BLOB_ASS'])){

            $imgs = $row_tabela_excel['BLOB_ASS']->load();
            $image = base64_encode($imgs);

            $html .=  '<td><img class="assinatura" src="data:image;base64,' . $image . '"/></td>';

        } else{

            $html .= '<td class="align-middle"> - </td>';  

        }
           $html .= '</tbody>';        

?>

<?php

    }

    $html .= '</table>';

// inclusão da biblioteca
include 'dompdf/autoload.inc.php';

// alguns ajustes devido a variações de servidor para servidor

use Dompdf\Dompdf;
use Dompdf\Options;

// abertura de novo documento
$dompdf = new DOMPDF();

// carregar o HTML
$dompdf->load_html(

'<div>

    <div class="row">

        <div class="col-md-4" style="border: none !important; line-height: 23 !important; padding-top:10px; margin: 0 auto !important;">
            <img src="https://www.santacasasjc.com.br/wp-content/uploads/2018/06/logotipo-santa-casa-sjc-210x75.png" alt="Logo Santa Casa" width="200 px" height="70 px" >
        </div>

    </div>

        <div style="border: none !important; text-align: center;">
        
            <h2>Santa Casa de Misericórdia de São José dos Campos</h2>
            <h3>Rua Dolzani Ricardo, 620 - Fone: (012) 3876-1999<br>CEP 12210-110 - São José dos Campos - SP<br>CNPJ 45.186.053/0001-87</h3>
            <h3>Solicitações SESMT</h3>
        
        </div>

    </div>
    
</div>' 

. $html . '  ');
$dompdf->set_option('isRemoteEnabled', true); 

// dados do documento destino
$dompdf->set_paper("A4", "landscape");

// gerar documento destino
$dompdf->render();

header ("Content-type: application/pdf");
echo $dompdf->output();/*

$mpdf = new \Mpdf\Mpdf();
$mpdf->AddPage('L'); // margin footer
$mpdf->WriteHTML($html);
$mpdf->Output($arquivo, 'I');*/

?>

</body>
</html>