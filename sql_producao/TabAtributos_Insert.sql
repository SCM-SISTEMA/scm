-- 89 -  Status do Contrato
INSERT
INTO    tab_atributos (cod_atributos, dsc_descricao, sgl_chave)
  SELECT  89,'Status do Contrato','status-do-contrato'
  WHERE   89 NOT IN (SELECT  cod_atributos FROM    tab_atributos);
-- 89 -  Status do Contrato - (1-Em elaboração)
INSERT
INTO    tab_atributos_valores (cod_atributos_valores, fk_atributos_valores_atributos_id, sgl_valor, dsc_descricao)
  SELECT  nextval ('tab_atributos_valores_cod_atributos_valores_seq'), 89,'1','Em elaboração'
  WHERE   NOT exists(SELECT  cod_atributos_valores FROM    tab_atributos_valores
                     WHERE fk_atributos_valores_atributos_id = 89 AND sgl_valor= '1');
-- 89 -  Status do Contrato - (2-Em análise financeiro)
INSERT
INTO    tab_atributos_valores (cod_atributos_valores, fk_atributos_valores_atributos_id, sgl_valor, dsc_descricao)
  SELECT  nextval ('tab_atributos_valores_cod_atributos_valores_seq'), 89,'2','Em análise financeiro'
  WHERE   NOT exists(SELECT  cod_atributos_valores FROM    tab_atributos_valores
                     WHERE fk_atributos_valores_atributos_id = 89 AND sgl_valor= '2');





