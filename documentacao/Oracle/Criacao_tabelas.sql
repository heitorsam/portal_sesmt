--DURABILIDADE

-- CREATE TABLE 

DROP TABLE portal_sesmt.DURABILIDADE;

CREATE TABLE portal_sesmt.DURABILIDADE(
CD_DURABILIDADE     INT NOT NULL,
CD_PRODUTO_MV       INT NOT NULL,
SN_ATIVO            VARCHAR(1),
DIAS                INT NOT NULL,
CD_USUARIO_CADASTRO VARCHAR(20) not null,
HR_CADASTRO         TIMESTAMP(6) not null,
CD_USUARIO_ULT_ALT  VARCHAR2(20),
HR_ULT_ALT          TIMESTAMP(6),

--PRIMARY_KEY
CONSTRAINT PK_CD_DURABILIDADE PRIMARY KEY (CD_DURABILIDADE)
);

--SEQUENCE 
 
CREATE SEQUENCE portal_sesmt.SEQ_CD_DURABILIDADE  
START WITH 1    
INCREMENT BY 1
NOCACHE
NOCYCLE;




--SOLICITACAO
DROP TABLE portal_sesmt.SOLICITACAO;

CREATE TABLE portal_sesmt.SOLICITACAO(
CD_SOLICITACAO         INT NOT NULL,
CD_USUARIO_MV          VARCHAR(20),
CD_SETOR_MV            INT NOT NULL,
CD_PRODUTO_MV          INT NOT NULL,
CA_MV                  INT NOT NULL,
QUANTIDADE             INT NOT NULL,
CD_USUARIO_CADASTRO    VARCHAR(20) NOT NULL,
HR_CADASTRO            TIMESTAMP(6) NOT NULL,
CD_USUARIO_ULT_ALT     VARCHAR(20),
HR_ULT_ALT             TIMESTAMP,

--PRIMARY_KEY
CONSTRAINT PK_CD_SOLICITACAO PRIMARY KEY (CD_SOLICITACAO)
);

--SEQUENCE 
DROP SEQUENCE portal_sesmt.SEQ_CD_SOLICITACAO;
 
CREATE SEQUENCE portal_sesmt.SEQ_CD_SOLICITACAO  
START WITH 1    
INCREMENT BY 1
NOCACHE
NOCYCLE;

--LOG_SOLICITACAO
DROP TABLE portal_sesmt.LOG_SOLICITACAO;

CREATE TABLE portal_sesmt.LOG_SOLICITACAO(
CD_LOG_SOLICITACAO     INT NOT NULL,
TP_LOG                 VARCHAR(1) NOT NULL, --E (EXCLUSAO)
CD_USUARIO_LOG         VARCHAR(20) NOT NULL,
HR_ACAO_LOG            TIMESTAMP(6) NOT NULL,
CD_SOLICITACAO         INT NOT NULL,
CD_USUARIO_MV          VARCHAR(20),
CD_SETOR_MV            INT NOT NULL,
CD_PRODUTO_MV          INT NOT NULL,
CA_MV                  INT NOT NULL,
QUANTIDADE             INT NOT NULL,
CD_USUARIO_CADASTRO    VARCHAR(20) NOT NULL,
HR_CADASTRO            TIMESTAMP(6) NOT NULL,
CD_USUARIO_ULT_ALT     VARCHAR(20),
HR_ULT_ALT             TIMESTAMP,

--PRIMARY_KEY
CONSTRAINT PK_CD_LOG_SOLICITACAO PRIMARY KEY (CD_LOG_SOLICITACAO)
);

--SEQUENCE 
DROP SEQUENCE portal_sesmt.SEQ_CD_LOG_SOLICITACAO;
 
CREATE SEQUENCE portal_sesmt.SEQ_CD_LOG_SOLICITACAO  
START WITH 1    
INCREMENT BY 1
NOCACHE
NOCYCLE;



