CREATE USER portal_sesmt IDENTIFIED BY sjc_2000_50_15_bilolao;

GRANT CREATE SESSION TO portal_sesmt;
GRANT CREATE PROCEDURE TO portal_sesmt;
GRANT CREATE TABLE TO portal_sesmt;
GRANT CREATE VIEW TO portal_sesmt;
GRANT UNLIMITED TABLESPACE TO portal_sesmt;
GRANT CREATE SEQUENCE TO portal_sesmt;

GRANT INSERT ON portal_projetos.ACESSO TO portal_sesmt;

GRANT EXECUTE ON dbasgu.FNC_MV2000_HMVPEP TO portal_sesmt;

GRANT SELECT ON dbasgu.USUARIOS TO portal_sesmt;
GRANT SELECT ON dbasgu.PAPEL_USUARIOS TO portal_sesmt;

GRANT SELECT ON dbamv.PRODUTO TO portal_sesmt;
GRANT SELECT ON dbamv.SETOR TO portal_sesmt;
GRANT SELECT ON dbamv.UNI_PRO TO portal_sesmt;

GRANT SELECT ON dbamv.SOLSAI_PRO TO portal_sesmt;
GRANT INSERT ON dbamv.SOLSAI_PRO TO portal_sesmt;
GRANT SELECT ON dbamv.SEQ_SOLSAI_PRO TO portal_sesmt;

GRANT SELECT ON dbamv.ITSOLSAI_PRO TO portal_sesmt;
GRANT INSERT ON dbamv.ITSOLSAI_PRO TO portal_sesmt;
GRANT SELECT ON dbamv.SEQ_ITSOLSAI_PRO TO portal_sesmt;
GRANT SELECT ON dbamv.STA_TB_FUNCIONARIO TO portal_sesmt;


--DAR REVOKE
GRANT DELETE ON dbamv.SOLSAI_PRO TO portal_sesmt;
GRANT DELETE ON dbamv.ITSOLSAI_PRO TO portal_sesmt;

REVOKE DELETE ON dbamv.SOLSAI_PRO FROM portal_sesmt;
REVOKE DELETE ON dbamv.ITSOLSAI_PRO FROM portal_sesmt;


