
/*

EXEMPLO TESTE: 

BEGIN
  portal_sesmt.PRC_ACOES_SOL(13,'TESTE_PROC');
END;

*/


BEGIN 
  portal_sesmt.PRC_ACOES_DURABILIDADE(10 ,'LDPGOMES'); 
END;


DROP PROCEDURE portal_sesmt.PRC_ACOES_DURABILIDADE

CREATE OR REPLACE PROCEDURE portal_sesmt.PRC_ACOES_DURABILIDADE(
                                                                  VAR_DUR NUMBER, 
                                                                  VAR_USU_DUR VARCHAR2
                                                                  --TP_ACAO_DUR VARCHAR
                                                                )
IS

BEGIN
  
   /**********/
   /*EXCLUSAO*/
   /**********/

   --PRIMEIRA ETAPA
   --SALVA AS INFORMACOES NO LOG   
   INSERT INTO portal_sesmt.LOG_DURABILIDADE  
   SELECT 
   portal_sesmt.SEQ_CD_LOG_DURABILIDADE.NEXTVAL AS CD_LOG_DURABILIDADE,
   'E' AS TP_LOG, --E (EXCLUSAO)
   VAR_USU_DUR AS CD_USUARIO_LOG,
   sol.*
   FROM portal_sesmt.DURABILIDADE dur
   WHERE dur.CD_DURABILIDADE = VAR_DUR;    
   
   --SEGUNDA ETAPA
   --EXCLUE DA TABELA SOLICITACAO   
   DELETE FROM portal_sesmt.DURABILIDADE dur 
   WHERE dur.CD_DURABILIDADE = VAR_DUR;   
   
   --COMMIT
   COMMIT;

END;
