SELECT * FROM V$SQLAREA area 
WHERE area.PARSING_SCHEMA_NAME = 'HSSAMPAIO'
ORDER BY 1 DESC

SELECT *
FROM dbamv.SOLSAI_PRO sp
WHERE sp.CD_SOLSAI_PRO =  7035181;


SELECT *
FROM dbamv.ITSOLSAI_PRO itsp
WHERE itsp.CD_SOLSAI_PRO = 7035181;


--UNI PRO
SELECT uni_pro.ds_unidade , uni_pro.vl_fator , uni_pro.cd_uni_pro  
FROM dbamv.uni_pro uni_pro  
WHERE cd_produto = 43096 
AND uni_pro.sn_ativo = 'S' 

