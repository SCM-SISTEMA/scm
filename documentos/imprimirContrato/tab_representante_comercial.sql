CREATE TABLE comercial.tab_representante_comercial
(
   cod_representante_comercial serial, 
   nome character varying(100), 
   nacionalidade character varying(50), 
   estado_civil_fk bigint, 
   profissao character varying(120), 
   cpf character varying(12), 
   rg character varying(15), 
   secretaria character varying(2), 
   dt_nascimento date, 
   contador character varying(150), 
   cod_cliente_fk bigint, 
   PRIMARY KEY (cod_representante_comercial), 
   FOREIGN KEY (cod_cliente_fk) REFERENCES public.tab_cliente (cod_cliente) ON UPDATE NO ACTION ON DELETE NO ACTION
) 
WITH (
  OIDS = FALSE
)
;
COMMENT ON COLUMN comercial.tab_representante_comercial.nome IS 'Nome';
COMMENT ON COLUMN comercial.tab_representante_comercial.nacionalidade IS 'Nacionalidade';
COMMENT ON COLUMN comercial.tab_representante_comercial.estado_civil_fk IS 'Estado Civil';
COMMENT ON COLUMN comercial.tab_representante_comercial.profissao IS 'Profissão';
COMMENT ON COLUMN comercial.tab_representante_comercial.rg IS 'RG';
COMMENT ON COLUMN comercial.tab_representante_comercial.secretaria IS 'SSP';
COMMENT ON COLUMN comercial.tab_representante_comercial.dt_nascimento IS 'Nascimento';
COMMENT ON COLUMN comercial.tab_representante_comercial.contador IS 'Contator';
