-- Table: public.tab_regiao

-- DROP TABLE public.tab_regiao;

CREATE TABLE public.tab_regiao
(
  cod_regiao bigserial NOT NULL,
  uf_fk character(2),
  cod_atributo_regiao bigint,
  CONSTRAINT tab_regiao_pkey PRIMARY KEY (cod_regiao),
  CONSTRAINT tab_regiao_cod_atributo_regiao_fkey FOREIGN KEY (cod_atributo_regiao)
      REFERENCES public.tab_atributos_valores (cod_atributos_valores) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT tab_regiao_uf_fk_fkey FOREIGN KEY (uf_fk)
      REFERENCES public.tab_estados (sgl_estado) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
)
WITH (
  OIDS=FALSE
);
ALTER TABLE public.tab_regiao
  OWNER TO postgres;




INSERT INTO public.tab_atributos(
            dsc_descricao, sgl_chave)
    VALUES ('Região', 'regiao');


INSERT INTO public.tab_atributos_valores(
             fk_atributos_valores_atributos_id, sgl_valor, 
            dsc_descricao)
    VALUES ( (select cod_atributos from public.tab_atributos where sgl_chave='regiao'), '1', 'verde');



INSERT INTO public.tab_atributos_valores(
             fk_atributos_valores_atributos_id, sgl_valor, 
            dsc_descricao)
    VALUES ( (select cod_atributos from public.tab_atributos where sgl_chave='regiao'), '2', 'vermelho');


    


INSERT INTO public.tab_atributos_valores(
             fk_atributos_valores_atributos_id, sgl_valor, 
            dsc_descricao)
    VALUES ( (select cod_atributos from public.tab_atributos where sgl_chave='regiao'), '3', 'laranja');


    


INSERT INTO public.tab_atributos_valores(
             fk_atributos_valores_atributos_id, sgl_valor, 
            dsc_descricao)
    VALUES ( (select cod_atributos from public.tab_atributos where sgl_chave='regiao'), '4', 'rosa');

    


INSERT INTO public.tab_atributos_valores(
             fk_atributos_valores_atributos_id, sgl_valor, 
            dsc_descricao)
    VALUES ( (select cod_atributos from public.tab_atributos where sgl_chave='regiao'), '5', 'azul');



INSERT INTO public.tab_regiao(
            uf_fk, cod_atributo_regiao)
    VALUES 
    ('CE', (select cod_atributos_valores from public.tab_atributos_valores where dsc_descricao='verde')),
    ('RN', (select cod_atributos_valores from public.tab_atributos_valores where dsc_descricao='verde')),
    ('PB', (select cod_atributos_valores from public.tab_atributos_valores where dsc_descricao='verde')),
    ('PE', (select cod_atributos_valores from public.tab_atributos_valores where dsc_descricao='verde')),
    ('AL', (select cod_atributos_valores from public.tab_atributos_valores where dsc_descricao='verde')),
    ('MA', (select cod_atributos_valores from public.tab_atributos_valores where dsc_descricao='verde')),
    ('SE', (select cod_atributos_valores from public.tab_atributos_valores where dsc_descricao='verde')),

    ('PI', (select cod_atributos_valores from public.tab_atributos_valores where dsc_descricao='vermelho')),
    ('TO', (select cod_atributos_valores from public.tab_atributos_valores where dsc_descricao='vermelho')),
    ('PA', (select cod_atributos_valores from public.tab_atributos_valores where dsc_descricao='vermelho')),
    ('AP', (select cod_atributos_valores from public.tab_atributos_valores where dsc_descricao='vermelho')),
    ('RR', (select cod_atributos_valores from public.tab_atributos_valores where dsc_descricao='vermelho')),
    ('AM', (select cod_atributos_valores from public.tab_atributos_valores where dsc_descricao='vermelho')),
    ('AC', (select cod_atributos_valores from public.tab_atributos_valores where dsc_descricao='vermelho')),
    ('RO', (select cod_atributos_valores from public.tab_atributos_valores where dsc_descricao='vermelho')),

     ('BA', (select cod_atributos_valores from public.tab_atributos_valores where dsc_descricao='laranja')),
    ('MG', (select cod_atributos_valores from public.tab_atributos_valores where dsc_descricao='laranja')),
    ('ES', (select cod_atributos_valores from public.tab_atributos_valores where dsc_descricao='laranja')), 

  ('RJ', (select cod_atributos_valores from public.tab_atributos_valores where dsc_descricao='rosa')),
    ('SP', (select cod_atributos_valores from public.tab_atributos_valores where dsc_descricao='rosa')), 

	('MT', (select cod_atributos_valores from public.tab_atributos_valores where dsc_descricao='azul')),
	('DF', (select cod_atributos_valores from public.tab_atributos_valores where dsc_descricao='azul')),
	('GO', (select cod_atributos_valores from public.tab_atributos_valores where dsc_descricao='azul')),
	('MS', (select cod_atributos_valores from public.tab_atributos_valores where dsc_descricao='azul')),
	('PR', (select cod_atributos_valores from public.tab_atributos_valores where dsc_descricao='azul')),
	('SC', (select cod_atributos_valores from public.tab_atributos_valores where dsc_descricao='azul')),
	('RS', (select cod_atributos_valores from public.tab_atributos_valores where dsc_descricao='azul'));