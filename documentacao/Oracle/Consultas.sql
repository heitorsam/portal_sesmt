--CONSULTAS SOLICITACOES

SELECT usu.NM_USUARIO,
       usu.DS_OBSERVACAO AS DS_FUNCAO
FROM dbasgu.USUARIOS usu
WHERE usu.SN_ATIVO = 'S'
AND usu.CD_USUARIO = --VARIAVEL PHP

----------------------------------
--CONSULTAS SOLICITACOES ( C.A ) 


SELECT prod.CD_PRODUTO, prod.DS_PRODUTO, 
SUBSTR( prod.DS_PRODUTO,
    INSTR( prod.DS_PRODUTO, '(CA') + 1,
    INSTR( prod.DS_PRODUTO, ')') - INSTR( prod.DS_PRODUTO, '(CA') - 1) AS CA
FROM dbamv.PRODUTO prod
WHERE prod.DS_PRODUTO LIKE '%(CA %'
AND prod.TP_ATIVO = 'S'
ORDER BY 2 ASC
