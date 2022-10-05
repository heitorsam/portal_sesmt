<?php 

    include '../../conexao.php';

    $cons_filtro = "SELECT res.QTD
    FROM (SELECT *
            FROM (SELECT '01' AS MES
                    FROM DUAL
                UNION ALL
                SELECT '02' AS MES
                    FROM DUAL
                UNION ALL
                SELECT '03' AS MES
                    FROM DUAL
                UNION ALL
                SELECT '04' AS MES
                    FROM DUAL
                UNION ALL
                SELECT '05' AS MES
                    FROM DUAL
                UNION ALL
                SELECT '06' AS MES
                    FROM DUAL
                UNION ALL
                SELECT '07' AS MES
                    FROM DUAL
                UNION ALL
                SELECT '08' AS MES
                    FROM DUAL
                UNION ALL
                SELECT '09' AS MES
                    FROM DUAL
                UNION ALL
                SELECT '10' AS MES
                    FROM DUAL
                UNION ALL
                SELECT '11' AS MES
                    FROM DUAL
                UNION ALL
                SELECT '12' AS MES
                    FROM DUAL) PERIODOS) peri
    LEFT JOIN (SELECT TO_CHAR(sol.hr_cadastro, 'MM') as mes, COUNT(*) as qtd
                FROM portal_sesmt.solicitacao sol
                WHERE TO_CHAR(sol.hr_cadastro, 'YYYY') = TO_CHAR(SYSDATE, 'YYYY')
            GROUP BY TO_CHAR(sol.hr_cadastro, 'MM')) res
    ON peri.MES = res.MES
    ORDER BY peri.MES ASC
    ";    




    $result_filtro = oci_parse($conn_ora, $cons_filtro);

    oci_execute($result_filtro);

?>


<div class="col-md-12">
        <canvas id="myChart" style="width: 800px;max-width:800px; margin: 0 auto;"></canvas>
</div>


<script>
    var ctx = document.getElementById("myChart").getContext("2d")

    var data = {
        labels: ["Jan", "Fev", "Mar","Abr", "Mai","Jun","Jul","Aug","Set","Out","Nov","Dez"],
        datasets: [
            {
                label: "Solicitações",
                backgroundColor: "#A2B3FC",
                data: [<?php 
                            while($row_1 =  oci_fetch_array($result_filtro)){
                                echo $row_1['QTD'].',';
                            }?>]
            }
        ]
    }

    var myBarChart = new Chart(ctx, {
        type: 'bar',
        data: data,
        options: {
            barValueSpacing: 20,
            scales: {
                yAxes: [{
                    ticks: {
                        min: 0,
                    }
                }]
            }
        }
    })

</script>