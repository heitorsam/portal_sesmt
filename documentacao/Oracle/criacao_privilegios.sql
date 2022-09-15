CREATE USER portal_projetos IDENTIFIED BY sjc_arroz_doce_piui_2022;

GRANT CREATE SESSION TO portal_projetos;
GRANT CREATE PROCEDURE TO portal_projetos;
GRANT CREATE TABLE TO portal_projetos;
GRANT CREATE VIEW TO portal_projetos;
GRANT UNLIMITED TABLESPACE TO portal_projetos;
GRANT CREATE SEQUENCE TO portal_projetos;

GRANT EXECUTE ON dbasgu.FNC_MV2000_HMVPEP TO portal_projetos;

GRANT SELECT ON dbasgu.USUARIOS TO portal_projetos;
GRANT SELECT ON dbasgu.PAPEL_USUARIOS TO portal_projetos;

/*
GRANT SELECT ON dbamv.ATENDIME TO portal_same;
GRANT SELECT ON dbamv.PACIENTE TO portal_same;
GRANT SELECT ON dbamv.PRESTADOR TO portal_same;
GRANT SELECT ON dbamv.LEITO TO portal_same;
GRANT SELECT ON dbamv.UNID_INT TO portal_same;
GRANT SELECT ON dbamv.SETOR TO portal_same;
GRANT SELECT ON dbamv.TIP_PRESC TO portal_same;
GRANT SELECT ON dbamv.UNI_PRO TO portal_same;
GRANT SELECT ON dbamv.TIP_PRESC TO portal_same;
GRANT SELECT ON dbamv.TIP_ESQ TO portal_same;
GRANT SELECT ON dbamv.MOV_INT TO portal_same;
GRANT SELECT ON dbamv.HRITPRE_CONS TO portal_same;
GRANT SELECT ON dbamv.ITPRE_MED TO portal_same;
GRANT SELECT ON dbamv.PRE_MED TO portal_same;
GRANT SELECT ON dbamv.CONVENIO TO portal_same;
GRANT SELECT ON dbamv.TIP_FRE TO portal_same;
GRANT SELECT ON dbamv.TIP_PRESTA TO portal_same;
GRANT SELECT ON dbamv.TISS_GUIA TO portal_same;
GRANT SELECT ON dbamv.TISS_ITGUIA TO portal_same;
GRANT SELECT ON dbamv.CONVENIO TO portal_same;

GRANT INSERT ON dbamv.PRESTADOR_ASSINATURA TO portal_same;
GRANT UPDATE ON dbamv.PRESTADOR_ASSINATURA TO portal_same;
GRANT DELETE ON dbamv.PRESTADOR_ASSINATURA TO portal_same;

grant execute on PKG_TISS_UTIL to portal_same;
*/
