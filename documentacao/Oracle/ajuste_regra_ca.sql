SELECT prod.CD_PRODUTO, prod.DS_PRODUTO, prod.TP_ATIVO
FROM dbamv.PRODUTO prod
--UPDATE dbamv.PRODUTO prod SET prod.TP_ATIVO = 'S'
WHERE prod.DS_PRODUTO LIKE '%(CA%'
AND prod.TP_ATIVO = 'N'
AND prod.DS_PRODUTO NOT LIKE '%(CAA%'
AND prod.DS_PRODUTO NOT LIKE '%(CAB%'
AND prod.DS_PRODUTO NOT LIKE '%(CAC%'
AND prod.DS_PRODUTO NOT LIKE '%(CAD%'
AND prod.DS_PRODUTO NOT LIKE '%(CAE%'
AND prod.DS_PRODUTO NOT LIKE '%(CAF%'
AND prod.DS_PRODUTO NOT LIKE '%(CAG%'
AND prod.DS_PRODUTO NOT LIKE '%(CAH%'
AND prod.DS_PRODUTO NOT LIKE '%(CAI%'
AND prod.DS_PRODUTO NOT LIKE '%(CAJ%'
AND prod.DS_PRODUTO NOT LIKE '%(CAK%'
AND prod.DS_PRODUTO NOT LIKE '%(CAL%'
AND prod.DS_PRODUTO NOT LIKE '%(CAM%'
AND prod.DS_PRODUTO NOT LIKE '%(CAN%'
AND prod.DS_PRODUTO NOT LIKE '%(CAO%'
AND prod.DS_PRODUTO NOT LIKE '%(CAP%'
AND prod.DS_PRODUTO NOT LIKE '%(CAQ%'
AND prod.DS_PRODUTO NOT LIKE '%(CAR%'
AND prod.DS_PRODUTO NOT LIKE '%(CAS%'
AND prod.DS_PRODUTO NOT LIKE '%(CAT%'
AND prod.DS_PRODUTO NOT LIKE '%(CAU%'
AND prod.DS_PRODUTO NOT LIKE '%(CAV%'
AND prod.DS_PRODUTO NOT LIKE '%(CAW%'
AND prod.DS_PRODUTO NOT LIKE '%(CAX%'
AND prod.DS_PRODUTO NOT LIKE '%(CAY%'
AND prod.DS_PRODUTO NOT LIKE '%(CAZ%'
