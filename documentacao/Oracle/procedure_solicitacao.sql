--SELECT * FROM portal_sesmt.Solicitacao;
--SELECT * FROM portal_sesmt.LOG_Solicitacao;

/*

BEGIN
  portal_sesmt.PRC_ACOES_SOL(13,'TESTE_PROC');
END;

*/

CREATE OR REPLACE PROCEDURE portal_sesmt.PRC_ACOES_SOL(
                                                        VAR_SOL NUMBER, 
                                                        VAR_USU VARCHAR2
                                                        --TP_ACAO VARCHAR
                                                      )
IS
BEGIN
  
   /**********/
   /*EXCLUSAO*/
   /**********/

   --PRIMEIRA ETAPA
   --SALVA AS INFORMACOES NO LOG   
   INSERT INTO portal_sesmt.LOG_SOLICITACAO   
   SELECT 
   portal_sesmt.SEQ_CD_LOG_SOLICITACAO.NEXTVAL AS CD_LOG_SOLICITACAO,
   'E' AS TP_LOG, --E (EXCLUSAO)
   VAR_USU AS CD_USUARIO_LOG,
   SYSDATE AS HR_ACA_LOG,
   sol.*
   FROM portal_sesmt.SOLICITACAO sol
   WHERE sol.CD_SOLICITACAO = VAR_SOL;    
   
   --SEGUNDA ETAPA
   --EXCLUE DA TABELA SOLICITACAO   
   DELETE FROM portal_sesmt.SOLICITACAO sol
   WHERE sol.CD_SOLICITACAO = VAR_SOL;   
   
   --COMMIT
   COMMIT;

END;
