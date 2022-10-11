CREATE OR REPLACE VIEW portal_sesmt.VW_CA_SOL_ATUAL AS 

SELECT edc.CD_SOLICITACAO,
CASE
  WHEN edc.EDITADO_SN = 'S' THEN edc.MV_CA 
  ELSE (SELECT SUBSTR(SUBSTR(prod_ca.DS_PRODUTO,
                      INSTR(prod_ca.DS_PRODUTO, '(CA') + 1,
                      INSTR(prod_ca.DS_PRODUTO, ')') -
                      INSTR(prod_ca.DS_PRODUTO, '(CA') - 1),3,10) * 1 AS CA
                      FROM dbamv.PRODUTO prod_ca
                      WHERE prod_ca.DS_PRODUTO LIKE '%(CA %'
                      AND prod_ca.CD_PRODUTO = sol.CD_PRODUTO_MV
                      ) 
END AS CA_SOL
FROM portal_sesmt.EDITAR_CA edc 
INNER JOIN portal_sesmt.SOLICITACAO sol
  ON sol.CD_SOLICITACAO = edc.CD_SOLICITACAO
INNER JOIN dbamv.PRODUTO prod 
  ON prod.CD_PRODUTO = sol.CD_PRODUTO_MV
