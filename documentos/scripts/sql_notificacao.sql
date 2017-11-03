-- Table: public.tab_andamento

-- DROP TABLE public.tab_andamento;

CREATE TABLE public.tab_andamento
(
  cod_andamento bigint NOT NULL DEFAULT nextval('tab_notificacao_cod_notificacao_seq'::regclass),
  cod_assunto_fk bigint, -- attributo valor do assunto que é a notificação
  dt_inclusao timestamp without time zone DEFAULT now(),
  dt_exclusao timestamp without time zone,
  cod_tipo_contrato_fk bigint,
  txt_notificacao text,
  dt_retorno date,
  cod_modulo_fk bigint,
  CONSTRAINT pk_notificacao PRIMARY KEY (cod_andamento),
  CONSTRAINT tipo_contrato_notificacao FOREIGN KEY (cod_tipo_contrato_fk)
      REFERENCES comercial.tab_contrato_tipo_contrato (cod_contrato_tipo_contrato) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
)
WITH (
  OIDS=FALSE
);
ALTER TABLE public.tab_andamento
  OWNER TO postgres;
COMMENT ON COLUMN public.tab_andamento.cod_assunto_fk IS 'attributo valor do assunto que é a notificação';


-- Index: public.fki_tipo_contrato_notificacao

-- DROP INDEX public.fki_tipo_contrato_notificacao;

CREATE INDEX fki_tipo_contrato_notificacao
  ON public.tab_andamento
  USING btree
  (cod_tipo_contrato_fk);



INSERT INTO public.tab_atributos(
             dsc_descricao, sgl_chave)
    VALUES ('Tipo de Assunto Notificacao', 'tipo-assunto-notificacao');




INSERT INTO public.tab_atributos_valores(
            fk_atributos_valores_atributos_id, sgl_valor, 
            dsc_descricao)
    VALUES ((select cod_atributos from public.tab_atributos where sgl_chave='tipo-assunto-notificacao'), 1, 
            'Notificação Geral');
