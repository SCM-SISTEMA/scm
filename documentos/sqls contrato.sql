insert into public.tab_atributos (dsc_descricao, sgl_chave) values ('Status Contrato', 'status-contrato');


insert into public.tab_atributos_valores (fk_atributos_valores_atributos_id, sgl_valor, dsc_descricao) 
				values 
((select cod_atributos from  public.tab_atributos where sgl_chave='status-contrato'),'1', 'Negociando'),
((select cod_atributos from  public.tab_atributos where sgl_chave='status-contrato'),'2', 'Recusado'),
((select cod_atributos from  public.tab_atributos where sgl_chave='status-contrato'),'3', 'Fechado')

;