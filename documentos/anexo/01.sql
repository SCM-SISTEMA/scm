
CREATE TABLE comercial.tab_contrato_anexo
(
  cod_contrato_anexo bigserial NOT NULL,
  nome character varying(50),
  url character varying(120),
  cod_contrato_fk bigint,
  CONSTRAINT tab_contrato_anexo_pkey PRIMARY KEY (cod_contrato_anexo),
  CONSTRAINT tab_contrato_anexo_cod_contrato_fk_fkey FOREIGN KEY (cod_contrato_fk)
      REFERENCES comercial.tab_contrato (cod_contrato) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
)
WITH (
  OIDS=FALSE
);
ALTER TABLE comercial.tab_contrato_anexo
  OWNER TO postgres;
